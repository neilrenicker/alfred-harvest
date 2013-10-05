  <?php
  require('auth.php');
  $url = "https://$subdomain.harvestapp.com/daily";
  $dir = "../../../Workflow Data/com.neilrenicker.harvest/";

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
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_HEADER, 1);
  $response = curl_exec($ch);

  // Then, after your curl_exec call:
  $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
  $header = substr($response, 0, $header_size);
  $response_code = substr($header, 9, 3);
  $response = substr($response, $header_size);

  if (curl_errno($ch)) {
    print "Error: " . curl_error($ch);
    curl_close($ch);
  } elseif ($response_code == "200") {
    curl_close($ch);
    $fp = fopen($dir . 'projects.json', 'w');
    fwrite($fp, $response);
    fclose($fp);
  } else {
    curl_close($ch);
    print "Error: " . $header;
  }

?>