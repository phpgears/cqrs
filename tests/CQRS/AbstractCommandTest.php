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

    public function testReconstitute(): void
    {
        $stub = AbstractCommandStub::reconstitute(['parameter' => 'value']);

        static::assertEquals(['parameter' => 'value'], $stub->getPayload());
    }

    public function testSerialization(): void
    {
        $stub = AbstractCommandStub::instance(['parameter' => 'value']);

        $serialized = \version_compare(\PHP_VERSION, '7.4.0') >= 0
            ? 'O:41:"Gears\CQRS\Tests\Stub\AbstractCommandStub":1:{s:9:"parameter";s:5:"value";}'
            : 'C:41:"Gears\CQRS\Tests\Stub\AbstractCommandStub":34:{a:1:{s:9:"parameter";s:5:"value";}}';

        static::assertSame($serialized, \serialize($stub));

        /** @var AbstractCommandStub $unserializedStub */
        $unserializedStub = \unserialize($serialized);
        static::assertSame($stub->getPayload(), $unserializedStub->getPayload());
    }
}
