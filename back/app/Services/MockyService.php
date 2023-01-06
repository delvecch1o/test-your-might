<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client as HttpClient;
use Illuminate\Support\Facades\Auth;


class MockyService
{
    public function authorizeTransaction()
    {

        $httpCliente = new HttpClient(['verify' => false]);
        $authorizeTransaction = json_decode($httpCliente
            ->get("https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6")
            ->getBody()
            ->getContents());
        
        return $authorizeTransaction;

    }

    public function notifyUser()
    {

        $httpCliente = new HttpClient(['verify' => false]);
        $notify = json_decode($httpCliente
            ->get("http://o4d9z.mocklab.io/notify")
            ->getBody()
            ->getContents());
        
        return $notify;

    }
}
