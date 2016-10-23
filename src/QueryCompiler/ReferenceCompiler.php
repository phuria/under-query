<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\UnderQuery\QueryCompiler;

use Phuria\UnderQuery\QueryBuilder\AbstractBuilder;
use Phuria\UnderQuery\QueryBuilder\BuilderInterface;
use Phuria\UnderQuery\Table\AbstractTable;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class ReferenceCompiler
{
    /**
     * @param CompilerPayload $payload
     *
     * @return CompilerPayload
     */
    public function compileReference(CompilerPayload $payload)
    {
        $builder = $payload->getBuilder();
        $references = [];

        if ($builder instanceof AbstractBuilder) {
            $references = $builder->getReferences()->toArray();
        }

        $actualSQL = $this->compile($payload->getActualSQL(), $references);

        return $payload->updateSQL($actualSQL);
    }

    /**
     * @param string $rawSQL
     * @param array  $references
     *
     * @return string
     */
    public function compile($rawSQL, array $references)
    {
        foreach ($references as &$value) {
            $value = $this->convertReferenceToValue($value);
        }

        return str_replace(array_keys($references), array_values($references), $rawSQL);
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