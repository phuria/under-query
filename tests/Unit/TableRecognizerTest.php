<?php

namespace Phuria\QueryBuilder\Test\Unit;

use Phuria\QueryBuilder\TableRecognizer;
use Phuria\QueryBuilder\Test\Helper\ExampleTable;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class TableRecognizerTest extends \PHPUnit_Framework_TestCase
{
    public function testTypes()
    {
        $recognizer = new TableRecognizer();

        $type = $recognizer->recognizeType(function (ExampleTable $table) { });
        static::assertSame(TableRecognizer::TYPE_CLOSURE, $type);

        $type = $recognizer->recognizeType('example.route.to.other.table');
        static::assertSame(TableRecognizer::TYPE_ROUTE, $type);

        $type = $recognizer->recognizeType(ExampleTable::class);
        static::assertSame(TableRecognizer::TYPE_CLASS_NAME, $type);

        $type = $recognizer->recognizeType('example_table_name');
        static::assertSame(TableRecognizer::TYPE_TABLE_NAME, $type);
    }
}
