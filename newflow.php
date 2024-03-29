<?php

include __DIR__ . '/vendor/autoload.php';
include __DIR__ . "/Core/Log.php";


$dir = scandir(__DIR__);
if (!in_array("Tests", $dir)) {
    mkdir(__DIR__ . "/Tests");
}

$escopo = $_SERVER['argv'][1];

mkdir(__DIR__ . "/Tests/" . $escopo);
mkdir(__DIR__ . "/Tests/" . $escopo . "/data");
file_put_contents(
    __DIR__ . "/Tests/" . $escopo . "/data/Configs.php",
    '<?php
$host  = "https://jsonplaceholder.typicode.com";
$oauth = "";
if (file_exists(__DIR__ . "/oauth.cache")) {
    $oauth = file_get_contents(__DIR__ . "/oauth.cache");
}'
);

file_put_contents(
    __DIR__ . "/Tests/" . $escopo . "/01-example-request.php",
    '<?php
# Guzzle Documentation
# http://docs.guzzlephp.org/en/stable/request-options.html
use Core\ClientRest;
use Core\Log;

include __DIR__ . "/data/Configs.php";

$client = ClientRest::getClient($host);

$response = $client->get("/posts/1");

$statusCode = $response->getStatusCode();
$color      = $statusCode < 299 ? "yellow" : "red";
Log::consolePrint($statusCode, $color);
Log::consolePrint(ClientRest::getResponse($response), $color);'
);