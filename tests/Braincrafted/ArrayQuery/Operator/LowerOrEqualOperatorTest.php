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

use Braincrafted\ArrayQuery\Operator\LowerOrEqualOperator;

/**
 * LowerOrEqualOperatorTest
 *
 * @package    braincrafted/arrayquery
 * @subpackage Operator
 * @author     Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright  2013 Florian Eckerstorfer
 * @license    http://opensource.org/licenses/MIT The MIT License
 * @group      unit
 */
class LowerOrEqualOperatorTest extends \PHPUnit_Framework_TestCase
{
    /** @var LowerOrEqualOperator */
    private $operator;

    public function setUp()
    {
        $this->operator = new LowerOrEqualOperator;
    }

    /**
     * @covers Braincrafted\ArrayQuery\Operator\LowerOrEqualOperator::getName()
     */
    public function testGetName()
    {
        $this->assertEquals('<=', $this->operator->getName());
    }

    /**
     * @covers Braincrafted\ArrayQuery\Operator\LowerOrEqualOperator::evaluate()
     */
    public function testEvaluate()
    {
        $this->assertTrue($this->operator->evaluate(5, 10));
        $this->assertTrue($this->operator->evaluate(5, 5));
        $this->assertFalse($this->operator->evaluate(5, 4));
    }
}
