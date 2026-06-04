 
<?php

if (!function_exists('productImage')) {
    function productImage($image) {
        if (!$image) return null;
        
        if (str_starts_with($image, 'http')) {
            return $image;
        }
        
        return secure_asset('storage/' . $image);
    }
}