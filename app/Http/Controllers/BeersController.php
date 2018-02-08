<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use App\Resources\ResponseResource;
use Illuminate\Support\Facades\Validator; 

class BeersController extends Controller
{
    protected $_url = "https://api.punkapi.com/v2/";

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
        return $this->requestApi('beers');
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
       
        return $this->requestApi('beers?page='.$page.'&per_page='.$totalPage);
    }
  
    /**
     * @filter
     * @tag -> tipo de filtro a ser aplicado (abv_gt, abv_lt, ibu_gt, ibu_lt, ebc_gt, ebc_lt, beer_name)
     * @filter -> o valor do filtro
     */
    public function filter(Request $request){
        $filter = array_filter($request->input());
        return $this->requestApi('beers?'.http_build_query($filter));
    }

    /**
     * @random
     * Retornar cervejas por ID
     */
    public function singlebeer(Request $request ,$id){
        $request['id'] = $id;
 
        $this->validate($request, [
            'id' => ['required','numeric'] 
        ]);
      
        return $this->requestApi('beers/'.$id);
    }
     /**
     * @random
     * Retornar cervejas aleatoria
     */
    public function random(){
        return $this->requestApi('beers/random');        
    }

     /**
     * @requestApi
     * Request Api
     */
    private function requestApi($url){
        try{
            $res = $this->client->request('GET',$this->_url.$url);
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
