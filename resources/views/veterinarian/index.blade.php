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
                <th class="header-table-col-default" scope="col">Situação</th>
                <th class="header-table-col-default" scope="col">Data Cadastro</th>
                <th class="header-table-col-default" scope="col">Data Alteração</th>
                <th class="header-table-col-default"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $val)
                <tr>
                    <th scope="row">{{ $val->id }}</th>
                    <th scope="row">{{ $val->nome }}</th>
                    <th scope="row">{{ $val->nome_social }}</th>
                    <th scope="row">{{ $val->user_id . ' - ' . $val->user }}</th>
                    <th scope="row">{{ $val->id_pf_inscricao }}</th>
                    <th scope="row">{{ $val->pf_inscricao }}</th>
                    <th scope="row">{{ $val->pf_uf }}</th>
                    <th scope="row">{{ $val->atuante == 1 ? 'Sim' : 'Não' }}</th>
                    <th scope="row">{{ $val->situation }}</th>
                    <th scope="row">{{ $val->created_at }}</th>
                    <th scope="row">{{ $val->updated_at }}</th>
                    <th scope="row">
                        <div class="btn-group" role="group" aria-label="Botões">
                            <a class="botao-default" href="{{ route('veterinarian.edit', $val->id) }}"><i
                                    class='bx bx-show-alt'></i></a>
                            <form id="form-excluir{{ $val->id }}" action="{{ route('veterinarian.destroy') }}"
                                method="POST">
                                @method('POST')
                                @csrf
                                <input type="number" name="id" value="{{ $val->id }}" hidden>
                                <button id="{{ $val->id }}" @if ($val->isNotDeletable) hidden @endif class="botao-risco-default" type="submit">
                                    <i class='bx bx-trash'></i> Excluir
                                </button>
                            </form>
                        </div>
                    </th>
                </tr>

                <div class="modal fade" id="modal-confirmacao{{ $val->id }}" role="dialog"
                    aria-labelledby="modal-confirmacao-titulo" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modal-confirmacao-titulo">Confirmar exclusão
                                </h5>
                                <button type="button" class="botao-default close bx bx-x" id="{{ $val->id }}"
                                    data-dismiss="modal" aria-label="Fechar" style="background: white; color: #000; font-size: 30px;">
                                </button>
                            </div>
                            <div class="modal-body">
                                Tem certeza que deseja excluir?
                            </div>
                            <div class="modal-footer">
                                <button type="submit" form="form-excluir{{ $val->id }}"
                                    class="btn btn-danger">Excluir</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </tbody>
    </table>
@endsection
