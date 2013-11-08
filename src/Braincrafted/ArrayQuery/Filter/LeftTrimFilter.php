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
 * LeftTrimFilter
 *
 * @package    braincrafted/arrayquery
 * @subpackage Filter
 * @author     Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright  2013 Florian Eckerstorfer
 * @license    http://opensource.org/licenses/MIT The MIT License
 */
class LeftTrimFilter implements FilterInterface
{
    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'ltrim';
    }

    /**
     * {@inheritDoc}
     */
    public function evaluate($value, array $args = array())
    {
        return ltrim($value);
    }
}
