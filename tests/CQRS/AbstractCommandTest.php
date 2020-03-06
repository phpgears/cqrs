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
        $stub = AbstractCommandStub::instance();

        static::assertEquals(AbstractCommandStub::class, $stub->getCommandType());
    }

    public function testReconstitution(): void
    {
        $stub = AbstractCommandStub::reconstitute(['parameter' => 'value']);

        static::assertEquals(['parameter' => 'value'], $stub->getPayload());
    }
}
