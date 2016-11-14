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
use Phuria\UnderQuery\UnderQuery;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class ConnectionTest extends DatabaseTestCase
{
    /**
     * @test
     * @coversNothing
     */
    public function itCanBeConnected()
    {
        $uq = new UnderQuery($this->createDoctrineConnection());
        $query = $uq->createSelect()->addSelect('2+2')->buildQuery();

        static::assertSame('4', $query->execute()->fetchColumn());
    }
}