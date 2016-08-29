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
use Phuria\QueryBuilder\Table\UnknownTable;
use Phuria\QueryBuilder\TableFactory;
use Phuria\QueryBuilder\TableRegistry;
use Phuria\QueryBuilder\Test\Helper\ExampleTable;

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

    /**
     * @test
     */
    public function itWillSelectWithWhere()
    {
        $qb = $this->createQb();

        $rootTable = $qb->from('example');
        $rootTable->addSelect('example.id');
        $rootTable->addSelect('example.name');
        $qb->andWhere('example.id BETWEEN 1 AND 10');

        static::assertSame(
            'SELECT example.id, example.name FROM example WHERE example.id BETWEEN 1 AND 10',
            $qb->buildQuery()->getSQL()
        );
    }

    /**
     * @test
     */
    public function itWillSelectColumnReferences()
    {
        $qb = $this->createQb();

        $rootTable = $qb->from('example');
        $rootTable->addSelect($rootTable->column('id'));
        $rootTable->addSelect($rootTable->column('name'));

        static::assertSame('SELECT example.id, example.name FROM example', $qb->buildQuery()->getSQL());

        $rootTable->setAlias('SRC');

        static::assertSame('SELECT SRC.id, SRC.name FROM example AS SRC', $qb->buildQuery()->getSQL());
    }

    public function testSelectMax()
    {
        $qb = $this->createQb();

        $rootTable = $qb->from('example');
        $qb->addSelect("MAX({$rootTable->column('points')})");

        static::assertSame('SELECT MAX(example.points) FROM example', $qb->buildQuery()->getSQL());

        $rootTable->setAlias('SRC');

        static::assertSame('SELECT MAX(SRC.points) FROM example AS SRC', $qb->buildQuery()->getSQL());
    }

    /**
     * @test
     */
    public function itWilHaveWhereClause()
    {
        $qb = $this->createQb();

        $rootTable = $qb->from('example');
        $qb->addSelect($rootTable->column('*'));
        $qb->andWhere("{$rootTable->column('name')} IS NOT NULL");

        static::assertSame('SELECT example.* FROM example WHERE example.name IS NOT NULL', $qb->buildQuery()->getSQL());

        $rootTable->setAlias('SRC');

        static::assertSame('SELECT SRC.* FROM example AS SRC WHERE SRC.name IS NOT NULL', $qb->buildQuery()->getSQL());
    }

    /**
     * @test
     */
    public function itWillHaveConnectedWhereClause()
    {
        $qb = $this->createQb();

        $rootTable = $qb->from('example');
        $qb->addSelect('*');
        $qb->andWhere("{$rootTable->column('name')} IS NOT NULL");
        $qb->andWhere("{$rootTable->column('id')} > 10");

        $expectedSQL = 'SELECT * FROM example WHERE example.name IS NOT NULL AND example.id > 10';
        static::assertSame($expectedSQL, $qb->buildQuery()->getSQL());

        $qb->andWhere("({$rootTable->column('name')} = \"Albert\" OR {$rootTable->column('name')} = \"Olaf\")");

        $expectedSQL .= ' AND (example.name = "Albert" OR example.name = "Olaf")';
        static::assertSame($expectedSQL, $qb->buildQuery()->getSQL());
    }

    /**
     * @test
     */
    public function itWillHaveCrossJoinClause()
    {
        $qb = $this->createQb();

        $qb->from('example');
        $qb->addSelect('*');
        $qb->crossJoin('test');

        static::assertSame('SELECT * FROM example CROSS JOIN test', $qb->buildQuery()->getSQL());
    }

    /**
     * @test
     */
    public function itWillHaveMultipleFromTables()
    {
        $qb = $this->createQb();

        $exampleTable = $qb->from('example');
        $testTable = $qb->addFrom('test');
        $qb->addSelect('*');

        static::assertSame('SELECT * FROM example, test', $qb->buildQuery()->getSQL());

        $exampleTable->setAlias('SRC');
        $testTable->setAlias('OTHER');

        static::assertSame('SELECT * FROM example AS SRC, test AS OTHER', $qb->buildSQL());
    }

    public function testLeftJoin()
    {
        $qb = $this->createQb();

        $exampleTable = $qb->from('example');
        $qb->addSelect('*');
        $testTable = $qb->leftJoin('test');
        $testTable->joinOn("{$testTable->column('id')} = {$exampleTable->column('test_id')}");

        static::assertSame('SELECT * FROM example LEFT JOIN test ON test.id = example.test_id', $qb->buildSQL());
    }

    public function testJoins()
    {
        $qb = $this->createQb();

        $userTable = $qb->from('users');
        $userTable->setAlias('u');
        $qb->addSelect('*');

        $contactTable = $qb->leftJoin('contact');
        $contactTable->joinOn("{$userTable->column('id')} = {$contactTable->column('user_id')}");
        $contactTable->setAlias('c');

        $profileTable = $qb->innerJoin('profile');
        $profileTable->joinOn("{$userTable->column('id')} = {$profileTable->column('user_id')}");
        $profileTable->setAlias('p');

        $expectedSQL = 'SELECT * FROM users AS u'
            . ' LEFT JOIN contact AS c ON u.id = c.user_id'
            . ' INNER JOIN profile AS p ON u.id = p.user_id';

        static::assertSame($expectedSQL, $qb->buildSQL());
    }

    /**
     * @test
     */
    public function itWillHaveSubQuery()
    {
        $maxQb = $this->createQb();

        $exampleTable = $maxQb->from('example');
        $maxQb->addSelect("MAX({$exampleTable->column('value')}) AS max_value");

        $qb = $this->createQb();
        $subQuery = $qb->from($maxQb);
        $subQuery->setAlias('SRC');
        $qb->addSelect($subQuery->column('max_value'));

        $expectedSQL = 'SELECT SRC.max_value FROM (SELECT MAX(example.value) AS max_value FROM example) AS SRC';
        static::assertSame($expectedSQL, $qb->buildSQL());

        $maxQb->addGroupBy($exampleTable->column('user_id'));

        $expectedSQL = 'SELECT SRC.max_value FROM (SELECT MAX(example.value) AS max_value FROM example GROUP BY example.user_id) AS SRC';
        static::assertSame($expectedSQL, $qb->buildSQL());
    }

    /**
     * @test
     */
    public function itWillHaveOrderByClause()
    {
        $qb = $this->createQb();

        $exampleTable = $qb->from('example');
        $qb->addSelect('*');
        $qb->addOrderBy("{$exampleTable->column('id')} DESC");

        $expectedSQL = 'SELECT * FROM example ORDER BY example.id DESC';
        static::assertSame($expectedSQL, $qb->buildSQL());

        $qb->addOrderBy("{$exampleTable->column('name')} ASC");

        $expectedSQL .= ', example.name ASC';
        static::assertSame($expectedSQL, $qb->buildSQL());
    }

    public function testUpdateSet()
    {
        $qb = $this->createQb();

        $exampleTable = $qb->update('example');
        $qb->addSet("{$exampleTable->column('name')} = NULL");

        $expectedSQL = 'UPDATE example SET example.name = NULL';
        static::assertSame($expectedSQL, $qb->buildSQL());

        $qb->addSet("{$exampleTable->column('value')} = 10");

        $expectedSQL .= ', example.value = 10';
        static::assertSame($expectedSQL, $qb->buildSQL());
    }

    /**
     * @test
     */
    public function itWillGroupBy()
    {
        $qb = $this->createQb();

        $exampleTable = $qb->from('price_list');
        $exampleTable->setAlias('p');
        $qb->addSelect($exampleTable->column('user_id'));
        $qb->addSelect("SUM({$exampleTable->column('price')})");
        $qb->addGroupBy($exampleTable->column('user_id'));

        static::assertSame('SELECT p.user_id, SUM(p.price) FROM price_list AS p GROUP BY p.user_id', $qb->buildSQL());
    }

    /**
     * @test
     */
    public function itWillReturnOnlySelect()
    {
        $qb = $this->createQb();
        $qb->addSelect('1 + 1');

        static::assertSame('SELECT 1 + 1', $qb->buildSQL());
    }

    /**
     * @test
     */
    public function itWillHaveOrderedGroupBy()
    {
        $qb = $this->createQb();

        $exampleTable = $qb->from('example');
        $qb->addSelect('*');
        $qb->addGroupBy("{$exampleTable->column('user_id')} DESC");

        $expectedSQL = 'SELECT * FROM example GROUP BY example.user_id DESC';
        static::assertSame($expectedSQL, $qb->buildSQL());
    }

    /**
     * @test
     */
    public function itWillHaveHavingClause()
    {
        $qb = $this->createQb();

        $exampleTable = $qb->from('example');
        $qb->addSelect("SUM({$exampleTable->column('price')}) AS price");
        $qb->andHaving('price > 100');

        $expectedSQL = 'SELECT SUM(example.price) AS price FROM example HAVING price > 100';
        static::assertSame($expectedSQL, $qb->buildSQL());
    }

    /**
     * @test
     */
    public function itWillHaveLimit()
    {
        $qb = $this->createQb();

        $qb->from('example');
        $qb->addSelect('*');
        $qb->limit(10);

        static::assertSame('SELECT * FROM example LIMIT 10', $qb->buildSQL());

        $qb->limit('10, 20');

        static::assertSame('SELECT * FROM example LIMIT 10, 20', $qb->buildSQL());
    }
}