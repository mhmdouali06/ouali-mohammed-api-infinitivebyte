<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
/**
 * @OA\Info(
 *     title="Laravel API",
 *     version="1.0.0",
 *     @OA\Contact(
 *         email="mhmdouali@gmail.com"
 *     ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="https://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 *   @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     description="Enter 'Bearer' [space] and then your token in the text input below.
 *                   Example: 'Bearer eyJhbGciOiJIU...'"
 * )

 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
