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
use Gears\Immutability\ImmutabilityBehaviour;

/**
 * Abstract empty immutable serializable command.
 */
abstract class AbstractEmptyCommand implements Command
{
    use ImmutabilityBehaviour, ScalarPayloadBehaviour {
        ScalarPayloadBehaviour::__call insteadof ImmutabilityBehaviour;
    }

    /**
     * AbstractEmptyCommand constructor.
     */
    final protected function __construct()
    {
        $this->assertImmutable();
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
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    final public static function reconstitute(array $parameters)
    {
        $commandClass = static::class;

        return new $commandClass();
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
     * {@inheritdoc}
     *
     * @return string[]
     */
    final protected function getAllowedInterfaces(): array
    {
        return [Command::class];
    }
}
