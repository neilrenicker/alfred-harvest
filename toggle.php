<?php

  $id          = trim($argv[1]);

  $shortname   = "YOUR_SHORTNAME";
  $email       = "YOUR_EMAIL";
  $password    = "YOUR_PASSWORD";
  $credentials = $email . ":" . $password;
  $toggle_url = "https://$shortname.harvestapp.com/daily/timer/$id";

  $headers = array (
    "Content-type: application/json",
    "Accept: application/json",
    "Authorization: Basic " . base64_encode($credentials)
  );

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $toggle_url);
  curl_setopt($ch, CURLOPT_VERBOSE, 0);
  curl_setopt($ch, CURLOPT_TIMEOUT, 60);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $data_raw = curl_exec($ch);
  curl_close($ch);

  $data = json_decode($data_raw, true);

  $was_started = $data["timer_started_at"];
  $project = $data["project"];

  if ( $was_started ) {
    $query = "Started —" . " " . $project;
  } else {
    $query = "Stopped —" . " " . $project;
  }

  echo $query;

?>