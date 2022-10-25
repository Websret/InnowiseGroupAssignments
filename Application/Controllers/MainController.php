<?php

namespace Application\Controllers;

use Application\Core\Controller;

class MainController extends Controller
{
    public function indexAction(): void
    {
        $data = $this->model->checkAuthorization();
        if ($data[0] != '/') {
            $this->view->redirect($data[0]);
        }
        $this->view->render($data[1]);
    }

    public function loginAction(array $data = []): void
    {
        $this->view->render($data);
    }

    public function authorizationAction(): void
    {
        $params = [
            'email' => $_POST['email'],
            'password' => $_POST['password'],
        ];
        $data = $this->model->checkUsers($params);
        if ($data[0] == '/') {
            $this->view->redirect($data[0]);
        }
        $this->view->path = '/main/login';
        $this->loginAction($data[1]);

    }

    public function logoutAction(): void
    {
        $url = $this->model->logoutAccount();
        $this->view->redirect($url);
    }
}
