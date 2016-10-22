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
use Phuria\SQLBuilder\Parameter\ParameterCollectionInterface;
use Phuria\SQLBuilder\Reference\ReferenceCollectionInterface;

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

        $parameterClass = $container->get('phuria.sql_builder.parameter_collection.class');
        $collection = new $parameterClass;
        static::assertInstanceOf(ParameterCollectionInterface::class, $collection);

        $referenceClass = $container->get('phuria.sql_builder.reference_collection.class');
        $collection = new $referenceClass;
        static::assertInstanceOf(ReferenceCollectionInterface::class, $collection);
    }
}