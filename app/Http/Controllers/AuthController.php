<?php


namespace App\Http\Controllers;


use App\Http\Models\User;
use Josantonius\Session\Session;
use App\Services\Redirector;

class AuthController extends Controller
{
    private $logined_message = 'Вы вошли в систему под пользователем %s';
    private $error_message = 'Неверный ввод логина или пароля';

    public function login()
    {
        $parameters = $this->request->request;
        $user = User::where([
            ['username', $parameters->get('username')],
            ['password', $parameters->get('password')],
        ])->first();

        if ($user) {
            Session::set('status', true);
            Session::set('user', $user);

            Redirector::redirect('/login?message=' . sprintf($this->logined_message, $user->username));
        }

        Redirector::redirect("/login?error=$this->error_message");
    }

    public function loginForm()
    {
        $message = $this->request->query->has('message') ? $this->request->query->get('message') : null;
        $error = $this->request->query->has('error') ? $this->request->query->get('error') : null;

        return $this->twig->render('pages/login.html.twig', [
            'is_authorized' => Session::get('status'),
            'message' => $message,
            'error' => $error,
        ]);
    }

    public function logout()
    {
        Session::set('status', false);
        Session::destroy('user');

        Redirector::redirect('/home');
    }
}