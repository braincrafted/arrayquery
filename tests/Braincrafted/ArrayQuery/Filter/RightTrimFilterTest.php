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

use Braincrafted\ArrayQuery\Filter\RightTrimFilter;

/**
 * RightTrimFilterTest
 *
 * @package    braincrafted/arrayquery
 * @subpackage Filter
 * @author     Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright  2013 Florian Eckerstorfer
 * @license    http://opensource.org/licenses/MIT The MIT License
 * @group      unit
 */
class RightTrimFilterTest extends \PHPUnit_Framework_TestCase
{
    /** @var RightTrimFilter */
    private $filter;

    public function setUp()
    {
        $this->filter = new RightTrimFilter;
    }

    /**
     * @covers Braincrafted\ArrayQuery\Filter\RightTrimFilter::getName()
     */
    public function testGetName()
    {
        $this->assertEquals('rtrim', $this->filter->getName());
    }

    /**
     * @covers Braincrafted\ArrayQuery\Filter\RightTrimFilter::evaluate()
     */
    public function testEvaluate()
    {
        $this->assertEquals(' hello', $this->filter->evaluate(' hello '));
    }
}
