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

use Phuria\UnderQuery\Parameter\ParameterCollection;
use Phuria\UnderQuery\Query\Query;
use Phuria\UnderQuery\Tests\TestCase\DatabaseTestCase;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class PDOIntegrationTest extends DatabaseTestCase
{
    /**
     * @test
     * @coversNothing
     */
    public function itShouldBuildValidStatement()
    {
        $connection = $this->createQueryConnection();
        $sql = 'SELECT * FROM user WHERE id=1';

        $stmt = $connection->prepareStatement($sql, []);
        $stmt->execute();

        static::assertSame(1, $stmt->rowCount());
    }
}
