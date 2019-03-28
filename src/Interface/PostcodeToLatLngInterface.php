<?php

namespace KevinRuscoe\PostcodeToLatLng\Interface;

interface PostcodeToLatLngInterface
{
    /**
     * Searches for a postcode and returns a lat/lng array.
     *
     * @param string $query
     * @throws \Exception
     * @return array
     */
    public function search($query);
}
