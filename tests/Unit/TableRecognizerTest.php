<?php

/**
 * This file is part of UnderQuery package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\UnderQuery\Tests\Unit;

use Phuria\UnderQuery\TableRecognizer;
use Phuria\UnderQuery\Tests\Fixtures\ExampleTable;
use Phuria\UnderQuery\Tests\Fixtures\NullQueryBuilder;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class TableRecognizerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @covers \Phuria\UnderQuery\TableRecognizer
     */
    public function itWillReturnValidTypes()
    {
        $recognizer = new TableRecognizer();

        $type = $recognizer->recognizeType(function (ExampleTable $table) { });
        static::assertSame(TableRecognizer::TYPE_CLOSURE, $type);

        $type = $recognizer->recognizeType(ExampleTable::class);
        static::assertSame(TableRecognizer::TYPE_CLASS_NAME, $type);

        $type = $recognizer->recognizeType('example_table_name');
        static::assertSame(TableRecognizer::TYPE_TABLE_NAME, $type);

        $type = $recognizer->recognizeType(new NullQueryBuilder());
        static::assertSame(TableRecognizer::TYPE_SUB_QUERY, $type);
    }

    /**
     * @test
     * @covers \Phuria\UnderQuery\TableRecognizer
     */
    public function itExtractClassName()
    {
        $recognizer = new TableRecognizer();

        $class = $recognizer->extractClassName(function (ExampleTable $table) {});

        static::assertSame(ExampleTable::class, $class);
    }
}
