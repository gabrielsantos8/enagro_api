@extends('app')
@section('title', 'Parcelas por usuário')
@section('menuAtivo', 'parcelasPorUsuario')
@section('error', isset($error) ? $error : '')
@section('content')

    <div class="mb-3">
        <div class="filtro row">
            <div class="col-2">
                <label for="dataInicial">Data Inicial</label>
                <input type="date" class="form-control" id="dataInicial">
            </div>
            <div class="col-2">
                <label for="dataFinal">Data Final</label>
                <input type="date" class="form-control" id="dataFinal">
            </div>
            <div class="col-4">
                <label for="usuario">Usuário</label>
                <select id="usuario" class="form-control">
                    @foreach ($usuarios as $usuario)
                        <option value="{{ $usuario->id }}">
                            {{ $usuario->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-4">
                <label for="situacao">Situação</label>
                <select id="situacao" class="form-control">
                    @foreach ($status as $stt)
                        <option value="{{ $stt->id }}">
                            {{ $stt->id . ' - ' . $stt->description }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 mt-3"">
                <button class="form-control botao-default" id="btnPesquisarIns">Pesquisar</button>
            </div>
            <div id="aviso">

            </div>
        </div>
    </div>

    <table id="userInstallmentTable" class="display">
        <thead>
            <tr>
                <th>Cód. Contrato</th>
                <th>Número Parcela</th>
                <th>Situação</th>
                <th>Data de Vencimento</th>
                <th>Valor</th>
                <th>Plano</th>
                <th>Tipo</th>
                <th>Data de Criação</th>
            </tr>
        </thead>
    </table>
    {{-- <script src="https://code.jquery.com/jquery-3.7.0.js"></script> --}}
    <script src="{{ mix('js/jquery-3.7.0.js') }}"></script>
    <script src="{{ mix('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ mix('js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ mix('js/jszip.min.js') }}"></script>
    <script src="{{ mix('js/pdfmake.min.js') }}"></script>
    <script src="{{ mix('js/vfs_fonts.js') }}"></script>
    <script src="{{ mix('js/buttons.html5.min.js') }}"></script>
    <script src="{{ mix('js/buttons.print.min.js') }}"></script>


    <script>
        $(document).ready(function() {
            var tabela = $('#userInstallmentTable').DataTable({
                "columns": [{
                        "data": "contract_id"
                    },
                    {
                        "data": "Número Parcela"
                    },
                    {
                        "data": "Situação"
                    },
                    {
                        "data": "Data de Vencimento"
                    },
                    {
                        "data": "Valor"
                    },
                    {
                        "data": "Plano"
                    },
                    {
                        "data": "Tipo"
                    },
                    {
                        "data": "Data de Criação"
                    }
                ],
                "dom": 'Bfrtip',
                "buttons": [
                    'excel', 'print'
                ]
            });

            $("#btnPesquisarIns").on("click", function() {
                var dini = $('#dataInicial').val();
                var dfim = $('#dataFinal').val();
                var user_id = $('#usuario').val();
                var situacao = $('#situacao').val();
                if (dini === '' || dfim === '' || user_id === '' || situacao === '') {
                    $('#aviso').html('<p style="color: red; padding: 5px;">Preencha todos os campos!</p>')
                        .addClass('aviso-erro');
                } else {
                    $('#aviso').empty();
                    $.post("/relatory/installmentByUserIndexData", {
                        "dini": dini,
                        "dfim": dfim,
                        "user_id": user_id,
                        "status_id": situacao
                    }, function(data) {
                        tabela.clear().rows.add(data.dados).draw();
                    });
                }
            });

        });
    </script>

    </html>

@endsection
