<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\SQLBuilder\Test\Unit\Reference;

use Phuria\SQLBuilder\Reference\ReferenceCollection;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class ReferenceCollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @covers \Phuria\SQLBuilder\Reference\ReferenceCollection
     */
    public function itGiveArrayOfReferences()
    {
        $collection = new ReferenceCollection();
        $collection->createReference('test');

        static::assertCount(1, $collection->toArray());
    }

    /**
     * @test
     * @covers \Phuria\SQLBuilder\Reference\ReferenceCollection
     */
    public function itCreateReference()
    {
        $collection = new ReferenceCollection();
        $ref = $collection->createReference('test');

        static::assertTrue(is_scalar($ref));
        static::assertSame('test', $collection->toArray()[$ref]);
    }
}
