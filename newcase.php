$<?php
error_reporting(E_ALL && !E_NOTICE && !E_WARNING);

include __DIR__ . '/vendor/autoload.php';
include __DIR__ . "/Core/Log.php";


$escopo = $_SERVER['argv'][1];
if ($escopo == "") {
    \Core\Log::consolePrint("Informe o escopo para prosseguir", "red");
    exit;
}
$nomeTeste = $_SERVER['argv'][2];
if ($nomeTeste == "") {
    \Core\Log::consolePrint("Informe o nome teste para prosseguir: php newcase.php escopo nome-teste", "red");
    exit;
}


$dir = scandir(__DIR__ . "/Tests/" . $escopo);
if ($dir == false) {
    \Core\Log::consolePrint("Pasta de teste não existe: " . $escopo, 'red');
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

file_put_contents($filedir, '<?php
# Guzzle Documentation
# http://docs.guzzlephp.org/en/stable/request-options.html
use Core\ClientRest;
use Core\Log;

include __DIR__ . "/data/Configs.php";

$client = ClientRest::getClient($host);

##Your Test Here!');

\Core\Log::consolePrint("\nCase criado com sucesso!\n");
\Core\Log::consolePrint($filedir . "\n", 'white');