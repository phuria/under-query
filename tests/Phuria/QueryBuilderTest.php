<?php

namespace Phuria;

use Phuria\QueryBuilder\QueryBuilder;
use Phuria\QueryBuilder\Table\UnknownTable;
use Phuria\QueryBuilder\TableFactory;
use Phuria\QueryBuilder\TableRegistry;
use Phuria\QueryBuilder\Test\ExampleTable;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class QueryBuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return QueryBuilder
     */
    private function createQb()
    {
        $tableRegistry = new TableRegistry();
        $tableRegistry->registerTable(ExampleTable::class, 'example');
        $tableFactory = new TableFactory($tableRegistry);

        return new QueryBuilder($tableFactory);
    }

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

    public function testCreateExampleTable()
    {
        $qb = $this->createQb();
        $rootTable = $qb->from('example');

        static::assertInstanceOf(ExampleTable::class, $rootTable);
    }

    public function testSelectAndWhereExampleTable()
    {
        $qb = $this->createQb();

        $rootTable = $qb->from('example');
        $rootTable->addSelect('example.id');
        $rootTable->addSelect('example.name');
        $rootTable->where('example.id BETWEEN 1 AND 10');

        static::assertSame(
            'SELECT example.id, example.name FROM example WHERE example.id BETWEEN 1 AND 10',
            $qb->buildQuery()->getSQL()
        );
    }

    public function testSelectColumnReference()
    {
        $qb = $this->createQb();

        $rootTable = $qb->from('example');
        $rootTable->addSelect($rootTable->column('id'));
        $rootTable->addSelect($rootTable->column('name'));

        static::assertSame('SELECT example.id, example.name FROM example', $qb->buildQuery()->getSQL());

        $rootTable->setAlias('SRC');

        static::assertSame('SELECT SRC.id, SRC.name FROM example AS SRC', $qb->buildQuery()->getSQL());
    }

    public function testSelectColumnReferenceFromColumn()
    {
        $qb = $this->createQb();

        $rootTable = $qb->from('example');
        $rootTable->column('id')->select();

        static::assertSame('SELECT example.id FROM example', $qb->buildQuery()->getSQL());

        $rootTable->setAlias('SRC');

        static::assertSame('SELECT SRC.id FROM example AS SRC', $qb->buildQuery()->getSQL());
    }

    public function testSelectColumnReferenceAs()
    {
        $qb = $this->createQb();

        $rootTable = $qb->from('example');
        $rootTable->column('id')->alias('primary_identity')->select();

        static::assertSame('SELECT example.id AS primary_identity FROM example', $qb->buildQuery()->getSQL());
    }
}