<?php

/**
 * This file is part of braincrafted/arrayquery.
 *
 * (c) Florian Eckerstorfer <florian@eckerstorfer.co>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Braincrafted\ArrayQuery\Operator;

use Braincrafted\ArrayQuery\Operator\GreaterOperator;

/**
 * GreaterOperatorTest
 *
 * @category   Test
 * @package    braincrafted/arrayquery
 * @subpackage Operator
 * @author     Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright  2013 Florian Eckerstorfer
 * @license    http://opensource.org/licenses/MIT The MIT License
 * @group      unit
 */
class GreaterOperatorTest extends \PHPUnit_Framework_TestCase
{
    /** @var GreaterOperator */
    private $operator;

    public function setUp()
    {
        $this->operator = new GreaterOperator;
    }

    /**
     * @covers Braincrafted\ArrayQuery\Operator\GreaterOperator::getName()
     */
    public function testGetName()
    {
        $this->assertEquals('>', $this->operator->getName());
    }

    /**
     * @covers Braincrafted\ArrayQuery\Operator\GreaterOperator::evaluate()
     */
    public function testEvaluate()
    {
        $this->assertTrue($this->operator->evaluate(10, 5));
        $this->assertFalse($this->operator->evaluate(5, 5));
        $this->assertFalse($this->operator->evaluate(4, 5));
    }
}
