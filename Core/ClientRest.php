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
}