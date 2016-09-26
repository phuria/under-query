<?php

namespace Phuria\SQLBuilder\Table;

use Phuria\SQLBuilder\QueryBuilder\AbstractBuilder;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class SubQueryTable extends AbstractTable
{
    /**
     * @var AbstractBuilder
     */
    private $subQb;

    /**
     * @param AbstractBuilder $subQb
     * @param AbstractBuilder $qb
     */
    public function __construct(AbstractBuilder $subQb, AbstractBuilder $qb)
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