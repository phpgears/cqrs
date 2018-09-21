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

This package only provides the building blocks to CQRS. Actual implementation 

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

Commands are DTOs that carry all the information for an action to happen on Write Model

You can create your own by implementing `Gears\CQRS\Command` or extend from `Gears\CQRS\AbstractCommand` which ensures command immutability and payload is composed only of scalar values. AbstractCommand has a protected constructor forcing you to create a custom static constructor

### Queries

Queries are DTOs that carry all the information for a request to be made on Read Model
 
 You can create your own by implementing `Gears\CQRS\Query` or extend from `Gears\CQRS\AbstractQuery` which ensures query immutability and payload is composed only of scalar values. AbstractQuery has a protected constructor forcing you to create a custom static constructor

### Async commands

There is a special `Gears\CQRS\AsyncCommand` and corresponding `Gears\CQRS\AbstractAsyncCommand` which are meant to be used when commands are needed to be sent to queue systems so their handling is delegated asynchronously

This is the case where having command assuring all its payload is composed only of scalar values proves handy, serializing and unserializing scalar values is trivial in any format and language

Have a look at [phpgears/dto](https://github.com/phpgears/dto) fo a better understanding of how commands and queries hold their payload

_Asynchronous behaviour must be implemented at CommandBus level and is out of the scope of this package, this is enqueue, dequeue, command serialization and reconstitution, ..._

### Handlers

Commands and Queries are handed over to `Gears\CQRS\CommandHandler` and `Gears\CQRS\QueryHandler` respectively on their corresponding buses

`AbstractCommandHandler` and `AbstractQueryHandler` are provided, this abstract classes verifies the type of the command/query so you can focus only on implementing the handling logic

Be aware that QueryHandler::handle method must return a DTO object from [phpgears/dto](https://github.com/phpgears/dto)

### Buses

Only `Gears\CQRS\CommandBus` and `Gears\CQRS\QueryBus` interfaces are provided, you can easily use any of the good bus libraries available out there by simply adding an adapter layer

As an example this is an implementation of CommandBus using [tactician](https://github.com/thephpleague/tactician):

```php
use Gears\CQRS\Command;
use Gears\CQRS\CommandBus;
use League\Tactician\CommandBus as TacticianCommandBus;

final class CommandBusImpl implements CommandBus
{
    /**
     * @var TacticianCommandBus
     */
    private $wrappedCommandBus;

    /**
     * @param TacticianCommandBus $wrappedCommandBus
     */
    public function __construct(TacticianCommandBus $wrappedCommandBus)
    {
        $this->wrappedCommandBus = $wrappedCommandBus;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(Command $command): void
    {
        $this->wrappedCommandBus->handle($command);
    }
}
```

## Contributing

Found a bug or have a feature request? [Please open a new issue](https://github.com/phpgears/cqrs/issues). Have a look at existing issues before.

See file [CONTRIBUTING.md](https://github.com/phpgears/cqrs/blob/master/CONTRIBUTING.md)

## License

See file [LICENSE](https://github.com/phpgears/cqrs/blob/master/LICENSE) included with the source code for a copy of the license terms.
