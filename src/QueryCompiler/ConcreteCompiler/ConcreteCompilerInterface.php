<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\UnderQuery\QueryCompiler\ConcreteCompiler;

use Phuria\UnderQuery\QueryBuilder\BuilderInterface;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
interface ConcreteCompilerInterface
{
    /**
     * @param BuilderInterface $builder
     *
     * @return boolean
     */
    public function supportsBuilder(BuilderInterface $builder);

    /**
     * @param BuilderInterface $builder
     *
     * @return string
     */
    public function compile(BuilderInterface $builder);
}