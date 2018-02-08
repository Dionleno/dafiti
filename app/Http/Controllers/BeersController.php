<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use App\Resources\ResponseResource;
use Illuminate\Support\Facades\Validator; 

class BeersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function teste(){

        $client = new Client();
        $response = new ResponseResource();

        try{
            
            $res = $client->request('GET', 'https://api.punkapi.com/v2/beers');
            return $response->ResponseStatusSuccess(json_decode($res->getBody(), true));

        }catch(ClientException $e){

            $res = $e->getResponse();
            $statusCode = $res->getStatusCode();
            if($statusCode == '404'){
                return $response->notFoundResponse();
            }else{
                throw $e;                
            }
        }
        
    }

    public function paginate($page, $totalPage){
        $itens = [
            'page'=> $page,
            'totalPage'=> $totalPage
        ];

        $client = new Client();
        $response = new ResponseResource();

        try{
            
            $res = $client->request('GET', 'https://api.punkapi.com/v2/beers?page='.$page.'&per_page='.$totalPage);
            return $response->ResponseStatusSuccess(json_decode($res->getBody(), true));

        }catch(ClientException $e){

            $res = $e->getResponse();
            $statusCode = $res->getStatusCode();
            if($statusCode == '404'){
                return $response->notFoundResponse();
            }else{
                throw $e;                
            }
        }
    }

    public function filter($tag, $filter){

      

        $client = new Client();
        $response = new ResponseResource();

        try{
            
            $res = $client->request('GET', 'https://api.punkapi.com/v2/beers?'.$tag.'='.$filter);
            return $response->ResponseStatusSuccess(json_decode($res->getBody(), true));

        }catch(ClientException $e){

            $res = $e->getResponse();
            $statusCode = $res->getStatusCode();
            if($statusCode == '404'){
                return $response->notFoundResponse();
            }else{
                throw $e;                
            }
        }
        
        
        
    }


    private function validateTags($tags){

    }
    
}
