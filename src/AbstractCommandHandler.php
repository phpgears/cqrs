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
use Gears\DTO\DTO;

abstract class AbstractCommandHandler implements CommandHandler
{
    /**
     * {@inheritdoc}
     *
     * @throws InvalidQueryException
     */
    final public function handle(Command $command): ?DTO
    {
        if ($command->getCommandType() !== $this->getSupportedCommandType()) {
            throw new InvalidCommandException(\sprintf(
                'Command handler "%s" can only handle "%s" commands, "%s" given',
                self::class,
                $this->getSupportedCommandType(),
                $command->getCommandType()
            ));
        }

        $this->handleCommand($command);
    }

    /**
     * Get supported command type.
     *
     * @return string
     */
    abstract protected function getSupportedCommandType(): string;

    /**
     * Handle command.
     *
     * @param Command $command
     */
    abstract protected function handleCommand(Command $command): ?DTO;
}
