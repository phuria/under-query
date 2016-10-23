<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\UnderQuery\Tests\Unit\QueryBuilder;

use Phuria\UnderQuery\Parameter\ParameterCollectionInterface;
use Phuria\UnderQuery\Query\Query;
use Phuria\UnderQuery\QueryCompiler\QueryCompilerInterface;
use Phuria\UnderQuery\TableFactory\TableFactoryInterface;
use Phuria\UnderQuery\Tests\TestCase\UnderQueryTrait;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class AbstractBuilderTest extends \PHPUnit_Framework_TestCase
{
    use UnderQueryTrait;

    /**
     * @test
     * @covers \Phuria\UnderQuery\QueryBuilder\AbstractBuilder
     */
    public function itShouldSetParameter()
    {
        $qb = static::underQuery()->createSelect();
        $qb->setParameter('test', 10);

        static::assertSame(10, $qb->getParameters()->getParameter('test')->getValue());
    }

    /**
     * @test
     * @covers \Phuria\UnderQuery\QueryBuilder\AbstractBuilder
     */
    public function itReturnSelf()
    {
        $qb = static::underQuery()->createSelect();

        static::assertSame($qb, $qb->getQueryBuilder());
    }

    /**
     * @test
     * @covers \Phuria\UnderQuery\QueryBuilder\AbstractBuilder
     */
    public function itConvertObjectToString()
    {
        $qb = static::underQuery()->createSelect();
        $object = (object) ['test'];
        $string = $qb->objectToString($object);

        static::assertTrue(is_string($string));
    }

    /**
     * @test
     * @covers \Phuria\UnderQuery\QueryBuilder\AbstractBuilder
     */
    public function itWillBuildSQL()
    {
        $qb = static::underQuery()->createSelect();

        static::assertTrue(is_string($qb->buildSQL()));
    }

    /**
     * @test
     * @covers \Phuria\UnderQuery\QueryBuilder\AbstractBuilder
     */
    public function itWillBuildQuery()
    {
        $qb = static::underQuery()->createSelect();

        static::assertInstanceOf(Query::class, $qb->buildQuery());
    }

    /**
     * @test
     * @covers \Phuria\UnderQuery\QueryBuilder\AbstractBuilder
     */
    public function itHasValidInstances()
    {
        $qb = static::underQuery()->createSelect();

        static::assertInstanceOf(TableFactoryInterface::class, $qb->getTableFactory());
        static::assertInstanceOf(QueryCompilerInterface::class, $qb->getQueryCompiler());
        static::assertInstanceOf(ParameterCollectionInterface::class, $qb->getParameters());
    }
}
