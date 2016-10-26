<?php

/**
 * This file is part of UnderQuery package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\UnderQuery\Table;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
interface TableInterface
{
    /**
     * @return string
     */
    public function getTableName();

    /**
     * @return string
     */
    public function getAliasOrName();
}