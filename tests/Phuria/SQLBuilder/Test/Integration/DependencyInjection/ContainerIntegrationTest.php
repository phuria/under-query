<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\SQLBuilder\Test\Integration\DependencyInjection;

use Interop\Container\ContainerInterface;
use Phuria\SQLBuilder\DependencyInjection\ContainerFactory;
use Phuria\SQLBuilder\Parameter\ParameterManagerInterface;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class ContainerIntegrationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @covers \Phuria\SQLBuilder\DependencyInjection\ContainerFactory::create()
     */
    public function itHasValidParameters()
    {
        $factory = new ContainerFactory();
        $container = $factory->create();

        static::assertInstanceOf(ContainerInterface::class, $container);

        $parameterClass = $container->get('phuria.sql_builder.parameter_manager.class');
        $parameterManager = new $parameterClass;
        static::assertInstanceOf(ParameterManagerInterface::class, $parameterManager);
    }
}