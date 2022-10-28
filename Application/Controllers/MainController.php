<?php

namespace Application\Controllers;

use Application\Core\Controller;
use Application\Lib\Validator;
use Application\Models\Main;

class MainController extends Controller
{
    public function indexAction(): void
    {
        $this->view->render();
    }

    public function registrationAction(): void
    {
        $validator = new Validator([
            'formFirstName' => 'onlyString|min:2|required',
            'formLastName' => 'onlyString|min:2|required',
            'formConfirmEmail' => 'required',
            'formConfirmPassword' => 'required',
            'formEmail' => 'isEmail|min:4|isEqualTo:' . $_POST["formConfirmEmail"] . '|emailExist:' . Main::class . ',email|required',
            'formPassword' => 'upperCase:1|lowerCase:1|checkDigit:1|specialCharacter:1|min:6|isEqualTo:' . $_POST["formConfirmPassword"] . '|required',
        ]);

        if (!$validator->validate()) {
            $this->view->redirect('/');
        }

        $params = [
            'email' => $_POST["formEmail"],
            'firstName' => $_POST["formFirstName"],
            'lastName' => $_POST["formLastName"],
            'password' => password_hash($_POST["formPassword"], PASSWORD_DEFAULT),
            'data' => date('Y-m-d H:i:s'),
        ];
        $this->model->addUser($params);
    }
}
