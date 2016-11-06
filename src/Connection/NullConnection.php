<?php

/**
 * This file is part of UnderQuery package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\UnderQuery\Connection;

use Phuria\UnderQuery\Statement\NullStatement;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 * @codeCoverageIgnore
 */
class NullConnection implements ConnectionInterface
{
    /**
     * @inheritdoc
     */
    public function prepareStatement($SQL, $parameters = [])
    {
        return new NullStatement();
    }

    /**
     * @inheritdoc
     */
    public function fetchScalar($SQL, array $parameters = [])
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function fetchRow($SQL, array $parameters = [])
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function fetchAll($SQL, array $parameters = [])
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function rowCount($SQL, array $parameters = [])
    {
        return 0;
    }

    /**
     * @inheritdoc
     */
    public function execute($SQL, array $parameters = [])
    {
        return 0;
    }
}