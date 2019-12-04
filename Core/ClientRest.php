<?php

namespace Core;


use Psr\Http\Message\ResponseInterface;

class ClientRest
{
    static $hostInformed = false;

    /**
     * @return \GuzzleHttp\Client
     */
    public static function getClient($host = null)
    {
        if ($host == null) {
            self::$hostInformed == false;

            $host = BASE_URL;
        }

        if (self::$hostInformed == false) {
            Log::consolePrint("Host: " . $host, "grey");
            self::$hostInformed = true;
        }

        return new \GuzzleHttp\Client(["base_uri" => $host, "http_errors" => false]);
    }

    public static function getResponse(ResponseInterface $response)
    {
        $body = json_decode($response->getBody()->getContents(), 1);
        if ($body == null) {
            $response->getBody()->rewind();
            $body = $response->getBody()->getContents();
        }

        return $body;
    }

    public static function printCompleteResponse(ResponseInterface $response)
    {
        $contentType = $response->getHeaderLine("Content-Type");
        Log::consolePrint("Content-Type: " . $contentType, 'white');

        $statusCode = $response->getStatusCode();
        $color      = $statusCode < 299 ? "yellow" : "red";
        Log::consolePrint($statusCode, $color);

        $body = ClientRest::getResponse($response);
        Log::consolePrint($body, $color);
    }
}