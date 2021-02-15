<?php
  $query = trim($argv[1]);
  $dir = "../../../Workflow Data/com.neilrenicker.harvest/";

  if ($query) {
    // get data from $query:
    $strings = explode( "|", $query);
    $entry_notes = $strings[0];
    $entry_hours = $strings[1];
    $entry_spent_at = $strings[2];
    $entry_project_id = $strings[3];
    $entry_task_id = $strings[4];

    require('get_daily.php');
    $data = json_decode($response, true);
     if ($data["day_entries"]) {
      foreach ( $data["day_entries"] as $entry ){

        if ( $entry["id"] == $entry_task_id ) {
          $existing_entry_notes = $entry["notes"];
          $existing_entry_hours = $entry["hours"];
          $existing_entry_spent_at = $entry["spent_at"];
          $existing_entry_project_id = $entry["project_id"];
          $existing_entry_task_id = $task_id;
          $existing_entry_project_name = htmlspecialchars($entry["project"]);
          $existing_entry_task = htmlspecialchars($entry["task"]);
          $existing_active  = $entry["timer_started_at"];
        }
      }
    }


    $default_tz = "UTC";
    $tz_file = readlink("/etc/localtime");
    $pos = strpos($tz_file, "zoneinfo");
    if ($pos) {
      $tz = substr($tz_file, $pos + strlen("zoneinfo/"));
    } else {
      $tz = $default_tz;
    }
    date_default_timezone_set( $tz );
    // reformat $entry_spent_at for posting to Harvest API
    $entry_spent_at = date_create_from_format("Y-m-d", $entry_spent_at);
    $entry_spent_at = $entry_spent_at->format("D, d M Y");

    require('auth.php');
    $url = "https://$subdomain.harvestapp.com/daily/update/$entry_task_id";

    // build xml_data to post to Harvest API:
    $xml_data = "<request> <notes>$existing_entry_notes\n$entry_notes</notes> <hours>$existing_entry_hours</hours> <spent_at type=\"date\">$entry_spent_at</spent_at> <project_id>$entry_project_id</project_id> <task_id>$entry_task_id</task_id> </request>";

    $headers = array (
      "Content-type: application/xml",
      "Accept: application/xml",
      "Authorization: Basic " . base64_encode($credentials)
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_VERBOSE, 0);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, stripslashes($xml_data));
    curl_exec($ch);
    curl_close($ch);

    $query = stripslashes($entry_notes);
    echo $query;
  }

?>
