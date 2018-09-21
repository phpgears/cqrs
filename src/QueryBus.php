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

use Gears\DTO\DTO;

interface QueryBus
{
    /**
     * Handle query command.
     *
     * @param Query $query
     *
     * @return DTO
     */
    public function handle(Query $query): DTO;
}
