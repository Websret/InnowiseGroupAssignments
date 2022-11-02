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

    private int $numberInputs;

    private string $startTime;

    private string $endTime;

    public function __construct()
    {
        $this->users = new User();
    }

    public static function isAuth(): bool
    {
        if (self::checkSession() && $_SESSION['data']['user']['authenticated']) {
            return true;
        }
        return false;
    }

    private static function checkSession(): bool
    {
        return isset($_SESSION['data']['user']);
    }

    public static function loginUser(array $params = []): void
    {
        $auth = new Auth;
        $auth->params = $params;
        $validParams = $auth->checkUsersData();

        $auth->createSession($validParams);
        $auth->checkRememberField();
    }

    private function checkRememberField(): void
    {
        if ($this->params['remember']) {
            $this->setCookie();
        }
    }

    private function createSession(bool $valid): void
    {
        $_SESSION['data']['user'] = [
            'name' => $this->userData[0]['first_name'],
            'authenticated' => $valid,
            'errorMessage' => $this->errorMessage,
        ];
    }

    public static function createRegistrationSession(array $params = []): void
    {
        $_SESSION['data']['user'] = [
            'name' => $params['firstName'],
            'authenticated' => true,
        ];
    }

    public static function logoutAccount(): void
    {
        unset($_SESSION['data']);
        (new Auth)->deleteCookie();
    }

    private function checkUsersData(): bool
    {
        $row = $this->users->getUsersData(['email' => $this->params['email']]);
        $this->userData = $row;
        if (empty($row) || !$this->checkPassword()) {
            $this->errorMessage .= " Login is incorrect.";
            return false;
        }
        return true;
    }

    private function checkPassword(): bool
    {
        if ($this->checkPasswordInDb() && $this->checkUserBanned()) {
            $this->deleteAttackerFromTable();
            return true;
        }
        $this->checkLoginAttempts();
        return false;
    }

    private function checkPasswordInDb(): bool
    {
        return (password_verify($this->params['password'], $this->userData[0]['password']) ||
            ($this->params['password'] == $this->userData[0]['password']));
    }

    private function checkUserBanned(): bool
    {
        $row = $this->users->getAttackers(['ip' => $_SERVER['REMOTE_ADDR']]);
        $nowDateTime = date("d-m-y H:i:s");
        if (strtotime($nowDateTime) < strtotime($row[0]['endTime']) && $row[0]['numberAttack'] == 3) {
            return false;
        }
        return true;
    }

    private function checkLoginAttempts(): void
    {
        $row = $this->users->getAttackers(['ip' => $_SERVER['REMOTE_ADDR']]);
        $this->startTime = date("d-m-y H:i:s");
        $this->endTime = date("y-m-d H:i:s", strtotime($this->startTime . '+ 15 min'));
        if (empty($row)) {
            $this->numberInputs = 1;
            $this->addAttacker();
        } elseif ($row[0]['numberAttack'] < 3) {
            $this->numberInputs = ++$row[0]['numberAttack'];
            $this->updateAttacker();
        } else {
            $this->errorMessage .= "You ip address blocked, try again later.";
        }
    }

    private function addAttacker(): void
    {
        $params = [
            'ip' => $_SERVER['REMOTE_ADDR'],
            'email' => $this->params['email'],
            'startTime' => $this->startTime,
            'numberAttack' => $this->numberInputs,
            'endTime' => $this->endTime,
        ];
        $this->users->addAttackers($params);
    }

    private function updateAttacker(): void
    {
        $this->users->updateAttackers([
            'numberAttack' => $this->numberInputs,
            'startTime' => $this->startTime,
            'ip' => $_SERVER['REMOTE_ADDR'],
            'endTime' => $this->endTime,
        ]);
    }

    private function deleteAttackerFromTable(): void
    {
        $this->users->deleteAttackers(['ip' => $_SERVER['REMOTE_ADDR']]);
    }

    private function setCookie(): void
    {
        setcookie("email", $this->userData[0]['email'], time() + 60 * 60 * 24 * 7, "/");
        setcookie("token", $this->userData[0]['password'], time() + 60 * 60 * 24 * 7, "/", null, null, true);
        $this->checkCookie();
    }

    private function checkCookie(): void
    {
        if (isset($_COOKIE['id']) && isset($_COOKIE)) {
            if (($this->userData[0]['email'] !== $_COOKIE['email']) &&
                ($this->userData[0]['password'] !== $_COOKIE['token'])) {
                $this->deleteCookie();
                $this->errorMessage = "Error with cookie files.";
            }
        }
    }

    private function deleteCookie(): void
    {
        setcookie("email", "", time() - 3600 * 24 * 30 * 12, "/");
        setcookie("token", "", time() - 3600 * 24 * 30 * 12, "/", null, null, true);
    }

    public function addFunctions(&$twig)
    {
        $isAuthFunc = new TwigFunction('isAuth', fn() => self::isAuth());
        $twig->addGlobal('session', $_SESSION);
        $twig->addFunction($isAuthFunc);
    }
}
