<?php

require 'vendor/autoload.php';
putenv('GOOGLE_APPLICATION_CREDENTIALS='.__DIR__.'/hackathon-7659e0d010b7.json');
require 'lib/translator.php';

$translator = new translator();
$originalText = $translator->getAudioText();