<?php

namespace Phuria\QueryBuilder\Expression;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class RawExpression implements ExpressionInterface
{
    /**
     * @var mixed $rawData
     */
    private $rawData;

    /**
     * @param mixed $rawData
     */
    public function __construct($rawData)
    {
        $this->rawData = $rawData;
    }

    /**
     * @inheritdoc
     */
    public function compile()
    {
        return (string) $this->rawData;
    }
}