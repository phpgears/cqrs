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

namespace Gears\CQRS\Tests\Stub;

use Gears\CQRS\AbstractCommand;

/**
 * Abstract command stub class.
 */
class AbstractCommandStub extends AbstractCommand
{
    /**
     * @var string
     */
    private $parameter;

    /**
     * Instantiate command.
     *
     * @param iterable<mixed> $payload
     *
     * @return self
     */
    public static function instance(iterable $payload): self
    {
        return new self($payload);
    }

    /**
     * @return string|null
     */
    public function getParameter(): ?string
    {
        return $this->parameter !== null ? \strtolower($this->parameter) : null;
    }
}
