<?php

/**
 * This file is part of UnderQuery package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\UnderQuery\Tests\Unit\Utils;

use Phuria\UnderQuery\Utils\RecursiveArgs;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class RecursiveArgsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param array $collection
     *
     * @return \Closure
     */
    private function createCollector(array &$collection)
    {
        return function ($arg) use (&$collection) {
              $collection[] = $arg;
        };
    }

    /**
     * @test
     * @covers \Phuria\UnderQuery\Utils\RecursiveArgs
     */
    public function itCanHandleArrays()
    {
        $collection = [];
        RecursiveArgs::each([['a', 'b', 'c']], $this->createCollector($collection));
        static::assertSame(['a', 'b', 'c'], $collection);

        $collection = [];
        RecursiveArgs::each([], $this->createCollector($collection));
        static::assertSame([], $collection);

        $collection = [];
        RecursiveArgs::each([['a'], ['b'], ['c']], $this->createCollector($collection));
        static::assertSame(['a', 'b', 'c'], $collection);
    }

    /**
     * @test
     * @covers \Phuria\UnderQuery\Utils\RecursiveArgs
     */
    public function itCanHandleScalars()
    {
        $collection = [];
        RecursiveArgs::each(['a', 'b', 'c'], $this->createCollector($collection));
        static::assertSame(['a', 'b', 'c'], $collection);

        $collection = [];
        RecursiveArgs::each(['a', ['b', 'c']], $this->createCollector($collection));
        static::assertSame(['a', 'b', 'c'], $collection);
    }
}
