<?php

/**
 * This file is part of UnderQuery package.
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
    public function itWillNotChangeParamInQuery()
    {
        $qb = static::underQuery()->createSelect();
        $qb->setParameter('test', 10);
        $query = $qb->buildQuery();

        $query->setParameter('test', 20);

        static::assertSame(10, $qb->getParameters()->getParameter('test')->getValue());
        static::assertSame(20, $query->getParameters()->getParameter('test')->getValue());
    }
}