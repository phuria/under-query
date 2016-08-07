<?php

namespace Phuria\QueryBuilder\Expression;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
interface ExpressionInterface
{
    /**
     * @return mixed
     */
    public function compile();
}