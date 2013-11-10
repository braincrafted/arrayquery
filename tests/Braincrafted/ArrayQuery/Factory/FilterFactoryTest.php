<?php

/**
 * This file is part of braincrafted/arrayquery.
 *
 * (c) Florian Eckerstorfer <florian@eckerstorfer.co>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Braincrafted\ArrayQuery\Factory;

use Braincrafted\ArrayQuery\Factory\FilterFactory;

/**
 * FilterFactoryTest
 *
 * @package    braincrafted/arrayquery
 * @subpackage Factory
 * @author     Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright  2013 Florian Eckerstorfer
 * @license    http://opensource.org/licenses/MIT The MIT License
 * @group      unit
 */
class FilterFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Braincrafted\ArrayQuery\Factory\FilterFactory::getFilters()
     */
    public function testGetFilters()
    {
        $operators = FilterFactory::getFilters();

        $this->assertCount(7, $operators);
        foreach ($operators as $operator) {
            $this->assertInstanceOf('Braincrafted\ArrayQuery\Filter\FilterInterface', $operator);
        }
    }
}
