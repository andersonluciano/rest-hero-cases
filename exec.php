<?php

include __DIR__ . '/vendor/autoload.php';

use Core\Log;
use Core\ClientRest;
use Core\OAuth;

$runCase = [];
function getTest($flow, $caseNumber)
{
    foreach ($flow as $item) {
        $itemExp = explode("-", $item);
        if ($itemExp[0] == $caseNumber) {
            return $item;
        }
    }

    return false;
}

function executeCase($flow, $case)
{
    Log::consolePrint("Running Case " . $case, "blue");

    include_once __DIR__ . "/Tests/" . $flow . "/" . $case;
}


$flow = $_SERVER['argv'][1];
if (array_key_exists(2, $_SERVER['argv'])) {
    $runCase = $_SERVER['argv'][2];
    $runCase = explode(",", $runCase);
}
$flowCases = scandir(__DIR__ . "/Tests/" . $flow);

if (count($runCase) > 0) {
    if ($runCase[0] == "ls") {
        $dir = scandir(__DIR__ . "/Tests/" . $flow);
        Log::consolePrint("\n --------- Available Cases  --------- ", "blue");
        Log::consolePrint(print_r($dir, 1), "white");
        exit;
    }

    foreach ($runCase as $item) {
        $case = getTest($flowCases, $item);
        if (empty($case)) {
            Log::consolePrint("Case " . $item . " not found", 'red');
        }

        executeCase($flow, $case);
    }
} else {
    foreach ($flowCases as $case) {
        if ($case == "." || $case == ".." || $case == "data" || $case[0] == "_") {
            continue;
        }

        executeCase($flow, $case);
    }
}

