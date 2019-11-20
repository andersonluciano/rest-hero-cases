<?php

namespace Core;

class Log
{
    public static function write($text)
    {
        if (is_array($text)) {
            $text = print_r($text, 1);
        }

        $dir = scandir(__DIR__ . "/../");
        if (!in_array("test-log", $dir)) {
            mkdir(__DIR__ . "/../test-log");
        }

        $file = __DIR__ . "/../test-log/" . date("d_m_y") . ".txt";
        $text = date("d-m-Y H:i:s") . "\t\t" . $text . "\n\n";
        file_put_contents($file, $text, FILE_APPEND);
    }

    public static function consolePrint($text, $color = "green")
    {
        switch ($color) {
            case "black":
                $color = "0;30";
                break;
            case "dark_grey":
                $color = "1;30";
                break;
            case "red":
                $color = "0;31";
                break;
            case "light_red":
                $color = "1;31";
                break;
            case "green":
                $color = "0;32";
                break;
            case "light_green":
                $color = "1;32";
                break;
            case "brown":
                $color = "0;33";
                break;
            case "yellow":
                $color = "1;33";
                break;
            case "blue":
                $color = "0;34";
                break;
            case "light_blue":
                $color = "1;34";
                break;
            case "magenta":
                $color = "0;35";
                break;
            case "light_magenta":
                $color = "1;35";
                break;
            case "cyan":
                $color = "0;36";
                break;
            case "light_cyan":
                $color = "1;36";
                break;
            case "grey":
                $color = "0;37";
                break;
            case "white":
                $color = "1;37";
                break;
        }

        if (is_array($text)) {
            $text = print_r($text, 1);
        }
        self::write($text);


        echo "\e[" . $color . "m" . $text . "\e[0m \n";
    }
}