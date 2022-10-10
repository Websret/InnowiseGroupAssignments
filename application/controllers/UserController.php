<?php

namespace application\controllers;

use application\core\Controller;
use PDO;

class UserController extends Controller
{
    /**
     * Render form
     *
     * @return void
     */
    public function createAction()
    {
        $this->view->render('Add page');
    }

    /**
     * POST
     *
     * @return void
     */
    public function addAction()
    {
        if (!$this->validatePostData()) {
            $this->view->redirect('/user/create');
        }

        $params = [
            'email' => $_POST["email"],
            'name' => $_POST["name"],
            'gender' => $_POST["gender"],
            'status' => $_POST["status"],
        ];
        $this->model->addUser($params);

        $this->view->redirect('/');
    }

    /**
     * Render form
     *
     * @return void
     */
    public function updateAction()
    {
        $queryParams = $this->getQueryParams();
        $result = $this->model->getUserParam($queryParams);
        $vars = [
            'user' => $result,
        ];

        $this->view->render('Update page', $vars);
    }

    /**
     * POST
     *
     * @return void
     */
    public function editAction()
    {
        if (!$this->validatePostData()) {
            $this->view->redirect('/user/update');
        }

        $params = [
            'email' => $_POST["email"],
            'name' => $_POST["name"],
            'gender' => $_POST["gender"],
            'status' => $_POST["status"],
            'emailOld' => $_POST["emailOld"],
        ];
        $this->model->updateUser($params);

        $this->view->redirect('/');
    }

    public function deleteAction()
    {
        $queryParams = $this->getQueryParams();
        $this->model->deleteUser($queryParams);
        $this->view->redirect('/');
    }

    private function validatePostData(): bool
    {
        $params = [
            'email' => $_POST["email"],
            'name' => $_POST["name"],
            'gender' => $_POST["gender"],
            'status' => $_POST["status"],
        ];
        $row = $this->model->getUserEmail(['email' => $_POST["email"]]);
        $members = $row['count'];
        if (!filter_var($params["email"], FILTER_VALIDATE_EMAIL)) {
            $_SESSION["message"] = "Email is not valid.";
            return false;
        }
        if ($members > 0) {
            $_SESSION["message"] = "This email is already in use";
            return false;
        }
        if (strlen($params["name"]) < 3 and !preg_match("/^[a-zA-z]*$/", $params["name"])) {
            $_SESSION["message"] = "Only alphabets and whitespace are allowed.";
            return false;
        }
        return true;
    }
}
