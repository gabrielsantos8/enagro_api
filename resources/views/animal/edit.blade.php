@extends('app')
@section('title', 'Editar de animais')
@section('menuAtivo', 'animal')
@section('error', isset($error) ? $error : '')
@section('content')

    <h1>Animais - Manutenção</h1>


    <form action="{{ route('animal.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <div class="row">
                <div class="col-4">
                    <label for="name" class="form-label"><b>Nome:</b></label>
                    <input type="text" value="{{ $data->name}}" required name="name" id="name" class="form-control">
                </div>
                <div class="col-4">
                    <label for="description" class="form-label"><b>Descrição</b></label>
                    <input type="text" value="{{ $data->description}}" required name="description" id="description" class="form-control">
                </div>
                <div class="col-4">
                    <label for="amount" class="form-label"><b>Quantidade</b></label>
                    <input type="number"value="{{ $data->amount}}" required name="amount" id="amount" class="form-control">
                </div>
                <div class="col-4">
                    <label for="weight" class="form-label"><b>Peso</b></label>
                    <input type="number" value="{{ $data->weight}}" required name="weight" id="weight" class="form-control">
                </div>
                <div class="col-4">
                    <label for="animal_subtype_id" class="form-label"><b>Tipo:</b></label>
                    <select name="animal_subtype_id" required class="form-control" id="animal_subtype_id">
                        @foreach ($animal_subtypes as $type)
                            <option @if ($data->animal_subtype_id == $type->id) selected @endif value="{{ $type->id }}">
                                {{ $type->id . ' - ' . $type->description }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-4">
                    <label for="user_address_id" class="form-label"><b>Endereço do Cliente:</b></label>
                    <select name="user_address_id" required class="form-control" id="user_address_id">
                        @foreach ($user_address as $type)
                            <option @if ($data->user_address_id == $type->id) selected @endif value="{{ $type->id }}">
                                {{ $type->id . ' - ' . $type->complement }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <div class="row">
                
                <div class="col-2">
                    <label for="birth_date" class="form-label"><b>Data Nascimento</b></label>
                    <input type="date" value="{{ $data->birth_date}}" required name="birth_date" id="birth_date" class="form-control"
                        placeholder="01/01/2001">
                </div>

                <input type="number" value="{{ $data->id}}" required name="id" id="id" hidden class="form-control">

                {{-- <div class="col-4">
                    <label for="situation_id" class="form-label"><b>Situação:</b></label>
                    <select name="situation_id" required class="form-control" id="situation_id">
                        @foreach ($situations as $situation)
                            <option value="{{ $situation->id }}">
                                {{ $situation->id . ' - ' . $situation->description }}</option>
                        @endforeach
                    </select>
                </div> --}}
            </div>
        </div>

        <div class="mb-3">
            <div class="row">
                <div class="col-12">
                    <label for="img_url" class="form-label"><b>Imagem:</b></label>
                    <input type="file" class="form-control" name="img_url" accept="image/*" />
                </div>
            </div>
        </div>


        <button class="botao-default w-100" type="submit">Salvar</button>
    </form>

@endsection
