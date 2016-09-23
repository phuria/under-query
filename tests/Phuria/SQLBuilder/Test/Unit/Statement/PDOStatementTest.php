<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\SQLBuilder\Test\Unit;

use Phuria\SQLBuilder\Parameter\ParameterManager;
use Phuria\SQLBuilder\Query;
use Phuria\SQLBuilder\Test\TestCase\DatabaseTestCase;

class PDOStatementTest extends DatabaseTestCase
{
    /**
     * @test
     */
    public function itWillReturnOneRow()
    {
        $connection= $this->createQueryConnection();
        $sql= 'select * FROM user where id=1';
        $query= new Query($sql, new ParameterManager(), $connection);
        $stmt= $query->buildStatement();

        $stmt->execute();

        static::assertSame(1, $stmt->rowCount());
    }

}
