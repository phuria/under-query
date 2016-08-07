<?php

namespace Phuria\QueryBuilder;

use Phuria\QueryBuilder\Table\UnknownTable;

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
     * @param TableRegistry $registry
     */
    public function __construct(TableRegistry $registry = null)
    {
        $this->registry = $registry ?: new TableRegistry();
        $this->tableRecognizer = new TableRecognizer();
    }

    public function createNewTable($table, QueryBuilder $qb)
    {
        $tableType = $this->tableRecognizer->recognizeType($table);

        $tableClass = null;

        switch ($tableType) {
            case TableRecognizer::TYPE_CLOSURE:
                $tableClass = $this->tableRecognizer->extractClassName($table);
                break;
            case TableRecognizer::TYPE_ROUTE:
                return $this->createTableSeries(explode('.', $table), $qb);
            case TableRecognizer::TYPE_CLASS_NAME:
                $tableClass = $table;
                break;
            case TableRecognizer::TYPE_TABLE_NAME:
                $tableClass = $this->registry->getTableClass($table);
                break;
        }

        $tableObject = new $tableClass();

        if ($tableObject instanceof UnknownTable) {
            $tableObject->setTableName($table);
        }

        return $tableObject;
    }

    public function createTableSeries(array $tables, QueryBuilder $qb)
    {
        $lastTable = null;

        foreach ($tables as $table) {
            $lastTable = $this->createNewTable($table, $qb);
        }

        return $lastTable;
    }
}