<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\SQLBuilder\Connection;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
interface ConnectionInterface
{
    /**
     * @param string $SQL
     * @param array  $parameters
     *
     * @return mixed|null Null when no results.
     */
    public function fetchScalar($SQL, array $parameters = []);

    /**
     * @param string $SQL
     * @param array  $parameters
     *
     * @return mixed|null Null when no results.
     */
    public function fetchRow($SQL, array $parameters = []);

    /**
     * @param string $SQL
     * @param array  $parameters
     *
     * @return array Empty array when no results.
     */
    public function fetchAll($SQL, array $parameters = []);

    /**
     * @param string $SQL
     * @param array  $parameters
     *
     * @return int
     */
    public function rowCount($SQL, array $parameters = []);
}