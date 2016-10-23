<?php

namespace Phuria\UnderQuery\Table;

use Phuria\UnderQuery\QueryBuilder\BuilderInterface;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class SubQueryTable extends AbstractTable
{
    /**
     * @var BuilderInterface
     */
    private $wrappedQueryBuilder;

    /**
     * @param BuilderInterface $subQb
     * @param BuilderInterface $qb
     */
    public function __construct(BuilderInterface $subQb, BuilderInterface $qb)
    {
        $this->wrappedQueryBuilder = $subQb;
        parent::__construct($qb);
    }

    /**
     * @inheritdoc
     */
    public function getTableName()
    {
        $ref = $this->getQueryBuilder()->objectToString($this->wrappedQueryBuilder);

        return '(' . $ref . ')';
    }

    /**
     * @return BuilderInterface
     */
    public function getWrappedQueryBuilder()
    {
        return $this->wrappedQueryBuilder;
    }
}