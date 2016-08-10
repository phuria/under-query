<?php

namespace Phuria\QueryBuilder\Expression;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class AddExpression implements ExpressionInterface
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
     * @inheritdoc
     */
    public function compile()
    {
        return $this->leftComponent->compile() . ' + ' . $this->rightComponent->compile();
    }
}