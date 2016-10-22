<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\SQLBuilder\Test\Unit\QueryBuilder;

use Phuria\SQLBuilder\Parameter\ParameterCollectionInterface;
use Phuria\SQLBuilder\Query\Query;
use Phuria\SQLBuilder\QueryCompiler\QueryCompilerInterface;
use Phuria\SQLBuilder\TableFactory\TableFactoryInterface;
use Phuria\SQLBuilder\Test\TestCase\QueryBuilderTrait;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class AbstractBuilderTest extends \PHPUnit_Framework_TestCase
{
    use QueryBuilderTrait;

    /**
     * @test
     * @covers \Phuria\SQLBuilder\QueryBuilder\AbstractBuilder
     */
    public function itShouldSetParameter()
    {
        $qb = static::phuriaSQL()->createSelect();
        $qb->setParameter('test', 10);

        static::assertSame(10, $qb->getParameters()->getParameter('test')->getValue());
    }

    /**
     * @test
     * @covers \Phuria\SQLBuilder\QueryBuilder\AbstractBuilder
     */
    public function itReturnSelf()
    {
        $qb = static::phuriaSQL()->createSelect();

        static::assertSame($qb, $qb->getQueryBuilder());
    }

    /**
     * @test
     * @covers \Phuria\SQLBuilder\QueryBuilder\AbstractBuilder
     */
    public function itConvertObjectToString()
    {
        $qb = static::phuriaSQL()->createSelect();
        $object = (object) ['test'];
        $string = $qb->objectToString($object);

        static::assertTrue(is_string($string));
    }

    /**
     * @test
     * @covers \Phuria\SQLBuilder\QueryBuilder\AbstractBuilder
     */
    public function itWillBuildSQL()
    {
        $qb = static::phuriaSQL()->createSelect();

        static::assertTrue(is_string($qb->buildSQL()));
    }

    /**
     * @test
     * @covers \Phuria\SQLBuilder\QueryBuilder\AbstractBuilder
     */
    public function itWillBuildQuery()
    {
        $qb = static::phuriaSQL()->createSelect();

        static::assertInstanceOf(Query::class, $qb->buildQuery());
    }

    /**
     * @test
     * @covers \Phuria\SQLBuilder\QueryBuilder\AbstractBuilder
     */
    public function itHasValidInstances()
    {
        $qb = static::phuriaSQL()->createSelect();

        static::assertInstanceOf(TableFactoryInterface::class, $qb->getTableFactory());
        static::assertInstanceOf(QueryCompilerInterface::class, $qb->getQueryCompiler());
        static::assertInstanceOf(ParameterCollectionInterface::class, $qb->getParameters());
    }
}
