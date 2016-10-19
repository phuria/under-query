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

use Phuria\SQLBuilder\Test\TestCase\DatabaseTestCase;
use Phuria\SQLBuilder\Test\TestCase\QueryBuilderTrait;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class ParametersTest extends DatabaseTestCase
{
    use QueryBuilderTrait;

    /**
     * @test
     * @coversNothing
     */
    public function itShouldWorkWithParameterSetInQb()
    {
        $connection = $this->createQueryConnection();

        $qb = static::phuriaSQLBuilder()->createSelect();
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

        $qb = static::phuriaSQLBuilder()->createSelect();
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
        $qb = static::phuriaSQLBuilder()->createSelect();
        $userTable = $qb->from('user');
        $qb->addSelect($userTable->column('username'));
        $qb->andWhere("{$userTable->column('id')} = :id");

        $query = $qb->buildQuery($connection);
        $query->setParameter('id', 65646565);

        static::assertNull($query->fetchScalar());
    }
}