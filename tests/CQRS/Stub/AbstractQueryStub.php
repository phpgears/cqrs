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

use Gears\CQRS\AbstractQuery;

/**
 * Abstract query stub class.
 */
class AbstractQueryStub extends AbstractQuery
{
    /**
     * Instantiate query.
     *
     * @return self
     */
    public static function instance(): self
    {
        return new self([]);
    }
}
