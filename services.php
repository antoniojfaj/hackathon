<?php

require 'vendor/autoload.php';

// we load the language model, it would create
// the $config object for us.
$detect = LanguageDetector\Detect::initByPath('datafile.php');

echo $detect->detect($_POST['text']);