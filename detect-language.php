<?php

require 'vendor/autoload.php';
putenv('GOOGLE_APPLICATION_CREDENTIALS='.__DIR__.'/hackathon-7659e0d010b7.json');
require 'lib/translator.php';

header("Content-type: application/json; charset=utf-8");
$translator = new translator();
echo $translator->getAudioLanguage();