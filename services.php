<?php

require 'vendor/autoload.php';

function detect_language($txt) {
    $detect = LanguageDetector\Detect::initByPath('datafile.php');
    $lang = $detect->detect($txt);
    $language = is_array($lang) ? $lang[0]['lang'] : $lang;
    return json_encode(['lang' => $language, 'text' => $txt]);
}

# save audio file
unlink('audio.ogg');
foreach($_FILES as $file) {
    move_uploaded_file($file['tmp_name'], 'audio.ogg');
}

# transcode to wav
unlink('audio.wav');
shell_exec('ffmpeg -i audio.ogg audio.wav');

putenv('GOOGLE_APPLICATION_CREDENTIALS='.__DIR__.'/hackathon-7659e0d010b7.json');

# Imports the Google Cloud client library
use Google\Cloud\Speech\V1p1beta1\SpeechClient;
use Google\Cloud\Speech\V1p1beta1\RecognitionAudio;
use Google\Cloud\Speech\V1p1beta1\RecognitionConfig;
use Google\Cloud\Speech\V1p1beta1\RecognitionConfig\AudioEncoding;

# The name of the audio file to transcribe
$audioFile = __DIR__ . '/audio.wav';

# get contents of a file into a string
$content = file_get_contents($audioFile);

# set string as audio content
$audio = (new RecognitionAudio())
    ->setContent($content);

# The audio file's encoding, sample rate and language
$config = new RecognitionConfig([
    'encoding' => AudioEncoding::LINEAR16,
    'sample_rate_hertz' => 48000,
    'language_code' => 'en-US',
    'alternative_language_codes' => ['es','fr','zh']
]);

# Instantiates a client
$client = new SpeechClient();

# Detects speech in the audio file
$response = $client->recognize($config, $audio);

# Print most likely transcription
$found = false;
foreach ($response->getResults() as $result) {
    $alternatives = $result->getAlternatives();
    $mostLikely = $alternatives[0];
    echo detect_language($mostLikely->getTranscript());
    $found = true;
    break;
}

$client->close();

if(!$found) {
    echo json_encode([]);
}