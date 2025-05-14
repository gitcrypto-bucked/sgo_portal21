<?php 
$link ='storage/public/';
$target = 'public/storage';

var_dump(symlink($target, $link));
echo "Done";
