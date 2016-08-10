<?php

namespace Phuria\QueryBuilder\Expression;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class IfNullExpression implements ExpressionInterface
{
    /**
     * @var ExpressionInterface $firstPara
     */
    private $firstParameter;

    /**
     * @var ExpressionInterface $secondParameter
     */
    private $secondParameter;

    /**
     * @param ExpressionInterface $firstParameter
     * @param ExpressionInterface $secondParameter
     */
    public function __construct(ExpressionInterface $firstParameter, ExpressionInterface $secondParameter)
    {
        $this->firstParameter = $firstParameter;
        $this->secondParameter = $secondParameter;
    }

    /**
     * @inheritdoc
     */
    public function compile()
    {
        return 'IFNULL(' . $this->firstParameter->compile() . ', ' . $this->secondParameter->compile() . ')';
    }
}