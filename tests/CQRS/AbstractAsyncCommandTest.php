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

use Gears\CQRS\Tests\Stub\AbstractAsyncCommandStub;
use PHPUnit\Framework\TestCase;

/**
 * Abstract asynchronous command test.
 */
class AbstractAsyncCommandTest extends TestCase
{
    public function testReconstitute(): void
    {
        $command = AbstractAsyncCommandStub::reconstitute(['parameter' => 'one']);

        $this->assertTrue($command->has('parameter'));
    }
}
