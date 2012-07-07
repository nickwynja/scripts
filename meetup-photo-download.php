<?php

$filename = "Schunemunk Mountain Ridge Loop and The Megaliths_12-06-23";
$ext = ".jpg";


$album_id = "7097972";
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
    //Now you can access the 'row' data using $Item in this case 
    //two elements, a name and an array of key/value pairs
    echo "Downloading " . $item->highres_link . "\n";
    //Loop through the attribute array to access the 'fields'.
    foreach($item->highres_link as $photo){
      file_put_contents($filename . "_" . $i . $ext, get_data($photo));
      $i = $i + 1;

      }
    }
?>