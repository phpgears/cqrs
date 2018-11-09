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

use Gears\CQRS\AbstractEmptyCommand;

/**
 * Abstract empty command stub class.
 */
class AbstractEmptyCommandStub extends AbstractEmptyCommand
{
    /**
     * Instantiate command.
     *
     * @return self
     */
    public static function instance(): self
    {
        return new self();
    }
}
