<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

//https://github.com/zircote/swagger-php/issues/473
//https://quickadminpanel.com/blog/laravel-api-documentation-with-openapiswagger/
//https://github.com/zircote/swagger-php/blob/master/Examples/swagger-spec/petstore-simple/SimplePetsController.php
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @OA\Info(
     *  title="Rest Api",
     *  version="1.0",
     *  @OA\Contact(
     *      name="Fúlvio Cezar Canducci Dias",
     *      email="fulviocanducci@hotmail.com"
     *  ),
     *  @OA\License(
     *      name="Apache 2.0",
     *      url="http://www.apache.org/licenses/LICENSE-2.0.html"
     *  )
     * )
     *
     *
     * @OA\Tag(
     *     name="Project Example ApiRest",
     *     description="ApiRest"
     * )
     *
     *
     * @OA\SecurityScheme(
     *     type="http",
     *     description="Login with email and password to get the authentication token",
     *     name="Token based Based",
     *     in="header",
     *     scheme="bearer",
     *     bearerFormat="JWT",
     *     securityScheme="apiAuth",
     * )
     */

    /**
     * @OA\Schema(
     *   schema="DestroyResource",
     *   @OA\Property(
     *     property="found",
     *     type="boolean"
     *   ),
     *   @OA\Property(
     *     property="deleted",
     *     type="boolean"
     *   )
     * )
     */
}
