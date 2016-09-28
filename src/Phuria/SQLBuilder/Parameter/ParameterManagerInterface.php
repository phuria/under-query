<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\SQLBuilder\Parameter;

use Phuria\SQLBuilder\Statement\StatementInterface;

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

    /**
     * @param string $name
     *
     * @return QueryParameter
     */
    public function createOrGetParameter($name);

    /**
     * @param mixed $value
     *
     * @return string
     */
    public function createReference($value);

    /**
     * @return array
     */
    public function getReferences();
}