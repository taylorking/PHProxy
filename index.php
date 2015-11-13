<?php
  $forwardingAddress = "http://127.0.0.1:5000";
  $method = $_SERVER['REQUEST_METHOD'];
  $requestUri = $_SERVER['REQUEST_URI'];
  $data = explode('/', $requestUri);
  $indexFound = false;
  $paramsList = array();
  foreach($data as $value) {
    if($value == "index.php") {
      $indexFound = true;
      continue;
    }
    if($indexFound) {
      if($value == "") { continue; }
      array_push($paramsList, $value); 
    }
  }
  $paramString = "";
  foreach($paramsList as $value) {
    $paramString = $paramString . "/$value"; 
  }
  $body = "";
  if($method == 'POST') {
   $body = file_get_contents("php://input");
  }  
  echo $body;
  $headerString = get_curl_headers();
  $command = "./request.sh " . ($forwardingAddress . $paramString) . " $method '$headerString' '$body'";
  $response = shell_exec($command);
  $response = json_decode($response, true); 
  foreach($response['headers'] as $key => $value) {
    if($key == "code") {
      http_response_code($value);
      continue;
    } 
    header("$key: $value");
  }
  echo $response['body'];
  function get_curl_headers() {
    $headerString = "";
    $reqHeaders = getallheaders();
    $i = 0;
    foreach($reqHeaders as $key => $value) {
      if($key == 'Content-length' || $key == 'Content-Length') {
        continue; // Content Length was messing me up. If you need this write the code yourself.
      }
      if($i == 0) {
        $headerString = "-H \"$key:$value\"";
        $i++;
        continue;
      } else {
        $headerString = "$headerString -H \"$key:$value\"";    
      }
    }
    return $headerString;
  }

?>
