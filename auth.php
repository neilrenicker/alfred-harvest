<?php

  $fp = fopen("id.txt", "r");
  $data = stream_get_contents($fp);
  fclose($fp);

  $strings = explode( "\n", $data);
  $shortname = $strings[0];
  $email = $strings[1];
  $password = $strings[2];
  $credentials = $email . ":" . $password;

?>