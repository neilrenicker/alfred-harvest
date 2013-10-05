<?php
  $query = trim($argv[1]);
  $dir = "../../../Workflow Data/com.neilrenicker.harvest/";

  // get data from $query:
  $strings = explode( "|", $query);
  $entry_notes = $strings[0];
  $entry_hours = $strings[1];
  $entry_spent_at = $strings[2];
  $entry_project_id = $strings[3];
  $entry_task_id = $strings[4];

  // set default timezone to avoid warnings
  $tz_string = exec('systemsetup -gettimezone');
  $tz = substr( $tz_string, ( strpos( $tz_string, ": " ) + 2 ) );
  date_default_timezone_set( $tz );
  // reformat $entry_spent_at for posting to Harvest API
  $entry_spent_at = date_create_from_format("Y-m-d", $entry_spent_at);
  $entry_spent_at = $entry_spent_at->format("D, d M Y");

  require('auth.php');
  $url = "https://$subdomain.harvestapp.com/daily/update/$entry_task_id";

  // build xml_data to post to Harvest API:
  $xml_data = "<request> <notes>$entry_notes</notes> <hours>$entry_hours</hours> <spent_at type=\"date\">$entry_spent_at</spent_at> <project_id>$entry_project_id</project_id> <task_id>$entry_task_id</task_id> </request>";

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

?>