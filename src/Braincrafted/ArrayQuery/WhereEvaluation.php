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
use Braincrafted\ArrayQuery\Exception\UnkownOperatorException;
use Braincrafted\ArrayQuery\Operator\OperatorInterface;
use Braincrafted\ArrayQuery\Filter\FilterInterface;

/**
 * WhereEvaluation
 *
 * @package   braincrafted/arrayquery
 * @author    Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright 2013 Florian Eckerstorfer
 * @license   http://opensource.org/licenses/MIT The MIT License
 */
class WhereEvaluation
{
    /** @var array */
    private $operators = [];

    /** @var array */
    private $filters = [];

    /**
     * @param OperatorInterface $operator
     *
     * @return WhereEvaluation
     */
    public function addOperator(OperatorInterface $operator)
    {
        $this->operators[$operator->getOperator()] = $operator;

        return $this;
    }

    /**
     * @param FilterInterface $filter
     *
     * @return WhereEvaluation
     */
    public function addFilter(FilterInterface $filter)
    {
        $this->filters[$filter->getName()] = $filter;

        return $this;
    }

    /**
     * @param array $row
     * @param array $clause
     *
     * @return boolean
     */
    public function evaluate(array $row, array $clause)
    {
        $value = isset($row[$clause[0]]) ? $row[$clause[0]] : null;
        $value = $this->evaluateFilter($value, $clause);

        if (false === isset($this->operators[$clause[2]])) {
            throw new UnkownOperatorException(sprintf('The operator "%s" does not exist.', $clause[2]));
        }
        if (false === $this->operators[$clause[2]]->evaluate($value, $clause[1])) {
            return false;
        }

        return true;
    }

    /**
     * @param mixed $value
     * @param array $clause
     *
     * @return mixed
     */
    protected function evaluateFilter($value, array $clause)
    {
        if (true === isset($clause[3])) {
            if (false === is_array($clause[3])) {
                $clause[3] = [ $clause[3] ];
            }
            foreach ($clause[3] as $filter) {
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
        }

        return $value;
    }
}
