<?php
session_start();
header('Content-type: image/jpeg');
$tekst = $_SESSION['captchatekst'] = rand(1000, 9999);
$teksti_suurus = 20;
$laius = 100;
$korgus = 100;
$pilt = imagecreate($laius, $korgus);
imagecolorallocate($pilt, 255, 255, 255);
$teksti_varv = imagecolorallocate($pilt, 0, 0, 0);

for ($i = 1; $i <= 40; $i++) {
    $x1 = rand(1, 100);
    $y1 = rand(1, 100);
    $x2 = rand(1, 100);
    $y2 = rand(1, 100);
    imagesetthickness($pilt, 2);
    imagedashedline($pilt, $x1, $y1, $x2, $y2, $teksti_varv);
}

$font = 'aaaaaa.ttf';
imagettftext($pilt, $teksti_suurus, 0, 10, 25, $teksti_varv, $font, $tekst);
imagejpeg($pilt);
?>
