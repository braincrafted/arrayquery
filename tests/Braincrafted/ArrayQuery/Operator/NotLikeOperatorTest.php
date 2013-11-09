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

use Braincrafted\ArrayQuery\Operator\NotLikeOperator;

/**
 * NotLikeOperatorTest
 *
 * @package    braincrafted/arrayquery
 * @subpackage Operator
 * @author     Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright  2013 Florian Eckerstorfer
 * @license    http://opensource.org/licenses/MIT The MIT License
 * @group      unit
 */
class NotLikeOperatorTest extends \PHPUnit_Framework_TestCase
{
    /** @var NotLikeOperator */
    private $operator;

    public function setUp()
    {
        $this->operator = new NotLikeOperator;
    }

    /**
     * @covers Braincrafted\ArrayQuery\Operator\NotLikeOperator::getName()
     */
    public function testGetName()
    {
        $this->assertEquals('notlike', $this->operator->getName());
    }

    /**
     * @covers Braincrafted\ArrayQuery\Operator\NotLikeOperator::evaluate()
     */
    public function testEvaluate()
    {
        $this->assertFalse($this->operator->evaluate('foo', 'fo%'));
        $this->assertFalse($this->operator->evaluate('foo', '%oo'));
        $this->assertTrue($this->operator->evaluate('foo', 'bar%'));
    }
}
