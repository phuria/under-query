<?php

namespace Phuria;

use Phuria\QueryBuilder\QueryBuilder as QB;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class QueryBuilder
{
    public function create()
    {
        return new QB();
    }
}