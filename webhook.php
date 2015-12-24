<?php

if ($_POST['payload']) {

  $payload = json_decode($_POST['payload']);
  $action = $payload['action'];//since API alerts on other stuff like "assigned", "unassigned", "labeled", "unlabeled", "opened", "closed", or "reopened", or "synchronize"
  $secret = file_get_contents('secretkey');
  
  if($action == 'opened') { 

    $pullrequestID = $payload['number'];
    $username = $payload['pull_request']['user']['login'];

    $url = 'https://api.github.com/repos/codethejason/gci15.fossasia.org/issues/'.$pullrequestID.'/comments';

    $token = file_get_contents('token');

    $data = array(    
      "body" => "http://".$username.".github.io/gci15.fossasia.org"
    );                                                                    
    $data_string = json_encode($data);                                                                                   

    $ch = curl_init($url);                                                            
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');                                                                      
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
        "Content-Type: application/json",
        "Authorization: token $token"
    ));            
    
    $result = curl_exec($ch);
    print_r($result);
    curl_close($ch);
    
  }
}
?>
