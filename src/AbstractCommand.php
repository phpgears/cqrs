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
}
