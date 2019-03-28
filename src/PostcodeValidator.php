<?php

namespace KevinRuscoe\PostcodeToLatLng;

class PostcodeValidator
{
    /**
     * Validates a postcode.
     *
     * @param string $postcode
     * @return bool
     */
    public static function validate(string $postcode)
    {
        $regex = '/[A-Z]{1,2}\d[A-Z\d]? ?\d[A-Z]{2}/m';

        return preg_match($postcode, $regex);
    }
}
