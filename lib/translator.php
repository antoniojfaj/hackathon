<?php
require 'vendor/autoload.php';
putenv('GOOGLE_APPLICATION_CREDENTIALS='.__DIR__.'/hackathon-7659e0d010b7.json');

# Imports the Google Cloud client library
use Google\Cloud\Speech\V1p1beta1\SpeechClient;
use Google\Cloud\Speech\V1p1beta1\RecognitionAudio;
use Google\Cloud\Speech\V1p1beta1\RecognitionConfig;
use Google\Cloud\Speech\V1p1beta1\RecognitionConfig\AudioEncoding;
use Google\Cloud\TextToSpeech\V1\AudioConfig;
use Google\Cloud\TextToSpeech\V1\AudioEncoding as AudioEncoding2;
use Google\Cloud\TextToSpeech\V1\SsmlVoiceGender;
use Google\Cloud\TextToSpeech\V1\SynthesisInput;
use Google\Cloud\TextToSpeech\V1\TextToSpeechClient;
use Google\Cloud\TextToSpeech\V1\VoiceSelectionParams;
use Google\Cloud\Translate\TranslateClient;

class translator
{
    public function deleteAudio()
    {
        ///unlink('audio.wav');
    }

    public function generateAufioFile($text, $lang)
    {
        // instantiates a client
        $client = new TextToSpeechClient();

        // sets text to be synthesised
        $synthesisInputText = (new SynthesisInput())->setText($text);

        // build the voice request, select the language code ("en-US") and the ssml
        // voice gender
        $voice = (new VoiceSelectionParams())
            ->setLanguageCode($lang)
            ->setSsmlGender(SsmlVoiceGender::FEMALE);

        // Effects profile
        $effectsProfileId = "telephony-class-application";

        // select the type of audio file you want returned
        $audioConfig = (new AudioConfig())
            ->setAudioEncoding(AudioEncoding2::MP3)
            ->setEffectsProfileId(array($effectsProfileId));

        // perform text-to-speech request on the text input with selected voice
        // parameters and audio file type
        $response = $client->synthesizeSpeech($synthesisInputText, $voice, $audioConfig);
        $audioContent = $response->getAudioContent();

        // the response's audioContent is binary
        $fileName = 'output-'.time().'.mp3';
        if(file_exists($fileName)) {
            unlink($fileName);
        }
        file_put_contents($fileName, $audioContent);
        return $fileName;
    }

    public function getAudioFileContent()
    {
        # save audio file
        foreach($_FILES as $file) {
            move_uploaded_file($file['tmp_name'], 'audio.ogg');
        }

        # The name of the audio file to transcribe
        $audioFile = 'audio-'.time().'.wav';

        # transcode to wav
        shell_exec('ffmpeg -i audio.ogg '.$audioFile);
        unlink('audio.ogg');

        # get contents of a file into a string
        return file_get_contents($audioFile);
    }

    public function getAudioLanguage()
    {
        # get contents of a file into a string
        $content = $this->getAudioFileContent();

        # set string as audio content
        $audio = (new RecognitionAudio())->setContent($content);

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
        foreach ($response->getResults() as $result) {
            $alternatives = $result->getAlternatives();
            $mostLikely = $alternatives[0];
            $json = $this->getTextLanguage($mostLikely->getTranscript());
            $client->close();
            $this->deleteAudio();
            return $json;
        }

        $client->close();
        $this->deleteAudio();

        return json_encode([]);
    }

    public function getAudioText()
    {
        # get contents of a file into a string
        $content = $this->getAudioFileContent();

        # set string as audio content
        $audio = (new RecognitionAudio())->setContent($content);

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
        foreach ($response->getResults() as $result) {
            $alternatives = $result->getAlternatives();
            $mostLikely = $alternatives[0];
            $text = $mostLikely->getTranscript();
            $client->close();
            $this->deleteAudio();
            return $text;
        }

        $client->close();
        $this->deleteAudio();

        return '-';
    }

    public function getTextLanguage($text)
    {
        $translate = new TranslateClient();
        $result = $translate->detectLanguage($text);
        return json_encode(['lang' => $result['languageCode'], 'text' => $text]);
    }

    public function getTextLanguage2($txt)
    {
        $detect = LanguageDetector\Detect::initByPath('datafile.php');
        $lang = $detect->detect($txt);
        $language = is_array($lang) ? $lang[0]['lang'] : $lang;
        return json_encode(['lang' => $language, 'text' => $txt]);
    }

    public function translateText($text, $lang)
    {
        $translate = new TranslateClient();
        $translation = $translate->translate($text, [
            'target' => $lang
        ]);
        return $translation['text'];
    }
}