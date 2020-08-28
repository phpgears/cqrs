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
 * Abstract empty immutable query.
 */
abstract class AbstractEmptyQuery implements Query
{
    use PayloadBehaviour;

    /**
     * AbstractEmptyQuery constructor.
     */
    final public function __construct()
    {
        $this->setPayload(null);
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
     */
    final public function getPayload(): array
    {
        return [];
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
