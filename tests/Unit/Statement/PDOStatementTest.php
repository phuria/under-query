<?php

/**
 * This file is part of UnderQuery package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\UnderQuery\Tests\Unit\Statement;

use Phuria\UnderQuery\Statement\PDOStatement;
use Phuria\UnderQuery\Tests\TestCase\DatabaseTestCase;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class PDOStatementTest extends DatabaseTestCase
{
    /**
     * @test
     * @covers \Phuria\UnderQuery\Statement\PDOStatement
     */
    public function itWillBeExecuted()
    {
        $connection = $this->getPDOConnection();
        $stmt = new PDOStatement($connection->prepare('SELECT 1+1'));

        static::assertSame($stmt, $stmt->execute());
        static::assertSame('2', $stmt->fetchColumn());
        static::assertSame(1, $stmt->rowCount());
        static::assertSame($stmt, $stmt->closeCursor());
    }
}
