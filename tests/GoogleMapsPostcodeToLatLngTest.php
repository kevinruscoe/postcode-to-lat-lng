<?php

namespace KevinRuscoe\PostcodeToLatLng\Test;

use PHPUnit\Framework\TestCase;
use KevinRuscoe\PostcodeToLatLng\GoogleMapsPostcodeToLatLng;

class GoogleMapsPostcodeToLatLngTest extends TestCase
{
    private $finder;

    public function setUp()
    {
        $this->finder = new GoogleMapsPostcodeToLatLng;
    }
    
    public function test_it_can_fetch_correctly()
    {
        $result = $this->finder
            ->setApiKey('bla-bla-bla')
            ->search("L4 4EL");

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
}
