<?php

  $shortname   = "sparkbox";
  $email		   = "neil@heysparkbox.com";
  $password    = "whi-mimo-kej";

  $credentials = $email . ":" . $password;
  $get_daily   = "https://$shortname.harvestapp.com/daily";

  $in = "{query}";

  $have_projects_list = ( file_exists( 'projects.txt' ) ) ? file_get_contents( 'projects.txt' ) : false;
  $have_tasks_list = ( file_exists( 'tasks.txt' ) ) ? file_get_contents( 'tasks.txt' ) : false;

  if ( !$have_projects_list ): // no data saved for step 1

    $headers = array (
      "Content-type: application/json",
      "Accept: application/json",
      "Authorization: Basic " . base64_encode($credentials)
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $get_daily);
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
      $name    = $project["name"];
      $task    = $project["task"];
      $client  = $project["client"];
      $id      = $project["id"];

      $xml .= "<item arg=\"$id\">\n";
      $xml .= "<title><![CDATA[$name, $client]]></title>\n";
      $xml .= "<subtitle>View available tasks...</subtitle>\n";
      $xml .= "<icon>icon.png</icon>\n";
      $xml .= "</item>\n";
    }

    $xml .= "</items>";
    echo $xml;

  elseif ( !$have_tasks_list ): // no data saved for step 2
    
    $project_list_raw = file_get_contents('projects.json');
    $project_list = json_decode($project_list_raw, true);
    $project_id = trim($argv[1]);

    $xml = "<?xml version=\"1.0\"?>\n<items>\n";

    foreach ($project_list["projects"] as $project){
      $name    = $project["name"];
      $task    = $project["task"];
      $client  = $project["client"];
      $id      = $project["id"];

      $xml .= "<item arg=\"$id\">\n";
      $xml .= "<title><![CDATA[$name, $client]]></title>\n";
      $xml .= "<subtitle>View available tasks...</subtitle>\n";
      $xml .= "<icon>icon.png</icon>\n";
      $xml .= "</item>\n";
    }

    $xml .= "</items>";
    echo $xml;

  endif;

?>