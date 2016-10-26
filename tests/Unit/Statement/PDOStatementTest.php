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

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class PDOStatementTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @covers \Phuria\UnderQuery\Statement\PDOStatement
     */
    public function itShouldCallExecute()
    {
        $stmt = $this->prophesize(\PDOStatement::class);
        $stmt->execute()->willReturn(null);

        $stmt = new PDOStatement($stmt->reveal());

        static::assertSame($stmt, $stmt->execute());
    }

    /**
     * @test
     * @covers \Phuria\UnderQuery\Statement\PDOStatement
     */
    public function itShouldCallRowCount()
    {
        $stmt = $this->prophesize(\PDOStatement::class);
        $stmt->rowCount()->willReturn(10);

        $stmt = new PDOStatement($stmt->reveal());

        static::assertSame(10, $stmt->rowCount());
    }
}
