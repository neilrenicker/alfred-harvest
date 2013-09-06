<?php

  $query = trim($argv[1]);

  require('auth.php');
  $url = "https://$subdomain.harvestapp.com/daily";

  if ( substr_count( $query, '→' ) == 0 ):

    $headers = array (
      "Content-type: application/json",
      "Accept: application/json",
      "Authorization: Basic " . base64_encode($credentials)
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_VERBOSE, 0);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    $fp = fopen('projects.txt', 'w');
    fwrite($fp, $response);
    fclose($fp);

    $data = json_decode($response, true);

    $xml = "<?xml version=\"1.0\"?>\n<items>\n";

    foreach ($data["projects"] as $project){
      $name    = htmlspecialchars($project["name"]);
      $client  = htmlspecialchars($project["client"]);

      $xml .= "<item valid=\"no\" autocomplete=\" $name → \">\n";
      $xml .= "<title>$name, $client</title>\n";
      $xml .= "<subtitle>View available tasks...</subtitle>\n";
      $xml .= "<icon>add.png</icon>\n";
      $xml .= "</item>\n";
    }

    $xml .= "</items>";
    echo $xml;

  elseif ( substr_count( $query, '→' ) == 1 ):

    $project_name = trim( $query, " → " );
    $data_raw = file_get_contents('projects.txt');
    $data = json_decode($data_raw, true);

    foreach ( $data["projects"] as $project ){

      if ( $project["name"] == $project_name ) {
        $project_tasks = $project["tasks"];
        $project_name = $project["name"];
        $project_id = $project["id"];
        $project_name_encoded = str_replace(" ", "_", htmlspecialchars($project_name));
      }
    }

    $xml = "<?xml version=\"1.0\"?>\n<items>\n";

    foreach ($project_tasks as $task){
      $task_name = htmlspecialchars($task["name"]);
      $task_id = $task["id"];

      $xml .= "<item arg=\"$project_id|$task_id|$project_name_encoded\">\n";
      $xml .= "<title>$task_name</title>\n";
      $xml .= "<subtitle>Start this task</subtitle>\n";
      $xml .= "<icon>go.png</icon>\n";
      $xml .= "</item>\n";
    }

    $xml .= "</items>";
    echo $xml;

  endif;

?>