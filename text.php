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
        chmod($file, 0777);
        
        if ('' == file_get_contents($file)) {
          $scratch = $note; }
        else {
          $scratch = "\n\n" . $note; }

        file_put_contents($file, $scratch, FILE_APPEND);
}

if ($type == 'hm-draft') {

        $ext = '.md';   
        $file_name = $date . '_' . $time . $ext;
        $file_path = '/home/blog/Dropbox/hackmake/drafts/';
        $file = $file_path . $file_name;
        chmod($file, 0777);
        file_put_contents($file, $note);
}

if ($type == 'wr-draft') {

        $ext = '.md';   
        $file_name = $date . '_' . $time . $ext;
        $file_path = '/home/blog/Dropbox/nickwynja/writing/drafts/';
        $file = $file_path . $file_name;
        chmod($file, 0777);
        file_put_contents($file, $note);
}

if ($type == 'new') {

        $ext = '.txt';
        $file_name = $date . '_' . $time . $ext;
        $file_path = '/home/blog/Dropbox/Notes/';
        $file = $file_path . $file_name;
        chmod($file, 0777);

        file_put_contents($file, $note);
}

if ($type == 'new') {

        $ext = '.txt';
        $file_name = $date . '_' . $time . $ext;
        $file_path = '/home/blog/Dropbox/Notes/';
        $file = $file_path . $file_name;
        chmod($file, 0777);

        file_put_contents($file, $note);
}

if ($type == 'book-list') {

        $file_name = 'Books to Read.txt';
        $file_path = '/home/blog/Dropbox/Notes/';
        $file = $file_path . $file_name;
        $text = "\n" . $note;
        chmod($file, 0777);

        file_put_contents($file, $text, FILE_APPEND);
        
}

if ($type == 'wiki-list') {

        $file_name = 'Things to Wiki.txt';
        $file_path = '/home/blog/Dropbox/Notes/';
        $file = $file_path . $file_name;
        $text = "\n" . $note;
        chmod($file, 0777);

        file_put_contents($file, $text, FILE_APPEND);

}

// header('Content-Type: text/plain; charset=utf-8');
// echo "Saving to [$output_filename]:\n-----------------------\n$draft_contents\n------------------------\n";

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
