@extends('app')

@section('titulo', 'Editar Diarista')

@section('conteudo')
<h1>Editar Diarista</h1>
    <!-- Form Area -->
    <form action="{{ route('diaristas.update', $diarista ) }}" method="POST" enctype="multipart/form-data">
    
        @method('PUT')
        <!-- 
            Aqui precisa popular o formulário quando já houver dados da diarista
            para trazer na view EDIT todos os dados já preenchidos
         -->

        @include('_form') 
         <!-- Button Here -->
    <button type="submit" class="btn btn-primary">Atualizar</button>
    </form>  
@endsection


<!-- 
    quando o usuario clicar em Atualizar temos que chamar uma nova ação que vai salvar os dados alterados no banco de dados
 -->




