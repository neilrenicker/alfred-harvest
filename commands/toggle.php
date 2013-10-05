<?php

  $query = trim($argv[1]);
  $dir = "../../../Workflow Data/com.neilrenicker.harvest/";

  if ( !$query ) {

    require('get_daily.php');

    $data = json_decode($response, true);
    $xml = "<?xml version=\"1.0\"?>\n<items>\n";

    foreach ($data["day_entries"] as $day_entry) {
      $project = htmlspecialchars($day_entry["project"]);
      $task    = htmlspecialchars($day_entry["task"]);
      $client  = htmlspecialchars($day_entry["client"]);
      $notes   = htmlspecialchars($day_entry["notes"]);
      $hours   = $day_entry["hours"];
      $active  = $day_entry["timer_started_at"];
      $id      = $day_entry["id"];

      if ( $active ) {
        $xml .= "<item uid=\"harvestcurrent-$id\" arg=\"$id\">\n";
      } else {
        $xml .= "<item arg=\"$id\">\n";
      }

      $xml .= "<title>$hours hours – $project</title>\n";

      if ( $notes ) {
        $xml .= "<subtitle>$client, $task – \"$notes\"</subtitle>\n";
      } else {
        $xml .= "<subtitle>$client, $task</subtitle>\n";
      }
      if ( $active ) {
        $xml .= "<icon>icons/stop.png</icon>\n";
      } else {
        $xml .= "<icon>icons/go.png</icon>\n";
      }

      $xml .= "</item>\n";
    }

    $xml .= "</items>";
    echo $xml;

  } else {

    $data_raw = file_get_contents($dir . 'projects.json');
    $data = json_decode($data_raw, true);

    $xml = "<?xml version=\"1.0\"?>\n<items>\n";

    foreach ($data["day_entries"] as $day_entry){
      $project = htmlspecialchars($day_entry["project"]);
      $task    = htmlspecialchars($day_entry["task"]);
      $client  = htmlspecialchars($day_entry["client"]);
      $notes   = htmlspecialchars($day_entry["notes"]);
      $hours   = $day_entry["hours"];
      $active  = $day_entry["timer_started_at"];
      $id      = $day_entry["id"];

      if ( stripos($project . $task . $client . $notes, $query) !== false ) {
    
        if ( $active ) {
          $xml .= "<item uid=\"harvestcurrent-$id\" arg=\"$id\">\n";
        } else {
          $xml .= "<item arg=\"$id\">\n";
        }

        $xml .= "<title>$hours hours – $project</title>\n";

        if ( $notes ) {
          $xml .= "<subtitle>$client, $task – \"$notes\"</subtitle>\n";
        } else {
          $xml .= "<subtitle>$client, $task</subtitle>\n";
        }

        if ( $active ) {
          $xml .= "<icon>icons/stop.png</icon>\n";
        } else {
          $xml .= "<icon>icons/go.png</icon>\n";
        }

        $xml .= "</item>\n";
      }
    }
    
    $xml .= "</items>";
    echo $xml;
  }

?>