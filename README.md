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

Commands are DTOs that carry all the information for an action to happen

You can create your own by implementing `Gears\CQRS\Command` or extend from `Gears\CQRS\AbstractCommand` which ensures command immutability and payload is composed only of **scalar values** which is a very interesting capability. AbstractCommand has a protected constructor forcing you to create custom static named constructors

```php
use Gears\CQRS\AbstractCommand;

class CreateUserCommand extends AbstractCommand
{
    public static function fromPersonalData(
        string $name,
        string lastname,
        \DateTimeImmutable $birthDate
    ): self {
        return new self([
            'name' => $name,
            'lastname' => $lastname,
            'birthDate' => $birthDate->format('U'),
        ]);
    }
}
```

In case of a command without any payload you could extend `Gears\CQRS\AbstractEmptyCommand`

```php
use Gears\CQRS\AbstractCommand;

class CreateUserCommand extends AbstractEmptyCommand
{
    public static function instance(): self {
        return new self();
    }
}
```

#### Async commands

Having command assuring all of its payload is composed only of scalar values proves handy when you want to delegate command handling to a message queue system such as RabbitMQ, Gearman or Apache Kafka, serializing/deserializing scalar values is trivial in any format and language

Asynchronous behaviour must be implemented at CommandBus level, command bus must be able to identify async commands (a map of commands, implementing an interface, by a payload parameter, ...) and enqueue them 

If you want to have asynchronous behaviour on your CommandBus have a look [phpgears/cqrs-async](https://github.com/phpgears/cqrs-async), there you'll find all the necessary pieces to start your async command bus, for example using queue-interop with [phpgears/cqrs-async-queue-interop](https://github.com/phpgears/cqrs-async-queue-interop)

### Queries

Queries are DTOs that carry all the information for a request to be made to the data source
 
 You can create your own by implementing `Gears\CQRS\Query` or extend from `Gears\CQRS\AbstractQuery` which ensures query immutability and payload is composed only of scalar values. AbstractQuery has a protected constructor forcing you to create a custom static named constructors

```php
use Gears\CQRS\AbstractQuery;

class FindUserQuery extends AbstractQuery
{
    public static function fromName(string $name): self 
    {
        return new self(['name' => $name]);
    }
}
```

### Handlers

Commands and Queries are handed over to `Gears\CQRS\CommandHandler` and `Gears\CQRS\QueryHandler` respectively on their corresponding buses

`AbstractCommandHandler` and `AbstractQueryHandler` are provided in this package, this abstract classes verifies the type of the command/query so you can focus only on implementing the handling logic

```php
class CreateUserCommandHandler extends AbstractCommandHandler
{
    protected function getSupportedCommandType(): string
    {
        return CreateUserCommand::class;
    }

    protected function handleCommand(Command $command): void
    {
        /* @var CreateUserCommand $command */

        $user = new User(
            $command->getName(),
            $command->getLastname(),
            $command->getBirthDate()
        );

        [...]
    }
}
```

Have a look at [phpgears/dto](https://github.com/phpgears/dto) fo a better understanding of how commands and queries are built out of DTOs and how they hold their payload

### Buses

Only `Gears\CQRS\CommandBus` and `Gears\CQRS\QueryBus` interfaces are provided, you can easily use any of the good bus libraries available out there by simply adding an adapter layer

#### Implementations

CQRS buses implementations currently available

* [phpgears/cqrs-symfony-messenger](https://github.com/phpgears/cqrs-symfony-messenger) uses Symfony's Messenger
* [phpgears/cqrs-tactician](https://github.com/phpgears/cqrs-tactician) uses League's Tactician

## Contributing

Found a bug or have a feature request? [Please open a new issue](https://github.com/phpgears/cqrs/issues). Have a look at existing issues before.

See file [CONTRIBUTING.md](https://github.com/phpgears/cqrs/blob/master/CONTRIBUTING.md)

## License

See file [LICENSE](https://github.com/phpgears/cqrs/blob/master/LICENSE) included with the source code for a copy of the license terms.
