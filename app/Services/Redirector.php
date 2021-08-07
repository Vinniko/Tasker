<?php


namespace App\Services;


class Redirector
{
    public static function redirect(string $url)
    {
        header('Location: ' . $url, true, 302);

        exit();
    }
}