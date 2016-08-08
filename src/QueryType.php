<?php

namespace Phuria\QueryBuilder;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class QueryType
{
    /**
     * @var bool $update
     */
    private $select = false;

    /**
     * @var bool $update
     */
    private $update = false;

    /**
     * @return boolean
     */
    public function isSelect()
    {
        return $this->select;
    }

    /**
     * @param boolean $select
     *
     * @return $this
     */
    public function setSelect($select)
    {
        $this->select = $select;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isUpdate()
    {
        return $this->update;
    }

    /**
     * @param boolean $update
     *
     * @return $this
     */
    public function setUpdate($update)
    {
        $this->update = $update;

        return $this;
    }
}