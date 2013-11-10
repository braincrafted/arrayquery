<?php

/**
 * This file is part of braincrafted/arrayquery.
 *
 * (c) Florian Eckerstorfer <florian@eckerstorfer.co>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Braincrafted\ArrayQuery\Factory;

use Braincrafted\ArrayQuery\Factory\OperatorFactory;

/**
 * OperatorFactoryTest
 *
 * @category   Test
 * @package    braincrafted/arrayquery
 * @subpackage Factory
 * @author     Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright  2013 Florian Eckerstorfer
 * @license    http://opensource.org/licenses/MIT The MIT License
 * @group      unit
 */
class OperatorFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Braincrafted\ArrayQuery\Factory\OperatorFactory::getOperators()
     */
    public function testGetOperators()
    {
        $operators = OperatorFactory::getOperators();

        $this->assertCount(8, $operators);
        foreach ($operators as $operator) {
            $this->assertInstanceOf('Braincrafted\ArrayQuery\Operator\OperatorInterface', $operator);
        }
    }
}
