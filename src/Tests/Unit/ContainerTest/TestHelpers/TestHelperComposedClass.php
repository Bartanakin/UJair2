<?php

namespace Tests\Unit\ContainerTest\TestHelpers;

class TestHelperComposedClass
{
    public function __construct(
        protected TestHelperClassWithoutConstructor $p1,
        protected TestHelperClassWithConstructor    $p2
    ){

    }
}