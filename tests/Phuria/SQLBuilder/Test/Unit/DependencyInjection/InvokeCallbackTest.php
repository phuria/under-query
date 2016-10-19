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

use Phuria\SQLBuilder\DependencyInjection\InvokeCallback;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class InvokeCallbackTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @covers \Phuria\SQLBuilder\DependencyInjection\InvokeCallback
     */
    public function itCallCallback()
    {
        $invoke = new InvokeCallback(function () {
            return 123;
        });

        static::assertTrue(is_callable($invoke));
        static::assertSame(123, $invoke());
    }
}
