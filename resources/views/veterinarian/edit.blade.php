@extends('app')
@section('title', 'Editar Veterinários')
@section('menuAtivo', 'veterinarios')
@section('error', isset($error) ? $error : '')
@section('content')

    <h1>Veterinário - Manutenção</h1>


    <form action="{{ route('veterinarian.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <div class="row">
                <div class="col-8">
                    <label for="name" class="form-label"><b>Nome:</b></label>
                    <input type="text" value="{{ $data->nome }}" required name="name" id="name"
                        class="form-control">
                    <input type="number" value="{{ $data->id }}" hidden required name="id" id="id"
                        class="form-control">
                </div>
                <div class="col-4">
                    <label for="uf" class="form-label"><b>UF:</b></label>
                    <select name="uf" required class="form-control" id="uf">
                        @foreach ($ufs as $uf)
                            <option value="{{ $uf->uf }}" @if ($uf->uf == $data->pf_uf) selected @endif>
                                {{ $uf->uf }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <div class="row">
                <div class="col-2">
                    <label for="idcrmv" class="form-label"><b>Cód. Registro CRMV:</b></label>
                    <input type="number" value="{{ $data->id_pf_inscricao }}" required name="idcrmv" id="idcrmv"
                        class="form-control">
                </div>
                <div class="col-2">
                    <label for="crmv" class="form-label"><b>CRMV:</b></label>
                    <input type="number" value="{{ $data->pf_inscricao }}" required name="crmv" id="crmv"
                        class="form-control">
                </div>
                <div class="col-4">
                    <label for="user_id" class="form-label"><b>Usuário:</b></label>
                    <select name="user_id" required class="form-control" id="user_id">
                        @foreach ($users as $user)
                            <option @if ($data->user_id == $user->id) selected @endif value="{{ $user->id }}">
                                {{ $user->id . ' - ' . $user->name }}</option>
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
        <button class="botao-default w-100" type="submit">Salvar</button>
    </form>

@endsection
