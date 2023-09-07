@php
    // echo "<pre>";
    // print_r($dados); die;
@endphp


@extends('app')
@section('title', 'Enagro Admin')
@section('menuAtivo', 'usuarios')


@section('content')
    <h1>Usuários</h1>
    <div class="d-flex justify-content-start">
        <a class="botao-default" href="{{ route('user.create') }}"><i class='bx bx-add-to-queue'></i> Adicionar</a>
    </div>
    <table class="table table-striped">
        <thead>
            <tr class="header-table-default">
                <th class="header-table-col-default" scope="col">ID</th>
                <th class="header-table-col-default" scope="col">Nome</th>
                <th class="header-table-col-default" scope="col">Email</th>
                <th class="header-table-col-default" scope="col">Senha </th>
                <th class="header-table-col-default" scope="col">Data Criado</th>
                <th class="header-table-col-default" scope="col">Data Atualizado</th>
                <th class="header-table-col-default" scope="col">Tipo de Usuário</th>
                <th class="header-table-col-default"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dados as $val)
                <tr>
                    <th scope="row">{{ $val->id }}</th>
                    <th scope="row">{{ $val->name }}</th>
                    <th scope="row">{{ $val->email }}</th>
                    <th scope="row">***********</th>
                    <th scope="row">{{ $val->created_at }}</th>
                    <th scope="row">{{ $val->updated_at }}</th>
                    <th scope="row">{{ $val->user_type }}</th>
                    <th scope="row">
                        <div class="btn-group" role="group" aria-label="Botões">
                            {{-- <a class="botao-default" href="{{ route('cows.edit', $cow->id) }}"><i --}}
                            {{-- class='bx bx-show-alt'></i></a> --}}
                            {{-- <form action="{{ route('cows.destroy', $cow) }}" method="POST"> --}}
                            @method('DELETE')
                            @csrf
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
