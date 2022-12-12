<?php

namespace Application\Controllers;

use Application\Core\Controller;
use OpenApi\Generator;

class ApiDocumentController extends Controller
{

    /**
     * @OA\Get(
     *     path="/api-document",
     *     summary="Method displays document about available methods this application",
     *     tags={"Document"},
     *     @OA\Response(
     *         response="200",
     *         description="Success"
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Not found"
     *     ),
     * )
     */
    public function index()
    {
        $openapi = Generator::scan([$_SERVER['DOCUMENT_ROOT'] . '/Application/Controllers']);

        header('Content-Type: application/json');
        echo $openapi->toYaml();
    }
}