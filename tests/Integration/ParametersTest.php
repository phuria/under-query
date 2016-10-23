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

use Phuria\UnderQuery\Tests\TestCase\DatabaseTestCase;
use Phuria\UnderQuery\Tests\TestCase\UnderQueryTrait;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class ParametersTest extends DatabaseTestCase
{
    use UnderQueryTrait;

    /**
     * @test
     * @coversNothing
     */
    public function itShouldWorkWithParameterSetInQb()
    {
        $connection = $this->createQueryConnection();

        $qb = static::underQuery()->createSelect();
        $userTable = $qb->from('user');
        $qb->addSelect($userTable->column('username'));
        $qb->andWhere("{$userTable->column('id')} = :id");
        $qb->setParameter('id', 1);

        static::assertSame('phuria', $qb->buildQuery($connection)->fetchScalar());
    }

    /**
     * @test
     * @coversNothing
     */
    public function itShouldWorkWithParameterSetInQuery()
    {
        $connection = $this->createQueryConnection();

        $qb = static::underQuery()->createSelect();
        $userTable = $qb->from('user');
        $qb->addSelect($userTable->column('username'));
        $qb->andWhere("{$userTable->column('id')} = :id");

        $query = $qb->buildQuery($connection);
        $query->setParameter('id', 2);

        static::assertSame('romero', $query->fetchScalar());
    }

    /**
     * @test
     * @coversNothing
     */
    public function itWillSelectNotExistingUser()
    {
        $connection = $this->createQueryConnection();
        $qb = static::underQuery()->createSelect();
        $userTable = $qb->from('user');
        $qb->addSelect($userTable->column('username'));
        $qb->andWhere("{$userTable->column('id')} = :id");

        $query = $qb->buildQuery($connection);
        $query->setParameter('id', 65646565);

        static::assertNull($query->fetchScalar());
    }

    /**
     * @test
     * @coversNothing
     */
    public function itWillNotChangeParamInQuery()
    {
        $qb = static::underQuery()->createSelect();
        $qb->setParameter('test', 10);
        $query = $qb->buildQuery();

        $query->setParameter('test', 20);

        static::assertSame(10, $qb->getParameters()->getParameter('test')->getValue());
        static::assertSame(20, $query->getParameterCollection()->getParameter('test')->getValue());
    }
}