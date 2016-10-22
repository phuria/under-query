<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\SQLBuilder\Test\Unit\Parameter;

use Phuria\SQLBuilder\Parameter\QueryParameter;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class QueryParameterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @covers \Phuria\SQLBuilder\Parameter\QueryParameter
     */
    public function itAllowsToSetValue()
    {
        $param = new QueryParameter('name');

        $param->setValue(123);

        static::assertSame(123, $param->getValue());
        static::assertSame('name', $param->getName());
    }
}
