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

use Gears\CQRS\Exception\CommandException;
use Gears\DTO\ScalarPayloadBehaviour;

/**
 * Abstract immutable serializable command.
 */
abstract class AbstractCommand implements Command
{
    use ScalarPayloadBehaviour;

    /**
     * AbstractCommand constructor.
     *
     * @param iterable<mixed> $payload
     */
    final protected function __construct(iterable $payload)
    {
        $this->setPayload($payload);
    }

    /**
     * {@inheritdoc}
     */
    public function getCommandType(): string
    {
        return static::class;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        return $this->getPayloadRaw();
    }

    /**
     * {@inheritdoc}
     */
    final public static function reconstitute(iterable $payload)
    {
        $commandClass = static::class;

        return new $commandClass($payload);
    }

    /**
     * {@inheritdoc}
     *
     * @return string[]
     */
    final protected function getAllowedInterfaces(): array
    {
        return [Command::class];
    }

    /**
     * @return string[]
     */
    final public function __sleep(): array
    {
        throw new CommandException(\sprintf('Command "%s" cannot be serialized', static::class));
    }

    final public function __wakeup(): void
    {
        throw new CommandException(\sprintf('Command "%s" cannot be unserialized', static::class));
    }

    /**
     * @return array<string, mixed>
     */
    final public function __serialize(): array
    {
        throw new CommandException(\sprintf('Command "%s" cannot be serialized', static::class));
    }

    /**
     * @param array<string, mixed> $data
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    final public function __unserialize(array $data): void
    {
        throw new CommandException(\sprintf('Command "%s" cannot be unserialized', static::class));
    }
}
