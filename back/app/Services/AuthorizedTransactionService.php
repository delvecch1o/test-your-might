<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client as HttpClient;
use Illuminate\Support\Facades\Auth;


class AuthorizedTransactionService
{
    const AUTHORIZED_MESSAGE = "Autorizado";
    const SUCCESSFULLY_MESSAGE = "Success";
    
    public function authorizeTransaction()
    {

        $httpCliente = new HttpClient(['verify' => false]);
        $authorize = json_decode($httpCliente
            ->get("https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6")
            ->getBody()
            ->getContents());
        
        return $authorize->message===self::AUTHORIZED_MESSAGE;

    }

    public function notifyUser()
    {

        $httpCliente = new HttpClient(['verify' => false]);
        $notify = json_decode($httpCliente
            ->get("http://o4d9z.mocklab.io/notify")
            ->getBody()
            ->getContents());
        
        return $notify->message===self::SUCCESSFULLY_MESSAGE;

    }
}
