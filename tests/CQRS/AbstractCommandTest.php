<?php

/*
 * cqrs (https://github.com/phpgears/cqrs).
 * CQRS base.
 *
 * @license MIT
 * @link https://github.com/phpgears/cqrs
 * @author Julián Gutiérrez <juliangut@gmail.com>
 */

declare(strict_types=1);

namespace Gears\CQRS\Tests;

use Gears\CQRS\Exception\CommandException;
use Gears\CQRS\Tests\Stub\AbstractCommandStub;
use PHPUnit\Framework\TestCase;

/**
 * Abstract command test.
 */
class AbstractCommandTest extends TestCase
{
    public function testCommandType(): void
    {
        $stub = AbstractCommandStub::instance([]);

        static::assertEquals(AbstractCommandStub::class, $stub->getCommandType());
    }

    public function testNoPayload(): void
    {
        $stub = AbstractCommandStub::instance([]);

        static::assertEquals(['parameter' => null], $stub->getPayload());
    }

    public function testPayload(): void
    {
        $stub = AbstractCommandStub::instance(['parameter' => 'Value']);

        static::assertEquals(['parameter' => 'value'], $stub->getPayload());
    }

    public function testToArray(): void
    {
        $stub = AbstractCommandStub::instance(['parameter' => 'Value']);

        static::assertEquals(['parameter' => 'Value'], $stub->toArray());
    }

    public function testReconstitution(): void
    {
        $stub = AbstractCommandStub::reconstitute(['parameter' => 'value']);

        static::assertEquals(['parameter' => 'value'], $stub->getPayload());
    }

    public function testNoSerialization(): void
    {
        $this->expectException(CommandException::class);
        $this->expectExceptionMessage('Command "Gears\CQRS\Tests\Stub\AbstractCommandStub" cannot be serialized');

        \serialize(AbstractCommandStub::instance([]));
    }

    public function testNoDeserialization(): void
    {
        $this->expectException(CommandException::class);
        $this->expectExceptionMessage('Command "Gears\CQRS\Tests\Stub\AbstractCommandStub" cannot be unserialized');

        \unserialize('O:41:"Gears\CQRS\Tests\Stub\AbstractCommandStub":0:{}');
    }
}
