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
 * Abstract asynchronous immutable serializable command.
 */
abstract class AbstractAsyncCommand implements AsyncCommand
{
    use ImmutabilityBehaviour, ScalarPayloadBehaviour {
        ScalarPayloadBehaviour::__call insteadof ImmutabilityBehaviour;
    }

    /**
     * AbstractAsyncCommand constructor.
     *
     * @param mixed[] $parameters
     */
    final protected function __construct(array $parameters)
    {
        $this->checkImmutability();

        $this->setPayload($parameters);
    }

    /**
     * {@inheritdoc}
     */
    final public static function reconstitute(array $parameters)
    {
        return new static($parameters);
    }

    /**
     * {@inheritdoc}
     *
     * @return string[]
     */
    final protected function getAllowedInterfaces(): array
    {
        return [AsyncCommand::class];
    }
}
