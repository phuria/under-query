<?php

namespace Phuria\QueryBuilder\Expression;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class ConjunctionExpression implements ExpressionInterface
{
    const SYMBOL_EQ = '=';
    const SYMBOL_GT = '>';
    const SYMBOL_GTE = '>=';
    const SYMBOL_LT = '<';
    const SYMBOL_LTE = '<=';
    const SYMBOL_NEQ = '<>';
    const SYMBOL_NULL_EQ = '<=>';
    const SYMBOL_AND = 'AND';
    const SYMBOL_OR = 'OR';
    const SYMBOL_ADD = '+';
    const SYMBOL_DIV = 'DIV';
    const SYMBOL_DIVIDE = '/';
    const SYMBOL_MODULO = 'MOD';
    const SYMBOL_MULTIPLY = '*';
    const SYMBOL_SUBTRACT = '-';

    /**
     * @var ExpressionInterface $left
     */
    private $left;

    /**
     * @var string $connector
     */
    private $connector;

    /**
     * @var ExpressionInterface $right
     */
    private $right;

    /**
     * @param ExpressionInterface $left
     * @param string              $connector
     * @param ExpressionInterface $right
     */
    public function __construct(ExpressionInterface $left, $connector, ExpressionInterface $right)
    {
        $this->left = $left;
        $this->connector = $connector;
        $this->right = $right;
    }

    /**
     * @inheritdoc
     */
    public function compile()
    {
        return $this->left->compile() . ' ' . $this->connector . ' ' . $this->right->compile();
    }
}