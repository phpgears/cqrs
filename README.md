[![PHP version](https://img.shields.io/badge/PHP-%3E%3D7.1-8892BF.svg?style=flat-square)](http://php.net)
[![Latest Version](https://img.shields.io/packagist/v/phpgears/cqrs.svg?style=flat-square)](https://packagist.org/packages/phpgears/cqrs)
[![License](https://img.shields.io/github/license/phpgears/cqrs.svg?style=flat-square)](https://github.com/phpgears/cqrs/blob/master/LICENSE)

[![Build Status](https://img.shields.io/travis/phpgears/cqrs.svg?style=flat-square)](https://travis-ci.org/phpgears/cqrs)
[![Style Check](https://styleci.io/repos/149037552/shield)](https://styleci.io/repos/149037552)
[![Code Quality](https://img.shields.io/scrutinizer/g/phpgears/cqrs.svg?style=flat-square)](https://scrutinizer-ci.com/g/phpgears/cqrs)
[![Code Coverage](https://img.shields.io/coveralls/phpgears/cqrs.svg?style=flat-square)](https://coveralls.io/github/phpgears/cqrs)

[![Total Downloads](https://img.shields.io/packagist/dt/phpgears/cqrs.svg?style=flat-square)](https://packagist.org/packages/phpgears/cqrs/stats)
[![Monthly Downloads](https://img.shields.io/packagist/dm/phpgears/cqrs.svg?style=flat-square)](https://packagist.org/packages/phpgears/cqrs/stats)

# CQRS

CQRS base classes and handling interfaces

This package only provides the building blocks to CQRS

## Installation

### Composer

```
composer require phpgears/cqrs
```

## Usage

Require composer autoload file

```php
require './vendor/autoload.php';
```

### Commands

Commands are immutable DTOs that carry all the information for an action to take place. A Command should be valid from the moment it is created and thus do not allow to mutate its properties

Extend from `Gears\CQRS\AbstractCommand` to ensure command immutability and the payload is only composed of **scalar values**, allowing for easy serialization and interoperability. AbstractCommand has a protected constructor forcing you to create custom static named constructors

```php
use Gears\CQRS\AbstractCommand;

/**
 * @method getName(): string
 * @method getLastName(): string
 */
final class CreateUserCommand extends AbstractCommand
{
    private $name;

    private $lastName;

    private $birthDate;

    public static function fromPersonalData(
        string $name,
        string $lastName,
        \DateTimeImmutable $birthDate
    ): self {
        return new self([
            'name' => $name,
            'lastName' => $lastName,
            'birthDate' => $birthDate->format(\DateTime::ATOM),
        ]);
    }

    public function getBirthDate(): \DateTimeImmutable
    {
        return DateTimeImmutable::createFromFormat(\DateTime::ATOM, $this->birthDate);
    }
}
```

**Why not just setting the variables directly in the named constructor?** Calling the Command constructor through `new self()` triggers the mechanisms to assure immutability and payload type check

In case of a command without any payload you could extend `Gears\CQRS\AbstractEmptyCommand` which is directly instantiable

```php
use Gears\CQRS\AbstractEmptyCommand;

final class CreateUserCommand extends AbstractEmptyCommand
{
}
```

#### Async commands

Having command assuring all of its payload is composed only of scalar values proves handy when you want to delegate command handling to a message queue system such as RabbitMQ, Gearman or Apache Kafka, serializing/deserializing scalar values is trivial in any language

Asynchronicity must be implemented at CommandBus level, meaning the command bus implementation must be able to identify which commands must be treated asynchronously and enqueue them

### Queries

Queries, like Commands, are immutable DTOs that carry all the information for a request to be made to the data source. A Query should be valid from the moment it is created and thus do not allow to mutate its properties
 
Extend from `Gears\CQRS\AbstractQuery` to ensure Query immutability. Unlike Command a Query is able to hold non scalar properties. AbstractQuery has a protected constructor forcing you to create a custom static named constructors

```php
use Gears\CQRS\AbstractQuery;

/**
 * @method getIdentity(): UserIdentity.
 */
final class FindUserQuery extends AbstractQuery
{
    private $identity;

    public static function fromIdentity(UserIdentity $identity): self 
    {
        return new self(['identity' => $identity]);
    }
}
```

**Why not just setting the variables directly in the named constructor?** Calling the Query constructor through `new self()` triggers the mechanisms to assure immutability

In case of a query without any payload you could extend `Gears\CQRS\AbstractEmptyQuery` which is directly instantiable

```php
use Gears\CQRS\AbstractEmptyQuery;

final class FindAllUsersQuery extends AbstractEmptyQuery
{
}
```

### Handlers

Commands and Queries are handed over to `Gears\CQRS\CommandHandler` and `Gears\CQRS\QueryHandler` respectively through their corresponding buses

`AbstractCommandHandler` and `AbstractQueryHandler`, provided in this package, are abstract classes that verify the type of the received Command/Query, so you can focus only on implementing the handling logic

A Command/Query Handler can be set to handle one or more Command/Query. It is controlled by the returned Command/Query types at `getSupportedQueryTypes` and `getSupportedCommandTypes`

```php
use Gears\CQRS\AbstractCommandHandler;

final class CreateUserCommandHandler extends AbstractCommandHandler
{
    protected function getSupportedCommandTypes(): array
    {
        return [CreateUserCommand::class];
    }

    private function handleCreateUserCommand(CreateUserCommand $command): void
    {
        $user = new User(
            $command->getName(),
            $command->getLastName(),
            $command->getBirthDate()
        );

        // Store the newly created user
    }
}
```

```php
use Gears\DTO\DTO;
use Gears\CQRS\AbstractQueryHandler;

final class FindUserQueryHandler extends AbstractQueryHandler
{
    protected function getSupportedQueryTypes(): array
    {
        return [FindUserQuery::class];
    }

    private function handleFindUserQuery(FindUserQuery $query): DTO
    {
        // Retrieve user from persistence by its identity: $query->getIdentity()

        return new UserDTO(/* parameters */);
    }
}
```

The method to handle each command is composed as "handle" followed by Command/Query type. If the type is a namespaced class only the class name is used. If you prefer other nomenclature you can override ` AbstractCommandHandler::getHandlerMethod` or `AbstractQueryHandler::getHandlerMethod`

By default, CommandType and QueryType are defined as the Command/Query `::class`. If you prefer to use any other string as type it's as simple as overriding the methods `AbstractCommand::getCommandType` and `AbstractQuery::getQueryType` respectively. Remember this will impact how the handlers support each Command/Query, see above

Have a look at [phpgears/dto](https://github.com/phpgears/dto) for a better understanding of how commands and queries are built out of DTOs and how they hold their payload

### CQRS Bus

Only `Gears\CQRS\CommandBus` and `Gears\CQRS\QueryBus` interfaces can be found in this package, you can easily use any of the good bus libraries available out there by simply adding an adapter layer

#### Implementations

CQRS bus implementations currently available:

* [phpgears/cqrs-symfony-messenger](https://github.com/phpgears/cqrs-symfony-messenger) uses Symfony's Messenger
* [phpgears/cqrs-tactician](https://github.com/phpgears/cqrs-tactician) uses League's Tactician

## Contributing

Found a bug or have a feature request? [Please open a new issue](https://github.com/phpgears/cqrs/issues). Have a look at existing issues before.

See file [CONTRIBUTING.md](https://github.com/phpgears/cqrs/blob/master/CONTRIBUTING.md)

## License

See file [LICENSE](https://github.com/phpgears/cqrs/blob/master/LICENSE) included with the source code for a copy of the license terms.
