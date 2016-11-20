<?php

/**
 * This file is part of UnderQuery package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\UnderQuery;

use Doctrine\DBAL\Driver\Connection as ConnectionInterface;
use Phuria\UnderQuery\QueryBuilder\DeleteBuilder;
use Phuria\UnderQuery\QueryBuilder\InsertBuilder;
use Phuria\UnderQuery\QueryBuilder\InsertSelectBuilder;
use Phuria\UnderQuery\QueryBuilder\QueryBuilderFacade;
use Phuria\UnderQuery\QueryBuilder\SelectBuilder;
use Phuria\UnderQuery\QueryBuilder\UpdateBuilder;
use Phuria\UnderQuery\QueryCompiler\ConcreteCompiler\DeleteCompiler;
use Phuria\UnderQuery\QueryCompiler\ConcreteCompiler\InsertCompiler;
use Phuria\UnderQuery\QueryCompiler\ConcreteCompiler\SelectCompiler;
use Phuria\UnderQuery\QueryCompiler\ConcreteCompiler\UpdateCompiler;
use Phuria\UnderQuery\QueryCompiler\QueryCompiler;
use Phuria\UnderQuery\QueryCompiler\QueryCompilerInterface;
use Phuria\UnderQuery\TableFactory\TableFactory;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class UnderQuery
{
    /**
     * @var QueryCompiler
     */
    private $queryCompiler;

    /**
     * @var ConnectionInterface|null
     */
    private $connection;

    /**
     * @param ConnectionInterface|null $connection
     */
    public function __construct(ConnectionInterface $connection = null)
    {
        $this->connection = $connection;
        $this->queryCompiler = $this->createQueryCompiler();
        $this->tableFactory = $this->createTableFactory();

        $this->queryFacade = new QueryBuilderFacade(
            $this->tableFactory,
            $this->queryCompiler,
            $this->connection
        );
    }

    /**
     * @return ConnectionInterface|null
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @return QueryCompiler
     */
    private function createQueryCompiler()
    {
        $queryCompiler = new QueryCompiler();
        $queryCompiler->addConcreteCompiler(new SelectCompiler());
        $queryCompiler->addConcreteCompiler(new InsertCompiler());
        $queryCompiler->addConcreteCompiler(new DeleteCompiler());
        $queryCompiler->addConcreteCompiler(new UpdateCompiler());

        return $queryCompiler;
    }

    /**
     * @return TableFactory
     */
    private function createTableFactory()
    {
        $tableFactory = new TableFactory();

        return $tableFactory;
    }

    /**
     * @param string $class
     *
     * @return QueryCompilerInterface
     */
    private function createQueryBuilder($class)
    {
        return new $class($this->queryFacade);
    }

    /**
     * @return SelectBuilder
     */
    public function createSelect()
    {
        return $this->createQueryBuilder(SelectBuilder::class);
    }

    /**
     * @return UpdateBuilder
     */
    public function createUpdate()
    {
        return $this->createQueryBuilder(UpdateBuilder::class);
    }

    /**
     * @return DeleteBuilder
     */
    public function createDelete()
    {
        return $this->createQueryBuilder(DeleteBuilder::class);
    }

    /**
     * @return InsertBuilder
     */
    public function createInsert()
    {
        return $this->createQueryBuilder(InsertBuilder::class);
    }

    /**
     * @return InsertSelectBuilder
     */
    public function createInsertSelect()
    {
        return $this->createQueryBuilder(InsertSelectBuilder::class);
    }
}