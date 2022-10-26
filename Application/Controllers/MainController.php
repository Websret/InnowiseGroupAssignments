<?php

namespace Application\Controllers;

use Application\Core\Controller;
use Application\Lib\Auth;

class MainController extends Controller
{
    public function indexAction(): void
    {
        if (!Auth::isAuth()) {
            $this->view->redirect('/main/login');
        }
        $this->view->render();
    }

    public function loginAction(): void
    {
        $this->view->render();
    }

    public function authorizationAction(): void
    {
        $params = [
            'email' => $_POST['email'],
            'password' => $_POST['password'],
        ];
        Auth::loginUser($params);
        $this->redirect();
    }

    public function logoutAction(): void
    {
        Auth::logoutAccount();
        $this->redirect();
    }

    private function redirect(): void
    {
        if (Auth::isAuth()) {
            $this->view->redirect('/');
        }
        $this->view->redirect('/main/login');
    }
}
