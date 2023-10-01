@extends('app')
@section('title', 'Editar de usuários')
@section('menuAtivo', 'usuarios')
@section('error', isset($error) ? $error : '')
@section('content')

    <h1>Usuário - Manutenção</h1>


    <form action="{{ route('user.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <div class="row">
                <div class="col-4">
                    <label for="name" class="form-label"><b>Nome:</b></label>
                    <input type="text" required name="name" id="name" value={{ $data->name }}
                        class="form-control">
                </div>
                <div class="col-4">
                    <label for="number" class="form-label"><b>Email:</b></label>
                    <input type="email" required name="email" id="email" value={{ $data->email }}
                        class="form-control">
                </div>
                <div class="col-4">
                    <label for="password" class="form-label"><b>Senha:</b></label>
                    <input type="password" required name="password" id="password" value="00000000" class="form-control">
                </div>
            </div>
        </div>

        <div class="mb-3">
            <div class="row">
                <div class="col-2">
                    <label for="ddd" class="form-label"><b>DDD:</b></label>
                    <input type="number" hidden name="id" id="id" value={{ $data->id }}
                        class="form-control">
                    <input type="number" hidden name="user_phone_id" id="user_phone_id" value={{ $data->user_phone_id }}
                        class="form-control">
                    <input type="number" required name="ddd" max="99" id="ddd" value={{ $data->ddd }}
                        class="form-control" placeholder="00">
                </div>
                <div class="col-2">
                    <label for="number" class="form-label"><b>Número Telefone:</b></label>
                    <input type="number" required name="number" id="number" value={{ $data->number }}
                        class="form-control" placeholder="000000000">
                </div>
                <div class="col-4">
                    <label for="user_type_id" class="form-label"><b>Tipo:</b></label>
                    <select name="user_type_id" required value={{ $data->user_type_id }} class="form-control"
                        id="user_type_id">
                        @foreach ($user_types as $type)
                            <option value="{{ $type->id }}" @if ($type->id == $data->user_type_id) selected @endif>
                                {{ $type->id . ' - ' . $type->description }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-4">
                    <label for="situation_id" class="form-label"><b>Situação:</b></label>
                    <select name="situation_id" required class="form-control" id="situation_id">
                        @foreach ($situations as $situation)
                            <option @if ($data->situation_id == $situation->id) selected @endif value="{{ $situation->id }}">
                                {{ $situation->id . ' - ' . $situation->description }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <div class="row">
                <div class="col-12">
                    <label for="foto_perfil" class="form-label"><b>Imagem:</b></label>
                    <input type="file" class="form-control" name="foto_perfil" accept="image/*" />
                </div>
            </div>
        </div>
        <div class="img-selected">
            <img src="{{ $data->image_url }}" alt="imagem">
        </div>


        <button class="botao-default w-100" type="submit">Salvar</button>
    </form>

@endsection
