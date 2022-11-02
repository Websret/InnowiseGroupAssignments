<?php

namespace Application\Controllers;

use Application\Core\Controller;
use Application\Lib\Auth;
use Application\Lib\Validator;
use Application\Models\User;

class UserController extends Controller
{
    /**
     * Render form
     * @return void
     */
    public function registrationAction(): void
    {
        $this->view->render();
    }

    public function registryAction(): void
    {
        $validator = new Validator([
            'formFirstName' => 'onlyString|min:2|required',
            'formLastName' => 'onlyString|min:2|required',
            'formConfirmEmail' => 'required',
            'formConfirmPassword' => 'required',
            'formEmail' => 'isEmail|min:4|isEqualTo:' . $_POST["formConfirmEmail"] . '|emailExist:' . User::class . ',email|required',
            'formPassword' => 'upperCase:1|lowerCase:1|checkDigit:1|specialCharacter:1|min:6|isEqualTo:' . $_POST["formConfirmPassword"] . '|required',
        ]);

        if (!$validator->validate()) {
            $this->view->redirect('/user/registration');
        }

        $params = [
            'email' => $_POST["formEmail"],
            'firstName' => $_POST["formFirstName"],
            'lastName' => $_POST["formLastName"],
            'password' => password_hash($_POST["formPassword"], PASSWORD_DEFAULT),
            'data' => date('Y-m-d H:i:s'),
        ];
        $this->model->addUser($params);
        Auth::loginUser($params);
        $this->redirect();
    }

    /**
     * Render form
     * @return void
     */
    public function loginAction(): void
    {
        $this->view->render();
    }

    public function authorizationAction(): void
    {
        $validator = new Validator([
            'formEmail' => 'isEmail|min:4|findUserEmail:' . User::class . ',email|required',
            'formPassword' => 'min:6|required',
        ]);

        if (!$validator->validate()) {
            $this->view->redirect('/user/login');
        }

        $params = [
            'email' => $_POST['formEmail'],
            'password' => $_POST['formPassword'],
            'remember' => isset($_POST['remember']),
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
        $this->view->redirect('/user/login');
    }
}
