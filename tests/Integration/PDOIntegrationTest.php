<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\UnderQuery\Tests\Integration;

use Phuria\UnderQuery\Parameter\ParameterCollection;
use Phuria\UnderQuery\Query\Query;
use Phuria\UnderQuery\Tests\TestCase\DatabaseTestCase;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class PDOIntegrationTest extends DatabaseTestCase
{
    /**
     * @test
     * @coversNothing
     */
    public function itShouldBuildValidStatement()
    {
        $connection = $this->createQueryConnection();
        $sql = 'SELECT * FROM user WHERE id=1';
        $query = new Query($sql, new ParameterCollection(), $connection);

        static::assertSame(1, $query->rowCount());
    }

    /**
     * @test
     * @coversNothing
     */
    public function itUpdateUser()
    {
        $connection = $this->createQueryConnection();
        $sql = 'UPDATE user SET username = "Benek" WHERE id = 1';
        $query = new Query($sql, new ParameterCollection(), $connection);

        static::assertSame(1, $query->execute());

        $sql = 'SELECT username FROM user WHERE id = 1';
        $query = new Query($sql, new ParameterCollection(), $connection);

        static::assertSame('Benek', $query->fetchScalar());
    }
}
