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

use Braincrafted\ArrayQuery\ArrayQuery;
use Braincrafted\ArrayQuery\Operator\EqualOperator;

/**
 * ArrayQueryTest
 *
 * @category  Test
 * @package   braincrafted/arrayquery
 * @author    Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright 2013 Florian Eckerstorfer
 * @license   http://opensource.org/licenses/MIT The MIT License
 * @group     unit
 */
class ArrayQueryTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->whereEvaluation = m::mock('Braincrafted\ArrayQuery\WhereEvaluation');
    }

    /**
     * @covers Braincrafted\ArrayQuery\ArrayQuery::select()
     * @covers Braincrafted\ArrayQuery\ArrayQuery::from()
     * @covers Braincrafted\ArrayQuery\ArrayQuery::execute()
     */
    public function testExecute()
    {
        $this->whereEvaluation->shouldReceive('evaluate')->never();

        $data = [ [ 'name' => 'foo' ], [ 'name' => 'bar' ], [ 'name' => 'baz' ] ];
        $q = (new ArrayQuery($this->whereEvaluation))
            ->select('name')
            ->from($data);
        $result = $q->execute();

        $this->assertCount(3, $result);
        $this->assertEquals('foo', $result[0]['name']);
        $this->assertEquals('bar', $result[1]['name']);
        $this->assertEquals('baz', $result[2]['name']);
    }

    /**
     * @covers Braincrafted\ArrayQuery\ArrayQuery::select()
     * @covers Braincrafted\ArrayQuery\ArrayQuery::from()
     * @covers Braincrafted\ArrayQuery\ArrayQuery::execute()
     * @covers Braincrafted\ArrayQuery\ArrayQuery::where()
     * @covers Braincrafted\ArrayQuery\ArrayQuery::evaluateWhere()
     */
    public function testExecuteWhere()
    {
        $this->whereEvaluation
            ->shouldReceive('evaluate')
            ->with([ 'name' => 'foo' ], [ 'name', 'foo', '=', [] ])
            ->once()
            ->andReturn(true);
        $this->whereEvaluation
            ->shouldReceive('evaluate')
            ->with([ 'name' => 'bar' ], [ 'name', 'foo', '=', [] ])
            ->once()
            ->andReturn(false);

        $data = [ [ 'name' => 'foo' ], [ 'name' => 'bar' ] ];
        $q = (new ArrayQuery($this->whereEvaluation))
            ->select('name')
            ->from($data)
            ->where('name', 'foo');
        $result = $q->execute();

        $this->assertCount(1, $result);
        $this->assertEquals('foo', $result[0]['name']);
    }

    /**
     * @covers Braincrafted\ArrayQuery\ArrayQuery::select()
     * @covers Braincrafted\ArrayQuery\ArrayQuery::from()
     * @covers Braincrafted\ArrayQuery\ArrayQuery::execute()
     * @covers Braincrafted\ArrayQuery\ArrayQuery::where()
     * @covers Braincrafted\ArrayQuery\ArrayQuery::evaluateWhere()
     */
    public function testExecuteOperator()
    {
        $this->whereEvaluation
            ->shouldReceive('evaluate')
            ->with([ 'name' => 'foo' ], [ 'name', 'foo', 'like', [] ])
            ->once()
            ->andReturn(true);

        $data = [ [ 'name' => 'foo' ] ];
        $q = (new ArrayQuery($this->whereEvaluation))
            ->select('name')
            ->from($data)
            ->where('name', 'foo', 'like');
        $result = $q->execute();

        $this->assertCount(1, $result);
        $this->assertEquals('foo', $result[0]['name']);
    }

    /**
     * @covers Braincrafted\ArrayQuery\ArrayQuery::select()
     * @covers Braincrafted\ArrayQuery\ArrayQuery::from()
     * @covers Braincrafted\ArrayQuery\ArrayQuery::execute()
     * @covers Braincrafted\ArrayQuery\ArrayQuery::where()
     * @covers Braincrafted\ArrayQuery\ArrayQuery::evaluateWhere()
     */
    public function testExecuteFilter()
    {
        $this->whereEvaluation
            ->shouldReceive('evaluate')
            ->with([ 'name' => 'foo' ], [ 'name', 'foo', 'like', 'lower' ])
            ->once()
            ->andReturn(true);

        $data = [ [ 'name' => 'foo' ] ];
        $q = (new ArrayQuery($this->whereEvaluation))
            ->select('name')
            ->from($data)
            ->where('name', 'foo', 'like', 'lower');
        $result = $q->execute();

        $this->assertCount(1, $result);
        $this->assertEquals('foo', $result[0]['name']);
    }
}
