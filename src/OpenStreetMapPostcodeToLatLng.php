<?php

namespace KevinRuscoe\PostcodeToLatLng;

use KevinRuscoe\PostcodeToLatLng\Interface\PostcodeToLatLngInterface;

class OpenStreetMapPostcodeToLatLng implements PostcodeToLatLngInterface
{
    /**
     * Turns Rf555GB into RF55 5GB because OSM is fussy.
     *
     * @param string $postcode
     * @return string
     */
    public static function cleanUpPostcode(string $postcode)
    {
        $firstPart = substr($postcode, 0, -3);
        $secondPart = str_replace($firstPart, '', $postcode);

        return strtoupper(sprintf("%s %s", $firstPart, $secondPart));
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
            throw new Exception(sprintf("%s is not a valid UK postcode.", $query));
        }

        $postcode = OpenStreetMapPostcodeToLatLng::cleanUpPostcode($query);

        $url = sprintf("%s?%s", 'https://nominatim.openstreetmap.org/', http_build_query([
            'format' => 'json',
            'q' => $postcode,
            'limit' => 1
        ]));

        $handle = curl_init();

        curl_setopt_array($handle, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true
        ]);

        $httpStatus = curl_getinfo($handle, CURLINFO_HTTP_CODE);

        $response = curl_exec($handle);

        curl_close($handle);

        if ($httpStatus !== 200) {
            throw new Exception('Failed to fetch postcode.');
        }

        $response = json_decode($response);

        if (empty($response)) {
            throw new Exception('Failed to fetch postcode.');
        }

        return [
            'latitude' => $response[0]['lat'],
            'longitude' => $response[0]['lon']
        ];
    }
}
