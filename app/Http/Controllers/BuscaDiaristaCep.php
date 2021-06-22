<?php

namespace App\Http\Controllers;

use App\Models\Diarista;
use App\Services\ViaCEP;
use Illuminate\Http\Request;

class BuscaDiaristaCep extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, ViaCEP $viaCEP)
    {
        
        // agora precisa pegar o cep  (entrada)
        // retornar o codigo IBGE (saida)
        // criar uma nova classe que se conecta ao viacep e obtenha os dados do cep e o IBGE
        $endereco = $viaCEP->buscar($request->cep);

        if ($endereco === false) {
            return response()->json(['erro'=>'Cep inválido'], 400);
        }
        

        // entrada codigo ibge
        // retornar lista de diaristas filtradas pelo codigo ( receber do DB)

        return [
           'diaristas' => Diarista::buscaPorCodigoIbge($endereco['ibge']),
           'quantidade_diaristas' => Diarista::quantidadePorCodigoIbge($endereco['ibge'])
        
        ];

       

       
    }
}
