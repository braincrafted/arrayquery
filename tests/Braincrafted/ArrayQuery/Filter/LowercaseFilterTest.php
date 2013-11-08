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

use Braincrafted\ArrayQuery\Filter\LowercaseFilter;

/**
 * LowercaseFilterTest
 *
 * @package    braincrafted/arrayquery
 * @subpackage Filter
 * @author     Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright  2013 Florian Eckerstorfer
 * @license    http://opensource.org/licenses/MIT The MIT License
 * @group      unit
 */
class LowercaseFilterTest extends \PHPUnit_Framework_TestCase
{
    /** @var LowercaseFilter */
    private $filter;

    public function setUp()
    {
        $this->filter = new LowercaseFilter;
    }

    /**
     * @covers Braincrafted\ArrayQuery\Filter\LowercaseFilter::getName()
     */
    public function testGetName()
    {
        $this->assertEquals('lower', $this->filter->getName());
    }

    /**
     * @covers Braincrafted\ArrayQuery\Filter\LowercaseFilter::evaluate()
     */
    public function testEvaluate()
    {
        $this->assertEquals('hello', $this->filter->evaluate('HELLO'));
    }
}
