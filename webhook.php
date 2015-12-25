<?php

$payload = file_get_contents('php://input');

if ($payload) {

  $payload = json_decode($payload, true);
  $action = $payload['action'];//since API alerts on other stuff like "assigned", "unassigned", "labeled", "unlabeled", "opened", "closed", or "reopened", or "synchronize"

  if($action == 'opened' || $action == 'reopened') { 

    $pullrequestID = $payload['number'];
    $username = $payload['pull_request']['user']['login'];

    $url = 'https://api.github.com/repos/codethejason/gci15.fossasia.org/issues/'.$pullrequestID.'/comments';

    $secretStuff = json_decode(file_get_contents('secret.json'), true);
    $token = $secretStuff['token'];
    $key = $secretStuff['webhookkey'];

    $httpheaders = array("Content-Type: application/json", "Authorization: token {$token}");
    print_r($httpheaders);
    $data = array(
      "body" => "http://".$username.".github.io/gci15.fossasia.org"
    );                                                                    
    $data_string = json_encode($data);                                                                                   

    $ch = curl_init($url);                                                            
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');                                                                      
    curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheaders);

    $result = curl_exec($ch);
    print_r($result);
    curl_close($ch);
    echo "Success!";

  }
}
?>
