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
    public function ResponseStatusSuccess($data,$status)
    {
        $response = [
            'code' => $status,
            'status' => $status == 200 ? 'succcess' : 'Erro codigo: '.$status,
            'data' => $data
        ];

        return response()->json($response, $response['code']);
    }

    public function ResponseStatusError($data,$status)
    {
        $response = [
            'code' => $status,
            'status' => 'Erro codigo: '.$status,
            'data' => $data
        ];

        return response()->json($response, $response['code']);
    }
}
