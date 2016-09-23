<?php

namespace Phuria\SQLBuilder\Table;

use Phuria\SQLBuilder\QueryBuilder;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class SubQueryTable extends AbstractTable
{
    /**
     * @var QueryBuilder $subQb
     */
    private $subQb;

    /**
     * @param QueryBuilder $subQb
     * @param QueryBuilder $qb
     */
    public function __construct(QueryBuilder $subQb, QueryBuilder $qb)
    {
        $this->subQb = $subQb;
        parent::__construct($qb);
    }

    /**
     * @inheritdoc
     */
    public function getTableName()
    {
        $ref = $this->getQueryBuilder()->getReferenceManager()->register($this->subQb);

        return '(' . $ref . ')';
    }
}