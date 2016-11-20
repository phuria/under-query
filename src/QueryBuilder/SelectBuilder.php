<?php

/**
 * This file is part of UnderQuery package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\UnderQuery\QueryBuilder;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class SelectBuilder extends AbstractBuilder implements
    Clause\GroupByInterface,
    Clause\HavingInterface,
    Clause\JoinInterface,
    Clause\LimitInterface,
    Clause\OrderByInterface,
    Clause\SelectInterface,
    Clause\WhereInterface
{
    use Clause\GroupByTrait;
    use Clause\HavingTrait;
    use Clause\JoinTrait;
    use Clause\LimitTrait;
    use Clause\OrderByTrait;
    use Clause\SelectTrait;
    use Clause\WhereTrait;
    use Component\FromComponentTrait;
}