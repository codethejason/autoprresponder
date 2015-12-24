<?php

$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_RETURNTRANSFER => 1,
  CURLOPT_URL => 'https://api.github.com/repos/octocat/Hello-World/issues/229/comments',
  CURLOPT_USERAGENT => 'PHP',
  CURLOPT_POST => 0,
  CURLOPT_HTTPHEADER => array(
    'Content-Type':'application/json',
    'Authorization': 'token'
  ),
 /* CURLOPT_POSTFIELDS => array(
    "body" => "testing101",
    "access_token" => "2d54013402c86c0e488b9bb2000ecbc2dedf35ff"
  )*/
)
);
print_r(curl_getinfo($curl));
$resp = curl_exec($curl);
print_r($resp);
curl_close($curl);

?>