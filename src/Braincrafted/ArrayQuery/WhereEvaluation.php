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

use Braincrafted\ArrayQuery\Exception\UnkownOperatorException;
use Braincrafted\ArrayQuery\Operator\OperatorInterface;
use Braincrafted\ArrayQuery\Filter\FilterInterface;

/**
 * WhereEvaluation
 *
 * Evaluates values against where clauses with the given set of operators and filters.
 *
 * @package   braincrafted/arrayquery
 * @author    Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright 2013 Florian Eckerstorfer
 * @license   http://opensource.org/licenses/MIT The MIT License
 */
class WhereEvaluation extends Evaluation
{
    /** @var array */
    private $operators = [];

    /** @var array */
    protected $filters = [];

    /**
     * Adds an operator to the evaluation.
     *
     * @param OperatorInterface $operator The operator.
     *
     * @return WhereEvaluation
     */
    public function addOperator(OperatorInterface $operator)
    {
        $this->operators[$operator->getName()] = $operator;

        return $this;
    }

    /**
     * Adds a filter to the evaluation.
     *
     * @param FilterInterface $filter The filter.
     *
     * @return WhereEvaluation
     */
    public function addFilter(FilterInterface $filter)
    {
        $this->filters[$filter->getName()] = $filter;

        return $this;
    }

    /**
     * Evaluates the given item with the given clause.
     *
     * @param array $item   The item to evaluate.
     * @param array $clause The clause to evaluate the item with. Has to contain `key`, `value` and `operator` and can
     *                      optionally also contain `filters`. `filters` can be either a string or an array.
     *
     * @return boolean `true` if the item evaluates to `true`, `false` otherwise.
     *
     * @throws \InvalidArgumentException if `key`, `value` or `operator` is missing in `$clause`.
     * @throws Braincrafted\ArrayQuery\Exception\UnkownFilterException if a filter does not exist.
     * @throws Braincrafted\ArrayQuery\Exception\UnkownOperatorException if the operator does not exist.
     */
    public function evaluate(array $item, array $clause)
    {
        if (false === isset($clause['key']) ||
            false === isset($clause['value']) ||
            false === isset($clause['operator'])
        ) {
            throw new \InvalidArgumentException('Clause must contain "key", "value" and operator.');
        }

        $value = isset($item[$clause['key']]) ? $item[$clause['key']] : null;
        $value = $this->evaluateFilters($value, $clause);

        if (false === isset($this->operators[$clause['operator']])) {
            throw new UnkownOperatorException(sprintf('The operator "%s" does not exist.', $clause['operator']));
        }

        if (false === $this->operators[$clause['operator']]->evaluate($value, $clause['value'])) {
            return false;
        }

        return true;
    }

    /**
     * Evaluates the given value with the given clause.
     *
     * @param mixed $value  The value to evaluate.
     * @param array $clause The clause to evaluate the item with.
     *
     * @return mixed The evaluated value.
     *
     * @throws Braincrafted\ArrayQuery\Exception\UnkownFilterException if the given filter does not exist.
     *
     * @see evaluate()
     */
    protected function evaluateFilters($value, array $clause)
    {
        if (true === isset($clause['filters'])) {
            if (false === is_array($clause['filters'])) {
                $clause['filters'] = [ $clause['filters'] ];
            }
            foreach ($clause['filters'] as $filter) {
                $value = $this->evaluateFilter($value, $filter);
            }
        }

        return $value;
    }
}
