<?php

namespace Application\Controllers;

use Application\Core\Controller;
use Application\Lib\FileSystem;

class MainController extends Controller
{
    public function indexAction(): void
    {
        $file = $this->model->getUploads();
        $vars = [
            'fileArray' => $file,
        ];
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
