<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\SQLBuilder\Statement;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
interface StatementInterface
{
    /**
     * @param mixed $parameter
     * @param mixed $value
     *
     * @return $this
     */
    public function bindValue($parameter, $value);

    /**
     * @return mixed
     */
    public function fetchScalar();

    /**
     * @return $this
     */
    public function execute();

    /**
     * @return int
     */
    public function rowCount();
}