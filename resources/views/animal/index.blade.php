@extends('app')
@section('title', 'Animal')
@section('menuAtivo', 'animal')
@section('error', isset($error) ? $error : '')


@section('content')
    <h1>Animais</h1>
    <div class="d-flex justify-content-start">
        <a class="botao-default" href="{{ route('animal.create') }}"><i class='bx bx-add-to-queue'></i> Adicionar</a>
    </div>
    <table class="table table-striped">
        <thead>
            <tr class="header-table-default">
                <th class="header-table-col-default" scope="col">ID</th>
                <th class="header-table-col-default" scope="col">Nome</th>
                <th class="header-table-col-default" scope="col">Descrição</th>
                <th class="header-table-col-default" scope="col">Quantidade</th>
                <th class="header-table-col-default" scope="col">Peso</th>
                <th class="header-table-col-default" scope="col">Tipo de Animal</th>
                <th class="header-table-col-default" scope="col">Endereço do Cliente</th>
                <th class="header-table-col-default" scope="col">Data Criado</th>
                <th class="header-table-col-default" scope="col">Data Atualizado</th>
                <th class="header-table-col-default" scope="col">Data Nascimento</th>
                <th class="header-table-col-default" scope="col">Situação</th>
                <th class="header-table-col-default"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $val)
                <tr>
                    <th scope="row">{{ $val->id }}</th>
                    <th scope="row">{{ $val->name }}</th>
                    <th scope="row">{{ $val->description }}</th>
                    <th scope="row">{{ $val->amount }}</th>
                    <th scope="row">{{ $val->weight }}</th>
                    <th scope="row">{{ $val->animal_type }}</th>
                    <th scope="row">{{ $val->user_address_id }}</th>
                    <th scope="row">{{ $val->created_at }}</th>
                    <th scope="row">{{ $val->updated_at }}</th>
                    <th scope="row">{{ $val->birth_date }}</th>
                    {{-- <th scope="row">{{ $val->situation }}</th> --}}
                    <th scope="row">
                        <div class="btn-group" role="group" aria-label="Botões">
                            <a class="botao-default" href="{{ route('animal.edit', $val->id) }}"><i
                                    class='bx bx-show-alt'></i></a>
                            <form id="form-excluir{{ $val->id }}" action="{{ route('animal.destroy') }}" method="POST">
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
