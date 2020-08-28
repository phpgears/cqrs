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

use Gears\CQRS\AbstractQueryHandler;
use Gears\CQRS\Query;
use Gears\DTO\DTO;

/**
 * Abstract query handler stub class.
 */
final class AbstractQueryHandlerStub extends AbstractQueryHandler
{
    /**
     * {@inheritdoc}
     */
    protected function getSupportedQueryTypes(): array
    {
        return [
            AbstractQueryStub::class,
            AbstractUnhandledEmptyQueryStub::class,
        ];
    }

    /**
     * @param Query $query
     *
     * @return DTO
     */
    private function handleAbstractQueryStub(Query $query): DTO
    {
        return DTOStub::instance();
    }
}
