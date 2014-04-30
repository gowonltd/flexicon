<?php

function sort_size() {
    return function ($a, $b) {
        if ($a['size'] == $b['size']) {
            return 0;
        }
        return ($a['size'] < $b['size']) ? -1 : 1;
    };
}

// Determine valid PNG files
$images = array();
$query = array();
$icon_sizes = array(
    array( 16, 16 ),
    array( 24, 24 ),
    array( 32, 32 ),
    array( 48, 48 )
);

$files = glob("*.png", GLOB_NOSORT);
foreach ($files as $file) {
    $image = array();
    $image['src'] = $file;
    list($image['size'], $height) = getimagesize($file);

    if ($image['size'] == $height) {
        $images[] = $image;
    }
}
usort($images, sort_size());


// Determine input params
$uri = explode('/',
    preg_replace('/\/{0,1}((\/?\?|\/?\#)([^\s])*)?$/', '', substr($_SERVER["REQUEST_URI"], strlen(substr($_SERVER["PHP_SELF"], 0, -9)))),
    2);

if (isset($_GET['type'])) {
    $format = ($_GET['type'] == 'ico') ? 'ico': 'png';
    $size = ($_GET['type'] == 'ico') ? false: $_GET['size'];
}
else if ($uri[0] != '') {
    $format = ($uri[0] == 'ico') ? 'ico': 'png';
    $size = ($uri[0] == 'ico') ? false: $uri[1];
}
else {
    header('HTTP/1.1 400 Bad Request' );
    exit;
}

// Output
if ($format == 'ico') {
    header("Content-type: image/x-icon");
    header('Content-Disposition: inline; filename="favicon.ico"');
}
else {
    header('Content-Type: image/png');
    header('Content-Disposition: inline; filename="favicon-' . $size . '.png"');

    for ($i = 0, $len = count($images); $i < $len; $i++) {
        if($i == ($len - 1) || $size < $images[$i]['size']) {
            // Output image
            $source = imagecreatefrompng($images[$i]['src']);
            $output = imagecreatetruecolor($size, $size);
            imagealphablending( $output, false );
            imagesavealpha( $output, true );
            imagecopyresampled($output, $source, 0, 0, 0, 0, $size, $size, $images[$i]['size'], $images[$i]['size']);
            imagepng($output);
            break;
        }
    }
}
exit;


/*
require( dirname( __FILE__ ) . '/class-php-ico.php' );

$source = dirname( __FILE__ ) . '/icon.png';
$destination = dirname( __FILE__ ) . '/example.ico';

$ico_sizes = array(
    array( 16, 16 ),
    array( 24, 24 ),
    array( 32, 32 ),
    array( 48, 48 )
);

$ico_lib = new PHP_ICO( $source, $ico_sizes );

if ($_GET["format"] == "ico") {
    $ico_lib->OutputIco();
}
else if ($_GET["format"] == "png") {
    $size = 152;
    if (isset($_GET["size"])) {
        $size = $_GET["size"];
    }
    $ico_lib->OutputPng($size);
}
//*/