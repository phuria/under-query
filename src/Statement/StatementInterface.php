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
     * @return $this
     */
    public function closeCursor();

    /**
     * @return int|null
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
     * @param mixed $name
     * @param mixed $value
     *
     * @return StatementInterface
     */
    public function bindValue($name, $value);

    /**
     * @param int|null $fetchStyle
     * @param int      $cursorOrientation
     * @param int      $cursorOffset
     *
     * @return mixed
     */
    public function fetch($fetchStyle = null, $cursorOrientation = \PDO::FETCH_ORI_NEXT, $cursorOffset = 0);

    /**
     * @param int $column
     *
     * @return mixed
     */
    public function fetchColumn($column = 0);

    /**
     * @param int|null $fetchStyle
     *
     * @return array
     */
    public function fetchAll($fetchStyle = null);

    /**
     * @param string $className
     * @param array  $constructorArguments
     *
     * @return mixed
     */
    public function fetchObject($className = 'stdClass', $constructorArguments = []);

    /**
     * @param callable $callback
     *
     * @return mixed
     */
    public function fetchCallback(callable $callback);
}