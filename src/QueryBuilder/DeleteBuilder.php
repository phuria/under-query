<?php

/**
 * This file is part of Phuria SQL Builder package.
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
class DeleteBuilder extends AbstractBuilder implements
    Clause\LimitClauseInterface,
    Clause\OrderByClauseInterface,
    Clause\WhereClauseInterface,
    Component\JoinComponentInterface,
    Component\TableComponentInterface
{
    use Clause\LimitClauseTrait;
    use Clause\OrderByClauseTrait;
    use Clause\WhereClauseTrait;
    use Component\JoinComponentTrait;
    use Component\TableComponentTrait;
    use Component\FromComponentTrait;

    /**
     * @var array $deleteClauses
     */
    private $deleteClauses = [];

    /**
     * @return $this
     */
    public function addDelete()
    {
        foreach (func_get_args() as $clause) {
            $this->doAddDelete($clause);
        }

        return $this;
    }

    /**
     * @param mixed $clause
     */
    private function doAddDelete($clause)
    {
        $this->deleteClauses[] = $clause;
    }

    /**
     * @return array
     */
    public function getDeleteClauses()
    {
        return $this->deleteClauses;
    }
}