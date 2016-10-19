<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\SQLBuilder\Test\TestCase;

use Phuria\SQLBuilder\PhuriaSQLBuilder;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
trait QueryBuilderTrait
{
    /**
     * @return PhuriaSQLBuilder
     */
    protected static function phuriaSQLBuilder()
    {
        return new PhuriaSQLBuilder();
    }
}