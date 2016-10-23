<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\UnderQuery\Tests\Unit\Exception;

use Phuria\UnderQuery\Exception\ConnectionException;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class ConnectionExceptionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @covers \Phuria\UnderQuery\Exception\ConnectionException
     */
    public function itIsExceptionAndContainsConnectionName()
    {
        $exception = ConnectionException::notRegistered('test');

        static::assertInstanceOf(\Exception::class, $exception);
        static::assertInstanceOf(ConnectionException::class, $exception);
        static::assertContains('test', $exception->getMessage());
    }
}
