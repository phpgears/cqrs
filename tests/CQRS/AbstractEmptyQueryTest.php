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

    public function testNoPayload(): void
    {
        $stub = AbstractEmptyQueryStub::instance();

        static::assertEquals([], $stub->getPayload());
    }

    public function testNoSerialization(): void
    {
        $this->expectException(QueryException::class);
        $this->expectExceptionMessage('Query "Gears\CQRS\Tests\Stub\AbstractEmptyQueryStub" cannot be serialized');

        \serialize(AbstractEmptyQueryStub::instance());
    }

    public function testNoDeserialization(): void
    {
        $this->expectException(QueryException::class);
        $this->expectExceptionMessage('Query "Gears\CQRS\Tests\Stub\AbstractEmptyQueryStub" cannot be unserialized');

        \unserialize('O:44:"Gears\CQRS\Tests\Stub\AbstractEmptyQueryStub":0:{}');
    }
}
