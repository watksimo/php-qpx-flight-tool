<?php
date_default_timezone_set('Australia/Brisbane');
$API_KEY='AIzaSyDjBf13Qu1XH0l-KcykGEM8LshQFw1c4Bc';
$NUM_SOLUTIONS = 20;

$start_date = strtotime('2017-01-14');
$dest_list = array(new Destination('BOS', 5), new Destination('LAX', 5), new Destination('BOS', 0));
$passengers = new Passengers(2,0,0,0,0);

$test_request = new RequestInfo($start_date, $dest_list, $passengers);
$test_request->execute_request();

print_r($test_request->flights);

class RequestInfo {
  public $containing_file = "";
  public $flights = [];
  public $start_date = NULL;
  public $dest_list = NULL;
  public $passengers = NULL;
  private $json_request = NULL;

  public function __construct($start_date, $dest_list, $passengers) {
    $this->start_date = $start_date;
    $this->dest_list = $dest_list;
    $this->passengers = $passengers;

    $this->json_request = $this->make_qpx_json();
  }

  public function execute_request() {
    $json_results = $this->make_qpx_request($this->json_request);
    if($json_results == -1) {
      echo "QPX request failed.";
    }
    $this->extract_flight_info($json_results);
    $this->save_results($json_results);
  }

  private function make_qpx_json() {
    global $NUM_SOLUTIONS;
    $json_request = file_get_contents('templates/basic_qpx_request.tpl');

    $json_request = preg_replace('/{\$adultCount}/', $this->passengers->adult_count, $json_request);
    $json_request = preg_replace('/{\$childCount}/', $this->passengers->child_count, $json_request);
    $json_request = preg_replace('/{\$infantInLapCount}/', $this->passengers->infant_lap_count, $json_request);
    $json_request = preg_replace('/{\$infantInSeatCount}/', $this->passengers->infant_seat_count, $json_request);
    $json_request = preg_replace('/{\$seniorCount}/', $this->passengers->senior_count, $json_request);

    $json_request = preg_replace('/{\$solutions}/', $NUM_SOLUTIONS, $json_request);

    $comb_slice_string = '';
    $origin = NULL;
    $flight_date = $this->start_date;

    foreach($this->dest_list as $dest) {
      if($origin != NULL) {
        $slice_string = $this->make_qpx_slice($origin, $dest, $flight_date);
        $comb_slice_string = $comb_slice_string . $slice_string . ',';
        $flight_date = strtotime('+' . $origin->duration . ' days', $flight_date);
      }
      $origin = $dest;
    }
    $comb_slice_string = rtrim($comb_slice_string, ",");

    $json_request = preg_replace('/{\$sliceText}/', $comb_slice_string, $json_request);

    return $json_request;

  }

  private function make_qpx_request($json_request) {
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
    curl_setopt($curlConnection, CURLOPT_CONNECTTIMEOUT, 60);
    curl_setopt($curlConnection, CURLOPT_TIMEOUT, 60);

    $flight_json_data = curl_exec($curlConnection);

    if(curl_errno($curlConnection)){
      return -1;
    }

    return $flight_json_data;
  }

  public function make_qpx_slice($orig, $dest, $date) {
    $slice_string = trim(file_get_contents('templates/slice.tpl'));

    $slice_string = preg_replace('/{\$origin}/', $orig->airport_code, $slice_string);
    $slice_string = preg_replace('/{\$destination}/', $dest->airport_code, $slice_string);
    $slice_string = preg_replace('/{\$date}/', date("Y-m-d", $date ), $slice_string);

    return $slice_string;
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

class Passengers {
  public $adult_count = 0;
  public $child_count = 0;
  public $infant_lap_count = 0;
  public $infant_seat_count = 0;
  public $senior_count = 0;

  public function __construct($adult_count, $child_count, $infant_lap_count, $infant_seat_count, $senior_count) {
      $this->adult_count = $adult_count;
      $this->child_count = $child_count;
      $this->infant_lap_count = $infant_lap_count;
      $this->infant_seat_count = $infant_seat_count;
      $this->senior_count = $senior_count;
  }
}

class Destination {
  public $airport_code = NULL;
  public $duration = NULL;

  public function __construct($airport_code, $duration) {
    $this->airport_code = $airport_code;
    $this->duration = $duration;
  }

}

class BasicInfo {
  public $cost = NULL;
  public $trip_legs = [];
}

class LegInfo {
  // TODO Add departure time
  public $class = NULL;
  public $origin = NULL;
  public $destination = NULL;
  public $duration = NULL;
}

?>
