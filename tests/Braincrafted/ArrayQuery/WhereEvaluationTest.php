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
    /** @var WhereEvaluation */
    private $where;

    public function setUp()
    {
        $this->where = new WhereEvaluation;
    }

    /**
     * @covers Braincrafted\ArrayQuery\WhereEvaluation::evaluate()
     * @expectedException \InvalidArgumentException
     */
    public function testEvaluateMissingKey()
    {
        $this->where->evaluate([ 'a' => 'x' ], [ 'value' => 'x', 'operator' => '=' ]);
    }

    /**
     * @covers Braincrafted\ArrayQuery\WhereEvaluation::evaluate()
     * @expectedException \InvalidArgumentException
     */
    public function testEvaluateMissingValue()
    {
        $this->where->evaluate([ 'a' => 'x' ], [ 'key' => 'x', 'operator' => '=' ]);
    }

    /**
     * @covers Braincrafted\ArrayQuery\WhereEvaluation::evaluate()
     * @expectedException \InvalidArgumentException
     */
    public function testEvaluateMissingOperator()
    {
        $this->where->evaluate([ 'a' => 'x' ], [ 'key' => 'x', 'value' => 'y' ]);
    }

    /**
     * @covers Braincrafted\ArrayQuery\WhereEvaluation::evaluate()
     * @expectedException Braincrafted\ArrayQuery\Exception\UnkownOperatorException
     */
    public function testEvaluateUnkownOperator()
    {
        $this->where->evaluate([ 'a' => 'x' ], [ 'key' => 'a', 'value' => 'x', 'operator' => 'invalid' ]);
    }

    /**
     * @covers Braincrafted\ArrayQuery\WhereEvaluation::evaluate()
     * @covers Braincrafted\ArrayQuery\WhereEvaluation::evaluateFilter()
     * @expectedException Braincrafted\ArrayQuery\Exception\UnkownFilterException
     */
    public function testEvaluateUnkownFilter()
    {
        $this->where->evaluate(
            [ 'a' => 'x' ],
            [ 'key' => 'a', 'value' => 'x', 'operator' => '.', 'filters' => 'unkown' ]
        );
    }

    /**
     * @covers Braincrafted\ArrayQuery\WhereEvaluation::addOperator()
     * @covers Braincrafted\ArrayQuery\WhereEvaluation::evaluate()
     */
    public function testEvaluateTrue()
    {
        $operator = m::mock('Braincrafted\ArrayQuery\Operator\OperatorInterface');
        $operator->shouldReceive('getName')->andReturn('.');
        $operator->shouldReceive('evaluate')->with('x', 'x')->andReturn(true);
        $this->where->addOperator($operator);

        $this->assertTrue($this->where->evaluate([ 'a' => 'x' ], [ 'key' => 'a', 'value' => 'x', 'operator' => '.' ]));
    }

    /**
     * @covers Braincrafted\ArrayQuery\WhereEvaluation::addOperator()
     * @covers Braincrafted\ArrayQuery\WhereEvaluation::evaluate()
     */
    public function testEvaluateFalse()
    {
        $operator = m::mock('Braincrafted\ArrayQuery\Operator\OperatorInterface');
        $operator->shouldReceive('getName')->andReturn('.');
        $operator->shouldReceive('evaluate')->with('x', 'y')->andReturn(false);
        $this->where->addOperator($operator);

        $this->assertFalse($this->where->evaluate([ 'a' => 'x' ], [ 'key' => 'a', 'value' => 'y', 'operator' => '.' ]));
    }

    /**
     * @covers Braincrafted\ArrayQuery\WhereEvaluation::addFilter()
     * @covers Braincrafted\ArrayQuery\WhereEvaluation::evaluate()
     * @covers Braincrafted\ArrayQuery\WhereEvaluation::evaluateFilters()
     * @covers Braincrafted\ArrayQuery\Evaluation::evaluateFilter()
     */
    public function testEvaluateFilter()
    {
        $operator = m::mock('Braincrafted\ArrayQuery\Operator\OperatorInterface');
        $operator->shouldReceive('getName')->andReturn('.');
        $operator->shouldReceive('evaluate')->with('y', 'x')->andReturn(true);
        $this->where->addOperator($operator);

        $filter = m::mock('Braincrafted\ArrayQuery\Filter\FilterInterface');
        $filter->shouldReceive('getName')->andReturn('test');
        $filter->shouldReceive('evaluate')->with('x', [])->andReturn('y');
        $this->where->addFilter($filter);

        $this->assertTrue(
            $this->where->evaluate(
                [ 'a' => 'x' ],
                [ 'key' => 'a', 'value' => 'x', 'operator' => '.', 'filters' => 'test' ]
            )
        );
    }

    /**
     * @covers Braincrafted\ArrayQuery\WhereEvaluation::addFilter()
     * @covers Braincrafted\ArrayQuery\WhereEvaluation::evaluate()
     * @covers Braincrafted\ArrayQuery\WhereEvaluation::evaluateFilter()
     * @covers Braincrafted\ArrayQuery\Evaluation::evaluateFilter()
     */
    public function testEvaluateFilterWithArgs()
    {
        $operator = m::mock('Braincrafted\ArrayQuery\Operator\OperatorInterface');
        $operator->shouldReceive('getName')->andReturn('.');
        $operator->shouldReceive('evaluate')->with('y', 'x')->andReturn(true);
        $this->where->addOperator($operator);

        $filter = m::mock('Braincrafted\ArrayQuery\Filter\FilterInterface');
        $filter->shouldReceive('getName')->andReturn('test');
        $filter->shouldReceive('evaluate')->with('x', [ 'a' ])->andReturn('y');
        $this->where->addFilter($filter);

        $this->assertTrue(
            $this->where->evaluate(
                [ 'a' => 'x' ],
                [ 'key' => 'a', 'value' => 'x', 'operator' => '.', 'filters' => 'test a' ]
            )
        );
    }
}
