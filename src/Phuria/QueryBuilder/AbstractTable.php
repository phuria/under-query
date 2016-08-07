<?php

namespace Phuria\QueryBuilder;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class AbstractTable
{
    private $manipulator;

    public function __construct(TableManipulator $manipulator)
    {
        $this->manipulator = $manipulator;
    }

    public function onlyActive()
    {

    }
}