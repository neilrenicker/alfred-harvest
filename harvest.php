<?php

  $query = trim($argv[1]);

  require('getdaily.php');

  $data = json_decode($response, true);
  $xml = "<?xml version=\"1.0\"?>\n<items>\n";

  foreach ($data["day_entries"] as $day_entry){
    $project = $day_entry["project"];
    $task    = $day_entry["task"];
    $client  = $day_entry["client"];
    $hours   = $day_entry["hours"];
    $active  = $day_entry["timer_started_at"];
    $id      = $day_entry["id"];

    if ( $active ) {
      $xml .= "<item uid=\"harvestcurrent-$id\" arg=\"$id\">\n";
    } else {
      $xml .= "<item arg=\"$id\">\n";
    }

    $xml .= "<title><![CDATA[$hours hours – $project]]></title>\n";
    $xml .= "<subtitle><![CDATA[$client, $task]]></subtitle>\n";

    if ( $active ) {
      $xml .= "<icon>stop.png</icon>\n";
    } else {
      $xml .= "<icon>go.png</icon>\n";
    }

    $xml .= "</item>\n";
  }

  $xml .= "</items>";
  echo $xml;
?>