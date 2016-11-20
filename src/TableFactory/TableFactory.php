<?php

/**
 * This file is part of UnderQuery package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\UnderQuery\TableFactory;

use Phuria\UnderQuery\QueryBuilder\BuilderInterface;
use Phuria\UnderQuery\Table\SubQueryTable;
use Phuria\UnderQuery\Table\DefaultTable;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class TableFactory implements TableFactoryInterface
{
    const TYPE_CLOSURE = 1;
    const TYPE_CLASS_NAME = 2;
    const TYPE_TABLE_NAME = 3;
    const TYPE_SUB_QUERY = 4;

    /**
     * @param mixed $stuff
     *
     * @return int
     */
    public function recognizeType($stuff)
    {
        if ($stuff instanceof \Closure) {
            return static::TYPE_CLOSURE;
        } else if ($stuff instanceof BuilderInterface) {
            return static::TYPE_SUB_QUERY;
        } else if (false !== strpos($stuff, '\\')) {
            return static::TYPE_CLASS_NAME;
        }

        return static::TYPE_TABLE_NAME;
    }

    /**
     * @inheritdoc
     */
    public function createNewTable($table, BuilderInterface $qb)
    {
        $tableType = $this->recognizeType($table);

        switch ($tableType) {
            case static::TYPE_CLOSURE:
                $tableClass = $this->extractClassName($table);
                return new $tableClass($qb);
            case static::TYPE_CLASS_NAME:
                return new $table($qb);
            case static::TYPE_SUB_QUERY:
                return new SubQueryTable($table, $qb);
        }

        $tableObject = new DefaultTable($qb);
        $tableObject->setTableName($table);

        return $tableObject;
    }

    /**
     * @param \Closure $closure
     *
     * @return string
     */
    public function extractClassName(\Closure $closure)
    {
        $ref = new \ReflectionFunction($closure);
        $firstParameter = $ref->getParameters()[0];

        return $firstParameter->getClass()->getName();
    }
}