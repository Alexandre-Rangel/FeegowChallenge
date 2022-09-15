<?php

namespace App\Helpers;


use Illuminate\Suport\Facades\Http;
use Illuminate\Support\Facades\Http as FacadesHttp;

class Api 
{
    private $api;
    private $token;
    private $url;
    private $route;


    public function __construct()
    {
        $this->token = config('api_feegow.api_token');
    }

    public function receiveDataApi()
    {
        $response = FacadesHttp::withHeaders([
            'x-access-token' => $this->token
            ])->get($this->url );

            $this->api = $response;

        return $response->body();
    }

    public function setRouteApi($tipo)
    {
        switch ($tipo) {
            case 'especialidade':
                $this->route = config('api_feegow.api_url_specialties');
                break;
            case 'especialista':
                $this->route = config('api_feegow.api_url_professional');
                break;
            case 'conheceu':
                $this->route = 'patient/list-sources';
                break;
         }

        if (!$this->route)
            return false;

        $this->url  = config('api_feegow.api_url').$this->route;
        
        return true;
    }

    public function getApi($tipo)
    {

        if (!empty($tipo))
        {
            $routeDefined = $this->setRouteApi($tipo);

            if ($routeDefined)
            {
                return  $this->receiveDataApi();
            }
                
        }

        return false;
    }
}

