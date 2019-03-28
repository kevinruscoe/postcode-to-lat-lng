<?php

namespace KevinRuscoe\PostcodeToLatLng;

use KevinRuscoe\PostcodeToLatLng\Interface\PostcodeToLatLngInterface;

class GoogleMapsPostcodeToLatLng implements PostcodeToLatLngInterface
{
    private $apiKey = null;

    /**
     * Set's the Google API Key.
     *
     * @param string
     * @return GoogleMapsPostcodeToLatLng
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;

        return $this;
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

        $postcode = $query;

        $params = [
            'address' => $postcode,
            'sensor' => 'false',
            'components' => 'country:UK'
        ];

        if ($this->apiKey) {
            $params['key'] = $this->apiKey;
        }

        $url = sprintf(
            "%s?%s",
            'https://maps.googleapis.com/maps/api/geocode/json',
            http_build_query($params)
        );

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
            'latitude' => $response['results'][0]['geometry']['location']['lat'],
            'longitude' => $response['results'][0]['geometry']['location']['lng']
        ];
    }
}
