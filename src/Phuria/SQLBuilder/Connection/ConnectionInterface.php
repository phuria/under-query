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

use Phuria\SQLBuilder\Statement\StatementInterface;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
interface ConnectionInterface
{
    /**
     * @param string $SQL
     *
     * @return StatementInterface
     */
    public function query($SQL);


    /**
     * @param string $SQL
     *
     * @return StatementInterface
     */
    public function prepare($SQL);
}