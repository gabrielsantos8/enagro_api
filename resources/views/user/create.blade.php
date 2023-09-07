@extends('app')
@section('title', 'Cadastro de Usuários')
@section('menuAtivo', 'usuarios')
@section('content')

    <h1>Usuário - Manutenção</h1>



    <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <div class="row">
                <div class="col-4">
                    <label for="name" class="form-label"><b>Nome:</b></label>
                    <input type="text" required name="name" id="name" class="form-control">
                </div>
                <div class="col-4">
                    <label for="email" class="form-label"><b>Email:</b></label>
                    <input type="email" required name="email" id="email" class="form-control">
                </div>
                <div class="col-4">
                    <label for="password" class="form-label"><b>Senha:</b></label>
                    <input type="password" required name="password" id="password" class="form-control">
                </div>
            </div>
        </div>

        <div class="mb-3">
            <div class="row">
                <div class="col-12">
                    <label for="user_type_id" class="form-label"><b>Tipo:</b></label>
                    <select name="user_type_id" required class="form-control" id="user_type_id">
                        @foreach ($user_types as $type)
                            <option value="{{ $type->id }}">{{ $type->id . ' - ' . $type->description }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <div class="row">
                <div class="col-12">
                    <label for="foto_perfil" class="form-label"><b>Imagem:</b></label>
                    <input type="file" class="form-control" name="foto_perfil"/>
                </div>
            </div>
        </div>
        <button class="botao-default w-100" type="submit">Cadastrar</button>
    </form>

@endsection
