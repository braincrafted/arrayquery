<?php

namespace Braincrafted\ArrayQuery;

use \Mockery as m;

use Braincrafted\ArrayQuery\SelectEvaluation;

/**
 * SelectEvaluationTest
 *
 * @group unit
 */
class SelectEvaluationTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->select = new SelectEvaluation;
    }

    /**
     * @covers Braincrafted\ArrayQuery\SelectEvaluation::evaluate()
     * @expectedException Braincrafted\ArrayQuery\Exception\UnkownFilterException
     */
    public function testEvaluateUnkownFilter()
    {
        $this->select->evaluate('x', 'unkown');
    }

    /**
     * @covers Braincrafted\ArrayQuery\SelectEvaluation::addFilter()
     * @covers Braincrafted\ArrayQuery\SelectEvaluation::evaluate()
     */
    public function testEvaluateFilter()
    {
        $filter = m::mock('Braincrafted\ArrayQuery\Filter\FilterInterface');
        $filter->shouldReceive('getName')->andReturn('test');
        $filter->shouldReceive('evaluate')->with('x', [])->andReturn('y');
        $this->select->addFilter($filter);

        $this->assertEquals('y', $this->select->evaluate('x', 'test'));
    }

    /**
     * @covers Braincrafted\ArrayQuery\SelectEvaluation::addFilter()
     * @covers Braincrafted\ArrayQuery\SelectEvaluation::evaluate()
     */
    public function testEvaluateFilterWithArgs()
    {
        $filter = m::mock('Braincrafted\ArrayQuery\Filter\FilterInterface');
        $filter->shouldReceive('getName')->andReturn('test');
        $filter->shouldReceive('evaluate')->with('x', [ 5 ])->andReturn('y');
        $this->select->addFilter($filter);

        $this->assertEquals('y', $this->select->evaluate('x', 'test 5'));
    }
}
