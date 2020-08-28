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
 * Query interface.
 */
interface Query
{
    /**
     * Get query type.
     *
     * @return string
     */
    public function getQueryType(): string;

    /**
     * Get parameter.
     *
     * @param string $parameter
     *
     * @return mixed
     */
    public function get(string $parameter);

    /**
     * Export query parameters.
     *
     * @return array<string, mixed>
     */
    public function getPayload(): array;
}
