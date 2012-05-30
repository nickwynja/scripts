<?php

date_default_timezone_set('America/New_York');

$pin_user = '';
$pin_pass = '';
$pin_url = 'api.pinboard.in/v1/';
$pin_method = 'posts/update';

function xml_attribute($object, $attribute)
{
    if(isset($object[$attribute]))
        return (string) $object[$attribute];
}

$pin_url = 'https://' . $pin_user . ':' . $pin_pass . '@' . $pin_url . $pin_method;

$ifttt_user = '';
$ifttt_pass = '';
$task_id = '';
$ifttt_login = 'https://ifttt.com/login?login=' . $ifttt_user . '&password=' . $ifttt_pass;
$task_url = 'http://ifttt.com/tasks/' . $task_id . '/force_run';

for ($i = 0; $i >= 0; $i++) {
  
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $pin_url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $resp = curl_exec($ch);
  curl_close($ch);
  
  $xml = simplexml_load_string($resp);
  
  $update_time = strtotime(xml_attribute($xml, 'time'));
  
  if ($update_time != $triggered_time) {
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_COOKIEJAR, "/tmp/cookieIFTTT");
    curl_setopt($ch, CURLOPT_URL, $ifttt_login);
    $resp1 = curl_exec($ch);
    curl_close ($ch);
      
    unset($ch);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_COOKIEFILE, "/tmp/cookieIFTTT");
    curl_setopt($ch, CURLOPT_URL, $task_url);
    $resp2 = curl_exec($ch);
    curl_close ($ch);

    error_log($resp1);
    error_log($resp2);
    
    $triggered_time = $update_time;
    
    error_log('Updated at ' . $triggered_time);
    
    sleep(5);
    
  }
  
  else {
  
  error_log('Nothing to update.');
  sleep(5);
  
  }
  
}
?>