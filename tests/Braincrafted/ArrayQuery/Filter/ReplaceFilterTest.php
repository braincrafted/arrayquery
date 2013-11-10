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

use Braincrafted\ArrayQuery\Filter\ReplaceFilter;

/**
 * ReplaceFilterTest
 *
 * @category   Test
 * @package    braincrafted/arrayquery
 * @subpackage Filter
 * @author     Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright  2013 Florian Eckerstorfer
 * @license    http://opensource.org/licenses/MIT The MIT License
 * @group      unit
 */
class ReplaceFilterTest extends \PHPUnit_Framework_TestCase
{
    /** @var ReplaceFilter */
    private $filter;

    public function setUp()
    {
        $this->filter = new ReplaceFilter;
    }

    /**
     * @covers Braincrafted\ArrayQuery\Filter\ReplaceFilter::getName()
     */
    public function testGetName()
    {
        $this->assertEquals('replace', $this->filter->getName());
    }

    /**
     * @covers Braincrafted\ArrayQuery\Filter\ReplaceFilter::evaluate()
     */
    public function testEvaluate()
    {
        $this->assertEquals('h3llo', $this->filter->evaluate('hello', [ 'e', '3' ]));
    }

    /**
     * @covers Braincrafted\ArrayQuery\Filter\ReplaceFilter::evaluate()
     * @expectedException \InvalidArgumentException
     */
    public function testEvaluateMissingArgs()
    {
        $this->filter->evaluate('hello', []);
    }
}
