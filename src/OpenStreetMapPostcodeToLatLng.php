<?php

namespace KevinRuscoe\PostcodeToLatLng;

use KevinRuscoe\PostcodeToLatLng\Interfaces\PostcodeToLatLngInterface;

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
        $postcode = str_replace(" ", "", $postcode);
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
            throw new \Exception(sprintf("%s is not a valid UK postcode.", $query));
        }

        $postcode = OpenStreetMapPostcodeToLatLng::cleanUpPostcode($query);

        $params = [
            'format' => 'json',
            'q' => $postcode,
            'limit' => 1
        ];

        $url = sprintf(
            "%s?%s",
            'https://nominatim.openstreetmap.org/',
            http_build_query($params)
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
            'latitude' => $response[0]->lat,
            'longitude' => $response[0]->lon
        ];
    }
}
