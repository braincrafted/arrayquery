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
 * ReplaceFilter
 *
 * @package    braincrafted/arrayquery
 * @subpackage Filter
 * @author     Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright  2013 Florian Eckerstorfer
 * @license    http://opensource.org/licenses/MIT The MIT License
 */
class ReplaceFilter implements FilterInterface
{
    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'replace';
    }

    /**
     * {@inheritDoc}
     */
    public function evaluate($value, array $args = array())
    {
        if (false === isset($args[0]) || false === isset($args[1])) {
            throw new \InvalidArgumentException('replace requires two arguments');
        }

        return str_replace($args[0], $args[1], $value);
    }
}
