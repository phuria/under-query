<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\SQLBuilder\Test\Unit\Connection;

use Phuria\SQLBuilder\Connection\ConnectionManager;
use Phuria\SQLBuilder\Connection\NullConnection;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class ConnectionManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itReturnDefaultConnection()
    {
        $manager = new ConnectionManager();
        $connection = new NullConnection();
        $manager->registerConnection($connection);

        static::assertSame($connection, $manager->getConnection());
    }

    /**
     * @test
     */
    public function itReturnNamedConnection()
    {
        $manager = new ConnectionManager();
        $defaultConnection = new NullConnection();
        $secondaryConnection = new NullConnection();

        $manager->registerConnection($defaultConnection, 'default');
        $manager->registerConnection($secondaryConnection, 'secondary');

        static::assertSame($defaultConnection, $manager->getConnection());
        static::assertSame($secondaryConnection, $manager->getConnection('secondary'));
    }
}
