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

namespace Gears\CQRS\Tests;

use Gears\CQRS\Tests\Stub\AbstractEmptyQueryStub;
use PHPUnit\Framework\TestCase;

/**
 * Abstract empty query test.
 */
class AbstractEmptyQueryTest extends TestCase
{
    public function testQueryType(): void
    {
        $stub = AbstractEmptyQueryStub::instance();

        static::assertEquals(AbstractEmptyQueryStub::class, $stub->getQueryType());
    }
}
