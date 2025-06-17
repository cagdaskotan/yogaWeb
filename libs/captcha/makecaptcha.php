<?php
ob_start();
session_save_path("../../env/sessions");
ini_set('session.gc_maxlifetime', 3600);
session_start();


header('Content-Type: image/jpeg');

$captcha = '';
$captchaHeight = 60;
$captchaWidth = 140;
$totalCharacters = 6; 
$possibleLetters = '123456789mnbvcxzasdfghjklpoiuytrewwq';
//$captchaFont = 'monofont.ttf';
$captchaFont = 'monofont.ttf';
$randomDots = 50;
$randomLines = 25;
$textColor = "6d87cf";
$noiseColor = "6d87cf";
$character = 0;
while ($character < $totalCharacters) { 
    $captcha .= substr($possibleLetters, mt_rand(0, strlen($possibleLetters)-1), 1);
    $character++;
}
$captchaFontSize = $captchaHeight * 0.65;
$captchaImage = @imagecreate(
    $captchaWidth,
    $captchaHeight
);
$backgroundColor = imagecolorallocate(
    $captchaImage,
    255,
    255,
    255
);
$arrayTextColor = hextorgb($textColor);
$textColor = imagecolorallocate(
    $captchaImage,
    $arrayTextColor['red'],
    $arrayTextColor['green'],
    $arrayTextColor['blue']
);
$arrayNoiseColor = hextorgb($noiseColor);
$imageNoiseColor = imagecolorallocate(
    $captchaImage,
    $arrayNoiseColor['red'],
    $arrayNoiseColor['green'],
    $arrayNoiseColor['blue']
);
for( $captchaDotsCount=0; $captchaDotsCount<$randomDots; $captchaDotsCount++ ) {
    imagefilledellipse(
        $captchaImage,
        mt_rand(0,$captchaWidth),
        mt_rand(0,$captchaHeight),
        2,
        3,
        $imageNoiseColor
    );
}
for( $captchaLinesCount=0; $captchaLinesCount<$randomLines; $captchaLinesCount++ ) {
    imageline(
        $captchaImage,
        mt_rand(0,$captchaWidth),
        mt_rand(0,$captchaHeight),
        mt_rand(0,$captchaWidth),
        mt_rand(0,$captchaHeight),
        $imageNoiseColor
    );
}
imagettftext(
    $captchaImage,
    $captchaFontSize,
    0,
    15,
    45,
    $textColor,
    $captchaFont,
    $captcha
);
imagejpeg($captchaImage);
imagedestroy($captchaImage);
$_SESSION['captcha'] = $captcha;

function hextorgb($hex) {
    // "#" işaretini kaldır
    $hex = str_replace("#", "", $hex);

    // Eğer renk kodu 3 karakterliyse, bunu 6 karaktere genişlet
    if (strlen($hex) == 3) {
        $hex = str_repeat(substr($hex, 0, 1), 2) . 
               str_repeat(substr($hex, 1, 1), 2) . 
               str_repeat(substr($hex, 2, 1), 2);
    }

    // Renk değerlerini çıkart
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));

    // RGB değerlerini dizi olarak döndür
    return array('red' => $r, 'green' => $g, 'blue' => $b);
}






?>

