<?php

namespace Phuria\QueryBuilder\Test\Helper;

use Phuria\QueryBuilder\Table\AbstractTable;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class ExampleTable extends AbstractTable
{
    /**
     * @inheritdoc
     */
    public function getTableName()
    {
        return 'example';
    }
}