<?php

namespace Braincrafted\ArrayQuery;

use \Mockery as m;

use Braincrafted\ArrayQuery\SelectEvaluation;

/**
 * SelectEvaluationTest
 *
 * @category  Test
 * @package   braincrafted/arrayquery
 * @author    Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright 2013 Florian Eckerstorfer
 * @license   http://opensource.org/licenses/MIT The MIT License
 * @group     unit
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
     * @covers Braincrafted\ArrayQuery\Evaluation::evaluateFilter()
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
     * @covers Braincrafted\ArrayQuery\Evaluation::evaluateFilter()
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
