<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\QueryBuilder\Expression;

use Phuria\QueryBuilder\ExprBuilder;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class FunctionExpression implements ExpressionInterface
{
    const FUNC_ASCI = 'ASCI';
    const FUNC_BIN = 'BIN';
    const FUNC_BIT_LENGTH = 'BIT_LENGTH';
    const FUNC_CHAR = 'CHAR';
    const FUNC_COALESCE = 'COALESCE';
    const FUNC_CONCAT = 'CONCAT';
    const FUNC_CONCAT_WS = 'CONCAT_WS';
    const FUNC_ELT = 'ELT';
    const FUNC_EXPORT_SET = 'EXPORT_SET';
    const FUNC_FIELD = 'FIELD';
    const FUNC_IFNULL = 'IFNULL';
    const FUNC_MAX = 'MAX';
    const FUNC_SUM = 'SUM';
    const FUNC_YEAR = 'YEAR';

    /**
     * @var string $functionName
     */
    private $functionName;

    /**
     * @var ExpressionInterface $args
     */
    private $arguments;

    /**
     * @var FunctionCallContext|null $context
     */
    private $context;

    /**
     * @param string                   $functionName
     * @param ExpressionInterface      $arguments
     * @param FunctionCallContext|null $context
     */
    public function __construct($functionName, ExpressionInterface $arguments, FunctionCallContext $context = null)
    {
        $this->functionName = $functionName;
        $this->arguments = $arguments;
        $this->context = $context;
    }

    /**
     * @inheritdoc
     */
    public function compile()
    {
        $expression = $this->arguments;

        if ($expression instanceof ExprBuilder) {
            $expression = $expression->getWrappedExpression();
        }

        if ($expression instanceof ExpressionCollection) {
            $expression = $expression->changeSeparator(', ');
        }

        return $this->functionName . '(' . $expression->compile() . $this->compileHints() . ')';
    }

    /**
     * @return string
     */
    private function compileHints()
    {
        if (null === $this->context) {
            return '';
        }

        $compiledHints = [];

        foreach ($this->context->getCallHints() as $hint) {
            $compiledHints[] = $hint->compile();
        }

        return implode('', $compiledHints);
    }
}