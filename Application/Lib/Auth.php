<?php

namespace Application\Lib;

use Twig\TwigFunction;

class Auth implements TwigImplementer
{
    private const PATH = 'Application/Config/users.php';

    private array $users;

    private array $params;

    private string $userName;

    private string $userPassword;

    public function __construct()
    {
        $this->users = require self::PATH;
    }

    public static function isAuth()
    {
        if (isset($_SESSION['authenticated'])) {
            return true;
        }
        return false;
    }

    public static function loginUser(array $params = []): void
    {
        $auth = new Auth;
        $auth->params = $params;
        $validParams = $auth->validationParams();

        $auth->createSession($validParams);
    }

    private function createSession(bool $valid): void
    {
        if ($valid) {
            $_SESSION['name'] = $this->userName;
            $_SESSION['authenticated'] = true;
        }
    }

    public static function logoutAccount(): void
    {
        unset($_SESSION['authenticated']);
    }

    private function validationParams(): bool
    {
        if (!filter_var($this->params['email'], FILTER_VALIDATE_EMAIL)) {
            $_SESSION['message'] = "Email is not valid.";
            return false;
        }
        if (!$this->findUser()) {
            $_SESSION['message'] = "This email is not found.";
            return false;
        }
        if (!$this->checkPassword()) {
            $_SESSION['message'] = "This password is not correct.";
            return false;
        }
        unset($_SESSION['message']);
        return true;
    }

    private function findUser(): bool
    {
        if (isset($this->users[$this->params['email']])) {
            $user = $this->users[$this->params['email']];
            $this->userName = $user['name'];
            $this->userPassword = $user['password'];
            return true;
        }
        return false;
    }

    private function checkPassword(): bool
    {
        return password_verify($this->params['password'], $this->userPassword);
    }

    public function addFunctions(&$twig)
    {
        $isAuthFunc = new TwigFunction('isAuth', fn() => self::isAuth());
        $twig->addGlobal('session', $_SESSION);
        $twig->addFunction($isAuthFunc);
    }
}
