<?php

/**
 * This file is part of braincrafted/arrayquery.
 *
 * (c) Florian Eckerstorfer <florian@eckerstorfer.co>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Braincrafted\ArrayQuery;

use Braincrafted\ArrayQuery\Exception\UnkownFilterException;

/**
 * Evaluation
 *
 * @package   braincrafted/arrayquery
 * @author    Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright 2013 Florian Eckerstorfer
 * @license   http://opensource.org/licenses/MIT The MIT License
 */
class Evaluation
{
    /**
     * Evaluates the given value with the given filter.
     *
     * @param mixed        $value
     * @param string|array $filter
     *
     * @return mixed
     *
     * @throws Braincrafted\ArrayQuery\Exception\UnkownFilterException if a filter does not exist.
     */
    protected function evaluateFilter($value, $filter)
    {
        $filter = explode(' ', $filter, 2);
        if (1 === count($filter)) {
            $args   = [];
            $filter = $filter[0];
        } else {
            $args   = array_map('trim', explode(',', $filter[1]));
            $filter = $filter[0];
        }

        if (false === isset($this->filters[$filter])) {
            throw new UnkownFilterException(sprintf('The filter "%s" does not exist.', $filter));
        }

        return $this->filters[$filter]->evaluate($value, $args);
    }
}
