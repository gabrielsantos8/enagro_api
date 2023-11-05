@extends('app')
@section('title', 'Planos por região')
@section('menuAtivo', 'planosPorRegiao')
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
                <label for="uf">Região</label>
                <select id="uf" class="form-control">
                    @foreach ($ufs as $uf)
                        <option value="{{ $uf->uf }}">
                            {{ $uf->uf }}</option>
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
                <button class="form-control botao-default" id="btnPesquisar">Pesquisar</button>
            </div>
            <div id="aviso">

            </div>
        </div>
    </div>

    <table id="minha-tabela" class="display">
        <thead>
            <tr>
                <th>Plano</th>
                <th>Valor</th>
                <th>Média de Animais</th>
                <th>Situação</th>
                <th>Cliente</th>
                <th>Cidade</th>
                <th>UF</th>
                <th>Data da Assinatura</th>
            </tr>
        </thead>
    </table>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js">
    </script>
    <script type="text/javascript" charset="utf8"
        src="https://cdn.datatables.net/buttons/1.13.6/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.13.6/js/buttons.html5.min.js">
    </script>

    <script>
        $(document).ready(function() {
            var tabela = $('#minha-tabela').DataTable({
                "columns": [{
                        "data": "Plano"
                    },
                    {
                        "data": "Valor"
                    },
                    {
                        "data": "Média de Animais"
                    },
                    {
                        "data": "Situação"
                    },
                    {
                        "data": "Cliente"
                    },
                    {
                        "data": "Cidade"
                    },
                    {
                        "data": "UF"
                    },
                    {
                        "data": "Data da Assinatura"
                    }
                ],
                "dom": 'Bfrtip',
                "buttons": [
                    'excel'
                ]
            });

            $("#btnPesquisar").on("click", function() {
                var dini = $('#dataInicial').val();
                var dfim = $('#dataFinal').val();
                var uf = $('#uf').val();
                var situacao = $('#situacao').val();
                if (dini === '' || dfim === '' || uf === '' || situacao === '') {
                    $('#aviso').html('<p style="color: red; padding: 5px;">Preencha todos os campos!</p>')
                        .addClass('aviso-erro');
                } else {
                    $('#aviso').empty();
                    $.post("/relatory/plansByRegionData", {
                        "_token": "3q2ot7OIliZ9BVrNDUlE1uEEEuXT7EFD912GKvzP",
                        "dini": dini,
                        "dfim": dfim,
                        "uf": uf,
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
