<?php
/*
 * picture.php
 * Nathan NICART & Quentin LAHOUSSE
 */
declare(strict_types=1);

use Entity\Collection\PictureCollection;
use Entity\Exception\EntityNotFoundException;
use Entity\Exception\ParameterException;
use Entity\Picture;

try {
    ctype_digit($_GET["imageId"]);
} catch (ParameterException) {
    http_response_code(400);
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (Exception) {
    http_response_code(500);
}

$stmt = PictureCollection::findById(intval($_GET["imageId"]));
header('Content-Type: image/jpeg');

echo $stmt->getJpeg();
