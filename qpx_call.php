<?php
date_default_timezone_set('Australia/Brisbane');

$API_KEY='AIzaSyDjBf13Qu1XH0l-KcykGEM8LshQFw1c4Bc';
$url = "https://www.googleapis.com/qpxExpress/v1/trips/search?key={$API_KEY}";

$outputFolder = 'results/';

$JSONRequest = file_get_contents('json/test1.json');

$postData = '{
  "request": {
    "passengers": {
      "adultCount": 1
    },
    "slice": [
      {
        "origin": "BOS",
        "destination": "LAX",
        "date": "2017-01-14"
      },
      {
        "origin": "LAX",
        "destination": "BOS",
        "date": "2017-02-04"
      }
    ]
  }
}';

# echo $url;
# echo $JSONRequest;

$curlConnection = curl_init();

curl_setopt($curlConnection, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
curl_setopt($curlConnection, CURLOPT_URL, $url);
curl_setopt($curlConnection, CURLOPT_POST, TRUE);
curl_setopt($curlConnection, CURLOPT_POSTFIELDS, $JSONRequest);
curl_setopt($curlConnection, CURLOPT_FOLLOWLOCATION, TRUE);
curl_setopt($curlConnection, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curlConnection, CURLOPT_SSL_VERIFYPEER, FALSE);

$results = curl_exec($curlConnection);

$dateStamp = date('Y-m-d H:i:s');
$outFile = fopen("{$outputFolder}{$dateStamp}", "w");

fwrite($outFile, $results);
fclose($outFile);
?>
