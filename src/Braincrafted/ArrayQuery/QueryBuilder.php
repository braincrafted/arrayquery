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

use Braincrafted\ArrayQuery\Operator;

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
        if (null !== $selectEvaluation && false === ($selectEvaluation instanceof SelectEvaluation)) {
            throw new \InvalidArgumentException('Argument "selectEvaluation" must be an instance of SelectEvaluation.');
        }
        if (null === $selectEvaluation) {
            $selectEvaluation = new SelectEvaluation;
        }

        if (null !== $whereEvaluation && false === ($whereEvaluation instanceof WhereEvaluation)) {
            throw new \InvalidArgumentException('Argument "whereEvaluation" must be an instance of WhereEvaluation.');
        }
        if (null === $whereEvaluation) {
            $whereEvaluation = new WhereEvaluation;
        }

        foreach (self::getDefaultOperators() as $operator) {
            $whereEvaluation->addOperator($operator);
        }
        foreach (self::getDefaultFilters() as $filter) {
            $whereEvaluation->addFilter($filter);
            $selectEvaluation->addFilter($filter);
        }

        $this->selectEvaluation = $selectEvaluation;
        $this->whereEvaluation = $whereEvaluation;
    }

    /**
     * @return ArrayQuery
     */
    public function create()
    {
        return new ArrayQuery($this->selectEvaluation, $this->whereEvaluation);
    }

    /**
     * @return array
     *
     * @codeCoverageIgnore
     */
    public static function getDefaultOperators()
    {
        return [
            new Operator\EqualOperator,
            new Operator\GreaterOperator,
            new Operator\GreaterOrEqualOperator,
            new Operator\LikeOperator,
            new Operator\LowerOperator,
            new Operator\LowerOrEqualOperator,
            new Operator\NotEqualOperator,
            new Operator\NotLikeOperator
        ];
    }

    /**
     * @return array
     *
     * @codeCoverageIgnore
     */
    public static function getDefaultFilters()
    {
        return [
            new Filter\LeftTrimFilter,
            new Filter\LengthFilter,
            new Filter\LowercaseFilter,
            new Filter\UppercaseFilter,
            new Filter\ReplaceFilter,
            new Filter\RightTrimFilter,
            new Filter\TrimFilter
        ];
    }
}