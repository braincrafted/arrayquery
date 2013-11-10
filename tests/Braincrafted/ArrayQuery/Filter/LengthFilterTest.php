<?php

/**
 * This file is part of braincrafted/arrayquery.
 *
 * (c) Florian Eckerstorfer <florian@eckerstorfer.co>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Braincrafted\ArrayQuery\Filter;

use Braincrafted\ArrayQuery\Filter\LengthFilter;

/**
 * LengthFilterTest
 *
 * @category   Test
 * @package    braincrafted/arrayquery
 * @subpackage Filter
 * @author     Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright  2013 Florian Eckerstorfer
 * @license    http://opensource.org/licenses/MIT The MIT License
 * @group      unit
 */
class LengthFilterTest extends \PHPUnit_Framework_TestCase
{
    /** @var LengthFilter */
    private $filter;

    public function setUp()
    {
        $this->filter = new LengthFilter;
    }

    /**
     * @covers Braincrafted\ArrayQuery\Filter\LengthFilter::getName()
     */
    public function testGetName()
    {
        $this->assertEquals('length', $this->filter->getName());
    }

    /**
     * @covers Braincrafted\ArrayQuery\Filter\LengthFilter::evaluate()
     */
    public function testEvaluate()
    {
        $this->assertEquals(3, $this->filter->evaluate('foo'));
    }
}
