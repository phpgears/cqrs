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

use Gears\CQRS\Tests\Stub\AbstractEmptyCommandStub;
use PHPUnit\Framework\TestCase;

/**
 * Abstract empty command test.
 */
class AbstractEmptyCommandTest extends TestCase
{
    public function testCommandType(): void
    {
        $stub = AbstractEmptyCommandStub::instance();

        static::assertEquals(AbstractEmptyCommandStub::class, $stub->getCommandType());
    }

    public function testNoPayload(): void
    {
        $stub = AbstractEmptyCommandStub::instance();

        static::assertEquals([], $stub->getPayload());
    }

    public function testToArray(): void
    {
        $stub = AbstractEmptyCommandStub::instance();

        static::assertEquals([], $stub->toArray());
    }

    public function testReconstitution(): void
    {
        $stub = AbstractEmptyCommandStub::reconstitute(['parameter' => 'value']);

        static::assertEquals([], $stub->getPayload());
    }
}
