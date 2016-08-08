<?php
namespace Phuria\QueryBuilder;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class TableRecognizer
{
    const TYPE_CLOSURE = 1;
    const TYPE_ROUTE = 2;
    const TYPE_CLASS_NAME = 3;
    const TYPE_TABLE_NAME = 4;

    /**
     * @param mixed $stuff
     *
     * @return int
     */
    public function recognizeType($stuff)
    {
        if ($stuff instanceof \Closure) {
            return static::TYPE_CLOSURE;
        }

        if (strpos($stuff, '.')) {
            return static::TYPE_ROUTE;
        }

        if (strpos($stuff, '\\')) {
            return static::TYPE_CLASS_NAME;
        }

        return static::TYPE_TABLE_NAME;
    }

    /**
     * @param \Closure $closure
     *
     * @return string
     */
    public function extractClassName(\Closure $closure)
    {
        $ref = new \ReflectionFunction($closure);
        $firstParameter = $ref->getParameters()[0];

        return $firstParameter->getClass()->getName();
    }
}