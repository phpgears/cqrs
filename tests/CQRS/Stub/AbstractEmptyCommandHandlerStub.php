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
class AbstractEmptyCommandHandlerStub extends AbstractCommandHandler
{
    /**
     * {@inheritdoc}
     */
    protected function getSupportedCommandTypes(): array
    {
        return [AbstractEmptyCommandStub::class];
    }

    /**
     * {@inheritdoc}
     */
    protected function handleCommand(Command $command): void
    {
    }
}
