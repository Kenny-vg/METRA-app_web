<?php
$size = 512;
$image = imagecreatetruecolor($size, $size);
imagesavealpha($image, true);
$trans = imagecolorallocatealpha($image, 0, 0, 0, 127);
imagefill($image, 0, 0, $trans);
$gold = imagecolorallocate($image, 197, 160, 89);
$center = $size / 2;
$rad = $size * 0.45;
$pts = [];
for ($i = 0; $i < 6; $i++) {
    $ang = pi() / 180 * (60 * $i - 90);
    $pts[] = $center + $rad * cos($ang);
    $pts[] = $center + $rad * sin($ang);
}
imagefilledpolygon($image, $pts, $gold);
imagepng($image, 'favicon.png');
imagepng($image, 'favicon-96x96.png');
imagepng($image, 'favicon-16x16.png');

// Also create .ico if we use a library, or we just copy png to ico as a hack (some browsers support this)
// But for now, let's just make the .ico transparent if possible by saving as png and renaming
copy('favicon.png', 'favicon.ico');

echo "Favicons generados.\n";
