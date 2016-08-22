<?php
$content = '';
if ($_FILES){
	$file = fopen($_FILES['file']['tmp_name'], 'r');
    $len = filesize($_FILES['file']['tmp_name']);
    $content = fread($file, $len);
    fclose($file);
}
include_once 'chess.html';