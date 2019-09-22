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
use Gears\Immutability\ImmutabilityBehaviour;

/**
 * Abstract immutable serializable query.
 */
abstract class AbstractQuery implements Query
{
    use ImmutabilityBehaviour, ScalarPayloadBehaviour {
        ScalarPayloadBehaviour::__call insteadof ImmutabilityBehaviour;
    }

    /**
     * AbstractQuery constructor.
     *
     * @param mixed[] $parameters
     */
    final protected function __construct(array $parameters)
    {
        $this->assertImmutable();

        $this->setPayload($parameters);
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
