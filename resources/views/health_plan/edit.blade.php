@extends('app')
@section('title', 'Editando Planos')
@section('menuAtivo', 'plans')
@section('error', isset($error) ? $error : '')
@section('content')

    <h1>Planos - Manutenção</h1>

    <form action="{{ route('health_plan.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="text" required name="id" id="id" class="form-control" hidden value="{{ $data->id}}">
        <div class="mb-3">
            <div class="row">
                <div class="col-12">
                    <label for="description" class="form-label"><b>Título:</b></label>
                    <input type="text" required name="description" id="description" class="form-control" value="{{ $data->description}}">
                </div>
            </div>
        </div>
        <div class="mb-3">
            <div class="row">
                <div class="col-12">
                    <label for="detailed_description" class="form-label"><b>Descrição:</b></label>
                    <textarea required name="detailed_description" id="detailed_description" cols="30" rows="10"
                        class="form-control">{{$data->detailed_description}}</textarea>
                </div>
            </div>
        </div>


        <div class="mb-3">
            <div class="row">
                <div class="col-2">
                    <label for="value" class="form-label"><b>Valor:</b></label>
                    <input type="number" required step=".01" name="value" id="value" value="{{ $data->value }}" class="form-control">
                </div>
                <div class="col-2">
                    <label for="minimal_animals" class="form-label"><b>Mínimo de animais:</b></label>
                    <input type="number" required name="minimal_animals" id="minimal_animals" value="{{$data->minimal_animals}}" class="form-control">
                </div>
                <div class="col-2">
                    <label for="maximum_animals" class="form-label"><b>Máximo de animais:</b></label>
                    <input type="number" required name="maximum_animals" id="maximum_animals" value="{{$data->maximum_animals}}" class="form-control">
                </div>
                <div class="col-6">
                    <label for="plan_colors" class="form-label"><b>Cor:</b></label>
                    <input type="color" required name="plan_colors" id="plan_colors" value="{{ $data->plan_colors}}" class="form-control">
                </div>
            </div>
        </div>
        <button class="botao-default w-100" type="submit">Salvar</button>
    </form>

@endsection