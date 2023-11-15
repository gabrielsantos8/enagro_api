@extends('app')
@section('title', 'Cadastro de Planos')
@section('menuAtivo', 'plans')
@section('error', isset($error) ? $error : '')
@section('content')

    <h1>Planos - Manutenção</h1>



    <form action="{{ route('health_plan.service_store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="number" name="health_plan_id" hidden value={{$plan_id}}>
        <div class="mb-3">
            <div class="row">
                <div class="col-12">
                    <label for="service_id" class="form-label"><b>Serviços:</b></label>
                    <select name="service_id" required class="form-control" id="service_id">
                        @foreach ($services as $service)
                            <option value="{{ $service->id }}">
                                {{ $service->id . ' - ' . $service->description }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <button class="botao-default w-100" type="submit">Cadastrar</button>
    </form>

@endsection