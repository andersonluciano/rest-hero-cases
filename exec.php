<?php
include __DIR__ . '/vendor/autoload.php';

//error_reporting(E_ALL && !E_NOTICE && !E_WARNING);

use Core\Log;
use Core\ClientRest;
use Core\OAuth;

$testeExecutar = [];
function getTest($testesEscopo, $numTeste)
{
    foreach ($testesEscopo as $item) {
        $itemExp = explode("-", $item);
        if ($itemExp[0] == $numTeste) {
            return $item;
        }
    }

    return false;
}


$escopo = $_SERVER['argv'][1];
if (array_key_exists(2, $_SERVER['argv'])) {
    $testeExecutar = $_SERVER['argv'][2];
    $testeExecutar = explode(",", $testeExecutar);
}
$testesEscopo = scandir(__DIR__ . "/Tests/" . $escopo);

if (count($testeExecutar) > 0) {
    if ($testeExecutar[0] == "ls") {
        $dir = scandir(__DIR__ . "/Tests/" . $escopo);
        Log::consolePrint("\n --------- Testes Disponíveis --------- ");
        Log::consolePrint(print_r($dir, 1), "white");
        exit;
    }

    foreach ($testeExecutar as $item) {
        $fileTeste = getTest($testesEscopo, $item);
        if (empty($fileTeste)) {
            Log::consolePrint("Teste " . $item . " não encontrado", 'red');
        }
        Log::consolePrint("Rodando teste " . $fileTeste);

        include_once __DIR__ . "/Tests/" . $escopo . "/" . $fileTeste;
    }
} else {
    foreach ($testesEscopo as $test) {
        if ($test == "." || $test == ".." || $test == "data") {
            continue;
        }
        Log::consolePrint("Rodando teste " . $test);

        include_once __DIR__ . "/Tests/" . $escopo . "/" . $test;
    }
}

