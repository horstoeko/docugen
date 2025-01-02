<?php

namespace horstoeko\docugen\tests\testcases;

use horstoeko\docugen\tests\TestCase;

class BasicTest extends TestCase
{
    public function testSoundCheck(): void
    {
        $this->assertTrue(true); // @phpstan-ignore method.alreadyNarrowedType
    }
}
