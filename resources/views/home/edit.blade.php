@extends('app')
@section('title', 'Cadastro de Vacas')
@section('manClass', 'active')
@section('relClass', '')
@section('content')

    <h1>Vacas - Manutenção</h1>


    <form action="{{ route('cows.update', $cow) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="nome" class="form-label"><b>Nome</b></label>
            <input type="text" required name="nome" id="nome" value={{$cow->nome}} class="form-control">
        </div>
        <div class="mb-3">
            <div class="row">
                <div class="col-4">
                    <label for="nascimento" class="form-label"><b>Data Nascimento:</b></label>
                    <input type="date" required name="nascimento" id="nascimento" value={{$cow->nascimento}} class="form-control">
                </div>
                <div class="col-4">
                    <label for="dataprimeiracria" class="form-label"><b>Data Primeira Cria:</b></label>
                    <input type="date" required name="dataprimeiracria" id="dataprimeiracria" value={{$cow->dataprimeiracria}} class="form-control">
                </div>
                <div class="col-4">
                    <label for="ultimacria" class="form-label"><b>Data Última Cria:</b></label>
                    <input type="date" required name="ultimacria" id="ultimacria" value={{$cow->ultimacria}} class="form-control">
                </div>
            </div>
        </div>
        <div class="mb-3">
            <div class="row">
                <div class="col-6">
                    <label for="litrosleite" class="form-label"><b>Litros de Leite:</b></label>
                    <input type="number" required name="litrosleite" id="litrosleite" value={{$cow->litrosleite}} class="form-control">
                </div>
                <div class="col-6">
                    <label for="cow_situation_id" class="form-label"><b>Situação:</b></label>
                    <select name="cow_situation_id" required class="form-control" id="cow_situation_id">
                        @foreach ($situacoes as $situacao)
                        <option {{$situacao->id == $cow->cow_situation_id ? 'selected' : ''}} value="{{$situacao->id}}">{{$situacao->descricao}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <button class="botao-default w-100" type="submit">Salvar</button>
    </form>

@endsection
