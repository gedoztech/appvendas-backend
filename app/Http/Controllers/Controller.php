<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * @OA\Info(
     *      version="1.0.0",
     *      title="API App Vendas",
     *      description="API App Vendas",
     *      @OA\Contact(
     *          email="this_is_just_a_test"
     *      )
     * )
     *
     * @OA\Server(
     *      url=SWAGGER_LUME_CONST_HOST,
     *      description="App Vendas"
     * )
     *
     *
     */
}
