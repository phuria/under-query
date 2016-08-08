<?php

namespace Phuria\QueryBuilder\Compiler;

use Phuria\QueryBuilder\QueryBuilder;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class CompilerManager
{
    /**
     * @var CompilerInterface[] $compilers
     */
    private $compilers = [];

    public function __construct()
    {
        $this->compilers = new \SplPriorityQueue();

        $this->addCompiler(new SelectQueryCompiler());
        $this->addCompiler(new UpdateQueryCompiler());
    }

    /**
     * @param QueryCompilerInterface $compiler
     * @param int                    $priority
     *
     * @return $this
     */
    public function addCompiler(QueryCompilerInterface $compiler, $priority = 0)
    {
        $this->compilers->insert($compiler, $priority);

        return $this;
    }

    /**
     * @param QueryBuilder $qb
     *
     * @return string
     */
    public function compile(QueryBuilder $qb)
    {
        foreach ($this->compilers as $compiler) {
            if ($compiler->canHandleQuery($qb)) {
                return $compiler->compile($qb);
            }
        }

        return null;
    }
}