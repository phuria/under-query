<?php

namespace Phuria;

use Phuria\QueryBuilder\Query;
use Phuria\QueryBuilder\QueryBuilder;
use Phuria\QueryBuilder\Table\UnknownTable;
use Phuria\QueryBuilder\Test\ExampleTable;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class QueryBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testSimpleSelect()
    {
        $qb = new QueryBuilder();

        $rootTable = $qb->from('test');
        $rootTable->addSelect('MIN(test.id)');

        static::assertSame('SELECT MIN(test.id) FROM test', $qb->buildQuery()->getSQL());
    }

    public function testSimpleSelectWithAlias()
    {
        $qb = new QueryBuilder();

        $rootTable = $qb->from('test');
        $rootTable->setAlias('SRC');
        $rootTable->addSelect('MIN(SRC.id)');

        static::assertSame('SELECT MIN(SRC.id) FROM test AS SRC', $qb->buildQuery()->getSQL());
    }

    public function testTwoSelects()
    {
        $qb = new QueryBuilder();

        $rootTable = $qb->from('test');
        $rootTable->addSelect('test.id');
        $rootTable->addSelect('test.name');

        static::assertSame('SELECT test.id, test.name FROM test', $qb->buildQuery()->getSQL());
    }

    public function testCreateUnknownTable()
    {
        $qb = new QueryBuilder();

        $rootTable = $qb->from('unknown_table');

        static::assertInstanceOf(UnknownTable::class, $rootTable);
    }
}