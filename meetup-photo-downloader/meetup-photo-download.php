<?php

/*

This script will download all images at full resolution from a Meetup.com photo gallery. To use, save the script to your computer and remember where you put it. For this example, the script will be in your Pictures folder. You can put it wherever you like.

Open Terminal in /Applications/Utilities and put in the command like this to execute the script. Type in:

php ~/Pictures/meetup-photo-download.php 1234567 /Directory/To/Save/ filename_prefix.

*/

// The ID for the photo album. Something like meetup.com/GroupName/photos/12345678
$album_id = ($_SERVER['argv'][1]);

// Path to save files
$path = ($_SERVER['argv'][2]);

// Filename for the outputted images. They will be appended with a sequential number.
$filename = ($_SERVER['argv'][3]);


// Get your API Key at http://www.meetup.com/meetup_api/key/
$key = "63e4346865432e323c354a214e7a4c";

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
          echo "Saved image as " . $path . $filename . "_" . $i . ".jpg" . "\n";
          $i = $i + 1;
          
        }
    }
}

?>
