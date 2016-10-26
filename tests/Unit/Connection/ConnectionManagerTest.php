<?php

/**
 * This file is part of UnderQuery package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\UnderQuery\Tests\Unit\Connection;

use Phuria\UnderQuery\Connection\ConnectionInterface;
use Phuria\UnderQuery\Connection\ConnectionManager;
use Phuria\UnderQuery\Exception\ConnectionException;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class ConnectionManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @covers \Phuria\UnderQuery\Connection\ConnectionManager
     */
    public function itReturnDefaultConnection()
    {
        $connection = $this->prophesize(ConnectionInterface::class)->reveal();

        $manager = new ConnectionManager();
        $manager->registerConnection($connection);

        static::assertSame($connection, $manager->getConnection());
    }

    /**
     * @test
     * @covers \Phuria\UnderQuery\Connection\ConnectionManager
     */
    public function itReturnNamedConnection()
    {
        $manager = new ConnectionManager();
        $defaultConnection = $this->prophesize(ConnectionInterface::class)->reveal();
        $secondaryConnection = $this->prophesize(ConnectionInterface::class)->reveal();

        $manager->registerConnection($defaultConnection, 'default');
        $manager->registerConnection($secondaryConnection, 'secondary');

        static::assertSame($defaultConnection, $manager->getConnection());
        static::assertSame($secondaryConnection, $manager->getConnection('secondary'));
    }

    /**
     * @test
     * @covers \Phuria\UnderQuery\Connection\ConnectionManager
     */
    public function itWillNotFindConnection()
    {
        $manager = new ConnectionManager();

        static::assertFalse($manager->hasConnection('default'));
        static::expectException(ConnectionException::class);
        $manager->getConnection('default');
    }
}
