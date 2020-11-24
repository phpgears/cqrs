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
use Gears\CQRS\Exception\InvalidCommandHandlerException;
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
                'Command handler "%s" can only handle "%s" command types, "%s" given.',
                static::class,
                \implode('", "', $this->getSupportedCommandTypes()),
                $command->getCommandType()
            ));
        }

        $method = $this->getHandlerMethod($command);
        if (!\method_exists($this, $method)) {
            throw new InvalidCommandHandlerException(
                \sprintf('Command handler method "%s" does not exist in "%s"', $method, static::class)
            );
        }

        $reflection = new \ReflectionMethod(static::class, $method);
        $reflection->setAccessible(true);

        $reflection->invoke($this, $command);
    }

    /**
     * Get method to handle the command.
     *
     * @param Command $command
     *
     * @return string
     */
    protected function getHandlerMethod(Command $command): string
    {
        $typeParts = \explode('\\', $command->getCommandType());
        /** @var string $commandType */
        $commandType = \end($typeParts);

        return 'handle' . \ucfirst($commandType);
    }

    /**
     * Get supported command types.
     *
     * @return string[]
     */
    abstract protected function getSupportedCommandTypes(): array;
}
