<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\UnderQuery\Tests\Unit\Parameter;

use Phuria\UnderQuery\Parameter\ParameterCollection;
use Phuria\UnderQuery\Parameter\QueryParameter;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class ParameterCollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @covers \Phuria\UnderQuery\Parameter\ParameterCollection
     */
    public function itWillCreateNewParameter()
    {
        $paramManager = new ParameterCollection();
        $param = $paramManager->getParameter('test');

        static::assertInstanceOf(QueryParameter::class, $param);
        static::assertSame($param, $paramManager->getParameter('test'));
    }

    /**
     * @test
     * @covers \Phuria\UnderQuery\Parameter\ParameterCollection
     */
    public function itShouldGiveArrayOfParameters()
    {
        $collection = new ParameterCollection();
        $collection->getParameter('foo');
        $collection->getParameter('boo');

        $array = $collection->toArray();

        static::assertCount(2, $array);
    }

    /**
     * @test
     * @covers \Phuria\UnderQuery\Parameter\ParameterCollection
     */
    public function itCanBeCloned()
    {
        $collection = new ParameterCollection();
        $collection->getParameter('foo')->setValue(100);

        $cloned = clone $collection;

        static::assertInstanceOf(ParameterCollection::class, $collection);
        static::assertSame(100, $cloned->getParameter('foo')->getValue());
    }
}
