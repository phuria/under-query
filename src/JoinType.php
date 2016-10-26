<?php

/**
 * This file is part of UnderQuery package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\UnderQuery;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class JoinType
{
    const JOIN = 1;
    const CROSS_JOIN = 2;
    const LEFT_JOIN = 3;
    const RIGHT_JOIN = 4;
    const INNER_JOIN = 5;
    const STRAIGHT_JOIN = 6;
}