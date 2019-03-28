<?php

namespace KevinRuscoe\PostcodeToLatLng\Test;

use PHPUnit\Framework\TestCase;
use KevinRuscoe\PostcodeToLatLng\OpenStreetMapPostcodeToLatLng;

class OpenStreetMapPostcodeToLatLngTest extends TestCase
{
    private $finder;

    public function setUp()
    {
        $this->finder = new OpenStreetMapPostcodeToLatLng;
    }

    public function test_it_can_fetch_correctly()
    {
        $result = $this->finder->search("L4 4EL");

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

        $this->finder->search("Funky town");
    }

    public function test_it_throws_exception_without_an_api_key()
    {
        $this->expectException(\Exception::class);

        $this->finder->search("Funky town");
    }
}
