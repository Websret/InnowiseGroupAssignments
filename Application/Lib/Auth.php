<?php

namespace Application\Lib;

use Application\Models\User;
use Twig\TwigFunction;

class Auth implements TwigImplementer
{
    private array $params;

    private string $errorMessage = '';

    private User $users;

    private array $userData;

    public function __construct()
    {
        $this->users = new User();
    }

    public static function isAuth()
    {
        if ($_SESSION['data']['user']['authenticated']) {
            return true;
        }
        return false;
    }

    public static function loginUser(array $params = []): void
    {
        $auth = new Auth;
        $auth->params = $params;
        $validParams = $auth->checkUsersData();

        $auth->createSession($validParams);
    }

    private function createSession(bool $valid): void
    {
        $_SESSION['data']['user'] = [
            'name' => $this->userData[0]['first_name'],
            'authenticated' => $valid,
            'errorMessage' => $this->errorMessage,
        ];
    }

    public static function logoutAccount(): void
    {
        unset($_SESSION['data']);
    }

    private function checkUsersData(): bool
    {
        $row = $this->users->getUsersData(['email' => $this->params['email']]);
        $this->userData = $row;
        if (empty($row) || !$this->checkPassword($row[0]['password'])) {
            $this->errorMessage = "Login is incorrect.";
            return false;
        }
        return true;
    }

    private function checkPassword($param): bool
    {
        if (password_verify($this->params['password'], $this->userData[0]['password'])) {
            return true;
        } elseif ($this->params['password'] == $this->userData[0]['password']) {
            return true;
        }
        return false;
    }

    public function addFunctions(&$twig)
    {
        $isAuthFunc = new TwigFunction('isAuth', fn() => self::isAuth());
        $twig->addGlobal('session', $_SESSION);
        $twig->addFunction($isAuthFunc);
    }
}
