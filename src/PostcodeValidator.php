<?php

namespace KevinRuscoe\PostcodeToLatLng;

class PostcodeValidator
{
    /**
     * Validates a postcode.
     *
     * @param string $postcode
     * @see https://stackoverflow.com/a/14935054
     * @return bool
     */
    public static function validate(string $postcode)
    {
        $regex = '#^(GIR ?0AA|[A-PR-UWYZ]([0-9]{1,2}|([A-HK-Y][0-9]([0-9ABEHMNPRV-Y])?)|[0-9][A-HJKPS-UW]) ?[0-9][ABD-HJLNP-UW-Z]{2})$#';

        return (bool) preg_match($regex, strtoupper($postcode));
    }
}
