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
  $paramString = "/";
  $command = "./request.sh " . ($forwardingAddress . $paramString) . " $method";
  foreach($paramsList as $value) {
    $paramString = $paramString . "$value/"; 
  }  
  echo(shell_exec($command));



  function serializeRequestJSON($params) {
  
  }
?>
