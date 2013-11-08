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

use Braincrafted\ArrayQuery\Operator\LowerOperator;

/**
 * LowerOperatorTest
 *
 * @package    braincrafted/arrayquery
 * @subpackage Operator
 * @author     Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright  2013 Florian Eckerstorfer
 * @license    http://opensource.org/licenses/MIT The MIT License
 * @group      unit
 */
class LowerOperatorTest extends \PHPUnit_Framework_TestCase
{
    /** @var LowerOperator */
    private $operator;

    public function setUp()
    {
        $this->operator = new LowerOperator;
    }

    /**
     * @covers Braincrafted\ArrayQuery\Operator\LowerOperator::getOperator()
     */
    public function testGetOperator()
    {
        $this->assertEquals('<', $this->operator->getOperator());
    }

    /**
     * @covers Braincrafted\ArrayQuery\Operator\LowerOperator::evaluate()
     */
    public function testEvaluate()
    {
        $this->assertTrue($this->operator->evaluate(5, 10));
        $this->assertFalse($this->operator->evaluate(5, 5));
        $this->assertFalse($this->operator->evaluate(5, 4));
    }
}
