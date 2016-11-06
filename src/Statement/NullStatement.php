<?php

/**
 * This file is part of UnderQuery package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\UnderQuery\Statement;

use Phuria\UnderQuery\Parameter\QueryParameterInterface;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 * @codeCoverageIgnore
 */
class NullStatement implements StatementInterface
{
    /**
     * @inheritdoc
     */
    public function execute()
    {
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function rowCount()
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function bindParameter(QueryParameterInterface $parameter)
    {
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function bindParameters($parameters)
    {
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function bindValue($name, $value)
    {
        return $this;
    }
}