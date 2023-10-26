@extends('app')
@section('title', 'Cadastro de Animais')
@section('menuAtivo', 'animal')
@section('error', isset($error) ? $error : '')
@section('content')

    <h1>Animais - Manutenção</h1>



    <form action="{{ route('animal.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <div class="row">
                <div class="col-4">
                    <label for="name" class="form-label"><b>Nome:</b></label>
                    <input type="text" required name="name" id="name" class="form-control">
                </div>
                <div class="col-4">
                    <label for="description" class="form-label"><b>Descrição</b></label>
                    <input type="text" required name="description" id="description" class="form-control">
                </div>
                <div class="col-4">
                    <label for="animal_type_id" class="form-label"><b>Tipo:</b></label>
                    <select name="animal_type_id" required class="form-control" id="animal_type_id">
                        @foreach ($animal_types as $type)
                            <option value="{{ $type->id }}">{{ $type->id . ' - ' . $type->description }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <div class="row">
                <div class="col-4">
                    <label for="animal_type_id" class="form-label"><b>Endereço do Cliente:</b></label>
                    <select name="animal_type_id" required class="form-control" id="animal_type_id">
                        @foreach ($animal_types as $type)
                            <option value="{{ $type->id }}">{{ $type->id . ' - ' . $type->description }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-2">
                    <label for="number" class="form-label"><b>Data Nascimento</b></label>
                    <input type="number" required name="number" max="9999999" id="number" class="form-control"
                        placeholder="01/01/2001">
                </div>

                <div class="col-4">
                    <label for="situation_id" class="form-label"><b>Situação:</b></label>
                    <select name="situation_id" required class="form-control" id="situation_id">
                        @foreach ($situations as $situation)
                            <option value="{{ $situation->id }}">
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
                    <input type="file" class="form-control" name="foto_perfil" accept="image/*" required />
                </div>
            </div>
        </div>
        <button class="botao-default w-100" type="submit">Cadastrar</button>
    </form>

@endsection
