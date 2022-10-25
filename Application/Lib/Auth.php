<?php

namespace Application\Lib;

class Auth
{
    private const PATH = 'Application/Config/users.php';

    private array $users;

    private array $params;

    private string $url;

    private string $userName;

    private string $userPassword;

    private string $errorMessage;

    public function __construct()
    {
        $this->users = require self::PATH;
    }

    public function checkAuthorization(): array
    {
        $this->checkSession();
        return [
            $this->url,
            [
                'name' => $_SESSION['name'],
            ],
        ];
    }

    public function loginUser(array $params = []): array
    {
        $this->params = $params;
        $validParams = $this->validationParams();

        $this->createSession($validParams);

        $this->redirect();
        return [
            $this->url,
            [
                'error' => $this->errorMessage,
            ]
        ];
    }

    public function exitAccount(): string
    {
        $_SESSION['name'] = '';

        $this->checkSession();
        return $this->url;
    }

    private function alert(string $message): void
    {
        $this->errorMessage = $message;
    }

    private function checkSession(): void
    {
        $url = '/';
        if (empty($_SESSION['name'])){
            $url = '/main/login';
        }
        $this->url = $url;
    }

    private function createSession(bool $valid): void
    {
        if ($valid){
            $_SESSION['name'] = $this->userName;
        }
    }

    private function redirect(): void
    {
        $url = '/';
        if (!$this->validationParams()) {
            $url = '/main/login';
        }
        $this->url = $url;
    }

    private function validationParams(): bool
    {
        if (!filter_var($this->params['email'], FILTER_VALIDATE_EMAIL)){
//            $_SESSION["message"] = "Email is not valid.";
            $this->alert("Email is not valid.");
            return false;
        }
        if (!$this->findUser()) {
//            $_SESSION["message"] = "This email is not correct.";
            $this->alert("This email is not correct.");
            return false;
        }
        if (!$this->checkPassword()) {
//            $_SESSION["message"] = "This password is not correct.";
            $this->alert("This password is not correct.");
            return false;
        }
        return true;
    }

    private function findUser(): bool
    {
        foreach ($this->users as $email => $user){
            if ($email == $this->params['email']){
                $this->userName = $user['name'];
                $this->userPassword = $user['password'];
                return true;
            }
        }
        return false;
    }

    private function checkPassword(): bool
    {
        if ($this->userPassword === $this->params['password']){
            return true;
        }
        return false;
    }
}
