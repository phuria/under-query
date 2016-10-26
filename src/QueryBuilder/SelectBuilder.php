<?php

/**
 * This file is part of UnderQuery package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\UnderQuery\QueryBuilder;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class SelectBuilder extends AbstractBuilder implements
    Clause\GroupByClauseInterface,
    Clause\HavingClauseInterface,
    Clause\LimitClauseInterface,
    Clause\OrderByClauseInterface,
    Clause\WhereClauseInterface,
    Component\JoinComponentInterface,
    Component\TableComponentInterface
{
    use Clause\GroupByClauseTrait;
    use Clause\HavingClauseTrait;
    use Clause\LimitClauseTrait;
    use Clause\OrderByClauseTrait;
    use Clause\WhereClauseTrait;
    use Component\JoinComponentTrait;
    use Component\TableComponentTrait;
    use Component\FromComponentTrait;

    /**
     * @var array $selectClauses
     */
    private $selectClauses = [];

    /**
     * @return $this
     */
    public function addSelect()
    {
        foreach (func_get_args() as $clause) {
            $this->doAddSelect($clause);
        }

        return $this;
    }

    /**
     * @param string $clause
     */
    private function doAddSelect($clause)
    {
        $this->selectClauses[] = $clause;
    }

    /**
     * @return array
     */
    public function getSelectClauses()
    {
        return $this->selectClauses;
    }
}