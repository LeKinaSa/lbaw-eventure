<?php

namespace App;

class Utils {
    public static function convertImageToBase64($image) {
        list($width, $height) = getimagesize($image);

        if ($image->extension() === 'png') {
            $original = imagecreatefrompng($image);
        }
        else if ($image->extension() === 'jpeg' || $image->extension() === 'jpg') {
            $original = imagecreatefromjpeg($image);
        }
        else {
            // Invalid file extension
            return NULL;
        }

        $square = min($width, $height);

        // Resize the uploaded image to 500x500 pixels
        $resized = imagecreatetruecolor(500, 500);
        imagecopyresized($resized, $original, 0, 0, ($width > $square) ? ($width - $square) / 2 : 0,
                ($height > $square) ? ($height - $square) / 2 : 0, 500, 500, $square, $square);

        // Using output buffering to store the result of imagejpeg into a string
        ob_start();
        imagejpeg($resized);
        $pictureString = ob_get_contents(); // Read string from buffer
        ob_end_clean();

        return base64_encode($pictureString);
    }
}