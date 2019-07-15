<?php

namespace KevinRuscoe\PostcodeToLatLng;

use KevinRuscoe\PostcodeToLatLng\Interfaces\PostcodeToLatLngInterface;

class PostcodeIOToLatLng implements PostcodeToLatLngInterface
{
    /**
     * Turns Rf555GB into RF55 5GB because OSM is fussy.
     *
     * @param string $postcode
     * @return string
     */
    public static function cleanUpPostcode(string $postcode)
    {
        return strtoupper(str_replace(" ", "", $postcode));
    }

    /**
     * Searches for a postcode and returns a lat/lng array.
     *
     * @param string $query
     * @throws \Exception
     * @return array
     */
    public function search(string $query)
    {
        if (! PostcodeValidator::validate($query)) {
            throw new \Exception(sprintf("%s is not a valid UK postcode.", $query));
        }

        $postcode = PostcodeIOToLatLng::cleanUpPostcode($query);

        $url = sprintf(
            "%s/%s",
            'https://postcodes.io/postcodes/',
            $postcode
        );

        $handle = curl_init();

        curl_setopt_array($handle, [
            CURLOPT_URL => $url,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.2 (KHTML, like Gecko) Chrome/22.0.1216.0 Safari/537.2',
            CURLOPT_RETURNTRANSFER => true
        ]);

        $response = curl_exec($handle);

        $httpStatus = curl_getinfo($handle, CURLINFO_HTTP_CODE);

        curl_close($handle);

        if ($httpStatus !== 200) {
            throw new \Exception('Failed to fetch postcode.');
        }

        $response = json_decode($response);

        if (empty($response)) {
            throw new \Exception('Failed to fetch postcode.');
        }

        return [
            'latitude' => $response->result->latitude,
            'longitude' => $response->result->longitude
        ];
    }
}
