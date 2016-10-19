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

use Interop\Container\ContainerInterface;
use Pimple\Container;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class PimpleContainer implements ContainerInterface
{
    /**
     * @var Container
     */
    private $wrappedContainer;

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->wrappedContainer = $container;
    }

    /**
     * @inheritdoc
     */
    public function get($id)
    {
        return $this->wrappedContainer->offsetGet($id);
    }

    /**
     * @inheritdoc
     */
    public function has($id)
    {
        return $this->wrappedContainer->offsetExists($id);
    }

    /**
     * @param string $id
     * @param string $value
     */
    public function setParameter($id, $value)
    {
        $this->wrappedContainer[$id] = $value;
    }

    /**
     * @param string   $id
     * @param callable $callback
     */
    public function setServiceFromCallback($id, callable $callback)
    {
        $this->wrappedContainer[$id] = new InvokeCallback($callback);
    }

    /**
     * @return Container
     */
    public function getWrappedContainer()
    {
        return $this->wrappedContainer;
    }
}