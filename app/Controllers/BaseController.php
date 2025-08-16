<?php

namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;

class BaseController
{
    protected Request $request;
    protected Response $response;

    public function __construct(
        Request $request,
        Response $response
    ) {
        $this->request = $request;
        $this->response = $response;
    }
}