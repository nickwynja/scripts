<?php

date_default_timezone_set('America/New_York');

$pinUser = 'nickwynja';
$pinPass = '';
$pinAPI = 'api.pinboard.in/v1/';
$pinUpdate = 'posts/update';
$pinGet = 'posts/get';
$triggeredTime = 0;

function get_data($url) {
  $ch = curl_init();
  $timeout = 5;
  curl_setopt($ch,CURLOPT_URL,$url);
  curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
  curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
  $data = curl_exec($ch);
  curl_close($ch);
  return $data;
}

function xml_attribute($object, $attribute){
  if(isset($object[$attribute]))
        return (string) $object[$attribute];
}

function slugify($text) {
  $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
  $text = trim($text, '-');
  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
  $text = strtolower($text);
  $text = preg_replace('~[^-\w]+~', '', $text);

  return $text;
}

for ($i = 0; $i >= 0; $i++) {

  $updateURL = 'https://' . $pinUser . ':' . $pinPass . '@' . $pinAPI . $pinUpdate;
  $xml = simplexml_load_string(get_data($updateURL));
  $updateTime = strtotime(xml_attribute($xml, 'time'));

  if ($updateTime != $triggeredTime) {
   
    $getURL = 'https://' . $pinUser . ':' . $pinPass . '@' . $pinAPI . $pinGet . '?tag=hm';
    $xml = simplexml_load_string(get_data($getURL));
    
    $mostRecent = count($xml->post) - 1;
        
    $postURL = $xml->post[$mostRecent]->attributes()->href;
    $postSlug = slugify($xml->post[$mostRecent]->attributes()->description);
    $postTitle = $xml->post[$mostRecent]->attributes()->description;
    $postText = $xml->post[$mostRecent]->attributes()->extended;
  
    $draft = $postTitle . "\n====\nlink: " . $postURL . "\npublish-not\n\n" . $postText;
    
    $file = '/home/blog/Dropbox/hackmake/drafts/' . $postSlug . '.md';
    file_put_contents($file, $draft);
     
    $triggeredTime = $updateTime;
    error_log($postTitle . ' draft added.'); 
    sleep(3);
    
  } else {
  
    sleep(3);
  
  }
}
?>
