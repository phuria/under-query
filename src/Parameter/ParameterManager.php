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
class ParameterManager implements ParameterManagerInterface
{
    /**
     * @var QueryParameter[] $params
     */
    private $params = [];

    /**
     * @param string $name
     *
     * @return QueryParameter
     */
    public function createOrGetParameter($name)
    {
        if (false === array_key_exists($name, $this->params)) {
            $this->params[$name] = new QueryParameter($name, null);
        }

        return $this->params[$name];
    }

    /**
     * @inheritdoc
     */
    public function bindStatement(StatementInterface $stmt)
    {
        foreach ($this->params as $param) {
            $stmt->bindValue($param->getName(), $param->getValue());
        }
    }
}