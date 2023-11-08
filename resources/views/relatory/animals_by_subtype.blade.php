@extends('app')
@section('title', 'Animais por Sub-Tipo')
@section('menuAtivo', 'animaisPorSubTipos')
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
            <div class="col-8">
                <label for="subTipo">Sub-tipos</label>
                <select id="subTipo" class="form-control">
                    @foreach ($subtypes as $subtype)
                        <option value="{{ $subtype->id }}">
                            {{ $subtype->id . ' - ' . $subtype->description }}</option>
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

    <table id="animalTabela" class="display">
        <thead>
            <tr>
                <th>Animal</th>
                <th>Dono</th>
                <th>Descrição</th>
                <th>Tipo</th>
                <th>Sub-Tipo</th>
                <th>Cidade</th>
                <th>Data Nascimento</th>
                <th>Peso</th>
                <th>Quantidade</th>
                <th>Data Cadastro</th>
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
            var tabela = $('#animalTabela').DataTable({
                "columns": [{
                        "data": "name"
                    },
                    {
                        "data": "u_owner"
                    },
                    {
                        "data": "description"
                    },
                    {
                        "data": "a_type"
                    },
                    {
                        "data": "a_subtype"
                    },
                    {
                        "data": "city"
                    },
                    {
                        "data": "birth_date"
                    },
                    {
                        "data": "weight"
                    },
                    {
                        "data": "amount"
                    },
                    {
                        "data": "created_at"
                    }
                ],
                "dom": 'Bfrtip',
                "buttons": [
                    'excel', 'print'
                ]
            });

            $("#btnPesquisar").on("click", function() {
                var dini = $('#dataInicial').val();
                var dfim = $('#dataFinal').val();
                var subtype_id = $('#subTipo').val();
                if (dini === '' || dfim === '' || subtype_id === '') {
                    $('#aviso').html('<p style="color: red; padding: 5px;">Preencha todos os campos!</p>')
                        .addClass('aviso-erro');
                } else {
                    $('#aviso').empty();
                    $.post("/relatory/animalsBySubtypeData", {
                        "dini": dini,
                        "dfim": dfim,
                        "subtype_id": subtype_id
                    }, function(data) {
                        tabela.clear().rows.add(data.dados).draw();
                    });
                }
            });

        });
    </script>

    </html>

@endsection
