<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\SQLBuilder\QueryBuilder;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class InsertSelectBuilder extends AbstractInsertBuilder
{
    /**
     * @var AbstractBuilder
     */
    private $selectInsert;

    /**
     * @param AbstractBuilder $sourceQb
     *
     * @return $this
     */
    public function selectInsert(AbstractBuilder $sourceQb)
    {
        $this->selectInsert = $sourceQb;

        return $this;
    }

    /**
     * @return AbstractBuilder
     */
    public function getSelectInsert()
    {
        return $this->selectInsert;
    }
}