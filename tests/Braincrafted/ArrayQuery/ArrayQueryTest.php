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
        $this->selectEvaluation = m::mock('Braincrafted\ArrayQuery\SelectEvaluation');
        $this->whereEvaluation = m::mock('Braincrafted\ArrayQuery\WhereEvaluation');
    }

    /**
     * @covers Braincrafted\ArrayQuery\ArrayQuery::select()
     * @covers Braincrafted\ArrayQuery\ArrayQuery::from()
     * @covers Braincrafted\ArrayQuery\ArrayQuery::execute()
     * @covers Braincrafted\ArrayQuery\ArrayQuery::findAll()
     */
    public function testFindAll()
    {
        $this->whereEvaluation->shouldReceive('evaluate')->never();
        $this->selectEvaluation->shouldReceive('evaluate')->with('foo', m::any())->andReturn('foo');
        $this->selectEvaluation->shouldReceive('evaluate')->with('bar', m::any())->andReturn('bar');
        $this->selectEvaluation->shouldReceive('evaluate')->with('baz', m::any())->andReturn('baz');

        $data = [ [ 'name' => 'foo' ], [ 'name' => 'bar' ], [ 'name' => 'baz' ] ];
        $q = (new ArrayQuery($this->selectEvaluation, $this->whereEvaluation))
            ->select('name')
            ->from($data);
        $result = $q->findAll();

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
     * @covers Braincrafted\ArrayQuery\ArrayQuery::findAll()
     */
    public function testExecuteWhere()
    {
        $this->selectEvaluation->shouldReceive('evaluate')->with('foo', m::any())->andReturn('foo');
        $this->selectEvaluation->shouldReceive('evaluate')->with('bar', m::any())->andReturn('bar');

        $this->whereEvaluation
            ->shouldReceive('evaluate')
            ->with([ 'name' => 'foo' ], [ 'key' => 'name', 'value' => 'foo', 'operator' => '=', 'filters' => [] ])
            ->once()
            ->andReturn(true);
        $this->whereEvaluation
            ->shouldReceive('evaluate')
            ->with([ 'name' => 'bar' ], [ 'key' => 'name', 'value' => 'foo', 'operator' => '=', 'filters' => [] ])
            ->once()
            ->andReturn(false);

        $data = [ [ 'name' => 'foo' ], [ 'name' => 'bar' ] ];
        $q = (new ArrayQuery($this->selectEvaluation, $this->whereEvaluation))
            ->select('name')
            ->from($data)
            ->where('name', 'foo');
        $result = $q->findAll();

        $this->assertCount(1, $result);
        $this->assertEquals('foo', $result[0]['name']);
    }

    /**
     * @covers Braincrafted\ArrayQuery\ArrayQuery::select()
     * @covers Braincrafted\ArrayQuery\ArrayQuery::from()
     * @covers Braincrafted\ArrayQuery\ArrayQuery::execute()
     * @covers Braincrafted\ArrayQuery\ArrayQuery::where()
     * @covers Braincrafted\ArrayQuery\ArrayQuery::evaluateWhere()
     * @covers Braincrafted\ArrayQuery\ArrayQuery::findAll()
     */
    public function testExecuteOperator()
    {
        $this->selectEvaluation->shouldReceive('evaluate')->with('foo', m::any())->andReturn('foo');

        $this->whereEvaluation
            ->shouldReceive('evaluate')
            ->with([ 'name' => 'foo' ], [ 'key' => 'name', 'value' => 'foo', 'operator' => 'like', 'filters' => [] ])
            ->once()
            ->andReturn(true);

        $data = [ [ 'name' => 'foo' ] ];
        $q = (new ArrayQuery($this->selectEvaluation, $this->whereEvaluation))
            ->select('name')
            ->from($data)
            ->where('name', 'foo', 'like');
        $result = $q->findAll();

        $this->assertCount(1, $result);
        $this->assertEquals('foo', $result[0]['name']);
    }

    /**
     * @covers Braincrafted\ArrayQuery\ArrayQuery::select()
     * @covers Braincrafted\ArrayQuery\ArrayQuery::from()
     * @covers Braincrafted\ArrayQuery\ArrayQuery::execute()
     * @covers Braincrafted\ArrayQuery\ArrayQuery::findAll()
     * @covers Braincrafted\ArrayQuery\ArrayQuery::where()
     * @covers Braincrafted\ArrayQuery\ArrayQuery::evaluateWhere()
     */
    public function testExecuteFilter()
    {
        $this->selectEvaluation->shouldReceive('evaluate')->with('foo', m::any())->andReturn('foo');

        $this->whereEvaluation
            ->shouldReceive('evaluate')
            ->with(
                [ 'name' => 'foo' ],
                [ 'key' => 'name', 'value' => 'foo', 'operator' => 'like', 'filters' => 'lower' ]
            )
            ->once()
            ->andReturn(true);

        $data = [ [ 'name' => 'foo' ] ];
        $q = (new ArrayQuery($this->selectEvaluation, $this->whereEvaluation))
            ->select('name')
            ->from($data)
            ->where('name', 'foo', 'like', 'lower');
        $result = $q->findAll();

        $this->assertCount(1, $result);
        $this->assertEquals('foo', $result[0]['name']);
    }

    /**
     * @covers Braincrafted\ArrayQuery\ArrayQuery::select()
     * @covers Braincrafted\ArrayQuery\ArrayQuery::from()
     * @covers Braincrafted\ArrayQuery\ArrayQuery::execute()
     * @covers Braincrafted\ArrayQuery\ArrayQuery::findAll()
     */
    public function testExecuteSelectFilter()
    {
        $this->selectEvaluation->shouldReceive('evaluate')->with('foo', 'upper')->andReturn('FOO');

        $data = [ [ 'name' => 'foo' ] ];
        $q = (new ArrayQuery($this->selectEvaluation, $this->whereEvaluation))
            ->select('name', 'upper')
            ->from($data);
        $result = $q->findAll();

        $this->assertCount(1, $result);
        $this->assertEquals('FOO', $result[0]['name']);
    }

    /**
     * @covers Braincrafted\ArrayQuery\ArrayQuery::select()
     * @covers Braincrafted\ArrayQuery\ArrayQuery::from()
     * @covers Braincrafted\ArrayQuery\ArrayQuery::execute()
     * @covers Braincrafted\ArrayQuery\ArrayQuery::findAll()
     */
    public function testExecuteSelectMultiple()
    {
        $this->selectEvaluation->shouldReceive('evaluate')->with('foo', null)->andReturn('foo');

        $data = [ [ 'name' => 'foo' ] ];
        $q = (new ArrayQuery($this->selectEvaluation, $this->whereEvaluation))
            ->select([ 'name' ])
            ->from($data);
        $result = $q->findAll();

        $this->assertCount(1, $result);
        $this->assertEquals('foo', $result[0]['name']);
    }

    /**
     * @covers Braincrafted\ArrayQuery\ArrayQuery::select()
     * @covers Braincrafted\ArrayQuery\ArrayQuery::from()
     * @covers Braincrafted\ArrayQuery\ArrayQuery::execute()
     * @covers Braincrafted\ArrayQuery\ArrayQuery::findAll()
     */
    public function testExecuteSelectMultipleWithFilter()
    {
        $this->selectEvaluation->shouldReceive('evaluate')->with(' foo ', 'trim')->andReturn('foo');

        $data = [ [ 'name' => ' foo ' ] ];
        $q = (new ArrayQuery($this->selectEvaluation, $this->whereEvaluation))
            ->select([ 'name' => 'trim' ])
            ->from($data);
        $result = $q->findAll();

        $this->assertCount(1, $result);
        $this->assertEquals('foo', $result[0]['name']);
    }

    /**
     * @covers Braincrafted\ArrayQuery\ArrayQuery::select()
     * @covers Braincrafted\ArrayQuery\ArrayQuery::from()
     * @covers Braincrafted\ArrayQuery\ArrayQuery::execute()
     * @covers Braincrafted\ArrayQuery\ArrayQuery::findAll()
     */
    public function testExecuteSelectAll()
    {
        $data = [ [ 'name' => 'foo' ] ];
        $q = (new ArrayQuery($this->selectEvaluation, $this->whereEvaluation))
            ->select('*')
            ->from($data);
        $result = $q->findAll();

        $this->assertCount(1, $result);
        $this->assertEquals('foo', $result[0]['name']);
    }

    /**
     * @covers Braincrafted\ArrayQuery\ArrayQuery::select()
     * @covers Braincrafted\ArrayQuery\ArrayQuery::from()
     * @covers Braincrafted\ArrayQuery\ArrayQuery::execute()
     * @covers Braincrafted\ArrayQuery\ArrayQuery::findOne()
     */
    public function testFindOne()
    {
        $this->whereEvaluation->shouldReceive('evaluate')->never();
        $this->selectEvaluation->shouldReceive('evaluate')->with('foo', m::any())->andReturn('foo');
        $this->selectEvaluation->shouldReceive('evaluate')->never();
        $this->selectEvaluation->shouldReceive('evaluate')->never();

        $data = [ [ 'name' => 'foo' ], [ 'name' => 'bar' ], [ 'name' => 'baz' ] ];
        $q = (new ArrayQuery($this->selectEvaluation, $this->whereEvaluation))
            ->select('name')
            ->from($data);
        $result = $q->findOne();

        $this->assertEquals('foo', $result['name']);
    }

    /**
     * @covers Braincrafted\ArrayQuery\ArrayQuery::select()
     * @covers Braincrafted\ArrayQuery\ArrayQuery::from()
     * @covers Braincrafted\ArrayQuery\ArrayQuery::execute()
     * @covers Braincrafted\ArrayQuery\ArrayQuery::findScalar()
     */
    public function testFindScalar()
    {
        $this->whereEvaluation->shouldReceive('evaluate')->never();
        $this->selectEvaluation->shouldReceive('evaluate')->with('foo', m::any())->andReturn('foo');
        $this->selectEvaluation->shouldReceive('evaluate')->with('bar', m::any())->andReturn('bar');
        $this->selectEvaluation->shouldReceive('evaluate')->with('baz', m::any())->andReturn('baz');

        $data = [ [ 'name' => 'foo' ], [ 'name' => 'bar' ], [ 'name' => 'baz' ] ];
        $q = (new ArrayQuery($this->selectEvaluation, $this->whereEvaluation))
            ->select('name')
            ->from($data);
        $result = $q->findScalar();

        $this->assertCount(3, $result);
        $this->assertEquals('foo', $result[0]);
        $this->assertEquals('bar', $result[1]);
        $this->assertEquals('baz', $result[2]);
    }

    /**
     * @covers Braincrafted\ArrayQuery\ArrayQuery::select()
     * @covers Braincrafted\ArrayQuery\ArrayQuery::from()
     * @covers Braincrafted\ArrayQuery\ArrayQuery::execute()
     * @covers Braincrafted\ArrayQuery\ArrayQuery::findScalar()
     *
     * @expectedException \InvalidArgumentException
     */
    public function testFindScalarMultipleColumns()
    {
        $q = (new ArrayQuery($this->selectEvaluation, $this->whereEvaluation))
            ->select('*')
            ->from([]);
        $q->findScalar();
    }

    /**
     * @covers Braincrafted\ArrayQuery\ArrayQuery::select()
     * @covers Braincrafted\ArrayQuery\ArrayQuery::from()
     * @covers Braincrafted\ArrayQuery\ArrayQuery::execute()
     * @covers Braincrafted\ArrayQuery\ArrayQuery::findOneScalar()
     */
    public function testFindOneScalar()
    {
        $this->whereEvaluation->shouldReceive('evaluate')->never();
        $this->selectEvaluation->shouldReceive('evaluate')->with('foo', m::any())->andReturn('foo');
        $this->selectEvaluation->shouldReceive('evaluate')->never();
        $this->selectEvaluation->shouldReceive('evaluate')->never();

        $data = [ [ 'name' => 'foo' ], [ 'name' => 'bar' ], [ 'name' => 'baz' ] ];
        $q = (new ArrayQuery($this->selectEvaluation, $this->whereEvaluation))
            ->select('name')
            ->from($data);
        $result = $q->findOneScalar();

        $this->assertEquals('foo', $result);
    }
}
