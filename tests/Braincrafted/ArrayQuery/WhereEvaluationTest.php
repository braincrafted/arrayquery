<?php

/**
 * This file is part of braincrafted/arrayquery.
 *
 * (c) Florian Eckerstorfer <florian@eckerstorfer.co>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Braincrafted\ArrayQuery;

use \Mockery as m;

use Braincrafted\ArrayQuery\WhereEvaluation;

/**
 * WhereEvaluationTest
 *
 * @package   braincrafted/arrayquery
 * @author    Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright 2013 Florian Eckerstorfer
 * @license   http://opensource.org/licenses/MIT The MIT License
 * @group     unit
 */
class WhereEvaluationTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->where = new WhereEvaluation;
    }

    /**
     * @covers Braincrafted\ArrayQuery\WhereEvaluation::evaluate()
     * @expectedException Braincrafted\ArrayQuery\Exception\UnkownOperatorException
     */
    public function testEvaluateUnkownOperator()
    {
        $this->where->evaluate([ 'a' => 'x' ], [ 'a', 'x', 'invalid' ]);
    }

    /**
     * @covers Braincrafted\ArrayQuery\WhereEvaluation::evaluate()
     * @covers Braincrafted\ArrayQuery\WhereEvaluation::addOperator()
     */
    public function testEvaluateTrue()
    {
        $operator = m::mock('Braincrafted\ArrayQuery\Operator\OperatorInterface');
        $operator->shouldReceive('getOperator')->andReturn('.');
        $operator->shouldReceive('evaluate')->with('x', 'x')->andReturn(true);
        $this->where->addOperator($operator);

        $this->assertTrue($this->where->evaluate([ 'a' => 'x' ], [ 'a', 'x', '.' ]));
    }

    /**
     * @covers Braincrafted\ArrayQuery\WhereEvaluation::evaluate()
     * @covers Braincrafted\ArrayQuery\WhereEvaluation::addOperator()
     */
    public function testEvaluateFalse()
    {
        $operator = m::mock('Braincrafted\ArrayQuery\Operator\OperatorInterface');
        $operator->shouldReceive('getOperator')->andReturn('.');
        $operator->shouldReceive('evaluate')->with('x', 'y')->andReturn(false);
        $this->where->addOperator($operator);

        $this->assertFalse($this->where->evaluate([ 'a' => 'x' ], [ 'a', 'y', '.' ]));
    }
}
