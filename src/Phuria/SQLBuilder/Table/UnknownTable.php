<?php

namespace Phuria\SQLBuilder\Table;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class UnknownTable extends AbstractTable
{
    /**
     * @var string $tableName
     */
    private $tableName;

    /**
     * @inheritdoc
     */
    public function getTableName()
    {
        return $this->tableName;
    }

    /**
     * @param string $tableName
     *
     * @return $this
     */
    public function setTableName($tableName)
    {
        $this->tableName = $tableName;

        return $this;
    }
}