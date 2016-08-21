<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\QueryBuilder\ExprBuilder;

use Phuria\QueryBuilder\ExprBuilder;
use Phuria\QueryBuilder\Expression\ExpressionInterface;
use Phuria\QueryBuilder\Expression\FunctionCallContext;
use Phuria\QueryBuilder\Expression\FunctionExpression;
use Phuria\QueryBuilder\ExprNormalizer;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
trait DateTimeTrait
{
    /**
     * @param string                   $functionName
     * @param FunctionCallContext|null $context
     *
     * @return ExprBuilder
     */
    abstract public function func($functionName, FunctionCallContext $context = null);

    /**
     * @return ExpressionInterface
     */
    abstract public function getWrappedExpression();

    /**
     * @param mixed $expression
     *
     * @return ExprBuilder
     */
    public function addDate($expression)
    {
        return new ExprBuilder(new FunctionExpression(
            FunctionExpression::FUNC_ADDDATE,
            ExprNormalizer::normalizeExpression([$this->getWrappedExpression(), $expression])
        ));
    }

    /**
     * @param mixed $expression
     *
     * @return ExprBuilder
     */
    public function addTime($expression)
    {
        return new ExprBuilder(new FunctionExpression(
            FunctionExpression::FUNC_ADDTIME,
            ExprNormalizer::normalizeExpression([$this->getWrappedExpression(), $expression])
        ));
    }

    /**
     * @return ExprBuilder
     */
    public function year()
    {
        return $this->func(FunctionExpression::FUNC_YEAR);
    }
}