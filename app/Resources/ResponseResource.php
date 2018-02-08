<?php

namespace App\Resources;

class ResponseResource
{
    public function notFoundResponse()
    {
        $response = [
            'code' => 404,
            'status' => 'error',
            'data' => 'Resource Not Found',
            'message' => 'Not Found'
        ];
        
        return response()->json($response, $response['code']);
    }
    public function ResponseStatusSuccess($data)
    {
        $response = [
            'code' => 200,
            'status' => 'succcess',
            'data' => $data
        ];

        return response()->json($response, $response['code']);
    }
}
