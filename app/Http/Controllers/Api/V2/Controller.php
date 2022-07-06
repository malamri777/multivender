<?php

namespace App\Http\Controllers\Api\V2;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function successResponse($data) {
        return response()->json([
            'status' => true,
            'data' => $data
        ], 200);
    }

    public function errorResponse($msg, $status = 403)
    {
        return response()->json([
            'status' => false,
            'message' => $msg,
        ], $status);
    }
}
