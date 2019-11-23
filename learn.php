<?php

require 'vendor/autoload.php';

// it could use a little bit of memory, but it's fine
// because this process runs once.
ini_set('memory_limit', '1G');

// we load the configuration (which will be serialized
// later into our language model file
$config = new LanguageDetector\Config;

$c = new LanguageDetector\Learn($config);
foreach (glob(__DIR__ . '/samples/*') as $file) { 
    // feed with examples ('language', 'text');
    $c->addSample(basename($file), file_get_contents($file));
}

// some callback so we know where the process is 
$c->addStepCallback(function($lang, $status) {
    echo "Learning {$lang}: $status\n";
});

// save it in `datafile`. 
// we currently support the `php` serialization but it's trivial
// to add other formats, just extend `\LanguageDetector\Format\AbstractFormat`. 
//You can check example at https://github.com/crodas/LanguageDetector/blob/master/lib/LanguageDetector/Format/PHP.php
$c->save(AbstractFormat::initFormatByPath('language.php'));