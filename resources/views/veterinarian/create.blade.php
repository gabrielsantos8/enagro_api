@extends('app')
@section('title', 'Cadastro de Veterinários')
@section('menuAtivo', 'veterinarios')
@section('error', isset($error) ? $error : '')
@section('content')

    <h1>Veterinário - Manutenção</h1>



    <form action="{{ route('veterinarian.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <div class="row">
                <div class="col-8">
                    <label for="name" class="form-label"><b>Nome:</b></label>
                    <input type="text" required name="name" id="name" class="form-control">
                </div>
                <div class="col-4">
                    <label for="uf" class="form-label"><b>UF:</b></label>
                    <select name="uf" required class="form-control" id="uf">
                        @foreach ($ufs as $uf)
                            <option value="{{ $uf->uf }}">{{$uf->uf}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <div class="row">
                <div class="col-2">
                    <label for="idcrmv" class="form-label"><b>Cód. Registro CRMV:</b></label>
                    <input type="number" required name="idcrmv" id="idcrmv" class="form-control">
                </div>
                <div class="col-2">
                    <label for="crmv" class="form-label"><b>CRMV:</b></label>
                    <input type="number" required name="crmv" id="crmv" class="form-control">
                </div>
                <div class="col-8">
                    <label for="user_id" class="form-label"><b>Usuário:</b></label>
                    <select name="user_id" required class="form-control" id="user_id">
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->id . ' - ' . $user->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <button class="botao-default w-100" type="submit">Cadastrar</button>
    </form>

@endsection
