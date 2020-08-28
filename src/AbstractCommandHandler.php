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

namespace Gears\CQRS;

use Gears\CQRS\Exception\InvalidCommandException;
use Gears\CQRS\Exception\InvalidQueryException;

abstract class AbstractCommandHandler implements CommandHandler
{
    /**
     * {@inheritdoc}
     *
     * @throws InvalidQueryException
     */
    final public function handle(Command $command): void
    {
        if (!\in_array($command->getCommandType(), $this->getSupportedCommandTypes(), true)) {
            throw new InvalidCommandException(\sprintf(
                'Command handler "%s" can only handle "%s" command types, "%s" given',
                static::class,
                \implode('", "', $this->getSupportedCommandTypes()),
                $command->getCommandType()
            ));
        }

        $this->handleCommand($command);
    }

    /**
     * Get supported command types.
     *
     * @return string[]
     */
    abstract protected function getSupportedCommandTypes(): array;

    /**
     * Handle command.
     *
     * @param Command $command
     */
    abstract protected function handleCommand(Command $command): void;
}
