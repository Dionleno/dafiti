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
     * @__construct
     *  Instanciar bibliotecas GuzzleHttp e ResponseResource 
     *  que retorna o status do Request
     */
    public function __construct(){
        $this->client = new Client();
        $this->response = new ResponseResource();
    }

    /**
     * @index 
     * Listar todas as cervejas 
     * @return void
     */
    public function index(){
 
        try{
            
            $res = $this->client->request('GET', 'https://api.punkapi.com/v2/beers');
            return $this->response->ResponseStatusSuccess(json_decode($res->getBody(), true),$res->getStatusCode());

        }catch(ClientException $e){
            return $this->ReturnFailsRequest($e);
        }
        
    }

    /**
     * @paginate
     * @page -> a pagina a ser buscada
     * @TotalPage -> Numero de itens por pagina
     */
    public function paginate(Request $request ,$page, $totalPage){
        $request['page'] = $page;
        $request['totalPage'] = $totalPage;

        $this->validate($request, [
            'page' => ['required','numeric'] 
        ]);
       
        $totalPage = $totalPage || 20;
         
        try{
            
            $res = $this->client->request('GET', 'https://api.punkapi.com/v2/beers?page='.$page.'&per_page='.$totalPage);
            return $this->response->ResponseStatusSuccess(json_decode($res->getBody(), true),$res->getStatusCode());

        }catch(ClientException $e){
            return $this->ReturnFailsRequest($e);
        }
    }

    /**
     * @filter
     * @tag -> tipo de filtro a ser aplicado (abv_gt, abv_lt, ibu_gt, ibu_lt, ebc_gt, ebc_lt, beer_name)
     * @filter -> o valor do filtro
     */
    public function filter(Request $request){
         
       
        try{

            //remover parametros null e vazio
            $filter = array_filter($request->input());
            
            $res = $this->client->request('GET', 'https://api.punkapi.com/v2/beers?'.http_build_query($filter));
            return $this->response->ResponseStatusSuccess(json_decode($res->getBody(), true),$res->getStatusCode());

        }catch(ClientException $e){
            return $this->ReturnFailsRequest($e);
        }
        
        
        
    }
    
    /**
     * @ReturnFailsRequest
     * @e -> ClientException 
     * Essa função trata os erros que será retornado da requição
     */
    private function ReturnFailsRequest(ClientException $e){
        $res = $e->getResponse();
        $statusCode = $res->getStatusCode();
        if($statusCode == '404'){
            return $this->response->notFoundResponse();
        }else if($statusCode != ''){
            return $this->response->ResponseStatusError($res,$statusCode);
        }else{
            throw $e;                
        }
    }



}
