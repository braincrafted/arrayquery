<?php

require_once __DIR__.'/../vendor/autoload.php';

use Braincrafted\ArrayQuery\QueryBuilder;

$thorinsCompany = [
    [ 'name' => 'Bilbo Baggins', 'race' => 'Hobbit' ],
    [ 'name' => 'Gandalf', 'race' => 'Wizard' ],
    [ 'name' => 'Thorin Oakenshild', 'race' => 'Dwarf' ],
    [ 'name' => 'Balin', 'race' => 'Dwarf'],
    [ 'name' => 'Bifur', 'race' => 'Dwarf'],
    [ 'name' => 'Bofur', 'race' => 'Dwarf'],
    [ 'name' => 'Bombur', 'race' => 'Dwarf'],
    [ 'name' => 'Dori', 'race' => 'Dwarf'],
    [ 'name' => 'Dwalin', 'race' => 'Dwarf'],
    [ 'name' => 'Fili', 'race' => 'Dwarf'],
    [ 'name' => 'Gloin', 'race' => 'Dwarf'],
    [ 'name' => 'Kili', 'race' => 'Dwarf'],
    [ 'name' => 'Nori', 'race' => 'Dwarf'],
    [ 'name' => 'Oin', 'race' => 'Dwarf'],
    [ 'name' => 'Ori', 'race' => 'Dwarf']
];

$qb = new QueryBuilder();

$query = $qb->create()
    ->select('name')
    ->from($thorinsCompany)
    ->where('race', 'Dwarf');
$result = $query->execute();

print_r($result);
