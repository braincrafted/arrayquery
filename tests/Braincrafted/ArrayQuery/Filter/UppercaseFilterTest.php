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

use Braincrafted\ArrayQuery\Filter\UppercaseFilter;

/**
 * UppercaseFilterTest
 *
 * @package    braincrafted/arrayquery
 * @subpackage Filter
 * @author     Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright  2013 Florian Eckerstorfer
 * @license    http://opensource.org/licenses/MIT The MIT License
 * @group      unit
 */
class UppercaseFilterTest extends \PHPUnit_Framework_TestCase
{
    /** @var UppercaseFilter */
    private $filter;

    public function setUp()
    {
        $this->filter = new UppercaseFilter;
    }

    /**
     * @covers Braincrafted\ArrayQuery\Filter\UppercaseFilter::getName()
     */
    public function testGetName()
    {
        $this->assertEquals('upper', $this->filter->getName());
    }

    /**
     * @covers Braincrafted\ArrayQuery\Filter\UppercaseFilter::evaluate()
     */
    public function testEvaluate()
    {
        $this->assertEquals('HELLO', $this->filter->evaluate('hello'));
    }
}
