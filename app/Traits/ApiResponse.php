<?php

namespace App\Traits;

trait ApiResponse
{
    public function responseApi($data, $message, $status, $statusCode = Response::HTTP_OK)
    {
        $response['data']        = $data;            
        $response['message']     = $message;    
        $response['status']      = $status;
        $response['status_code'] = $statusCode; 
        return $response;
    }
   
}