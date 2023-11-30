<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *     title="Product Price Tracking API",
 *     version="1.0.0",
 *     description="Product Price Tracking API"
 * )
 * @OA\SecurityScheme(
 *     type="http",
 *     in="header",
 *     securityScheme="bearer",
 *     scheme="bearer"
 * )
 */

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests, ApiResponse;
}
