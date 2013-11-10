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

/**
 * OperatorInterface
 *
 * @category   Interface
 * @package    braincrafted/arrayquery
 * @subpackage Operator
 * @author     Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright  2013 Florian Eckerstorfer
 * @license    http://opensource.org/licenses/MIT The MIT License
 */
interface OperatorInterface
{
    /**
     * Returns the name of the operator.
     *
     * @return string
     */
    public function getName();

    /**
     * Returns if the operator evalutes to true.
     *
     * @param mixed $value
     * @param mixed $matchValue
     *
     * @return boolean
     */
    public function evaluate($value, $matchValue);
}
