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

use Gears\DTO\ScalarPayloadBehaviour;

/**
 * Abstract immutable serializable command.
 */
abstract class AbstractCommand implements Command, \Serializable
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
     * @return array<string, mixed>
     */
    public function __serialize(): array
    {
        return ['payload' => $this->getPayloadRaw()];
    }

    /**
     * @param array<string, mixed> $data
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function __unserialize(array $data): void
    {
        $this->setPayload($data['payload']);
    }

    /**
     * {@inheritdoc}
     */
    public function serialize(): string
    {
        return \serialize($this->getPayloadRaw());
    }

    /**
     * {@inheritdoc}
     *
     * @param mixed $serialized
     */
    public function unserialize($serialized): void
    {
        $this->setPayload(\unserialize($serialized, ['allowed_classes' => false]));
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
