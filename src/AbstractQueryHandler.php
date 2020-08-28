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
use Gears\CQRS\Exception\InvalidQueryHandlerException;

abstract class AbstractQueryHandler implements QueryHandler
{
    /**
     * {@inheritdoc}
     *
     * @throws InvalidQueryException
     */
    final public function handle(Query $query)
    {
        if (!\in_array($query->getQueryType(), $this->getSupportedQueryTypes(), true)) {
            throw new InvalidQueryException(\sprintf(
                'Query handler "%s" can only handle "%s" query types, "%s" given',
                static::class,
                \implode('", "', $this->getSupportedQueryTypes()),
                $query->getQueryType()
            ));
        }

        $method = $this->getHandlerMethod($query);
        if (!\method_exists($this, $method)) {
            throw new InvalidQueryHandlerException(
                \sprintf('Query handler method "%s" does not exist in "%s"', $method, static::class)
            );
        }

        $reflection = new \ReflectionMethod(static::class, $method);
        $reflection->setAccessible(true);

        return $reflection->invoke($this, $query);
    }

    /**
     * Get method to handle the query.
     *
     * @param Query $query
     *
     * @return string
     */
    protected function getHandlerMethod(Query $query): string
    {
        $typeParts = \explode('\\', $query->getQueryType());
        /** @var string $queryType */
        $queryType = \end($typeParts);

        return 'handle' . \ucfirst($queryType);
    }

    /**
     * Get supported query types.
     *
     * @return string[]
     */
    abstract protected function getSupportedQueryTypes(): array;
}
