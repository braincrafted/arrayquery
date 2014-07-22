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
    /** @var SelectEvaluation */
    private $selectEvaluation;

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
    public function __construct(SelectEvaluation $selectEvaluation, WhereEvaluation $whereEvaluation)
    {
        $this->selectEvaluation = $selectEvaluation;
        $this->whereEvaluation  = $whereEvaluation;
    }

    /**
     * The names of the fields that should be selected by the query.
     *
     * Example 1: **One field**
     *
     * `$query->select('name');`
     *
     * Example 2: **One field with filters**
     *
     * `$query->select('name', 'length')`
     *
     * Example 3: **Two fields as array**
     *
     * `$query->select([ 'name', 'age' ]);`
     *
     * Example 4: **Two fields with filters**
     *
     * `$query->select([ 'name' => [ 'replace 3,e', 'trim' ], 'bio' => 'trim' ]);`
     *
     * @param mixed $select Either an array of field names or each field name as parameter
     *
     * @return ArrayQuery
     */
    public function select($select, $filters = array())
    {
        if (false === is_array($select)) {
            $newSelect = [ $select => $filters ];
        } else {
            $newSelect = [];
            foreach ($select as $key => $filters) {
                if (true === is_int($key) || '*' === $key) {
                    $newSelect[$filters] = [];
                } else {
                    $newSelect[$key] = $filters;
                }
            }
        }
        $this->select = $newSelect;

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
     * Add a clause that elements have to match to be returned.
     *
     * Example 1: **Simple where**
     *
     * `$select->where('name', 'Bilbo Baggings');`
     *
     * Example 2: **Different operator**
     *
     * `$select->where('age', 50, '>=');`
     *
     * Example 3: **Add filters**
     *
     * `$select->where('name', 5, '=', [ 'trim', 'count' ]);`
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
        $this->where[] = [
            'key'      => $key,
            'value'    => $value,
            'operator' => $operator,
            'filters'  => $filters
        ];

        return $this;
    }

    /**
     * Returns all items from the result.
     *
     * @return array The full result
     */
    public function findAll($preserveKeys = false)
    {
        return $this->execute(false, false, $preserveKeys);
    }

    /**
     * Returns one item of the array.
     *
     * @return array An item of the array
     */
    public function findOne()
    {
        return $this->execute(true);
    }

    /**
     * Returns an array of scalar values.
     *
     * @return array An array of scalar values.
     */
    public function findScalar($preserveKeys = false)
    {
        return $this->execute(false, true, $preserveKeys);
    }

    /**
     * Returns a single scalar value.
     *
     * @return mixed A scalar value
     */
    public function findOneScalar()
    {
        return $this->execute(true, true);
    }

    /**
     * Executes the query and returns the result.
     *
     * @return array Array of elements that match the query
     *
     * @throws \InvalidArgumentException when `$scalar` is `true` and more than one field is selected.
     */
    public function execute($one = false, $scalar = false, $preserveKeys = false)
    {
        if (true === $scalar && (count($this->select) > 1 || true === isset($this->select['*']))) {
            throw new \InvalidArgumentException('$scalar can only be true if only one field is selected.');
        }

        $result = [];

        foreach ($this->from as $key => $item) {
            if (true === $this->evaluateWhere($item)) {
                $resultItem = $this->evaluateSelect($item, $scalar);

                if (true === $one) {
                    return $resultItem;
                }

                if ($preserveKeys) {
                    $result[$key] = $resultItem;
                }
                else {
                    $result[] = $resultItem;
                }
            }
        }

        return $result;
    }

    /**
     * Evaluates the where clauses on the given item.
     *
     * @param array $item The item to evaluate
     *
     * @return boolean `true` if all where clauses evaluate to `true`, `false` otherwise
     */
    protected function evaluateWhere(array $item)
    {
        $result = true;

        foreach ($this->where as $clause) {
            $result = $result && $this->whereEvaluation->evaluate($item, $clause);
        }

        return $result;
    }

    /**
     * Evaluates the select.
     *
     * @param array   $item
     * @param boolean $scalar
     *
     * @return mixed
     */
    protected function evaluateSelect(array $item, $scalar)
    {
        $resultItem = [];
        foreach ($item as $key => $value) {
            if (true === isset($this->select['*']) || true === isset($this->select[$key])) {
                if (true === isset($this->select[$key])) {
                    $value = $this->selectEvaluation->evaluate($value, $this->select[$key]);
                }
                if (true === $scalar) {
                    $resultItem = $value;
                } else {
                    $resultItem[$key] = $value;
                }
            }
        }

        return $resultItem;
    }
}
