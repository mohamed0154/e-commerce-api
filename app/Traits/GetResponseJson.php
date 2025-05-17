<?php

namespace App\Traits;

trait GetResponseJson
{
    public function setData( $data, $message = '', $status = 200)
    {
        return response()->json([
            'message' => $message,
            'data' => $data
        ], $status);
    }

    public function setSuccessMessage($message, $data = [], $status = 200)
    {
        return response()->json([
            'message' => $message,
            'data' => $data
        ], $status);
    }

    public function setErrorMessage($message, $data = [], $status = 200)
    {
        return response()->json([
            'message' => $message,
            'errors' => $data
        ], $status);
    }
}
