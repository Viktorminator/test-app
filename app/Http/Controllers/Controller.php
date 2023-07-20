<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * @OA\Info(
     *     title="User-Company API",
     *     version="1.0.0",
     *     description="Test task for Yellow media by Viktor Matushevskyi",
     *     @OA\Contact(
     *         email="viktorminator@gmail.com"
     *     ),
     *     @OA\License(
     *         name="MIT License",
     *         url="https://opensource.org/licenses/MIT"
     *     )
     * )
     * @OA\SecurityScheme(
     *     type="http",
     *     scheme="bearer",
     *     bearerFormat="JWT",
     *     securityScheme="bearerAuth"
     * )
     */
}
