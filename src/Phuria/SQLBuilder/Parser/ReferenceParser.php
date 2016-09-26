<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\SQLBuilder\Parser;

use Phuria\SQLBuilder\QueryBuilder\Component\QueryComponentInterface;
use Phuria\SQLBuilder\ReferenceManager;
use Phuria\SQLBuilder\Table\AbstractTable;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class ReferenceParser
{
    /**
     * @var string $rawSQL
     */
    private $rawSQL;

    /**
     * @var ReferenceManager $manager
     */
    private $manager;

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
            if (is_string($value)) {
                $value = "\"" . $value ."\"";
            }

            if ($value instanceof AbstractTable) {
                $value = $value->getAliasOrName();
            }

            if ($value instanceof QueryComponentInterface) {
                $value = $value->buildSQL();
            }
        }

        return str_replace(array_keys($references), array_values($references), $this->rawSQL);
    }
}