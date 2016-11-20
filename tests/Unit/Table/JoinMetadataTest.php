<?php

/**
 * This file is part of UnderQuery package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\UnderQuery\Tests\Unit\Table;

use Phuria\UnderQuery\JoinType;
use Phuria\UnderQuery\Table\JoinMetadata;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class JoinMetadataTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @covers \Phuria\UnderQuery\Table\JoinMetadata
     */
    public function itShouldHaveConfigurableJoins()
    {
        $table = new JoinMetadata();

        $table->setJoinType(JoinType::INNER_JOIN);
        $table->setNaturalJoin(true);
        $table->setOuterJoin(true);
        $table->setJoinOn('0 = 0');

        static::assertTrue($table->isNaturalJoin());
        static::assertTrue($table->isOuterJoin());
        static::assertSame(JoinType::INNER_JOIN, $table->getJoinType());
        static::assertSame('0 = 0', $table->getJoinOn());
    }
}
