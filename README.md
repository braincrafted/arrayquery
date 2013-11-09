ArrayQuery
==========

ArrayQuery is a library to query arrays.


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

The `ArrayQuery` object has to be initialized with a `WhereEvaluation` object. By default, no operators and filters are
registered there.

    <?php

    use Braincrafted\ArrayQuery\ArrayQuery;
    use Braincrafted\ArrayQuery\WhereEvaluation;
    use Braincrafted\ArrayQuery\Operator\EqualOperator

    $query = new ArrayQuery(
        (new WhereEvaluation)->addOperator(new EqualOperator)
    );

However, you can also use the `QueryBuilder` to create an instance of `ArrayQuery` with default operators and filters
added to it.

    <?php

    use Braincrafted\ArrayQuery\QueryBuilder;

    $qb = new QueryBuilder;
    $query = $qb->create();

You can use the query object to build queries and then execute them. Building the query object contains of three steps:

1. Select the fields to be returned
2. Add the data source
3. Add where clauses which restrict the returned items

In code that could look like:

    <?php

    use Braincrafted\ArrayQuery\QueryBuilder;

    $thorinsCompany = [
        [ 'name' => 'Bilbo Baggins', 'race' => 'Hobbit' ],
        [ 'name' => 'Gandalf', 'race' => 'Wizard' ],
        [ 'name' => 'Thorin Oakenshild', 'race' => 'Dwarf' ],
        [ 'name' => 'Balin', 'race' => 'Dwarf'],
        [ 'name' => 'Bifur', 'race' => 'Dwarf'],
        // ...
    ];

    $qb = new QueryBuilder();

    // Select all dwarfes from Thorins company.
    $query = $qb->create()
        ->select('name')
        ->from($thorinsCompany)
        ->where('race', 'Dwarf');
    $result = $query->execute();

    // Array (
    //     [0] => Array (
    //         [name] => Thorin Oakenshild
    //     )
    //     [1] => Array (
    //         [name] => Balin
    //     )
    //     [2] => Array (
    //         [name] => Bifur
    //     )
    //     ...
    // )

It is also possible to use different operators.

    <?php

    use Braincrafted\ArrayQuery\QueryBuilder;

    $starks = [
        [ 'name' => 'Robb', 'age' => 15 ],
        [ 'name' => 'Sansa', 'age' => 11 ],
        [ 'name' => 'Arya', 'age' => 9 ],
        [ 'name' => 'Bran', 'age' => 7 ],
        [ 'name' => 'Rickon', 'age' => 3 ]
    ];

    // Select all of Ned's children older than 10.
    $query = $qb->create()
        ->select('name')
        ->from($starks)
        ->where('age', 10, '>');
    $result = $query->execute();

In the third example filters are added to modify values before they are evaluated:

    <?php

    use Braincrafted\ArrayQuery\QueryBuilder;

    $users = [
        [ 'name' => '  haXor' ],
        [ 'name' => '1337PWNR' ],
        [ 'name' => '     LOL  '],
        [ 'name' => 'N0b' ],
        [ 'name' => 'n3rd' ]
    ];

    $qb = new QueryBuilder();

    // Get all users with name "lol" (after trimming whitespaces and converting it lowercase)
    $query = $qb->create()
        ->select('name')
        ->from($users)
        ->where('name', 'lol', '=', [ 'trim', 'lower' ]);
    $result = $query->execute();

    // Array (
    //     [0] => Array (
    //         [name] =>      LOL
    //     )
    // )

    // Get all users with a name of length 3 (after trimming whitespaces)
    $query = $qb->create()
        ->select('name')
        ->from($users)
        ->where('name', 3, '=', [ 'trim', 'length' ]);
    $result = $query->execute();

    // Array (
    //     [0] => Array (
    //         [name] =>      LOL
    //     )
    //     [1] => Array (
    //         [name] => N0b
    //     )
    // )

    // Get all users with name nerd (replace the letter 3 in the name through e)
    $query = $qb->create()
        ->select('name')
        ->from($users)
        ->where('name', 'nerd', '=', [ 'replace 3,e' ]);
    $result = $query->execute();

    // Array (
    //     [0] => Array (
    //         [name] => n3rd
    //     )
    // )


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
