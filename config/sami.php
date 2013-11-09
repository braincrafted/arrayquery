<?php

use Sami\Sami;
use Sami\Version\GitVersionCollection;
use Symfony\Component\Finder\Finder;

$iterator = Finder::create()
    ->files()
    ->name('*.php')
    ->in($dir = __DIR__.'/../src');

// $versions = GitVersionCollection::create($dir)
//     ->add('master', 'master branch');

return new Sami($iterator, array(
    'theme'                => 'default',
    // 'versions'             => $versions,
    'title'                => 'ArrayQuery API',
    'build_dir'            => __DIR__.'/../docs/api/%version%',
    'cache_dir'            => __DIR__.'/../docs/api/%version%/cache',
    'default_opened_level' => 3
));
