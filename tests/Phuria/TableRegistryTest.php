<?php
/**
 * Created by PhpStorm.
 * User: phuria
 * Date: 07.08.16
 * Time: 18:25
 */

namespace Phuria;

use Phuria\QueryBuilder\TableRecognizer;
use Phuria\QueryBuilder\Test\ExampleTable;

class TableRegistryTest extends \PHPUnit_Framework_TestCase
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
