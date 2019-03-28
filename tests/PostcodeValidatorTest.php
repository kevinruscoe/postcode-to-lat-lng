<?php

namespace KevinRuscoe\PostcodeToLatLng\Test;

use PHPUnit\Framework\TestCase;
use KevinRuscoe\PostcodeToLatLng\PostcodeValidator;

class PostcodeValidatorTest extends TestCase
{
    public function test_it_can_validate()
    {
        $this->assertTrue(PostcodeValidator::validate("L4 4EL"));
        $this->assertTrue(PostcodeValidator::validate("l4 4el"));
        $this->assertTrue(PostcodeValidator::validate("L44EL"));
        $this->assertTrue(PostcodeValidator::validate("l44el"));
        $this->assertTrue(PostcodeValidator::validate("l44El"));

        $this->assertFalse(PostcodeValidator::validate("l44E l"));
        $this->assertFalse(PostcodeValidator::validate("l 44El"));
        $this->assertFalse(PostcodeValidator::validate(""));
    }
}
