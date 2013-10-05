<?php

  $query = trim($argv[1]);
  $dir = "../../../Workflow Data/com.neilrenicker.harvest/";

  if ( substr_count( $query, '→' ) == 0 ):

    if ( !$query ) {
      require('getdaily.php');
      $data = json_decode($response, true);
    } else {
      $data_raw = file_get_contents($dir . 'projects.json');
      $data = json_decode($data_raw, true);
    }

    $xml = "<?xml version=\"1.0\"?>\n<items>\n";

    foreach ($data["day_entries"] as $day_entry) {
      $project = htmlspecialchars($day_entry["project"]);
      $task    = htmlspecialchars($day_entry["task"]);
      $client  = htmlspecialchars($day_entry["client"]);
      $notes   = htmlspecialchars($day_entry["notes"]);
      $hours   = $day_entry["hours"];
      $active  = $day_entry["timer_started_at"];
      $id      = $day_entry["id"];

      if ( !$query ) {
       if ( $active ) {
          $xml .= "<item arg=\"$id\" valid=\"no\" uid=\"harvestcurrent\" autocomplete=\"$id → \">\n";
        } else {
          $xml .= "<item arg=\"$id\" valid=\"no\" autocomplete=\"$id → \">\n";
        }

        $xml .= "<title>Add note: $project</title>\n";
        
        if ( $notes ) {
          $xml .= "<subtitle>$client, $task ($hours hours) – \"$notes\"</subtitle>\n";
        } else {
          $xml .= "<subtitle>$client, $task ($hours hours)</subtitle>\n";
        }

        if ( $active ) {
          $xml .= "<icon>note-active.png</icon>\n";
        } else {
          $xml .= "<icon>note-inactive.png</icon>\n";
        }
        $xml .= "</item>\n";
      } elseif ( stripos($project . $task . $client . $notes, $query) !== false ) {
        if ( $active ) {
          $xml .= "<item arg=\"$id\" valid=\"no\" uid=\"harvestcurrent\" autocomplete=\"$id → \">\n";
        } else {
          $xml .= "<item arg=\"$id\" valid=\"no\" autocomplete=\"$id → \">\n";
        }

        $xml .= "<title>Add note: $project</title>\n";
        
        if ( $notes ) {
          $xml .= "<subtitle>$client, $task ($hours hours) – \"$notes\"</subtitle>\n";
        } else {
          $xml .= "<subtitle>$client, $task ($hours hours)</subtitle>\n";
        }

        if ( $active ) {
          $xml .= "<icon>note-active.png</icon>\n";
        } else {
          $xml .= "<icon>note-inactive.png</icon>\n";
        }
        $xml .= "</item>\n";
      }
    }

    $xml .= "</items>";
    echo $xml;

  elseif ( substr_count( $query, '→' ) == 1 ):

    $strings = explode( " →", $query);
    $task_id = $strings[0];
    $newQuery = $strings[1];
    $data_raw = file_get_contents($dir . 'projects.json');
    $data = json_decode($data_raw, true);

    foreach ( $data["day_entries"] as $entry ){

      if ( $entry["id"] == $task_id ) {
        $entry_notes = $entry["notes"];
        $entry_hours = $entry["hours"];
        $entry_spent_at = $entry["spent_at"];
        $entry_project_id = $entry["project_id"];
        $entry_task_id = $task_id;
        $entry_project_name = htmlspecialchars($entry["project"]);
        $entry_task = htmlspecialchars($entry["task"]);
        $active  = $entry["timer_started_at"];
      }
    }

    $xml = "<?xml version=\"1.0\"?>\n<items>\n";

    if ( !$newQuery ) {
      $xml .= "<item valid=\"no\">\n";
      $xml .= "<title>Add note: '...'</title>\n";
      $xml .= "<subtitle>$entry_project_name, $entry_task ($entry_hours hours)</subtitle>\n";
      if ( $active ) {
        $xml .= "<icon>note-active.png</icon>\n";
      } else {
        $xml .= "<icon>note-inactive.png</icon>\n";
      }
      $xml .= "</item>\n";
    } else {
      $newQuery = substr($newQuery, 1);
      if ($entry_notes) {
        $xml .= "<item arg=\"$entry_notes $newQuery|$entry_hours|$entry_spent_at|$entry_project_id|$entry_task_id\">\n";
      } else {
        $xml .= "<item arg=\"$newQuery|$entry_hours|$entry_spent_at|$entry_project_id|$entry_task_id\">\n";
      }
      $xml .= "<title>Add note: '$newQuery'</title>\n";
      $xml .= "<subtitle>$entry_project_name, $entry_task ($entry_hours hours)</subtitle>\n";
      if ( $active ) {
        $xml .= "<icon>note-active.png</icon>\n";
      } else {
        $xml .= "<icon>note-inactive.png</icon>\n";
      }
      $xml .= "</item>\n";
    }

    $xml .= "</items>";
    echo $xml;

  endif;

?>