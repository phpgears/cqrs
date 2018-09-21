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

use Gears\CQRS\AbstractCommand;
use Gears\CQRS\Tests\Stub\AbstractCommandHandlerStub;
use Gears\CQRS\Tests\Stub\AbstractCommandStub;
use PHPUnit\Framework\TestCase;

/**
 * Abstract command handler test.
 */
class AbstractCommandHandlerTest extends TestCase
{
    public function testHandling(): void
    {
        $handler = new AbstractCommandHandlerStub();
        $handler->handle(AbstractCommandStub::instance());

        $this->assertTrue(true);
    }

    /**
     * @expectedException \Gears\CQRS\Exception\InvalidCommandException
     * @expectedExceptionMessageRegExp /Command must be a .+\\AbstractCommandStub, .+ given/
     */
    public function testInvalidCommandType(): void
    {
        /** @var AbstractCommand $command */
        $command = $this->getMockBuilder(AbstractCommand::class)
            ->disableOriginalConstructor()
            ->getMock();

        $handler = new AbstractCommandHandlerStub();
        $handler->handle($command);
    }
}
