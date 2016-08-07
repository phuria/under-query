<?php

namespace Phuria\QueryBuilder\Expression;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class ImplodeExpression implements ExpressionInterface
{
    /**
     * @var array $expressionList
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
        $elements = array_map(function ($element) {
            if ($element instanceof ExpressionInterface) {
                return $element->compile();
            }

            return $element;
        }, $this->expressionList);

        return implode('', $elements);
    }
}