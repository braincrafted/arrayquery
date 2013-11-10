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

use Braincrafted\ArrayQuery\Factory\FilterFactory;
use Braincrafted\ArrayQuery\Factory\OperatorFactory;

/**
 * QueryBuilder
 *
 * @package   braincrafted/arrayquery
 * @author    Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright 2013 Florian Eckerstorfer
 * @license   http://opensource.org/licenses/MIT The MIT License
 */
class QueryBuilder
{
    /** @var SelectEvaluation */
    private $selectEvaluation;

    /** @var WhereEvaluation */
    private $whereEvaluation;

    /**
     * @param SelectEvaluation $selectEvaluation
     * @param WhereEvaluation  $whereEvaluation
     */
    public function __construct($selectEvaluation = null, $whereEvaluation = null)
    {
        $this->selectEvaluation = $this->getSelectEvaluation($selectEvaluation);
        $this->whereEvaluation  = $this->getWhereEvaluation($whereEvaluation);
    }

    /**
     * @return ArrayQuery
     */
    public function create()
    {
        return new ArrayQuery($this->selectEvaluation, $this->whereEvaluation);
    }

    /**
     * @param SelectEvaluation $selectEvaluation
     *
     * @return SelectEvaluation
     */
    protected function getSelectEvaluation($selectEvaluation = null)
    {
        if (null !== $selectEvaluation && false === ($selectEvaluation instanceof SelectEvaluation)) {
            throw new \InvalidArgumentException('Argument "selectEvaluation" must be an instance of SelectEvaluation.');
        }
        if (null === $selectEvaluation) {
            $selectEvaluation = new SelectEvaluation;
        }

        foreach (FilterFactory::getFilters() as $filter) {
            $selectEvaluation->addFilter($filter);
        }

        return $selectEvaluation;
    }

    /**
     * @param WhereEvaluation $whereEvaluation
     *
     * @return WhereEvaluation
     */
    protected function getWhereEvaluation($whereEvaluation = null)
    {
        if (null !== $whereEvaluation && false === ($whereEvaluation instanceof WhereEvaluation)) {
            throw new \InvalidArgumentException('Argument "whereEvaluation" must be an instance of WhereEvaluation.');
        }
        if (null === $whereEvaluation) {
            $whereEvaluation = new WhereEvaluation;
        }

        foreach (OperatorFactory::getOperators() as $operator) {
            $whereEvaluation->addOperator($operator);
        }
        foreach (FilterFactory::getFilters() as $filter) {
            $whereEvaluation->addFilter($filter);
        }

        return $whereEvaluation;
    }
}