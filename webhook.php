<?php

$data = array(    
  "body" => "testing101"
);                                                                    
$data_string = json_encode($data);                                                                                   

$ch = curl_init('https://api.github.com/repos/octocat/Hello-World/issues/229/comments');                                                            
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');                                                                      
curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
    'Content-Type: application/json',
    'Authorization: token x'
);                                                                                                                   
                                                                                                                     
$result = curl_exec($ch);
print_r($result);
curl_close($ch);

?>