<?php

namespace KevinRuscoe\PostcodeToLatLng\Test;

use PHPUnit\Framework\TestCase;
use KevinRuscoe\PostcodeToLatLng\PostcodeIOToLatLng;

class PostcodeIOToLatLngTest extends TestCase
{
    private $finder;

    public function setUp()
    {
        $this->finder = new PostcodeIOToLatLng;
    }
    
    public function test_it_can_fetch_correctly()
    {
        $result = $this->finder
            ->search("L4 4EL");

        $this->assertEquals(
            $result,
            [
                "latitude" => "53.439197",
                "longitude" => "-2.967017"
            ]
        );
    }   

    public function test_it_throws_exception()
    {
        $this->expectException(\Exception::class);

        $this->finder->search("Funky town");
    }
}
