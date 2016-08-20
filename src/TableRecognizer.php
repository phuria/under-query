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
    const TYPE_SUB_QUERY = 5;

    /**
     * @param mixed $stuff
     *
     * @return int
     */
    public function recognizeType($stuff)
    {
        switch (true) {
            case $stuff instanceof \Closure:
                return static::TYPE_CLOSURE;
            case $stuff instanceof QueryBuilder:
                return static::TYPE_SUB_QUERY;
            case false !== strpos($stuff, '.'):
                return static::TYPE_ROUTE;
            case false !== strpos($stuff, '\\'):
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