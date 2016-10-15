<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\SQLBuilder\DependencyInjection;

/**
 * Fixes a recognition callback by the container.
 *
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class InvokeCallback
{
    /**
     * @var callable
     */
    private $callback;

    /**
     * @param callable $callback
     */
    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    /**
     * @return mixed
     */
    public function __invoke()
    {
        return call_user_func_array($this->callback, func_get_args());
    }
}