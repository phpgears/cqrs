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

Commands are immutable DTOs that carry all the information for an action to take place. A Command should be valid from the moment it is created and thus do not allow to mutable its properties

Extend from `Gears\CQRS\AbstractCommand` to ensure command immutability and the payload is only composed of **scalar values**, allowing for easy serialization and interoperability. AbstractCommand has a protected constructor forcing you to create custom static named constructors

```php
use Gears\CQRS\AbstractCommand;
/**
 * @method getName(): string
 * @method getLastName(): string
 */
class CreateUserCommand extends AbstractCommand
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

**Why not just setting the variables directly in the named constructor?** Calling the Command constructor through `new self()` triggers the mechanisms to assure immutability and payload type

In case of a command without any payload you could extend `Gears\CQRS\AbstractEmptyCommand` which is directly instantiable

```php
use Gears\CQRS\AbstractEmptyCommand;

class CreateUserCommand extends AbstractEmptyCommand
{
}
```

#### Async commands

Having command assuring all of its payload is composed only of scalar values proves handy when you want to delegate command handling to a message queue system such as RabbitMQ, Gearman or Apache Kafka, serializing/deserializing scalar values is trivial in any language

Asynchronous behaviour must be implemented at CommandBus level, command bus must be able to identify async commands (through a map, implementing an interface, by a payload parameter, etc) and enqueue them

If you want to have asynchronous behaviour on your CommandBus have a look [phpgears/cqrs-async](https://github.com/phpgears/cqrs-async), there you'll find all the necessary pieces to start your async command bus, for example using queue-interop with [phpgears/cqrs-async-queue-interop](https://github.com/phpgears/cqrs-async-queue-interop)

### Queries

Queries, like Commands, are immutable DTOs that carry all the information for a request to be made to the data source. A Query should be valid from the moment it is created and thus do not allow to mutable its properties
 
Extend from `Gears\CQRS\AbstractQuery` to ensure Query immutability. Unlike Command a Query is able to hold non scalar properties. AbstractQuery has a protected constructor forcing you to create a custom static named constructors

```php
use Gears\CQRS\AbstractQuery;

/**
 * @method getIdentity(): UserIdentity.
 */
class FindUserQuery extends AbstractQuery
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

class FindAllUsersQuery extends AbstractEmptyQuery
{
}
```

### Handlers

Commands and Queries are handed over to `Gears\CQRS\CommandHandler` and `Gears\CQRS\QueryHandler` respectively through their corresponding buses

`AbstractCommandHandler` and `AbstractQueryHandler` are provided in this package, this abstract classes verifies the type of the Command/Query so you can focus only on implementing the handling logic

A Command/Query Handler can be set to handle one or more Command/Query. It is controlled by the returned Command/Query types at `getSupportedQueryTypes` and `getSupportedCommandTypes`

```php
use Gears\CQRS\AbstractCommandHandler;
use Gears\CQRS\Command;

class CreateUserCommandHandler extends AbstractCommandHandler
{
    protected function getSupportedCommandTypes(): array
    {
        return [CreateUserCommand::class];
    }

    protected function handleCommand(Command $command): void
    {
        /* @var CreateUserCommand $command */

        $user = new User(
            $command->getName(),
            $command->getLastName(),
            $command->getBirthDate()
        );

        // ...
    }
}
```

```php
use Gears\DTO\DTO;
use Gears\CQRS\AbstractQueryHandler;
use Gears\CQRS\Query;

class FindUserQueryHandler extends AbstractQueryHandler
{
    protected function getSupportedQueryTypes(): array
    {
        return [FindUserQuery::class];
    }

    protected function handleQuery(Query $query): DTO
    {
        /* @var FindUserQuery $query */

        // Retrieve user from persistence by its identity: $query->getIdentity()

        return new UserDTO(/* parameters */);
    }
}
```

By default, Command and Query types are defined as their own class names. If you prefer to use any other string as type is as simple as overriding the methods `getCommandType` and `getQueryType` respectively

Have a look at [phpgears/dto](https://github.com/phpgears/dto) fo a better understanding of how commands and queries are built out of DTOs and how they hold their payload

### CQRS Bus

Only `Gears\CQRS\CommandBus` and `Gears\CQRS\QueryBus` interfaces are provided, you can easily use any of the good bus libraries available out there by simply adding an adapter layer

#### Implementations

CQRS bus implementations currently available:

* [phpgears/cqrs-symfony-messenger](https://github.com/phpgears/cqrs-symfony-messenger) uses Symfony's Messenger
* [phpgears/cqrs-tactician](https://github.com/phpgears/cqrs-tactician) uses League's Tactician

## Contributing

Found a bug or have a feature request? [Please open a new issue](https://github.com/phpgears/cqrs/issues). Have a look at existing issues before.

See file [CONTRIBUTING.md](https://github.com/phpgears/cqrs/blob/master/CONTRIBUTING.md)

## License

See file [LICENSE](https://github.com/phpgears/cqrs/blob/master/LICENSE) included with the source code for a copy of the license terms.
