<?php
date_default_timezone_set('Australia/Brisbane');
$API_KEY='AIzaSyDjBf13Qu1XH0l-KcykGEM8LshQFw1c4Bc';

// $text = file_get_contents("results/file1.json");
// get_basic_info($text);

$BosToLax = new RequestInfo(file_get_contents("json/test1.json"));
print_r($BosToLax);

class RequestInfo {
  private $containing_file = "";
  private $flights = [];

  public function __construct($json_request) {
    global $API_KEY;
    $url = "https://www.googleapis.com/qpxExpress/v1/trips/search?key={$API_KEY}";

    $curlConnection = curl_init();
    curl_setopt($curlConnection, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
    curl_setopt($curlConnection, CURLOPT_URL, $url);
    curl_setopt($curlConnection, CURLOPT_POST, TRUE);
    curl_setopt($curlConnection, CURLOPT_POSTFIELDS, $json_request);
    curl_setopt($curlConnection, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($curlConnection, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curlConnection, CURLOPT_SSL_VERIFYPEER, FALSE);

    $flight_json_data = curl_exec($curlConnection);
    $this->save_results($flight_json_data);

    $this->extract_flight_info($flight_json_data);
  }

  private function extract_flight_info($flight_json_data) {
    $flight_array = json_decode($flight_json_data);

    foreach($flight_array->trips->tripOption as $trip_data) {
      array_push($this->flights, new TripInfo($trip_data));
    }

  }

  private function save_results($flight_json_data) {
    $filename = "results/" . strval(time()) . ".json";
    $outFile = fopen($filename, "w");

    fwrite($outFile, $flight_json_data);
    fclose($outFile);

    $this->containing_file = $filename;

  }

}

class TripInfo {

  public $basic_info = NULL;

  public function __construct($trip_data) {

    $this->extract_basic_info($trip_data);
  }

  private function extract_basic_info($trip_data) {
    $this->basic_info = new BasicInfo();

    $this->basic_info->cost = $trip_data->saleTotal;
    foreach($trip_data->slice as $journey_leg) {
      $this->basic_info->duration = $journey_leg->duration;
      foreach($journey_leg->segment as $segment) {
        $leg_info = new LegInfo();
        $leg_info->class = $segment->cabin;
        $leg = $segment->leg[0];
        $leg_info->origin = $leg->origin;
        $leg_info->destination = $leg->destination;
        $leg_info->duration = $leg->duration;
        array_push($this->basic_info->trip_legs, $leg_info);
      }
    }
  }

}

class BasicInfo {
  public $cost = NULL;
  public $trip_legs = [];
  public $duration = NULL;
}

class LegInfo {
  public $class = NULL;
  public $origin = NULL;
  public $destination = NULL;
  public $duration = NULL;
}

?>
