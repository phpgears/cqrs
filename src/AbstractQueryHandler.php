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

use Gears\CQRS\Exception\InvalidQueryException;
use Gears\DTO\DTO;

abstract class AbstractQueryHandler implements QueryHandler
{
    /**
     * {@inheritdoc}
     *
     * @throws InvalidQueryException
     */
    final public function handle(Query $query): DTO
    {
        if (!\in_array($query->getQueryType(), $this->getSupportedQueryTypes(), true)) {
            throw new InvalidQueryException(\sprintf(
                'Query handler "%s" can only handle "%s" query types, "%s" given',
                static::class,
                \implode('", "', $this->getSupportedQueryTypes()),
                $query->getQueryType()
            ));
        }

        return $this->handleQuery($query);
    }

    /**
     * Get supported query types.
     *
     * @return string[]
     */
    abstract protected function getSupportedQueryTypes(): array;

    /**
     * Handle query.
     *
     * @param Query $query
     *
     * @return DTO
     */
    abstract protected function handleQuery(Query $query): DTO;
}
