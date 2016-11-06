<?php

/**
 * This file is part of UnderQuery package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\UnderQuery\Statement;

use Phuria\UnderQuery\Parameter\QueryParameterInterface;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
interface StatementInterface
{
    /**
     * @return $this
     */
    public function execute();

    /**
     * @return int
     */
    public function rowCount();

    /**
     * @param QueryParameterInterface $parameter
     *
     * @return StatementInterface
     */
    public function bindParameter(QueryParameterInterface $parameter);

    /**
     * @param QueryParameterInterface[] $parameters
     *
     * @return StatementInterface
     */
    public function bindParameters($parameters);

    /**
     * @param $name
     * @param $value
     *
     * @return StatementInterface
     */
    public function bindValue($name, $value);


    /*
    public function fetch ($fetch_style = null, $cursor_orientation = PDO::FETCH_ORI_NEXT, $cursor_offset = 0) {}

    public function bindParam ($parameter, &$variable, $data_type = PDO::PARAM_STR, $length = null, $driver_options = null) {}

    public function bindValue ($parameter, $value, $data_type = PDO::PARAM_STR) {}

    public function fetchColumn ($column_number = 0) {}

    public function fetchAll ($fetch_style = null, $fetch_argument = null, array $ctor_args = 'array()') {}

    public function fetchObject ($class_name = "stdClass", array $ctor_args = null) {}

    public function errorCode () {}

    public function nextRowset () {}

    public function closeCursor () {}
    */
}