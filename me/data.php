<?php

$title = '柏龙';
$subtitle = 'PHP开发工程师';

$data = [
    'local'    => 1,
    'error'    => 0,
    'show'     => 1,
    'title'    => $title,
    'subtitle' => $subtitle,
    'content'  => file_get_contents('README.md')
];

header('Content-Type: application/json');

echo json_encode($data);
