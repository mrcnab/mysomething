<?php
//include_once('imageUtil.php');

header("Content-type: image/png");
$string = $_GET['text'];
$im     = imagecreatefrompng("images/RegImage.PNG");
$color = imagecolorallocate($im, 0, 0, 0);
imagestring($im, 3, 3, 9, $string, $color);
imagepng($im);
imagedestroy($im);
/*
header("Content-type: image/png");
$string = $_GET['text'];
$im     = imagecreatefrompng("../../images/RegImage.PNG");
$orange = imagecolorallocate($im, 220, 210, 60);
$px     = (imagesx($im) - 7.5 * strlen($string)) / 2;
imagestring($im, 3, $px, 9, $string, $orange);
imagepng($im);
imagedestroy($im);
*/
?> 
