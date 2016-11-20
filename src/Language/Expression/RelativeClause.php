<?php

/**
 * This file is part of UnderQuery package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\UnderQuery\Language\Expression;

use Phuria\UnderQuery\Table\TableInterface;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class RelativeClause
{
    const RELATIVE_DIRECTIVE = '@.';
    const SELF_DIRECTIVE = '@self.';

    /**
     * @var TableInterface
     */
    private $relatedTable;

    /**
     * @var string
     */
    private $clause;

    /**
     * @param TableInterface $relatedTo
     * @param string         $clause
     * @param string         $directive
     */
    public function __construct(TableInterface $relatedTo, $clause, $directive)
    {
        $this->relatedTable = $relatedTo;
        $this->clause = $clause;
        $this->directive = $directive;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->relatedTable->getQueryBuilder()->toReference($this);
    }

    /**
     * @return TableInterface
     */
    public function getRelatedTable()
    {
        return $this->relatedTable;
    }

    /**
     * @return string
     */
    public function getClause()
    {
        return $this->clause;
    }

    /**
     * @return string
     */
    public function getDirective()
    {
        return $this->directive;
    }
}