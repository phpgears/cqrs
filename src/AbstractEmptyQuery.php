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

use Gears\CQRS\Exception\QueryException;
use Gears\DTO\ScalarPayloadBehaviour;
use Gears\Immutability\ImmutabilityBehaviour;

/**
 * Abstract empty immutable query.
 */
abstract class AbstractEmptyQuery implements Query
{
    use ImmutabilityBehaviour, ScalarPayloadBehaviour {
        ScalarPayloadBehaviour::__call insteadof ImmutabilityBehaviour;
    }

    /**
     * AbstractEmptyQuery constructor.
     */
    final protected function __construct()
    {
        $this->assertImmutable();
    }

    /**
     * {@inheritdoc}
     */
    public function getQueryType(): string
    {
        return static::class;
    }

    /**
     * @return array<string, mixed>
     */
    final public function __serialize(): array
    {
        throw new QueryException(\sprintf('Query "%s" cannot be serialized', static::class));
    }

    /**
     * @param array<string, mixed> $data
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    final public function __unserialize(array $data): void
    {
        throw new QueryException(\sprintf('Query "%s" cannot be unserialized', static::class));
    }

    /**
     * @return string[]
     */
    final public function __sleep(): array
    {
        throw new QueryException(\sprintf('Query "%s" cannot be serialized', static::class));
    }

    final public function __wakeup(): void
    {
        throw new QueryException(\sprintf('Query "%s" cannot be unserialized', static::class));
    }

    /**
     * {@inheritdoc}
     *
     * @return string[]
     */
    final protected function getAllowedInterfaces(): array
    {
        return [Query::class];
    }
}
