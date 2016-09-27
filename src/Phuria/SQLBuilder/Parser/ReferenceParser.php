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

use Phuria\SQLBuilder\QueryBuilder\BuilderInterface;
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
            $value = $this->convertReferenceToValue($value);
        }

        return str_replace(array_keys($references), array_values($references), $this->rawSQL);
    }

    /**
     * @param $reference
     *
     * @return string
     */
    private function convertReferenceToValue($reference)
    {
        if (is_string($reference)) {
            return "\"" . $reference ."\"";
        } elseif ($reference instanceof AbstractTable) {
            return $reference->getAliasOrName();
        } elseif ($reference instanceof BuilderInterface) {
            return $reference->buildSQL();
        }

        return $reference;
    }
}