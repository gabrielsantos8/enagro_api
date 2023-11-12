@extends('app')
@section('title', 'Cadastro de Planos')
@section('menuAtivo', 'plans')
@section('error', isset($error) ? $error : '')
@section('content')

    <h1>Planos - Manutenção</h1>



    <form action="{{ route('health_plan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <div class="row">
                <div class="col-12">
                    <label for="description" class="form-label"><b>Título:</b></label>
                    <input type="text" required name="description" id="description" class="form-control">
                </div>
            </div>
        </div>
        <div class="mb-3">
            <div class="row">
                <div class="col-12">
                    <label for="detailed_description" class="form-label"><b>Descrição:</b></label>
                    <textarea required name="detailed_description" id="detailed_description" cols="30" rows="10"
                        class="form-control"></textarea>
                </div>
            </div>
        </div>


        <div class="mb-3">
            <div class="row">
                <div class="col-2">
                    <label for="value" class="form-label"><b>Valor:</b></label>
                    <input type="number" required name="value" id="value" class="form-control">
                </div>
                <div class="col-2">
                    <label for="minimal_animals" class="form-label"><b>Mínimo de animais:</b></label>
                    <input type="number" required name="minimal_animals" id="minimal_animals" class="form-control">
                </div>
                <div class="col-2">
                    <label for="maximum_animals" class="form-label"><b>Máximo de animais:</b></label>
                    <input type="number" required name="maximum_animals" id="maximum_animals" class="form-control">
                </div>
                <div class="col-6">
                    <label for="plan_colors" class="form-label"><b>Cor:</b></label>
                    <input type="color" required name="plan_colors" id="plan_colors" class="form-control">
                </div>
            </div>
        </div>
        <button class="botao-default w-100" type="submit">Cadastrar</button>
    </form>

@endsection
