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

use Gears\CQRS\Exception\InvalidCommandException;
use Gears\CQRS\Tests\Stub\AbstractCommandHandlerStub;
use Gears\CQRS\Tests\Stub\AbstractCommandStub;
use Gears\CQRS\Tests\Stub\AbstractEmptyCommandStub;
use PHPUnit\Framework\TestCase;

/**
 * Abstract command handler test.
 */
class AbstractCommandHandlerTest extends TestCase
{
    public function testInvalidCommandType(): void
    {
        $this->expectException(InvalidCommandException::class);
        $this->expectExceptionMessageRegExp(
            '/^Command handler ".+" can only handle ".+\\\AbstractCommandStub" commands, ".+" given\.$/'
        );

        $handler = new AbstractCommandHandlerStub();
        $handler->handle(AbstractEmptyCommandStub::instance());
    }

    public function testHandling(): void
    {
        $handler = new AbstractCommandHandlerStub();
        $handler->handle(AbstractCommandStub::instance());

        static::assertTrue(true);
    }

    public function testReconstitute(): void
    {
        $command = AbstractCommandStub::reconstitute(['parameter' => 'one']);

        static::assertTrue($command->has('parameter'));

        $emptyCommand = AbstractEmptyCommandStub::reconstitute(['parameter' => 'one']);

        static::assertFalse($emptyCommand->has('parameter'));
    }
}
