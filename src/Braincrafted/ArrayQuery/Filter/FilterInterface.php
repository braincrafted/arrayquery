<?php

/**
 * This file is part of braincrafted/arrayquery.
 *
 * (c) Florian Eckerstorfer <florian@eckerstorfer.co>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Braincrafted\ArrayQuery\Filter;

/**
 * FilterInterface
 *
 * @package    braincrafted/arrayquery
 * @subpackage Filter
 * @author     Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright  2013 Florian Eckerstorfer
 * @license    http://opensource.org/licenses/MIT The MIT License
 */
interface FilterInterface
{
    /**
     * Returns the name of the function.
     *
     * @return string
     */
    public function getName();

    /**
     * Evalutes the function and returns the value.
     *
     * @param mixed $value
     *
     * @return mixed
     */
    public function evaluate($value);
}
