<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

abstract class Controller
{
    protected function render_success($data = [], $message = 'Success', $status = Response::HTTP_OK)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], $status);
    }

    protected function render_error($data = [], $message = 'Error', $status = Response::HTTP_UNPROCESSABLE_ENTITY)
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ], $status);
    }
}
