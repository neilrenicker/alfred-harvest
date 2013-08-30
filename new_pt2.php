<?php

  $project_id = trim( "{query}" );

  $have_projects_list = ( file_exists( 'projects.txt' ) ) ? file_get_contents( 'projects.txt' ) : false;
  $have_tasks_list = ( file_exists( 'tasks.txt' ) ) ? file_get_contents( 'tasks.txt' ) : false;

  if ( !$have_projects_list ): // no data saved for step 1

    $fp = fopen('projects.txt', 'r');
    fread($fp, $projects);
    fclose($fp);

    $data = json_decode($projects, true);

    $xml = "<?xml version=\"1.0\"?>\n<items>\n";

    foreach ($data["projects"] as $project){

      if($project["id"] == $project_id) {
        $project_tasks = $project["tasks"];
        $project_name = $project["name"];
      }

      foreach ($project_tasks as $task)
        $task_name    = $task["name"];
        $task_id    = $task["id"];

        $xml .= "<item arg=\"$task_id\">\n";
        $xml .= "<title><![CDATA[$task_name]]></title>\n";
        $xml .= "<subtitle><![CDATA[Begin this task for $project_name]]</subtitle>\n";
        $xml .= "<icon>icon.png</icon>\n";
        $xml .= "</item>\n";
    }

    $xml .= "</items>";
    echo $xml;

  endif;

?>