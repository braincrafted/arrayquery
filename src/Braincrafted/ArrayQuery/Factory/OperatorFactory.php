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

use Braincrafted\ArrayQuery\Operator;

/**
 * OperatorFactory
 *
 * @package    braincrafted/arrayquery
 * @subpackage Factory
 * @author     Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright  2013 Florian Eckerstorfer
 * @license    http://opensource.org/licenses/MIT The MIT License
 */
class OperatorFactory
{
    /** @var array */
    private static $classes = [
        'Braincrafted\ArrayQuery\Operator\EqualOperator',
        'Braincrafted\ArrayQuery\Operator\GreaterOperator',
        'Braincrafted\ArrayQuery\Operator\GreaterOrEqualOperator',
        'Braincrafted\ArrayQuery\Operator\LikeOperator',
        'Braincrafted\ArrayQuery\Operator\LowerOperator',
        'Braincrafted\ArrayQuery\Operator\LowerOrEqualOperator',
        'Braincrafted\ArrayQuery\Operator\NotEqualOperator',
        'Braincrafted\ArrayQuery\Operator\NotLikeOperator',
    ];

    /** @var array */
    private static $operators;

    /**
     * @return array
     */
    public static function getOperators()
    {
        if (null === self::$operators) {
            foreach (self::$classes as $class) {
                self::$operators[] = new $class;
            }
        }

        return self::$operators;
    }
}
