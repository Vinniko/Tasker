<?php


namespace App\Services;


use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Twig
{
    private $twig;
    private $loader;

    public function __construct()
    {
        $this->loader = new FilesystemLoader(dirname(__DIR__) . '/Http/Views');
        $this->twig = new Environment($this->loader);
    }

    public function returnTwigInstance()
    {
        return $this->twig;
    }


}