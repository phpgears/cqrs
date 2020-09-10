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

use Gears\DTO\PayloadBehaviour;

/**
 * Abstract empty immutable serializable command.
 */
abstract class AbstractEmptyCommand implements Command, \Serializable
{
    use PayloadBehaviour;

    /**
     * AbstractEmptyCommand constructor.
     */
    final public function __construct()
    {
        $this->setPayload(null);
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
    final public function getPayload(): array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    final public function toArray(): array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    final public static function reconstitute(iterable $payload)
    {
        $commandClass = static::class;

        return new $commandClass();
    }

    /**
     * @return array<string, mixed>
     */
    public function __serialize(): array
    {
        return [];
    }

    /**
     * @param array<string, mixed> $data
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function __unserialize(array $data): void
    {
        $this->setPayload([]);
    }

    /**
     * {@inheritdoc}
     */
    public function serialize(): string
    {
        return \serialize([]);
    }

    /**
     * {@inheritdoc}
     *
     * @param mixed $serialized
     */
    public function unserialize($serialized): void
    {
        $this->setPayload([]);
    }

    /**
     * {@inheritdoc}
     *
     * @return string[]
     */
    final protected function getAllowedInterfaces(): array
    {
        return [Command::class, \Serializable::class];
    }
}
