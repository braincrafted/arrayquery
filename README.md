ArrayQuery
==========

ArrayQuery is a library to query arrays.

    // Select the name of all of Ned's children older than 10.
    $query = $qb->create()
        ->select('name')
        ->from([
            [ 'name' => 'Robb',   'age' => 15 ],
            [ 'name' => 'Sansa',  'age' => 11 ],
            [ 'name' => 'Arya',   'age' => 9 ],
            [ 'name' => 'Bran',   'age' => 7 ],
            [ 'name' => 'Rickon', 'age' => 3 ]
        ])
        ->where('age', 10, '>');
    $result = $query->findAll();


Motivation
----------

Data is often stored in arrays or arrays (for example, after reading it from CSV) and some items (or rows) have to be
picked out before the data can be further processed or stored in a database. Writing such code is not very hard, but
it often gets messy. Loops within loops, multiple if or switch statement, temporary variables and so on. ArrayQuery
provided a clean and testable interface (inspired by query builders from ORMs) for these "array queries."

Installation
------------

ArrayQuery can be installed using Composer:

    {
        "require": {
            "braincrafted/arrayquery": "dev-master"
        }
    }


Usage
-----

The `ArrayQuery` object has to be initialized with a `SelectEvaluation` and a `WhereEvaluation` object. By default, no
operators and filters are added.

    <?php

    use Braincrafted\ArrayQuery\ArrayQuery;
    use Braincrafted\ArrayQuery\SelectEvaluation;
    use Braincrafted\ArrayQuery\WhereEvaluation;
    use Braincrafted\ArrayQuery\Operator\EqualOperator

    $query = new ArrayQuery(
        new SelectEvaluation,
        (new WhereEvaluation)->addOperator(new EqualOperator)
    );

However, the `QueryBuilder` can be used to create an instance of `ArrayQuery` with default operators and filters.

    <?php

    use Braincrafted\ArrayQuery\QueryBuilder;

    $qb = new QueryBuilder;
    $query = $qb->create();

The query object can be used to build queries and execute them. Building the query object contains of three steps:

1. **Select** the fields to be returned
2. **From** the datasource
3. **Where** a clause is matched

When the query is built it has to be executed.

### Select

All elements of an item can be selected using the star `*` operator:

    $query->select('*');

Single elements of an item can be selected:

    $query->select('name');

Multiple elements of an item can be selected:

    $query->select([ 'name', 'age' ]);

Filters can be applied in both cases:

    $query->select('name', 'trim');
    $query->select([ 'name' => 'trim', 'bio' => 'trim' ]);

Multiple filters can also be applied:

    $query->select('name', [ 'trim', 'upper' ]);
    $query->select(
        [
            'name' => [ 'trim', 'upper' ],
            'bio' => [ 'trim', 'upper' ]
        ]
    );

### From

Next the data source from which to select from has to be defined:

    $thorinsCompany = [
        [ 'name' => 'Bilbo Baggins', 'race' => 'Hobbit' ],
        [ 'name' => 'Gandalf', 'race' => 'Wizard' ],
        [ 'name' => 'Thorin Oakenshild', 'race' => 'Dwarf' ],
        [ 'name' => 'Balin', 'race' => 'Dwarf'],
        [ 'name' => 'Bifur', 'race' => 'Dwarf'],
        // ...
    ];

    $query->from($thorinsCompany);

### Where

Where clauses define which items from the data source are put in the result set:

    $query->where('race', 'Dwarf');

There are numerous different operators available, which can be defined as third parameter:

    $query->where('age', 50, '>');

Before the clause is evaluated filters can be applied to the test value:

    $query->where('name', 'foo', '=', 'trim');
    $query->where('name', 'foo', '=', [ 'trim', 'strtolower' ]);

Filters can have arguments:

    $query->where('name', 'nerd', '=', 'replace 3,e');

### Execute

There are multiple ways to execute a query.

Find all results:

    $results = $query->findAll();
    // [ [ 'name' => 'Balin' ], [ 'name' => 'Bifur' ], ... ]

Find one result:

    $result = $query->findOne();
    // [ 'name' => 'Gandalf' ]

*__Note:__ For performance reasons the first result is returned immediately. There is no error or exception when multiple
results are returned.*

Find scalar results:

    $result = $query->findScalar();
    // [ 'Balin', 'Bifur', 'Bofur', ... ]

*__Note:__ This only works when only one field is selected, an exception is thrown when multiple fields are selected
(either through enumeration or by using the star operator).*

Find one scalar result:

    $result = $query->findOneScalar()
    // 'Gandalf'

*__Note:__ The same notes as for `findOne()` and `findScalar()` apply here.*


Default operators and filters
-----------------------------

Some operators and filters are included by default and can be used out of the box (if the `QueryBuilder` is used to create the `ArrayQuery` object).

### Operators

- Equal `=`
- Not equal `!=`
- Greater `>`
- Greater or equal `>=`
- Lower `<`
- Lower or equal `<=`
- Like `like` *(case insensitibe and `%` can be used to at the beginning and end to match anything)*
- Not like `notlike`

### Filters

Filters can optionally have arguments. Separate arguments from the filter name by a space and separate multiple arguments using a comma.

- Length `length`
- Lowercase `lower`
- Uppercase `upper`
- Trim `trim`
- Left trim `ltrim`
- Right trim `rtrim`
- Replace `replace` (two arguments: *search* and *replace*)

Author
------

- [Florian Eckerstorfer](http://florian.ec)


License
-------

For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
