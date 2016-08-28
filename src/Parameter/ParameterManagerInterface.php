<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\QueryBuilder\Parameter;

use Phuria\QueryBuilder\Statement\StatementInterface;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
interface ParameterManagerInterface
{
    /**
     * @param StatementInterface $stmt
     *
     * @return ParameterManagerInterface
     */
    public function bindStatement(StatementInterface $stmt);
}