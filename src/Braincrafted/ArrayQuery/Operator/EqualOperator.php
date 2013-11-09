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
 * EqualOperator
 *
 * @package    braincrafted/arrayquery
 * @subpackage Operator
 * @author     Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright  2013 Florian Eckerstorfer
 * @license    http://opensource.org/licenses/MIT The MIT License
 */
class EqualOperator implements OperatorInterface
{
    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return '=';
    }

    /**
     * {@inheritDoc}
     */
    public function evaluate($value, $matchValue)
    {
        return $value == $matchValue;
    }
}
