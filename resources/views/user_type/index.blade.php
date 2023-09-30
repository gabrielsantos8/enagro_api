@extends('app')
@section('title', 'Tipos de usuário')
@section('menuAtivo', 'tipUsuarios')

@section('content')
    <h1>Tipos de Usuários</h1>

    <div class="d-flex justify-content-start">
        <a class="botao-default" href="{{ route('user_type.create') }}"><i class='bx bx-add-to-queue'></i> Adicionar</a>
    </div>

    <table class="table table-striped">
        <thead>
            <tr class="header-table-default">
                <th class="header-table-col-default" scope="col">ID</th>
                <th class="header-table-col-default" scope="col">Descrição</th>
                <th class=""></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $val)
                <tr>
                    <th scope="row">{{ $val->id }}</th>
                    <th scope="row">{{ $val->description }}</th>
                    <th scope="row">
                        <div class="btn-group" role="group" aria-label="Botões">
                            <a class="botao-default" href="{{ route('user_type.edit', $val->id) }}"><i
                                    class='bx bx-show-alt'></i></a>
                            <form id="form-excluir{{ $val->id }}" action="{{ route('user_type.destroy') }}"
                                method="POST">
                                @method('POST')
                                @csrf
                                <input type="number" name="id" value="{{ $val->id }}" hidden>
                                <button id="{{ $val->id }}" class="botao-risco-default" type="submit">
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
                                <button type="button" class="botao-default close" id="{{ $val->id }}"
                                    data-dismiss="modal" aria-label="Fechar">
                                    Fechar
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
