@extends('app')
@section('title', 'Enagro Admin')
@section('menuAtivo', 'tipUsuarios')

@section('content')

    <h1>Tipos de Usuários</h1>
    <table class="table table-striped">
        <thead>
            <tr class="header-table-default">
                <th class="header-table-col-default" scope="col">ID</th>
                <th class="header-table-col-default" scope="col">Descrição</th>
                <th class="header-table-col-default" scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dados as $val)
                <tr>
                    <th scope="row">{{ $val->id }}</th>
                    <th scope="row">{{ $val->description }}</th>
                    <th scope="row">
                        <a class="botao-default" href="{{ route('user_type.edit', $val->id) }}"><i
                                class='bx bx-show-alt'></i></a>
                        <form action="{{ route('user_type.destroy', $val->id) }}" method="POST">
                            <div class="btn-group" role="group" aria-label="Botões">
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
