<?php

  $query = trim($argv[1]);
  
  $shortname   = "sparkbox";
  $email		   = "neil@heysparkbox.com";
  $password    = "whi-mimo-kej";
  $credentials = $email . ":" . $password;
  $url   = "https://$shortname.harvestapp.com/daily/add";

  // get id's from $query:
  $strings = explode( "|" , $query);
  $project_id = $strings[0];
  $task_id = $strings[1];
  $project = str_replace("_", " ", $strings[2]);

  // get timezone from system and format date: 
  $tz_string = exec('systemsetup -gettimezone');
  $tz = substr( $tz_string, ( strpos( $tz_string, ": " ) + 2 ) );
  date_default_timezone_set( $tz );
  $date = date("D, d M Y");

  // set xml_data to post to Harvest API:
  $xml_data = "<request> <notes></notes> <hours> </hours> <project_id>$project_id</project_id> <task_id>$task_id</task_id> <spent_at>$date</spent_at> </request>";

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
  curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_data);
  curl_exec($ch);
  curl_close($ch);

  $query = "Started —" . " " . $project;
  echo $query;

?>