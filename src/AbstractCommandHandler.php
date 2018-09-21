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
        $supportedCommandType = $this->getSupportedCommandType();
        if (!\is_a($command, $supportedCommandType)) {
            throw new InvalidCommandException(\sprintf(
                'Command must be a %s, %s given',
                $supportedCommandType,
                \get_class($command)
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
    abstract protected function handleCommand(Command $command): void;
}
