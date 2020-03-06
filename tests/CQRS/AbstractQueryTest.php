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

use Gears\CQRS\Exception\QueryException;
use Gears\CQRS\Tests\Stub\AbstractQueryStub;
use PHPUnit\Framework\TestCase;

/**
 * Abstract query test.
 */
class AbstractQueryTest extends TestCase
{
    public function testQueryType(): void
    {
        $stub = AbstractQueryStub::instance();

        static::assertEquals(AbstractQueryStub::class, $stub->getQueryType());
    }

    public function testNoSerialization(): void
    {
        $this->expectException(QueryException::class);
        $this->expectExceptionMessage('Query "Gears\CQRS\Tests\Stub\AbstractQueryStub" cannot be serialized');

        \serialize(AbstractQueryStub::instance());
    }

    public function testNoDeserialization(): void
    {
        $this->expectException(QueryException::class);
        $this->expectExceptionMessage('Query "Gears\CQRS\Tests\Stub\AbstractQueryStub" cannot be unserialized');

        \unserialize('O:39:"Gears\CQRS\Tests\Stub\AbstractQueryStub":0:{}');
    }
}
