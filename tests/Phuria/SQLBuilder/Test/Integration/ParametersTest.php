<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\SQLBuilder\Test\Integration;

use Phuria\SQLBuilder\QueryBuilder\SelectBuilder;
use Phuria\SQLBuilder\Test\TestCase\DatabaseTestCase;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class ParametersTest extends DatabaseTestCase
{
    /**
     * @test
     */
    public function itWillSetParameterInQueryBuilder()
    {
        $connection = $this->createQueryConnection();

        $qb = new SelectBuilder();
        $userTable = $qb->from('user');
        $qb->addSelect($userTable->column('username'));
        $qb->andWhere("{$userTable->column('id')} = :id");
        $qb->setParameter('id', 1);

        static::assertSame('phuria', $qb->buildQuery($connection)->fetchScalar());
    }

    /**
     * @test
     */
    public function itWillSetParameterInQuery()
    {
        $connection = $this->createQueryConnection();

        $qb = new SelectBuilder();
        $userTable = $qb->from('user');
        $qb->addSelect($userTable->column('username'));
        $qb->andWhere("{$userTable->column('id')} = :id");

        $query = $qb->buildQuery($connection);
        $query->setParameter('id', 2);

        static::assertSame('romero', $query->fetchScalar());
    }

    /**
     * @test
     */
    public function itWillSelectNotExistingUser()
    {
        $connection = $this->createQueryConnection();
        $qb = new SelectBuilder();
        $userTable = $qb->from('user');
        $qb->addSelect($userTable->column('username'));
        $qb->andWhere("{$userTable->column('id')} = :id");

        $query = $qb->buildQuery($connection);
        $query->setParameter('id', 65646565);

        static::assertNull($query->fetchScalar());
    }
}