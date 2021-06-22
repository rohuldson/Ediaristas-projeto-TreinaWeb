<?php

namespace App\Http\Controllers;

use App\Http\Requests\DiaristaRequest;
use App\Models\Diarista;
use App\Services\ViaCEP;
use Illuminate\Http\Request;


class DiaristaController extends Controller
{
    /* 
    Para PHP até 7.4 fazer assim:    

     protected viaCEP $viaCep;

     public function __construct(
         viaCEP $viaCep
          ) {
              $this->viaCep = $viaCep;        
    }    
    */

    // promoção de propriedade no costrutor, apartir do PHP 8
    public function __construct(
        protected viaCEP $viaCep
    ) {
        
    }

    /**
     * Lista as diaristas
     * 
     * @return void
     */
    
    public function index()
    {
        $diaristas = Diarista::get();

        return view('index', [
            'diaristas' => $diaristas
        ]);       
    }


    /**
     * Mostra o formulário de criação
     * 
     * @return void
     */

    public function create()
    {
        return view('create');
    }

    /**
     * Cria uma diarista no banco de dados
     * 
     * @return void
     */

    public function store(DiaristaRequest $request)
    {
        # code...
        $dados = $request->except('_token');
        $dados['foto_usuario'] = $request->foto_usuario->store('public');

        $dados['cpf'] = str_replace(['.', '-'], '', $dados['cpf']);
        $dados['cep'] = str_replace('-', '', $dados['cep']);
        $dados['telefone'] = str_replace(['(', ')' , ' ' , '-'], '', $dados['telefone']);
        $dados['codigo_ibge'] = $this->viaCep->buscar($dados['cep'])['ibge'];

        Diarista::create($dados);

        return redirect()->route('diaristas.index');
    }

    /**
     * Mostra o formulário de edição populado
     * 
     * @return void
     */

    public function edit(int $id)
    {
        /* o que precisa ser feito aqui?
        -buscar a diarista
        -depois retornar a view pra montar o formulario    
        */
        
        $diarista = Diarista::findOrFail($id); // buscar a diatista no DB - se não achar retorna 404 error 

        return view('edit', [
            'diarista' => $diarista
        ]);
    }

    /**
     * Atualiza uma diarista no banco de dados
     * 
     * @return void
     */

    public function update(int $id, DiaristaRequest $request)
    {
        # code...
        $diarista = Diarista::findOrFail($id); // buscar a diatista no DB - se não achar retorna 404 error 

        $dados = $request->except('_token', '_method');

        $dados['cpf'] = str_replace(['.', '-'], '', $dados['cpf']);
        $dados['cep'] = str_replace('-', '', $dados['cep']);
        $dados['telefone'] = str_replace(['(', ')' , ' ' , '-'], '', $dados['telefone']);
        $dados['codigo_ibge'] = $this->viaCep->buscar($dados['cep'])['ibge'];

        if($request->hasFile('foto_usuario')) {
            /* 
                se houver um arquivo novo de foto atualize, em ($dados) 
                se não houver nenhum arquivo novo deixa como está.
            */
            $dados['foto_usuario'] = $request->foto_usuario->store('public');
        }

        $diarista->update($dados);
        
        return redirect()->route('diaristas.index');

         
    }


    /**
     * Apaga uma diarista no banco de dados.
     * @return void
     */

    public function destroy(int $id)
    {
        $diarista = Diarista::findOrFail($id); // buscar a diatista no DB - se não achar retorna 404 error 

        $diarista->delete();

        return redirect()->route('diaristas.index');

       
    }
}
