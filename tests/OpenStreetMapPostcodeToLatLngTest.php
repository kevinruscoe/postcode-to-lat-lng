<?php

namespace KevinRuscoe\PostcodeToLatLng\Test;

use PHPUnit\Framework\TestCase;
use KevinRuscoe\PostcodeToLatLng\OpenStreetMapPostcodeToLatLng;

class OpenStreetMapPostcodeToLatLngTest extends TestCase
{
    public function test_it_can_fetch_correctly()
    {
        $result = OpenStreetMapPostcodeToLatLng::search("L4 4EL");

        var_dump($result);

        

        $this->assertTrue(true);

    }   
}
