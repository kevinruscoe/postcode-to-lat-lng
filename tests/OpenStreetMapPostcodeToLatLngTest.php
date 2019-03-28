<?php

namespace KevinRuscoe\PostcodeToLatLng\Test;

use PHPUnit\Framework\TestCase;
use KevinRuscoe\PostcodeToLatLng\OpenStreetMapPostcodeToLatLng;

class OpenStreetMapPostcodeToLatLngTest extends TestCase
{
    public function test_it_can_fetch_correctly()
    {
        $result = OpenStreetMapPostcodeToLatLng::search("L4 4EL");

        $this->assertEquals(
            $result,
            [
                "latitude" => "53.4388382063504",
                "longitude" => "-2.96638844396806"
            ]
        );
    }   

    public function test_it_throws_exception()
    {
        $this->expectException(\Exception::class);

        $result = OpenStreetMapPostcodeToLatLng::search("Funky town");
    }
}
