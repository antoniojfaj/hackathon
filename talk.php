<?php

require 'vendor/autoload.php';
putenv('GOOGLE_APPLICATION_CREDENTIALS='.__DIR__.'/hackathon-7659e0d010b7.json');
require 'lib/translator.php';

$translator = new translator();
$text = isset($_POST['text']) ? $_POST['text'] : 'Hemos avisado a emergencias, espere.';
$lang = isset($_POST['lang']) ? $_POST['lang'] : 'es-ES';
header('Location: '.$translator->generateAufioFile($text, $lang));