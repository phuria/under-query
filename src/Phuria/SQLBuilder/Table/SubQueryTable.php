<?php

namespace Phuria\SQLBuilder\Table;

use Phuria\SQLBuilder\QueryBuilder\BuilderInterface;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class SubQueryTable extends AbstractTable
{
    /**
     * @var BuilderInterface
     */
    private $subQb;

    /**
     * @param BuilderInterface $subQb
     * @param BuilderInterface $qb
     */
    public function __construct(BuilderInterface $subQb, BuilderInterface $qb)
    {
        $this->subQb = $subQb;
        parent::__construct($qb);
    }

    /**
     * @inheritdoc
     */
    public function getTableName()
    {
        $ref = $this->getQueryBuilder()->objectToString($this->subQb);

        return '(' . $ref . ')';
    }
}