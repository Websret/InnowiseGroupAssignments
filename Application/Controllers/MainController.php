<?php

namespace Application\Controllers;

use Application\Core\Controller;
use Application\Lib\Auth;
use Application\Lib\FileSystem;

class MainController extends Controller
{
    public function indexAction(): void
    {
        if (!Auth::isAuth()) {
            $this->view->redirect('/user/login');
        }
        $file = FileSystem::getFiles();
        $vars = [
            'fileArray' => $file,
        ];
//        unset($_SESSION['data']);
        $this->view->render($vars);
    }

    public function uploadAction(): void
    {
        $data = FileSystem::uploadFile();
        $vars = [
            'dataArray' => $data,
        ];
        $this->view->render($vars);
    }
}
