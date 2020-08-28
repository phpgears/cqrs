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

namespace Gears\CQRS\Tests\Stub;

use Gears\CQRS\AbstractCommandHandler;
use Gears\CQRS\Command;

/**
 * Abstract command handler stub class.
 */
final class AbstractCommandHandlerStub extends AbstractCommandHandler
{
    /**
     * {@inheritdoc}
     */
    protected function getSupportedCommandTypes(): array
    {
        return [
            AbstractCommandStub::class,
            AbstractUnhandledEmptyCommandStub::class,
        ];
    }

    /**
     * @param Command $command
     */
    private function handleAbstractCommandStub(Command $command): void
    {
    }
}
