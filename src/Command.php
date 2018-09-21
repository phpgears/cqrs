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
}
