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

use Gears\CQRS\Tests\Stub\AbstractCommandHandlerStub;
use Gears\CQRS\Tests\Stub\AbstractCommandStub;
use Gears\CQRS\Tests\Stub\AbstractEmptyCommandStub;
use PHPUnit\Framework\TestCase;

/**
 * Abstract command handler test.
 */
class AbstractCommandHandlerTest extends TestCase
{
    /**
     * @expectedException \Gears\CQRS\Exception\InvalidCommandException
     * @expectedExceptionMessageRegExp /Command must be a .+\\AbstractCommandStub, .+ given/
     */
    public function testInvalidCommandType(): void
    {
        $handler = new AbstractCommandHandlerStub();
        $handler->handle(AbstractEmptyCommandStub::instance());
    }

    public function testHandling(): void
    {
        $handler = new AbstractCommandHandlerStub();
        $handler->handle(AbstractCommandStub::instance());

        $this->assertTrue(true);
    }

    public function testReconstitute(): void
    {
        $command = AbstractCommandStub::reconstitute(['parameter' => 'one']);

        $this->assertTrue($command->has('parameter'));

        $emptyCommand = AbstractEmptyCommandStub::reconstitute(['parameter' => 'one']);

        $this->assertFalse($emptyCommand->has('parameter'));
    }
}
