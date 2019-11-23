<?php

require 'vendor/autoload.php';

// we load the language model, it would create
// the $config object for us.
$detect = LanguageDetector\Detect::initByPath('datafile.php');

$lang = $detect->detect("Bonjour, je suis à l'université d'Alicante");

var_dump($lang);