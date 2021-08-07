<?php


namespace App\Http\Controllers;


use App\Services\Twig;
use Josantonius\Session\Session;
use Symfony\Component\HttpFoundation\Request;

class Controller
{
    protected $request;
    protected $twig;
    const SESSION_LIFETIME_IN_SECONDS = 3600;

    public function __construct()
    {
        $this->request = Request::createFromGlobals();
        $twig = new Twig();
        $this->twig = $twig->returnTwigInstance();
        $this->initSession();
    }

    private function initSession()
    {
        Session::init(self::SESSION_LIFETIME_IN_SECONDS);
        Session::setPrefix('user_');

        if (!array_key_exists('user_status', Session::get())) {
            Session::set('status', false);
        }
    }
}