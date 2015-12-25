<?php
$config = array(
  'user' => 'codethejason',
  'repository' => 'gci15.fossasia.org'
);

$payloadJSON = file_get_contents('php://input');

if (isset($payloadJSON)) {

  $payload = json_decode($payloadJSON, true);
  $action = $payload['action'];//since API alerts on other stuff like "assigned", "unassigned", "labeled", "unlabeled", "opened", "closed", or "reopened", or "synchronize"
  $branch = $payload['pull_request']['head']['ref'];
  
  if($branch == 'gh-pages' && ($action == 'opened' || $action == 'reopened')) { 

    $pullrequestID = $payload['number'];
    $username = $payload['pull_request']['user']['login'];

    $url = "https://api.github.com/repos/".$config['user']."/".$config['repository']."/issues/".$pullrequestID."/comments";
    $secretStuff = json_decode(file_get_contents('secret.json'), true);
    $token = $secretStuff['token'];
    $key = "sha1=".hash_hmac('sha1', $payloadJSON, $secretStuff['githubkey']);

    if(isset($_SERVER['HTTP_X_HUB_SIGNATURE']) && $_SERVER['HTTP_X_HUB_SIGNATURE'] == $key) {

      $httpheaders = array("Content-Type: application/json", "Authorization: token {$token}");

      $data = array(
        "body" => "http://".$username.".github.io/{$config['repository']}"
      ); 

      $data_string = json_encode($data);                                                                                   

      $ch = curl_init($url);                                                            
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
      curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
      curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');                                                                      
      curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheaders);

      $result = curl_exec($ch);
      curl_close($ch);
      echo "Success! Commented for {$username} on pull request id {$pullrequestID}.";

    }
  } else {
    echo "This action does not qualify for a comment.";
  }
}

