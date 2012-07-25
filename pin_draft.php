<?php

date_default_timezone_set('America/New_York');

$pinUser = 'nickwynja';
$pinPass = '';
$pinAPI = 'api.pinboard.in/v1/';
$pinUpdate = 'posts/update';
$pinGet = 'posts/get';

$pinURL = 'https://' . $pinUser . ':' . $pinPass . '@' . $pinAPI . $pinUpdate;

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
 
  // replace non letter or digits by -
  $text = preg_replace('~[^\\pL\d]+~u', '-', $text);

  // trim
  $text = trim($text, '-');

  // transliterate
  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

  // lowercase
  $text = strtolower($text);

  // remove unwanted characters
  $text = preg_replace('~[^-\w]+~', '', $text);

  if (empty($text))
  {
    return 'n-a';
  }

  return $text;
}

for ($i = 0; $i >= 0; $i++) {
  $xml = simplexml_load_string(get_data($pinURL));
  $updateTime = strtotime(xml_attribute($xml, 'time'));
  $triggeredTime = 0;

  if ($updateTime != $triggeredTime) {
   
  $pinURL = 'https://' . $pinUser . ':' . $pinPass . '@' . $pinAPI . $pinGet . '?tag=hm';
  $xml = simplexml_load_string(get_data($pinURL));
  
  $postURL = $xml->post[0]->attributes()->href;
  $postSlug = slugify($xml->post[0]->attributes()->description);
  $postTitle = $xml->post[0]->attributes()->description;
  $postText = $xml->post[0]->attributes()->extended;

  $draft = $postTitle . "\n====\nlink: " . $postURL . "\npublish-not\n\n" . $postText;

  $file = '/home/blog/Dropbox/hackmake/drafts/' . $postSlug . '.md';
  file_put_contents($file, $draft);
   
  $triggeredTime = $updateTime;
  error_log('Updated at ' . $triggeredTime); 
  sleep(5);
    
  } else {
  
  error_log('Nothing to update.');
  sleep(5);
  
  }
}
?>
