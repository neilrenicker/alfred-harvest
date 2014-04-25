<?php

  $dir = "../../../Workflow Data/com.neilrenicker.harvest/";
  $fp = fopen($dir . "id.txt", "r");
  $data = stream_get_contents($fp);
  fclose($fp);

  $strings = explode( "\n", $data);
  $subdomain = $strings[0];
  $email = $strings[1];

  // Migrate to using the keychain
  if (count($strings) == 3) {
      $id = "$subdomain\n$email";
      $password = $strings[2];
      file_put_contents( $dir . 'id.txt', $id );
      shell_exec('/usr/bin/security delete-generic-password -s alfred-harvest-workflow > /dev/null 2>&1');
      shell_exec('/usr/bin/security -v add-generic-password -a alfred-harvest -l alfred-harvest -s alfred-harvest-workflow -w \'' . $password . '\' > /dev/null 2>&1');
  }
  
  $password = shell_exec('/usr/bin/security find-generic-password -s alfred-harvest-workflow -w');
  $password = preg_replace('/(.+)\n$/', '${1}', $password);
  $credentials = $email . ":" . $password;
?>