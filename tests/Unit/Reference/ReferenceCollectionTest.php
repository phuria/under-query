<?php

/**
 * This file is part of UnderQuery package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\UnderQuery\Tests\Unit\Reference;

use Phuria\UnderQuery\Reference\ReferenceCollection;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class ReferenceCollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @covers \Phuria\UnderQuery\Reference\ReferenceCollection
     */
    public function itGiveArrayOfReferences()
    {
        $collection = new ReferenceCollection();
        $collection->createReference('test');

        static::assertCount(1, $collection->toArray());
    }

    /**
     * @test
     * @covers \Phuria\UnderQuery\Reference\ReferenceCollection
     */
    public function itCreateReference()
    {
        $collection = new ReferenceCollection();
        $ref = $collection->createReference('test');

        static::assertTrue(is_scalar($ref));
        static::assertSame([$ref => 'test'], $collection->toArray());

        $ref2 = $collection->createReference('test2');

        static::assertTrue(is_scalar($ref2));
        static::assertSame([$ref => 'test', $ref2 => 'test2'], $collection->toArray());
        static::assertNotSame($ref, $ref2);
    }
}
