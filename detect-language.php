<?php
require 'vendor/autoload.php';
putenv('GOOGLE_APPLICATION_CREDENTIALS='.__DIR__.'/hackathon-7659e0d010b7.json');

# Imports the Google Cloud client library
use Google\Cloud\Speech\V1p1beta1\SpeechClient;
use Google\Cloud\Speech\V1p1beta1\RecognitionAudio;
use Google\Cloud\Speech\V1p1beta1\RecognitionConfig;
use Google\Cloud\Speech\V1p1beta1\RecognitionConfig\AudioEncoding;
use Google\Cloud\Translate\TranslateClient;

function detect_language($txt) {
    $detect = LanguageDetector\Detect::initByPath('datafile.php');
    $lang = $detect->detect($txt);
    $language = is_array($lang) ? $lang[0]['lang'] : $lang;
    return json_encode(['lang' => $language, 'text' => $txt]);
}

function detect_language2($text) {
    $translate = new TranslateClient();
    $result = $translate->detectLanguage($text);
    return json_encode(['lang' => $result['languageCode'], 'text' => $text]);
}

# save audio file
foreach($_FILES as $file) {
    move_uploaded_file($file['tmp_name'], 'audio.ogg');
}

# transcode to wav
shell_exec('ffmpeg -i audio.ogg audio.wav');
unlink('audio.ogg');

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

header("Content-type: application/json; charset=utf-8");

# Print most likely transcription
$found = false;
foreach ($response->getResults() as $result) {
    $alternatives = $result->getAlternatives();
    $mostLikely = $alternatives[0];
    echo detect_language2($mostLikely->getTranscript());
    $found = true;
    break;
}

$client->close();
unlink('audio.wav');

if(!$found) {
    echo json_encode([]);
}