<?php

  // $shortname   = "sparkbox";
  // $email		   = "neil@heysparkbox.com";
  // $password    = "whi-mimo-kej";

  $credentials = "neil@heysparkbox.com:whi-mimo-kej";
  $get_daily   = "https://sparkbox.harvestapp.com/daily";

  $headers = array (
    "Content-type: application/json",
    "Accept: application/json",
    "Authorization: Basic " . base64_encode($credentials)
  );

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $get_daily);
  curl_setopt($ch, CURLOPT_VERBOSE, 1);
  curl_setopt($ch, CURLOPT_TIMEOUT, 60);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  $data = curl_exec($ch);
  curl_close($ch);


  // while($entries < 1)
  // {
  // 	$response = query_harvest('daily/')
  // }

?>