<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\UnderQuery\Query;

use Phuria\UnderQuery\Connection\ConnectionInterface;
use Phuria\UnderQuery\Connection\ConnectionManagerInterface;
use Phuria\UnderQuery\Parameter\ParameterCollection;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class QueryFactory implements QueryFactoryInterface
{
    /**
     * @var ConnectionManagerInterface
     */
    private $connectionManager;

    /**
     * @param ConnectionManagerInterface $connectionManager
     */
    public function __construct(ConnectionManagerInterface $connectionManager)
    {
        $this->connectionManager = $connectionManager;
    }

    /**
     * @inheritdoc
     */
    public function buildQuery($SQL, array $parameters, $connectionHint = null)
    {
        if ($connectionHint instanceof ConnectionInterface) {
            $connection = $connectionHint;
        } else {
            $connection = $this->connectionManager->getConnection($connectionHint);
        }

        return new Query($SQL, new ParameterCollection($parameters), $connection);
    }
}
