<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\QueryBuilder\Parser;

use Phuria\QueryBuilder\ReferenceManager;
use Phuria\QueryBuilder\Table\AbstractTable;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class ReferenceParser
{
    /**
     * @param                  $rawSQL
     * @param ReferenceManager $manager
     */
    public function __construct($rawSQL, ReferenceManager $manager)
    {
        $this->rawSQL = $rawSQL;
        $this->manager = $manager;
    }

    /**
     * @return string
     */
    public function parseSQL()
    {
        $references = $this->manager->all();

        foreach ($references as &$value) {
            if ($value instanceof AbstractTable) {
                $value = $value->getAliasOrName();
            }
        }

        return str_replace(array_keys($references), array_values($references), $this->rawSQL);
    }
}