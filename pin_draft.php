<?php

date_default_timezone_set('America/New_York');

/*

# YOU PROBABLY SHOULDN'T USE THIS. USE THE [PYTHON SCRIPT] INSTEAD

* Add `# # # # # php /path/to/script/pin_draft.php` to crontab.
* Script will loop through 18 times, which should take about a minute, then die
* Cron will run the script every minute so you should never have downtime

[PYTHON SCRIPT]: https://github.com/nickwynja/scripts/blob/master/pin_draft.py

*/

/* Pinboard.in Credentials and Tag */
$pinToken = '';
$pinTag = ''; //Drafts will only be created for pins with this tag. Can't be empty.

/* Draft location and extension */
$draftPath = '/path/to/drafts/';
$draftExt = '.md';

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

for ($i = 0; $i < 18; $i++) {

  $updateURL = 'https://' . $pinAPI . $pinUpdate . '?auth_token=' . $pinToken;
  $xml = simplexml_load_string(get_data($updateURL));
  $updateTime = strtotime(xml_attribute($xml, 'time'));

  if ($updateTime != $triggeredTime) {
   
    $getURL = 'https://' . $pinAPI . $pinGet . '?auth_token=' . $pinToken . '&tag=' . $pinTag . '&meta=yes';
    $xml = simplexml_load_string(get_data($getURL));

    if (property_exists($xml, 'post')) {
              
      $mostRecent = count($xml->post) - 1;
          
      $postURL = $xml->post[$mostRecent]->attributes()->href;
      $postSlug = slugify($xml->post[$mostRecent]->attributes()->description);
      $postTitle = $xml->post[$mostRecent]->attributes()->description;
      $postText = $xml->post[$mostRecent]->attributes()->extended;
      $meta = '';

      if (($xml->post[$mostRecent]->attributes()->meta) != $meta) {
        
        $draft = $postTitle . "\n====\nlink: " . $postURL . "  \npublish-not  \n\n" . $postText;
        $meta = $xml->post[$mostRecent]->attributes()->meta;    
        $file = $draftPath . $postSlug . $draftExt;
	$date = date('y-m-d H:i:s'); 

	if (!file_exists($file)) {
          $msg = file_put_contents($file, $draft);
          ($msg == FALSE) ? error_log('Draft write failed.') : error_log($postTitle . ' draft created at ' . $date);
	
	} else {

	  error_log($postTitle . ' draft already exists.');
	
	}      

	$triggeredTime = $updateTime;
    
      }

    } else {

      $triggeredTime = $updateTime;

    }
    
    sleep(3);
    
  } else {
    
    sleep(3);
 
  }
}
?>
