<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\SQLBuilder\Test\Unit\QueryBuilder;

use Phuria\SQLBuilder\QueryBuilder\DeleteBuilder;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class DeleteBuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @teste
     */
    public function simpleDelete()
    {
        $qb = new DeleteBuilder();

        $table = $qb->from('example');
        $qb->andWhere("{$table->column('name')} = 'Foo'");

        static::assertSame('DELETE FROM example WHERE example.name = \'Foo\'', $qb->buildSQL());
    }
}
