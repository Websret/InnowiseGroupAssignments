<?php

namespace Application\Lib;

use Twig\TwigFunction;

class Auth implements TwigImplementer
{
    private const PATH = 'Application/Config/users.php';

    private array $users;

    private array $params;

    private string $userName = '';

    private string $userPassword;

    private string $errorMessage = '';

    public function __construct()
    {
        $this->users = require self::PATH;
    }

    public static function isAuth()
    {
        if ($_SESSION['user']['authenticated']) {
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
        $_SESSION['user'] = [
            'name' => $this->userName,
            'authenticated' => $valid,
            'errorMessage' => $this->errorMessage,
        ];
    }

    public static function logoutAccount(): void
    {
        unset($_SESSION['user']);
    }

    private function validationParams(): bool
    {
        if (!filter_var($this->params['email'], FILTER_VALIDATE_EMAIL)) {
            $this->errorMessage = "Email is not valid.";
            return false;
        }
        if (!$this->findUser()) {
            $this->errorMessage = "This email is not found.";
            return false;
        }
        if (!$this->checkPassword()) {
            $this->errorMessage = "This password is not correct.";
            return false;
        }
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
