<?php

namespace KevinRuscoe\PostcodeToLatLng\Interfaces;

interface PostcodeToLatLngInterface
{
    /**
     * Searches for a postcode and returns a lat/lng array.
     *
     * @param string $query
     * @throws \Exception
     * @return array
     */
    public static function search(string $query);
}
