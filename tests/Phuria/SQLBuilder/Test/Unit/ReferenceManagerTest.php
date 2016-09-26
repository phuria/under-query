<?php

/**
 * This file is part of Phuria SQL Builder package.
 *
 * Copyright (c) 2016 Beniamin Jonatan Šimko
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phuria\SQLBuilder\Test\Unit;

use Phuria\SQLBuilder\ReferenceManager;

/**
 * @author Beniamin Jonatan Šimko <spam@simko.it>
 */
class ReferenceManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function itWillReturnReference()
    {
        $manager = new ReferenceManager();

        $reference = $manager->register(new \DateTime());
        static::assertSame('@[0]', $reference);

        $reference = $manager->register(new \DateTime());
        static::assertSame('@[1]', $reference);
    }
}
