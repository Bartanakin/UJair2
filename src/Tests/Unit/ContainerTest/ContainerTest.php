<?php

namespace Tests\Unit\ContainerTest;

use App\Container;
use App\Exceptions\Container\ContainerException;
use PHPUnit\Framework\TestCase;
use Tests\Unit\ContainerTest\TestHelpers\TestHelperClass;
use Tests\Unit\ContainerTest\TestHelpers\TestHelperClassWithConstructor;
use Tests\Unit\ContainerTest\TestHelpers\TestHelperClassWithoutConstructor;
use Tests\Unit\ContainerTest\TestHelpers\TestHelperInterface;

class ContainerTest extends TestCase
{
    private Container $container;
    private $user;

    protected function setUp(): void {
        parent::setUp();
        $this -> container = new Container();

        $this -> user = new class() {};

    }

    /** @test */
    public function it_checks_has_function(){

        $this -> container -> set( $this -> user::class, fn() => ( new ($this -> user::class)() ) );

        self::assertTrue($this -> container -> has( $this -> user::class));
    }

    /** @test */
    public function it_checks_callable_case(){

        $test_call = (fn(Container $c) => true);

        $this -> container -> set($this -> user::class, $test_call);

        self::assertTrue($this -> container -> get($this -> user::class));
    }
    /** @test */
    public function it_checks_not_callable_case_for_get_with_setting(){


        $this -> container -> set(TestHelperInterface::class, TestHelperClass::class);

        $this -> assertInstanceOf(TestHelperClass::class,$this -> container -> get(TestHelperInterface::class));
    }
    /** @test */
    public function it_checks_not_callable_case_for_get_without_setting(){

        $this -> assertInstanceOf(TestHelperClass::class,$this -> container -> get(TestHelperClass::class));

    }

    /** @test */
    public function it_checks_resolve_for_uninstantiable_class(){

        $this -> expectException(ContainerException::class);
        $this -> expectExceptionMessage("Class ".TestHelperInterface::class." is not instantiable");

        $this -> container -> resolve(TestHelperInterface::class);
    }

    /** @test */
    public function it_checks_resolve_without_constructor(){

        $this -> assertInstanceOf(
            TestHelperClassWithoutConstructor::class,
            $this -> container -> resolve(TestHelperClassWithoutConstructor::class)
        );
    }
    /** @test */
    public function it_checks_resolve_with_constructor(){

        $this -> assertInstanceOf(
            TestHelperClassWithConstructor::class,
            $this -> container -> resolve(TestHelperClassWithConstructor::class)
        );
    }

    // TODO
    // dependencies handling...
}