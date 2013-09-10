<?php
  require('auth.php');
  $url = "https://$subdomain.harvestapp.com/daily";

  $headers = array (
    "Content-type: application/json",
    "Accept: application/json",
    "Authorization: Basic " . base64_encode($credentials)
  );

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_VERBOSE, 0);
  curl_setopt($ch, CURLOPT_TIMEOUT, 60);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $response = curl_exec($ch);

  if (curl_errno($ch)) {
    print "Error: " . curl_error($ch);
  } else {
    curl_close($ch);
  }

  $fp = fopen('projects.txt', 'w');
  fwrite($fp, $response);
  fclose($fp);
?>