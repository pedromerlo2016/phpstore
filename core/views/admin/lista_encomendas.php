<div class="contanier-fluid">
    <div class="row mt-3">
        <div class="col-md-2">
            <?php

use core\classes\Store;

include(__DIR__ . '/layouts/admin_menu.php') ?>
        </div>
        <div class="col-md-10">
            <h3>Lista de encomendas <?= $filtro != '' ? ($filtro != "EM PROCESSAMENTO" ? $filtro . "S" : $filtro) : '' ?></h3>
            <hr>
            <div class="row ">
                <div class="d-inline-flex">
                    <div class="align-self-center me-5">
                        <a href="?a=lista-encomendas" class="btn btn-primary btn-sm">Ver todas as encomendas</a>
                    </div>
                    <?php
                    // recupera o filtro que esta na quey string
                    $f = '';
                    if (isset($_GET['f'])) {
                        $f = $_GET['f'];
                    }
                    ?>

                    <div class="d-inline-flex ">
                        <div class="col-6  align-self-center">
                            <label for="">Escolher status</label>
                        </div class="col">
                        <select id="combo-status" class="form-select" onchange="definir_filtro()">
                            <option value="" <?= ($f == '' ? "selected" : "") ?>></option>
                            <option value="pendente" <?= ($f == 'pendente' ? "selected" : "") ?>>Pendentes</option>
                            <option value="em_processamento" <?= ($f == 'em_processamento' ? "selected" : "") ?>>Em processamento</option>
                            <option value="enviada" <?= ($f == 'enviada' ? "selected" : "") ?>>Enviadas</option>
                            <option value="cancelada" <?= ($f == 'cancelada' ? "selected" : "") ?>>Cancelas</option>
                            <option value="concluida" <?= ($f == 'concluida' ? "selected" : "") ?>>Concluídas</option>
                        </select>
                    </div>
                </div>
            </div>


            <?php if (count($lista_encomendas) == 0) : ?>
                <hr>
                <p>Não exitem encomendas registradas</p>
                <hr>
            <?php else : ?>
                <table class="table table-sm table-striped" id="tabela-encomendas">
                    <thead class='table-dark'>
                        <tr>
                            <th>Data</th>
                            <th>Codigo</th>
                            <th>Nome Cliente</th>
                            <th>E-mail</th>
                            <th>Telefone</th>
                            <th>Status</th>
                            <th>Atualizado em</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($lista_encomendas as $encomenda) : ?>
                            <tr>
                                <td><?= date('d/m/Y', strtotime($encomenda->data_encomenda)) ?></td>
                                <td><?= $encomenda->codigo_encomenda ?></td>
                                <td><?= $encomenda->nome_completo ?></td>
                                <td><?= $encomenda->email ?></td>
                                <td><?= $encomenda->telefone ?></td>
                                <td><a href="?a=detalhe_encomenda&e=<?= Store::aesEncriptar($encomenda->id_encomenda)?>"><?= $encomenda->status ?></a></td>
                                <td><?= date('d/m/Y', strtotime($encomenda->updated_at)) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#tabela-encomendas').DataTable({
            "language": {
                "lengthMenu": "Mostrando _MENU_ registro por página",
                "zeroRecords": "Nenhum registro encontrado - Desculpe!",
                "info": "Visualizando pagina _PAGE_ de _PAGES_",
                "infoEmpty": "Nenhum registro válido",
                "infoFiltered": "(filtrado de total de _MAX_ registros)",
                "loadingRecords": "Carregadon...",
                "processing": "Processando...",
                "search": "Procura:",
                "paginate": {
                    "first": "Primeiro",
                    "last": "Último",
                    "next": "Próximo",
                    "previous": "Prévio"
                },
                "aria": {
                    "sortAscending": ": Ativa para classificar a coluna ascendente",
                    "sortDescending": ":Ativa para classificar a coluna descendente"
                }
            }
        });
    });

    function definir_filtro() {
        var filtro = document.getElementById('combo-status').value;

        //reload da página para um filtro
        window.location.href = "?" + $.param({
            'a': 'lista_encomendas',
            'f': filtro
        })
    }
</script>