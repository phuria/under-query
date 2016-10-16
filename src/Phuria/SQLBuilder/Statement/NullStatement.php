<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\SQLBuilder\Statement;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class NullStatement implements StatementInterface
{
    /**
     * @inheritdoc
     */
    public function bindValue($parameter, $value)
    {
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function fetch($mode = \PDO::FETCH_ASSOC)
    {
        return null;
    }

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
}