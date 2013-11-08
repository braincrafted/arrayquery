<?php

require_once __DIR__.'/../vendor/autoload.php';

use Braincrafted\ArrayQuery\QueryBuilder;

$users = [
    [ 'name' => '  haXor' ],
    [ 'name' => '1337PWNR' ],
    [ 'name' => '     LOL  '],
    [ 'name' => 'N0b' ]
];

$qb = new QueryBuilder();

// Get all users with name "lol" (after trimming whitespaces and converting it lowercase)
$query = $qb->create()
    ->select('name')
    ->from($users)
    ->where('name', 'lol', '=', [ 'trim', 'lower' ]);
$result = $query->execute();

print_r($result);

// Get all users with a name of length 3 (after trimming whitespaces)
$query = $qb->create()
    ->select('name')
    ->from($users)
    ->where('name', 3, '=', [ 'trim', 'length' ]);
$result = $query->execute();

print_r($result);
