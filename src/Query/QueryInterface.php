<?php

/**
 * This file is part of UnderQuery package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\UnderQuery\Query;

use Doctrine\DBAL\Driver\Statement as StatementInterface;
use Doctrine\DBAL\Driver\ResultStatement as ResultStatementInterface;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
interface QueryInterface
{
    /**
     * @return StatementInterface
     */
    public function prepare();

    /**
     * @return ResultStatementInterface
     */
    public function execute();
}