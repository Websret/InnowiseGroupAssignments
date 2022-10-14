<?php

namespace Application\Controllers;

use Application\Core\Controller;

class UserController extends Controller
{
    /**
     * Render form
     *
     * @return void
     */
    public function createAction(): void
    {
        $this->view->render('Add page');
    }

    /**
     * POST
     *
     * @return void
     */
    public function addAction(): void
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
    public function updateAction(): void
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
    public function editAction(): void
    {
        if (!$this->validatePostData()) {
            $this->view->redirect('/user/update/' . $_POST["id"]);
        }

        $params = [
            'id' => $_POST["id"],
            'email' => $_POST["email"],
            'name' => $_POST["name"],
            'gender' => $_POST["gender"],
            'status' => $_POST["status"],
        ];
        $this->model->updateUser($params);

        $this->view->redirect('/');
    }

    public function deleteAction(): void
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
        if (!filter_var($params["email"], FILTER_VALIDATE_EMAIL)) {
            $_SESSION["message"] = "Email is not valid.";
            return false;
        }
        if (strlen($params["name"]) < 3 or !preg_match("/^([a-zA-Z' ]+)$/", $params["name"])) {
            $_SESSION["message"] = "Only alphabets and whitespace are allowed.";
            return false;
        }
        return true;
    }
}
