<?php

date_default_timezone_set('America/New_York');

$type = trim($_GET['t']);
$note = trim($_GET['n']);
$date = date("y-m-d");
$time = date("H-i-s");

if ($type == 'scratch') {

    $file_name = 'Scratchpad_' . $date . '.txt';
    $file_path = '/home/blog/Dropbox/Notes/';
    $file = $file_path . $file_name;
    
    if ('' == file_get_contents($file)) {
      $text = $note; }
    else {
      $text = "\n\n" . $note; }

}

if ($type == 'hm-draft') {

    $ext = '.md';   
    $file_name = $date . '_' . $time . $ext;
    $file_path = '/home/blog/Dropbox/hackmake/drafts/';
    $file = $file_path . $file_name;
    $text = $note;
}

if ($type == 'wr-draft') {

    $ext = '.md';   
    $file_name = $date . '_' . $time . $ext;
    $file_path = '/home/blog/Dropbox/nickwynja/writing/drafts/';
    $file = $file_path . $file_name;
    $text = $note;
}

if ($type == 'new') {

    $ext = '.txt';
    $file_name = $date . '_' . $time . $ext;
    $file_path = '/home/blog/Dropbox/Notes/';
    $file = $file_path . $file_name;
    $text = $note;
}

if ($type == 'new') {

    $ext = '.txt';
    $file_name = $date . '_' . $time . $ext;
    $file_path = '/home/blog/Dropbox/Notes/';
    $file = $file_path . $file_name;
    $text = $note;        
}

if ($type == 'book-list') {

    $file_name = 'Books to Read.txt';
    $file_path = '/home/blog/Dropbox/Notes/';
    $file = $file_path . $file_name;
    $text = "\n" . $note;
}

if ($type == 'wiki-list') {

    $file_name = 'Things to Wiki.txt';
    $file_path = '/home/blog/Dropbox/Notes/';
    $file = $file_path . $file_name;
    $text = "\n" . $note;
}

// Save file

chmod($file, 0777);
file_put_contents($file, $text, FILE_APPEND);


?>
<html>
    <head>
        <meta name="viewport" content="width=320"/>
        <title>Saved Note</title>
    </head>
    <body style="font: Normal 26px 'Lucida Grande', Verdana, sans-serif; text-align:center; color:#888; margin-top:100px;">
        Saved.
        <br/>
    </body>
</html>
