@extends('app')
@section('title', 'Veterinários')
@section('menuAtivo', 'veterinarios')
@section('error', isset($error) ? $error : '')


@section('content')
    <h1>Veterinários</h1>
    <div class="d-flex justify-content-start">
        <a class="botao-default" href="{{ route('veterinarian.create') }}"><i class='bx bx-add-to-queue'></i> Adicionar</a>
    </div>
    <table class="table table-striped">
        <thead>
            <tr class="header-table-default">
                <th class="header-table-col-default" scope="col">ID</th>
                <th class="header-table-col-default" scope="col">Nome</th>
                <th class="header-table-col-default" scope="col">Nome Social</th>
                <th class="header-table-col-default" scope="col">Usuário</th>
                <th class="header-table-col-default" scope="col">R.CRMV</th>
                <th class="header-table-col-default" scope="col">CRMV</th>
                <th class="header-table-col-default" scope="col">UF</th>
                <th class="header-table-col-default" scope="col">Atuante</th>
                <th class="header-table-col-default" scope="col">Data Cadastro</th>
                <th class="header-table-col-default" scope="col">Data Alteração</th>
                <th class="header-table-col-default"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dados as $val)
                <tr>
                    <th scope="row">{{ $val->id }}</th>
                    <th scope="row">{{ $val->nome }}</th>
                    <th scope="row">{{ $val->nome_social }}</th>
                    <th scope="row">{{ $val->user_id . ' - ' . $val->user }}</th>
                    <th scope="row">{{ $val->id_pf_inscricao }}</th>
                    <th scope="row">{{ $val->pf_inscricao }}</th>
                    <th scope="row">{{ $val->pf_uf }}</th>
                    <th scope="row">{{ $val->atuante == 1 ? 'Sim' : 'Não' }}</th>
                    <th scope="row">{{ $val->created_at }}</th>
                    <th scope="row">{{ $val->updated_at }}</th>
                    <th scope="row">
                        <div class="btn-group" role="group" aria-label="Botões">
                            <a class="botao-default" href="{{ route('veterinarian.edit', $val->id) }}"><i
                                    class='bx bx-show-alt'></i></a>
                            <form action="{{ route('veterinarian.destroy') }}" method="POST">
                                @method('POST')
                                @csrf
                                <input type="number" name="id" value="{{ $val->id }}" hidden>
                                <button class="botao-risco-default" type="submit"
                                    onclick="return confirm('Tem certeza que deseja apagar?')">
                                    <i class='bx bx-trash'></i>
                                </button>
                            </form>
                        </div>
                    </th>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
