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
        $supportedQueryType = $this->getSupportedQueryType();
        if (!\is_a($query, $supportedQueryType)) {
            throw new InvalidQueryException(\sprintf(
                'Query command must be a "%s", "%s" given',
                $supportedQueryType,
                \get_class($query)
            ));
        }

        return $this->handleQuery($query);
    }

    /**
     * Get supported query type.
     *
     * @return string
     */
    abstract protected function getSupportedQueryType(): string;

    /**
     * Handle query.
     *
     * @param Query $query
     *
     * @return DTO
     */
    abstract protected function handleQuery(Query $query): DTO;
}
