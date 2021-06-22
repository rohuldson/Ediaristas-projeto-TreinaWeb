<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ViaCEP {
   public function buscar(string $cep)
   {
      /** 
       * Consulta CEP no via cep
       *  @param string $cep
      * @return boolean|array
      */
      
       $url =sprintf('https://viacep.com.br/ws/%s/json/', $cep);

       $resposta = Http::get($url);

       if($resposta->failed()){
           return false;
       }

       // pegar os dados e retornar

       $dados = $resposta->json(); // vai pegar o json do via cep e tranformar em array

   

       if (isset($dados['erro']) && $dados['erro'] === true) {
           return false;
       }

       return $dados;

      
   }
}