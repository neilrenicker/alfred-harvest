<?php

  $dir = "../../../Workflow Data/com.neilrenicker.harvest/";
  $fp = fopen($dir . "id.txt", "r");
  $data = stream_get_contents($fp);
  fclose($fp);

  $strings = explode( "\n", $data);
  $subdomain = $strings[0];
  $email = $strings[1];
  $password = shell_exec('/usr/bin/security find-generic-password -s alfred-harvest-workflow -w');
  $password = preg_replace('/(.+)\n$/', '${1}', $password);
  $credentials = $email . ":" . $password;
?>