<?php

namespace Phuria\QueryBuilder\Expression;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class ImplodeExpression implements ExpressionInterface
{
    /**
     * @var ExpressionInterface[] $expressionList
     */
    private $expressionList;

    /**
     * @param array $expressionList
     */
    public function __construct(array $expressionList)
    {
        $this->expressionList = $expressionList;
    }

    /**
     * @inheritdoc
     */
    public function compile()
    {
        $elements = [];

        foreach ($this->expressionList as $expression) {
            $elements[] = $expression->compile();
        }

        return implode('', $elements);
    }
}