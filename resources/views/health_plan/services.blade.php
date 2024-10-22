@extends('app')
@section('title', 'Serviços do plano ' . (isset($data[0]) ? $data[0]->plan : ''))
@section('menuAtivo', 'plans')
@section('error', isset($error) ? $error : '')

@section('content')
    <h1>Serviços do plano {{ isset($data[0]) ? $data[0]->plan : '' }}</h1>
    <div class="d-flex justify-content-start">
        <a class="botao-default" href="{{ route('health_plan.service_create', $plan_id) }}"><i class='bx bx-add-to-queue'></i>
            Adicionar</a>
    </div>
    <table class="table table-striped">
        <thead>
            <tr class="header-table-default">
                <th class="header-table-col-default" scope="col">ID</th>
                <th class="header-table-col-default" scope="col">Descrição</th>
                <th class="header-table-col-default" scope="col">Sub-tipo Animal</th>
                <th class="header-table-col-default" scope="col">Valor</th>
                <th class="header-table-col-default" scope="col">Data Cadastro</th>
                <th class="header-table-col-default" scope="col">Data Alteração</th>
                <th class="header-table-col-default"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $val)
                <tr>
                    <th scope="row">{{ $val->id }}</th>
                    <th scope="row">{{ $val->service }}</th>
                    <th scope="row">{{ $val->animal_subtype }}</th>
                    <th scope="row">{{ $val->service_value }}</th>
                    <th scope="row">{{ $val->created_at }}</th>
                    <th scope="row">{{ $val->updated_at }}</th>
                    <th scope="row">
                        <div class="btn-group" role="group" aria-label="Botões">
                            <form id="form-excluir{{ $val->id }}" action="{{ route('health_plan.service_destroy') }}"
                                method="POST">
                                @method('POST')
                                @csrf
                                <input type="number" name="id" value="{{ $val->id }}" hidden>
                                <input type="number" name="health_plan_id" value="{{ $val->plan_id }}" hidden>
                                <button id="{{ $val->id }}" @if ($val->isNotDeletable) hidden @endif
                                    class="botao-risco-default" type="submit">
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
