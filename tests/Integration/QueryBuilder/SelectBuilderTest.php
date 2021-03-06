<?php

/**
 * This file is part of UnderQuery package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\UnderQuery\Tests\Integration\QueryBuilder;

use Phuria\UnderQuery\QueryBuilder\Clause\SelectInterface;
use Phuria\UnderQuery\Tests\Fixtures\ExampleTable;
use Phuria\UnderQuery\Tests\TestCase\UnderQueryTrait;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class SelectBuilderTest extends \PHPUnit_Framework_TestCase
{
    use UnderQueryTrait;

    /**
     * @test
     * @coversNothing
     */
    public function selectMinFromTest()
    {
        $qb = static::underQuery()->createSelect();

        $qb->from('test');
        $qb->addSelect('MIN(test.id)');

        static::assertSame('SELECT MIN(test.id) FROM test', $qb->buildQuery()->getSQL());
    }

    /**
     * @test
     * @coversNothing
     */
    public function selectTableWithAlias()
    {
        $qb = static::underQuery()->createSelect();

        $rootTable = $qb->from('test');
        $rootTable->setAlias('SRC');
        $qb->addSelect('MIN(SRC.id)');

        static::assertSame('SELECT MIN(SRC.id) FROM test AS SRC', $qb->buildQuery()->getSQL());
    }

    /**
     * @test
     * @coversNothing
     */
    public function selectTwoColumns()
    {
        $qb = static::underQuery()->createSelect();

        $qb->from('test');
        $qb->addSelect('test.id');
        $qb->addSelect('test.name');

        static::assertSame('SELECT test.id, test.name FROM test', $qb->buildQuery()->getSQL());
    }

    /**
     * @test
     * @coversNothing
     */
    public function selectColumnReferences()
    {
        $qb = static::underQuery()->createSelect();

        $rootTable = $qb->from('example');
        $qb->addSelect($rootTable->column('id'));
        $qb->addSelect($rootTable->column('name'));

        static::assertSame('SELECT example.id, example.name FROM example', $qb->buildQuery()->getSQL());

        $rootTable->setAlias('SRC');

        static::assertSame('SELECT SRC.id, SRC.name FROM example AS SRC', $qb->buildQuery()->getSQL());
    }

    /**
     * @test
     * @coversNothing
     */
    public function selectMaxColumnReference()
    {
        $qb = static::underQuery()->createSelect();

        $rootTable = $qb->from('example');
        $qb->addSelect("MAX({$rootTable->column('points')})");

        static::assertSame('SELECT MAX(example.points) FROM example', $qb->buildQuery()->getSQL());

        $rootTable->setAlias('SRC');

        static::assertSame('SELECT MAX(SRC.points) FROM example AS SRC', $qb->buildQuery()->getSQL());
    }

    /**
     * @test
     * @coversNothing
     */
    public function selectWithWhereClause()
    {
        $qb = static::underQuery()->createSelect();

        $rootTable = $qb->from('example');
        $qb->addSelect($rootTable->column('*'));
        $qb->andWhere("{$rootTable->column('name')} IS NOT NULL");

        static::assertSame('SELECT example.* FROM example WHERE example.name IS NOT NULL', $qb->buildQuery()->getSQL());

        $rootTable->setAlias('SRC');

        static::assertSame('SELECT SRC.* FROM example AS SRC WHERE SRC.name IS NOT NULL', $qb->buildQuery()->getSQL());
    }

    /**
     * @test
     * @coversNothing
     */
    public function selectWithWhereColumnReference()
    {
        $qb = static::underQuery()->createSelect();

        $rootTable = $qb->from('example');
        $qb->addSelect('example.id');
        $qb->addSelect('example.name');
        $qb->andWhere("{$rootTable->column('id')} BETWEEN 1 AND 10");

        $expectedSQL = 'SELECT example.id, example.name FROM example WHERE example.id BETWEEN 1 AND 10';
        static::assertSame($expectedSQL, $qb->buildQuery()->getSQL());
    }

    /**
     * @test
     * @coversNothing
     */
    public function selectWithConnectedWhereClause()
    {
        $qb = static::underQuery()->createSelect();

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
     * @coversNothing
     */
    public function selectWithCrossJoinClause()
    {
        $qb = static::underQuery()->createSelect();

        $qb->from('example');
        $qb->addSelect('*');
        $qb->crossJoin('test');

        static::assertSame('SELECT * FROM example CROSS JOIN test', $qb->buildQuery()->getSQL());
    }

    /**
     * @test
     * @coversNothing
     */
    public function selectWithMultipleFromTables()
    {
        $qb = static::underQuery()->createSelect();

        $exampleTable = $qb->from('example');
        $testTable = $qb->addFrom('test');
        $qb->addSelect('*');

        static::assertSame('SELECT * FROM example, test', $qb->buildQuery()->getSQL());

        $exampleTable->setAlias('SRC');
        $testTable->setAlias('OTHER');

        static::assertSame('SELECT * FROM example AS SRC, test AS OTHER', $qb->buildSQL());
    }

    /**
     * @test
     * @coversNothing
     */
    public function selectWithLeftJoinClause()
    {
        $qb = static::underQuery()->createSelect();

        $exampleTable = $qb->from('example');
        $qb->addSelect('*');
        $testTable = $qb->leftJoin('test');
        $testTable->getJoinMetadata()->setJoinOn("{$testTable->column('id')} = {$exampleTable->column('test_id')}");

        static::assertSame('SELECT * FROM example LEFT JOIN test ON test.id = example.test_id', $qb->buildSQL());
    }

    /**
     * @test
     * @coversNothing
     */
    public function selectWithDifferentJoins()
    {
        $qb = static::underQuery()->createSelect();

        $userTable = $qb->from('users');
        $userTable->setAlias('u');
        $qb->addSelect('*');

        $contactTable = $qb->leftJoin('contact');
        $contactTable->getJoinMetadata()->setJoinOn("{$userTable->column('id')} = {$contactTable->column('user_id')}");
        $contactTable->setAlias('c');

        $profileTable = $qb->innerJoin('profile');
        $profileTable->getJoinMetadata()->setJoinOn("{$userTable->column('id')} = {$profileTable->column('user_id')}");
        $profileTable->setAlias('p');

        $expectedSQL = 'SELECT * FROM users AS u'
            . ' LEFT JOIN contact AS c ON u.id = c.user_id'
            . ' INNER JOIN profile AS p ON u.id = p.user_id';

        static::assertSame($expectedSQL, $qb->buildSQL());

        $qb = static::underQuery()->createSelect();

        $qb->from('users', 'u');
        $qb->addSelect('*');
        $qb->leftJoin('contact', 'c', 'u.id = c.user_id');
        $qb->innerJoin('profile', 'p', 'u.id = p.user_id');

        static::assertSame($expectedSQL, $qb->buildSQL());
    }

    /**
     * @test
     * @coversNothing
     */
    public function selectWithLimitClause()
    {
        $qb = static::underQuery()->createSelect();

        $qb->from('example');
        $qb->addSelect('*');
        $qb->setLimit(10);

        static::assertSame('SELECT * FROM example LIMIT 10', $qb->buildSQL());

        $qb->setLimit('10, 20');

        static::assertSame('SELECT * FROM example LIMIT 10, 20', $qb->buildSQL());
    }

    /**
     * @test
     * @coversNothing
     */
    public function selectWithGroupByClause()
    {
        $qb = static::underQuery()->createSelect();

        $exampleTable = $qb->from('price_list');
        $exampleTable->setAlias('p');
        $qb->addSelect($exampleTable->column('user_id'));
        $qb->addSelect("SUM({$exampleTable->column('price')})");
        $qb->addGroupBy($exampleTable->column('user_id'));

        static::assertSame('SELECT p.user_id, SUM(p.price) FROM price_list AS p GROUP BY p.user_id', $qb->buildSQL());
    }

    /**
     * @test
     * @coversNothing
     */
    public function selectFromSubQuery()
    {
        $maxQb = static::underQuery()->createSelect();

        $exampleTable = $maxQb->from('example');
        $maxQb->addSelect("MAX({$exampleTable->column('value')}) AS max_value");

        $qb = static::underQuery()->createSelect();
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
     * @coversNothing
     */
    public function selectWithOrderByClause()
    {
        $qb = static::underQuery()->createSelect();

        $exampleTable = $qb->from('example');
        $qb->addSelect('*');
        $qb->addOrderBy("{$exampleTable->column('id')} DESC");

        $expectedSQL = 'SELECT * FROM example ORDER BY example.id DESC';
        static::assertSame($expectedSQL, $qb->buildSQL());

        $qb->addOrderBy("{$exampleTable->column('name')} ASC");

        $expectedSQL .= ', example.name ASC';
        static::assertSame($expectedSQL, $qb->buildSQL());
    }

    /**
     * @test
     * @coversNothing
     */
    public function selectOnly()
    {
        $qb = static::underQuery()->createSelect();
        $qb->addSelect('1 + 1');

        static::assertSame('SELECT 1 + 1', $qb->buildSQL());
    }

    /**
     * @test
     * @coversNothing
     */
    public function selectWithOrderedGroupBy()
    {
        $qb = static::underQuery()->createSelect();

        $exampleTable = $qb->from('example');
        $qb->addSelect('*');
        $qb->addGroupBy("{$exampleTable->column('user_id')} DESC");

        static::assertSame('SELECT * FROM example GROUP BY example.user_id DESC', $qb->buildSQL());
    }

    /**
     * @test
     * @coversNothing
     */
    public function selectWithHavingClause()
    {
        $qb = static::underQuery()->createSelect();

        $exampleTable = $qb->from('example');
        $qb->addSelect("SUM({$exampleTable->column('price')}) AS price");
        $qb->andHaving('price > 100');

        $expectedSQL = 'SELECT SUM(example.price) AS price FROM example HAVING price > 100';
        static::assertSame($expectedSQL, $qb->buildSQL());
    }

    /**
     * @test
     * @coversNothing
     */
    public function selectWithGroupByRollUp()
    {
        $qb = static::underQuery()->createSelect();

        $table = $qb->from('example');
        $qb->addSelect("SUM(".$table->column('price').")");
        $qb->addGroupBy($table->column('symbol'));
        $qb->addGroupBy($table->column('year'));
        $qb->setGroupByWithRollUp(true);

        $expectedSQL = 'SELECT SUM(example.price) FROM example GROUP BY example.symbol, example.year WITH ROLLUP';
        static::assertSame($expectedSQL, $qb->buildSQL());
    }

    /**
     * @test
     * @coversNothing
     */
    public function selectFromWithAlias()
    {
        $qb = static::underQuery()->createSelect();

        $table = $qb->from('example', 'e');
        $qb->addSelect($table->column('name'));

        static::assertSame('SELECT e.name FROM example AS e', $qb->buildSQL());
    }

    /**
     * @test
     * @coversNothing
     */
    public function selectMultipleArguments()
    {
        $qb = static::underQuery()->createSelect();

        $qb->addSelect('1+1', '2+2');

        static::assertSame('SELECT 1+1, 2+2', $qb->buildSQL());
    }

    /**
     * @test
     * @coversNothing
     */
    public function itCanSelectRelativeColumn()
    {
        $qb = static::underQuery()->createSelect();

        $fooTable = $qb->from('foo')->relative(function (SelectInterface $qb) {
            $qb->addSelect('@.column1');
            $qb->addSelect('@.column2');
        });

        static::assertSame('SELECT foo.column1, foo.column2 FROM foo', $qb->buildSQL());

        $fooTable->setAlias('boo');

        static::assertSame('SELECT boo.column1, boo.column2 FROM foo AS boo', $qb->buildSQL());
    }

    /**
     * @test
     * @coversNothing
     */
    public function itCanJoinRelativeSelf()
    {
        $qb = static::underQuery()->createSelect();

        $qb->from('foo')
            ->getRelativeBuilder()
            ->leftJoin('boo', null, '@self.id = @.boo_id')
            ->getRelativeBuilder()
            ->leftJoin('too', null, '@self.id = @.too_id');

        $qb->addSelect('*');

        $expectedSQL = 'SELECT * FROM foo LEFT JOIN boo ON boo.id = foo.boo_id LEFT JOIN too ON too.id = boo.too_id';
        static::assertSame($expectedSQL, $qb->buildSQL());
    }
}
