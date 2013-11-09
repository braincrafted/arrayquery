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

/**
 * ArrayQuery
 *
 * @package   braincrafted/arrayquery
 * @author    Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright 2013 Florian Eckerstorfer
 * @license   http://opensource.org/licenses/MIT The MIT License
 */
class ArrayQuery
{
    /** @var WhereEvaluation */
    private $whereEvaluation;

    /** @var array */
    private $select = [];

    /** @var array */
    private $from = [];

    /** @var array */
    private $where = [];

    /**
     * @param WhereEvaluation $whereEvaluation
     *
     * @codeCoverageIgnore
     */
    public function __construct(WhereEvaluation $whereEvaluation)
    {
        $this->whereEvaluation = $whereEvaluation;
    }

    /**
     * The names of the fields that should be selected by the query.
     *
     * @param mixed $select Either an array of field names or each field name as parameter
     *
     * @return ArrayQuery
     */
    public function select($select)
    {
        if (false === is_array($select)) {
            $select = func_get_args();
        }
        $this->select = $select;

        return $this;
    }

    /**
     * The data source of the query.
     *
     * @param array $from Array to query elements from
     *
     * @return ArrayQuery
     */
    public function from(array $from)
    {
        $this->from = $from;

        return $this;
    }

    /**
     * A clause that elements have to match to be returned.
     *
     * @param mixed $key       Key of the element to evaluate
     * @param mixed $value     Value the evaluated element has to match (occording to the operator)
     * @param string $operator Operator used for the evluation
     * @param array  $filters  Array of filters to be applied to a value before it is evaluated
     *
     * @return ArrayQuery
     */
    public function where($key, $value, $operator = '=', $filters = array())
    {
        $this->where[] = [ $key, $value, $operator, $filters ];

        return $this;
    }

    /**
     * Executes the query.
     *
     * @return array Array of elements that match the query
     */
    public function execute()
    {
        $result = [];

        $selectAll = in_array('*', $this->select);

        foreach ($this->from as $index => $row) {
            if (true === $this->evaluateWhere($row)) {
                $resultRow = [];
                foreach ($row as $key => $value) {
                    if (true === $selectAll || true === in_array($key, $this->select)) {
                        $resultRow[$key] = $value;
                    }
                }
                $result[] = $resultRow;
            }
        }

        return $result;
    }

    /**
     * @param array $row
     *
     * @return boolean
     */
    protected function evaluateWhere(array $row)
    {
        $result = true;

        foreach ($this->where as $clause) {
            $result = $result && $this->whereEvaluation->evaluate($row, $clause);
        }

        return $result;
    }
}
