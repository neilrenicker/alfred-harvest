<?php

  $dir = "../../../Workflow Data/com.neilrenicker.harvest/";
  $idPath = $dir . "id.txt";

  if(!file_exists($idPath)) {
    $xml = "<?xml version=\"1.0\"?>\n<items>\n";
    $xml .= "<item uid=\"harvestaccount\" arg=\"$url\">\n";
    $xml .= "<title>Run hv setup to authenticate first</title>\n";
    $xml .= "<subtitle>Required before you can run commands</subtitle>\n";
    $xml .= "<icon>icon.png</icon>\n";
    $xml .= "</item>\n";
    $xml .= "</items>";
    echo $xml;
    die();
  }

  $fp = fopen($idPath, "r");
  $data = stream_get_contents($fp);
  fclose($fp);

  $strings = explode( "\n", $data);
  $subdomain = $strings[0];
  $email = $strings[1];
  $password = $strings[2];
  $credentials = $email . ":" . $password;
?>
