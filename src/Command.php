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
     * Export command properties as array.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array;

    /**
     * Reconstitute command.
     *
     * @param iterable<mixed> $payload
     *
     * @return static
     */
    public static function reconstitute(iterable $payload);
}
