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
     * @param array $row
     * @param array $clause
     *
     * @return boolean
     */
    public function evaluate(array $row, array $clause)
    {
        $value = isset($row[$clause[0]]) ? $row[$clause[0]] : null;

        if (false === isset($this->operators[$clause[2]])) {
            throw new UnkownOperatorException(sprintf('The operator "%s" does not exist.', $clause[2]));
        }
        if (false === $this->operators[$clause[2]]->evaluate($value, $clause[1])) {
            return false;
        }

        return true;
    }
}
