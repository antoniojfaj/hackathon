<?php

require 'vendor/autoload.php';

putenv('GOOGLE_APPLICATION_CREDENTIALS=/var/www/html/hackathon/hackathon-7659e0d010b7.json');

# Imports the Google Cloud client library
use Google\Cloud\Speech\V1\SpeechClient;
use Google\Cloud\Speech\V1\RecognitionAudio;
use Google\Cloud\Speech\V1\RecognitionConfig;
use Google\Cloud\Speech\V1\RecognitionConfig\AudioEncoding;

# get contents of a file into a string
$content = $_POST['audio'];

# set string as audio content
$audio = (new RecognitionAudio())
    ->setContent($content);

# The audio file's encoding, sample rate and language
$config = new RecognitionConfig([
    'encoding' => AudioEncoding::LINEAR16,
    'sample_rate_hertz' => 32000,
    'language_code' => 'en-US'
]);

# Instantiates a client
$client = new SpeechClient();

# Detects speech in the audio file
$response = $client->recognize($config, $audio);

# Print most likely transcription
foreach ($response->getResults() as $result) {
    $alternatives = $result->getAlternatives();
    $mostLikely = $alternatives[0];
    $transcript = $mostLikely->getTranscript();
    printf('Transcript: %s' . PHP_EOL, $transcript);
}

$client->close();
