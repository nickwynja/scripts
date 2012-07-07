<?php

$filename = "Harriman Park 12-04-07";
$ext = ".jpg";


$album_id = "7302322";
$key = "63e4346865432e323c354a214e7a4c";
$page = 200;
$offset = 0;
$url = "https://api.meetup.com/2/photos.xml?key=" . $key . "&page=" . $page . "&offset=" . $offset . "&photo_album_id=" . $album_id;



function get_data($url)
{
  $ch = curl_init();
  $timeout = 5;
  curl_setopt($ch,CURLOPT_URL,$url);
  curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
  curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
  $data = curl_exec($ch);
  curl_close($ch);
  return $data;
}

$xml = simplexml_load_file(rawurlencode($url));

$i = 1;

foreach($xml->items->item as $item){
  echo "Downloading " . $item->highres_link . "\n";
  foreach($item->highres_link as $photo){
    file_put_contents($filename . "_" . $i . $ext, get_data($photo));
    $i = $i + 1;

  }
}

?>