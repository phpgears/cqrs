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

use Gears\CQRS\Exception\InvalidQueryException;
use Gears\CQRS\Exception\InvalidQueryHandlerException;
use Gears\CQRS\Tests\Stub\AbstractEmptyQueryStub;
use Gears\CQRS\Tests\Stub\AbstractQueryHandlerStub;
use Gears\CQRS\Tests\Stub\AbstractQueryStub;
use Gears\CQRS\Tests\Stub\AbstractUnhandledEmptyQueryStub;
use Gears\DTO\DTO;
use PHPUnit\Framework\TestCase;

/**
 * Abstract query handler test.
 */
class AbstractQueryHandlerTest extends TestCase
{
    public function testInvalidQueryType(): void
    {
        $this->expectException(InvalidQueryException::class);
        $this->expectExceptionMessageRegExp('/^Query handler ".+" can only handle ".+" query types, ".+" given$/');

        $handler = new AbstractQueryHandlerStub();
        $handler->handle(AbstractEmptyQueryStub::instance());
    }

    public function testHandling(): void
    {
        $handler = new AbstractQueryHandlerStub();

        static::assertInstanceOf(DTO::class, $handler->handle(AbstractQueryStub::instance([])));
    }

    public function testUnhandledQuery(): void
    {
        $this->expectException(InvalidQueryHandlerException::class);
        $this->expectExceptionMessageRegExp(
            '/^Query handler method "handleAbstractUnhandledEmptyQueryStub" does not exist in ".+"$/'
        );

        $handler = new AbstractQueryHandlerStub();
        $handler->handle(AbstractUnhandledEmptyQueryStub::instance());
    }
}
