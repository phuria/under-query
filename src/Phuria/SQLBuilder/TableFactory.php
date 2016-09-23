<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\SQLBuilder;

use Phuria\SQLBuilder\Table\AbstractTable;
use Phuria\SQLBuilder\Table\SubQueryTable;
use Phuria\SQLBuilder\Table\UnknownTable;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class TableFactory
{
    /**
     * @var TableRegistry $registry
     */
    private $registry;

    /**
     * @var TableRecognizer $tableRecognizer
     */
    private $tableRecognizer;

    /**
     * @param TableRegistry $registry
     */
    public function __construct(TableRegistry $registry = null)
    {
        $this->registry = $registry ?: new TableRegistry();
        $this->tableRecognizer = new TableRecognizer();
    }

    /**
     * @param mixed        $table
     * @param QueryBuilder $qb
     *
     * @return AbstractTable
     */
    public function createNewTable($table, QueryBuilder $qb)
    {
        $tableType = $this->tableRecognizer->recognizeType($table);

        $tableClass = null;

        switch ($tableType) {
            case TableRecognizer::TYPE_CLOSURE:
                $tableClass = $this->tableRecognizer->extractClassName($table);
                break;
            case TableRecognizer::TYPE_CLASS_NAME:
                $tableClass = $table;
                break;
            case TableRecognizer::TYPE_TABLE_NAME:
                $tableClass = $this->registry->getTableClass($table);
                break;
            case TableRecognizer::TYPE_SUB_QUERY:
                return $this->createSubQueryTable($table, $qb);
        }

        return $this->doCreate($table, $tableClass, $qb);
    }

    /**
     * @param string       $requestedTable
     * @param string       $tableClass
     * @param QueryBuilder $qb
     *
     * @return mixed
     */
    private function doCreate($requestedTable, $tableClass, QueryBuilder $qb)
    {
        $tableObject = new $tableClass($qb);

        if ($tableObject instanceof UnknownTable) {
            $tableObject->setTableName($requestedTable);
        }

        return $tableObject;
    }

    /**
     * @param QueryBuilder $subQb
     * @param QueryBuilder $qb
     *
     * @return SubQueryTable
     */
    public function createSubQueryTable(QueryBuilder $subQb, QueryBuilder $qb)
    {
        return new SubQueryTable($subQb, $qb);
    }
}