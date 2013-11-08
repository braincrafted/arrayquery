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
     * @param mixed $select
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
     * @param array $from
     *
     * @return ArrayQuery
     */
    public function from(array $from)
    {
        $this->from = $from;

        return $this;
    }

    /**
     * @param mixed $key
     * @param mixed $value
     *
     * @return ArrayQuery
     */
    public function where($key, $value, $operator = '=')
    {
        $this->where[] = [ $key, $value, $operator ];

        return $this;
    }

    /**
     * Executes the query.
     *
     * @return array
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
