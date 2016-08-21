<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\QueryBuilder\Test\Unit;

use Phuria\QueryBuilder\QueryBuilder;
use Phuria\QueryBuilder\TableRecognizer;
use Phuria\QueryBuilder\Test\Helper\ExampleTable;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class TableRecognizerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
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

        $type = $recognizer->recognizeType(new QueryBuilder());
        static::assertSame(TableRecognizer::TYPE_SUB_QUERY, $type);
    }
}
