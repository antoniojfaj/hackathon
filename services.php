<?php

require 'vendor/autoload.php';

var_dump($_POST);

// we load the language model, it would create
// the $config object for us.
$detect = LanguageDetector\Detect::initByPath('datafile.php');

echo $detect->detect('Hello, my name is peter.');