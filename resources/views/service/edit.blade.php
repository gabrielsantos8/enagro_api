@extends('app')
@section('title', 'Cadastro de Serviços')
@section('menuAtivo', 'services')
@section('error', isset($error) ? $error : '')
@section('content')

    <h1>Serviços - Manutenção</h1>

    <form action="{{ route('service.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="text" required value="{{$data->id}}" name="id" id="id" hidden class="form-control">
        <div class="mb-3">
            <div class="row">
                <div class="col-6">
                    <label for="description" class="form-label"><b>Descrição:</b></label>
                    <input type="text" required value="{{$data->description}}" name="description" id="description" class="form-control">
                </div>
                <div class="col-2">
                    <label for="value" class="form-label"><b>Valor:</b></label>
                    <input type="number" required value="{{$data->value}}" name="value" id="value" step=".01" class="form-control">
                </div>
                <div class="col-4">
                    <label for="animal_subtype_id" class="form-label"><b>Situação:</b></label>
                    <select name="animal_subtype_id" required class="form-control" id="animal_subtype_id">
                        @foreach ($animal_subtypes as $subtype)
                            <option @if ($data->animal_subtype_id == $subtype->id) selected @endif value="{{ $subtype->id }}">
                                {{ $subtype->id . ' - ' . $subtype->description }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <button class="botao-default w-100" type="submit">Cadastrar</button>
    </form>

@endsection