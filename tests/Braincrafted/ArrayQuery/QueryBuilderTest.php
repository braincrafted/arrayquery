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

use Braincrafted\ArrayQuery\QueryBuilder;

/**
 * QueryBuilderTest
 *
 * @package   braincrafted/arrayquery
 * @author    Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright 2013 Florian Eckerstorfer
 * @license   http://opensource.org/licenses/MIT The MIT License
 * @group     unit
 */
class QueryBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->qb = new QueryBuilder;
    }

    /**
     * @covers Braincrafted\ArrayQuery\QueryBuilder::__construct()
     * @expectedException \InvalidArgumentException
     */
    public function testConstructInvalidArgument()
    {
        $qb = new QueryBuilder(new \stdClass);
    }

    /**
     * @covers Braincrafted\ArrayQuery\QueryBuilder::__construct()
     */
    public function testConstructDefaultOperatorsDefaultFilters()
    {
        $whereEval = m::mock('Braincrafted\ArrayQuery\WhereEvaluation');
        $whereEval->shouldReceive('addOperator')->times(8);
        $whereEval->shouldReceive('addFilter')->times(7);

        $qb = new QueryBuilder($whereEval);
    }

    /**
     * @covers Braincrafted\ArrayQuery\QueryBuilder::create()
     */
    public function testCreate()
    {
        $this->assertInstanceOf('Braincrafted\ArrayQuery\ArrayQuery', $this->qb->create());
    }
}
