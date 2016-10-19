<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\SQLBuilder\Test\Unit\DependencyInjection;

use Phuria\SQLBuilder\DependencyInjection\PimpleContainer;
use Pimple\Container;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class PimpleContainerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @covers \Phuria\SQLBuilder\DependencyInjection\PimpleContainer
     */
    public function itWrapContainer()
    {
        $container = new Container();
        $pimpleContainer = new PimpleContainer($container);

        static::assertSame($container, $pimpleContainer->getWrappedContainer());
    }

    /**
     * @test
     * @covers \Phuria\SQLBuilder\DependencyInjection\PimpleContainer
     */
    public function itReturnGivenService()
    {
        $testService = (object) ['foo' => 123];

        $container = new Container();
        $pimpleContainer = new PimpleContainer($container);

        $pimpleContainer->setServiceFromCallback('test', function () use ($testService) {
            return $testService;
        });

        static::assertTrue($pimpleContainer->has('test'));
        static::assertSame($pimpleContainer->get('test'), $testService);
    }

    /**
     * @test
     * @covers \Phuria\SQLBuilder\DependencyInjection\PimpleContainer
     */
    public function itSetParameter()
    {
        $parameter = 'foo';

        $container = new Container();
        $pimpleContainer = new PimpleContainer($container);

        $pimpleContainer->setParameter('boo', $parameter);
        static::assertTrue($pimpleContainer->has('boo'));
        static::assertSame($parameter, $pimpleContainer->get('boo'));
    }
}
