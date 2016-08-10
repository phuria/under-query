<?php

namespace Phuria\QueryBuilder\Expression\Arithmetic;

use Phuria\QueryBuilder\Expression\ExpressionInterface;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
abstract class AbstractArithmeticExpression implements ExpressionInterface
{
    /**
     * @var ExpressionInterface $leftComponent
     */
    private $leftComponent;

    /**
     * @var ExpressionInterface $rightComponent
     */
    private $rightComponent;

    /**
     * @param ExpressionInterface $left
     * @param ExpressionInterface $right
     */
    public function __construct(ExpressionInterface $left, ExpressionInterface $right)
    {
        $this->leftComponent = $left;
        $this->rightComponent = $right;
    }

    /**
     * @return string
     */
    abstract public function getOperator();

    /**
     * @inheritdoc
     */
    public function compile()
    {
        return $this->leftComponent->compile() . ' ' . $this->getOperator() . ' ' . $this->rightComponent->compile();
    }
}