<?php

  $id          = trim($argv[1]);
  $shortname   = "YOUR_SHORTNAME";
  $email       = "YOUR_EMAIL";
  $password    = "YOUR_PASSWORD";

  $credentials = $email . ":" . $password;
  $delete_url = "https://$shortname.harvestapp.com/daily/delete/$id";

  $headers = array (
    "Content-type: application/json",
    "Accept: application/json",
    "Authorization: Basic " . base64_encode($credentials)
  );

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $delete_url);
  curl_setopt($ch, CURLOPT_VERBOSE, 0);
  curl_setopt($ch, CURLOPT_TIMEOUT, 60);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_exec($ch);
  curl_close($ch);

?>