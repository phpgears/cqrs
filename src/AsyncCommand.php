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
 * Asynchronous command interface.
 */
interface AsyncCommand extends Command
{
    /**
     * Reconstitute command.
     *
     * @param mixed[] $parameters
     *
     * @return mixed|self
     */
    public static function reconstitute(array $parameters);
}
