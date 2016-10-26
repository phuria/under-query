<?php

/**
 * This file is part of UnderQuery package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\UnderQuery\Tests\Unit\Query;

use Phuria\UnderQuery\Query\Query;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class QueryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @covers \Phuria\UnderQuery\Query\Query
     */
    public function itHasGivenSQL()
    {
        $query = new Query('abc');
        static::assertSame('abc', $query->getSQL());
    }

    /**
     * @test
     * @covers \Phuria\UnderQuery\Query\Query
     */
    public function itShouldHaveEmptyParametersCollection()
    {
        $query = new Query('');
        static::assertEmpty($query->getParameters()->toArray());
    }
}
