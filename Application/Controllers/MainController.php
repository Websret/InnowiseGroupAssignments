<?php

namespace Application\Controllers;

use Application\Core\Controller;
use Application\Lib\Validator;

class MainController extends Controller
{
    public function indexAction(): void
    {
        $this->view->render();
    }

    public function registrationAction(): void
    {
        $row = $this->model->getUsersEmail(['email' => $_POST["formEmail"]]);
        $validator = new Validator([
            'formFirstName' => 'onlyString|length:2',
            'formLastName' => 'onlyString|length:2',
            'formEmail' => 'isEmail|length:4|isEqualTo:' . $_POST["formConfirmEmail"] . '|emailExist:' . $row['total'],
            'formPassword' => 'upperCase:1|lowerCase:1|checkDigit:1|specialCharacter:1|length:6|isEqualTo:' . $_POST["formConfirmPassword"],
        ]);
        if ($validator->validate()) {
            $params = [
                'email' => $_POST["formEmail"],
                'firstName' => $_POST["formFirstName"],
                'lastName' => $_POST["formLastName"],
                'password' => password_hash($_POST["formPassword"], PASSWORD_DEFAULT),
                'data' => date('Y-m-d H:i:s'),
            ];
            $this->model->addUser($params);
        }
        $this->view->redirect('/');
    }
}
