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

/**
 * FilterFactory
 *
 * @package    braincrafted/arrayquery
 * @subpackage Factory
 * @author     Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright  2013 Florian Eckerstorfer
 * @license    http://opensource.org/licenses/MIT The MIT License
 */
class FilterFactory
{
    /** @var array */
    private static $classes = [
        'Braincrafted\ArrayQuery\Filter\LeftTrimFilter',
        'Braincrafted\ArrayQuery\Filter\LengthFilter',
        'Braincrafted\ArrayQuery\Filter\LowercaseFilter',
        'Braincrafted\ArrayQuery\Filter\UppercaseFilter',
        'Braincrafted\ArrayQuery\Filter\ReplaceFilter',
        'Braincrafted\ArrayQuery\Filter\RightTrimFilter',
        'Braincrafted\ArrayQuery\Filter\TrimFilter',
    ];

    /** @var array */
    private static $filters;

    /**
     * @return array
     */
    public static function getFilters()
    {
        if (null === self::$filters) {
            foreach (self::$classes as $class) {
                self::$filters[] = new $class;
            }
        }

        return self::$filters;
    }
}
