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

interface CommandBus
{
    /**
     * Handle command.
     *
     * @param Command $command
     */
    public function handle(Command $command): void;
}
