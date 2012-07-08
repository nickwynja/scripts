<?php

// Filename for the outputted images. They will be appended with a sequential number.
$filename = "Meetup_Photo";

// The ID for the photo album. Something like meetup.com/GroupName/photos/12345678
$album_id = "12345678";

// Get your API Key at http://www.meetup.com/meetup_api/key/
$key = "YOURKEYHERE";

$page = 200;
$url = "https://api.meetup.com/2/photos.xml?key=" . $key . "&page=" . $page . "&photo_album_id=" . $album_id;
$i = 1;

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

for ($offset = 0; $offset >= 0; $offset++) {

  $xml = simplexml_load_file(rawurlencode($url . "&offset=" . $offset));
  $response  = count($xml->items->item);

  if ($response == 0): {
    return;
  }
  endif;

    foreach($xml->items->item as $item) {
      
        echo "Downloading " . $item->highres_link . "\n";
        foreach($item->highres_link as $photo){
          file_put_contents($path . $filename . "_" . $i . ".jpg", get_data($photo));
          $i = $i + 1;
          
        }
    }
}

?>