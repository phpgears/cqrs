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

/**
 * Command interface.
 */
interface Command
{
    /**
     * Get command type.
     *
     * @return string
     */
    public function getCommandType(): string;

    /**
     * Check parameter existence.
     *
     * @param string $parameter
     *
     * @return bool
     */
    public function has(string $parameter): bool;

    /**
     * Get parameter.
     *
     * @param string $parameter
     *
     * @return mixed
     */
    public function get(string $parameter);

    /**
     * Export command parameters.
     *
     * @return array<string, mixed>
     */
    public function getPayload(): array;

    /**
     * Reconstitute command.
     *
     * @param mixed[] $parameters
     *
     * @return mixed|self
     */
    public static function reconstitute(array $parameters);
}
