<?php
namespace Core;

class OAuth
{
    public static function getTestAccess()
    {
        $client = ClientRest::getClient();

        $path = __DIR__ . "/../cache/oauth.txt";
        if (file_exists($path)) {
            $oauthfuile = file_get_contents($path);
            if ($oauthfuile != "") {
                if (self::tokenIsValid($oauthfuile) == true) {
                    return $oauthfuile;
                }
            }
        }

        $response = $client->post("/access_token", [
            "form_params" => [
                'grant_type' => 'client_credentials',
                'client_id' => 'client_test',
                'client_secret' => '123456',
                'scope' => 'api',
            ]
        ]);

        $content = json_decode($response->getBody()->getContents(), 1);
        if (!is_array($content)) {
            Log::consolePrint("oAuth não concedido", 'red');
            exit;
        }

        Log::write("oAuth: " . $content['access_token'], 'yellow');
        file_put_contents($path, $content['access_token']);
        $accessToken = $content['access_token'];

        if (self::tokenIsValid($accessToken) == false) {
            Log::consolePrint("Token inválido", 'red');
            exit;
        }

        return $accessToken;
    }

    public static function tokenIsValid($token)
    {
        // $client = ClientRest::getClient();

        // $response = $client->get("/api/pong", [
        //     "headers" => [
        //         "Authorization" => $token
        //     ]
        // ]);

        // if ($response->getStatusCode() != 200) {
        //     Log::consolePrint($response->getBody()->getContents() . $response->getStatusCode(), 'cyan');

        //     return false;
        // }

        return true;
    }

    public static function getJwtCache()
    {
        $path = __DIR__ . "/../cache/jwt.txt";

        if (file_exists($path)) {
            return file_get_contents($path);
        }
        throw new \Exception("Cache JWT não disponível");
    }

    public static function saveJwtCache($token)
    {
        file_put_contents(__DIR__ . "/../cache/jwt.txt", $token);
        Log::consolePrint("Cache Token JWT gravado", 'yellow');
    }
}