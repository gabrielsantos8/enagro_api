@extends('app')
@section('title', 'Cadastro de Veterinários')
@section('menuAtivo', 'veterinarios')
@section('error', isset($error) ? $error : '')
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
                    <label for="number" class="form-label"><b>Email:</b></label>
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
                <div class="col-2">
                    <label for="ddd" class="form-label"><b>DDD:</b></label>
                    <input type="number" required name="ddd" max="99" id="ddd" class="form-control" placeholder="00">
                </div>
                <div class="col-2">
                    <label for="number" class="form-label"><b>Número Telefone:</b></label>
                    <input type="number" required name="number" max="999999999" id="number" class="form-control" placeholder="000000000">
                </div>
                <div class="col-8">
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
                    <input type="file" class="form-control" name="foto_perfil" accept="image/*" required/>
                </div>
            </div>
        </div>
        <button class="botao-default w-100" type="submit">Cadastrar</button>
    </form>

@endsection
