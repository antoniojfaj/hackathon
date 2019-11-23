<?php

require 'vendor/autoload.php';

# save audio file
foreach($_FILES as $file) {
    move_uploaded_file($file['tmp_name'], 'audio.ogg');
}

putenv('GOOGLE_APPLICATION_CREDENTIALS='.__DIR__.'/hackathon-7659e0d010b7.json');

# Imports the Google Cloud client library
use Google\Cloud\Speech\V1\SpeechClient;
use Google\Cloud\Speech\V1\RecognitionAudio;
use Google\Cloud\Speech\V1\RecognitionConfig;
use Google\Cloud\Speech\V1\RecognitionConfig\AudioEncoding;

# The name of the audio file to transcribe
$audioFile = __DIR__ . '/audio.ogg';

# get contents of a file into a string
$content = file_get_contents($audioFile);

# set string as audio content
$audio = (new RecognitionAudio())
    ->setContent($content);

# The audio file's encoding, sample rate and language
$config = new RecognitionConfig([
    'encoding' => AudioEncoding::OGG_OPUS,
    'sample_rate_hertz' => 48000,
    'language_code' => 'es-ES',
    'max_alternatives' => 3,
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
