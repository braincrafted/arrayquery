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

use Braincrafted\ArrayQuery\Operator\LikeOperator;

/**
 * LikeOperatorTest
 *
 * @category   Test
 * @package    braincrafted/arrayquery
 * @subpackage Operator
 * @author     Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright  2013 Florian Eckerstorfer
 * @license    http://opensource.org/licenses/MIT The MIT License
 * @group      unit
 */
class LikeOperatorTest extends \PHPUnit_Framework_TestCase
{
    /** @var LikeOperator */
    private $operator;

    public function setUp()
    {
        $this->operator = new LikeOperator;
    }

    /**
     * @covers Braincrafted\ArrayQuery\Operator\LikeOperator::getName()
     */
    public function testGetName()
    {
        $this->assertEquals('like', $this->operator->getName());
    }

    /**
     * @covers Braincrafted\ArrayQuery\Operator\LikeOperator::evaluate()
     */
    public function testEvaluate()
    {
        $this->assertTrue($this->operator->evaluate('foo', 'fo%'));
        $this->assertTrue($this->operator->evaluate('foo', '%oo'));
        $this->assertFalse($this->operator->evaluate('foo', 'bar%'));
    }
}
