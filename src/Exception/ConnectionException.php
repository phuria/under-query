<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\UnderQuery\Exception;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class ConnectionException extends \DomainException
{
    /**
     * @param string $name
     *
     * @return ConnectionException
     */
    public static function notRegistered($name)
    {
        return new self("Connection [{$name}] is not registered.");
    }
}