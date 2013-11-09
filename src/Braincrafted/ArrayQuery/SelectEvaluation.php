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

use Braincrafted\ArrayQuery\Filter\FilterInterface;
use Braincrafted\ArrayQuery\Exception\UnkownFilterException;

/**
 * WhereEvaluation
 *
 * @package   braincrafted/arrayquery
 * @author    Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright 2013 Florian Eckerstorfer
 * @license   http://opensource.org/licenses/MIT The MIT License
 */
class SelectEvaluation
{
    /** @var array */
    private $filters = [];

    /**
     * Adds a filter.
     *
     * @param FilterInterface $filter The filter.
     *
     * @return SelectEvaluation
     */
    public function addFilter(FilterInterface $filter)
    {
        $this->filters[$filter->getName()] = $filter;

        return $this;
    }

    /**
     * Evaluates the given value with the given filters.
     *
     * @param mixed $value   The value.
     * @param array $filters The list of filters to apply.
     *
     * @return mixed The evaluated value.
     *
     * @throws Braincrafted\ArrayQuery\Exception\UnkownFilterException if a filter does not exist.
     */
    public function evaluate($value, $filters)
    {
        if (false === is_array($filters)) {
            $filters = [ $filters ];
        }

        foreach ($filters as $filter) {
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

            $value = $this->filters[$filter]->evaluate($value, $args);
        }

        return $value;
    }
}
