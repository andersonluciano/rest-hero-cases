<?php

include __DIR__ . '/vendor/autoload.php';
include __DIR__ . "/Core/Log.php";


$escopo = $_SERVER['argv'][1];
if ($escopo == "") {
    \Core\Log::consolePrint("Please type the flow name to continue: php newcase.php flow-name test-case", "red");
    exit;
}
$nomeTeste = $_SERVER['argv'][2];
if ($nomeTeste == "") {
    \Core\Log::consolePrint("Please type the case name to continue: php newcase.php flow-name test-case", "red");
    exit;
}

$dir = scandir(__DIR__ . "/Tests/" . $escopo);
if ($dir == false) {
    \Core\Log::consolePrint("Flow not found: " . $escopo, 'red');
    exit;
}
$numeroMaior = 1;
foreach ($dir as $item) {
    if (in_array($item, [".", "..", "data"])) {
        continue;
    }

    $numero = (int)explode("-", $item)[0];
    if ($numero > $numeroMaior) {
        $numeroMaior = $numero;
    }
}
$numeroTeste = ++$numeroMaior;

$numeroTeste = str_pad($numeroTeste, 2, "0", STR_PAD_LEFT);

$filedir = __DIR__ . "/Tests/" . $escopo . "/" . $numeroTeste . "-" . $nomeTeste . ".php";

file_put_contents(
    $filedir,
    '<?php
# Guzzle Documentation
# http://docs.guzzlephp.org/en/stable/request-options.html
use Core\ClientRest;
use Core\Log;

include __DIR__ . "/data/Configs.php";

$client = ClientRest::getClient($host);

##Your Test Here!'
);

\Core\Log::consolePrint("\nCase Created!\n");
\Core\Log::consolePrint($filedir . "\n", 'white');