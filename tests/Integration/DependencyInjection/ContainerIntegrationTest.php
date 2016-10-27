<?php

/**
 * This file is part of UnderQuery package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\UnderQuery\Tests\Integration\DependencyInjection;

use Interop\Container\ContainerInterface;
use Phuria\UnderQuery\DependencyInjection\ContainerFactory;
use Phuria\UnderQuery\Parameter\ParameterCollectionInterface;
use Phuria\UnderQuery\Reference\ReferenceCollectionInterface;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class ContainerIntegrationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @covers \Phuria\UnderQuery\DependencyInjection\ContainerFactory::create()
     */
    public function itHasValidParameters()
    {
        $factory = new ContainerFactory();
        $container = $factory->create();

        static::assertInstanceOf(ContainerInterface::class, $container);

        $parameterClass = $container->get('phuria.under_query.parameter_collection.class');
        $collection = new $parameterClass;
        static::assertInstanceOf(ParameterCollectionInterface::class, $collection);

        $referenceClass = $container->get('phuria.under_query.reference_collection.class');
        $collection = new $referenceClass;
        static::assertInstanceOf(ReferenceCollectionInterface::class, $collection);
    }
}