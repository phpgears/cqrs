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
 * Abstract immutable query.
 */
abstract class AbstractQuery implements Query
{
    use PayloadBehaviour;

    /**
     * AbstractQuery constructor.
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
    public function getQueryType(): string
    {
        return static::class;
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
