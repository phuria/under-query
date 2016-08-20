<?php

namespace Phuria\QueryBuilder\Expression;

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
     * @param $functionName
     * @param $arguments
     */
    public function __construct($functionName, ExpressionInterface $arguments)
    {
        $this->functionName = $functionName;
        $this->arguments = $arguments;
    }

    /**
     * @inheritdoc
     */
    public function compile()
    {
        return $this->functionName . '(' . $this->arguments->compile() . ')';
    }
}