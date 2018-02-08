<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use App\Resources\ResponseResource;
use Illuminate\Support\Facades\Validator; 

class BeersController extends Controller
{

    public function __construct(){
        $this->client = new Client();
        $this->response = new ResponseResource();
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function index(){
 
        try{
            
            $res = $this->client->request('GET', 'https://api.punkapi.com/v2/beers');
            return $this->response->ResponseStatusSuccess(json_decode($res->getBody(), true));

        }catch(ClientException $e){
            return $this->ReturnFailsRequest($e);
        }
        
    }

    public function paginate(Request $request ,$page, $totalPage){
        $request['page'] = $page;
        $request['totalPage'] = $totalPage;

        $this->validate($request, [
            'page' => ['required','numeric'] 
        ]);
       
        $totalPage = $totalPage || 20;
         
        try{
            
            $res = $this->client->request('GET', 'https://api.punkapi.com/v2/beers?page='.$page.'&per_page='.$totalPage);
            return $this->response->ResponseStatusSuccess(json_decode($res->getBody(), true));

        }catch(ClientException $e){
            return $this->ReturnFailsRequest($e);
        }
    }

    public function filter(Request $request , $tag, $filter){
        $request['tag'] = $tag;
        $request['filter'] = $filter;

        $this->validate($request, [
            'tag' => ['required'],
            'filter' => ['required']
        ]);
        
       

        try{
            
            $res = $this->client->request('GET', 'https://api.punkapi.com/v2/beers?'.$tag.'='.$filter);
            return $this->response->ResponseStatusSuccess(json_decode($res->getBody(), true));

        }catch(ClientException $e){
            return $this->ReturnFailsRequest($e);
        }
        
        
        
    }
    
    private function ReturnFailsRequest(ClientException $e){
        $res = $e->getResponse();
        $statusCode = $res->getStatusCode();
        if($statusCode == '404'){
            return $this->response->notFoundResponse();
        }else{
            throw $e;                
        }
    }
}
