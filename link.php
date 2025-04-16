<?php 

$target =__DIR__.'../storage/app/';
$link = __DIR__.'../public/storage';
symlink($target, $link);
echo "Done";
