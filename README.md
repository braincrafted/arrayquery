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


Example
-------

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


Author
------

- [Florian Eckerstorfer](http://florian.ec)


License
-------

For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
