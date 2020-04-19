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
use Gears\DTO\DTO;

/**
 * Abstract command handler stub class.
 */
class AbstractCommandHandlerStub extends AbstractCommandHandler
{
    /**
     * {@inheritdoc}
     */
    protected function getSupportedCommandType(): string
    {
        return AbstractCommandStub::class;
    }

    /**
     * {@inheritdoc}
     */
    protected function handleCommand(Command $command): ?DTO
    {
        return DTOStub::instance();
    }
}
