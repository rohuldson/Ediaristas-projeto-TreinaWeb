@extends('app')

@section('titulo', 'Cadastrar Diarista')

@section('conteudo')
<h1>Cadastrar Diarista</h1>

<!-- Form Area -->
<form action="{{ route('diaristas.store') }}" method="POST" enctype="multipart/form-data">
   

    @include('_form')
     <!-- Button Here -->
     <button type="submit" class="btn btn-primary">Salvar</button>

</form>     


@endsection





