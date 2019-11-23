<?php

require 'vendor/autoload.php';


// we load the language model, it would create
// the $config object for us.
$detect = LanguageDetector\Detect::initByPath('language.php');

$lang = $detect->detect("Agricultura (-ae, f.), sensu latissimo, 
est summa omnium artium et scientiarum et technologiarum quae de 
terris colendis et animalibus creandis curant, ut poma, frumenta, 
charas, carnes, textilia, et aliae res e terra bene producantur. 
Specialius, agronomia est ars et scientia quae terris colendis student, 
agricultio autem animalibus creandis.");

var_dump($lang);