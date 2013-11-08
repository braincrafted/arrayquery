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
 * UppercaseFilter
 *
 * @package    braincrafted/arrayquery
 * @subpackage Filter
 * @author     Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright  2013 Florian Eckerstorfer
 * @license    http://opensource.org/licenses/MIT The MIT License
 */
class UppercaseFilter implements FilterInterface
{
    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'upper';
    }

    /**
     * {@inheritDoc}
     */
    public function evaluate($value)
    {
        return mb_strtoupper($value);
    }
}
