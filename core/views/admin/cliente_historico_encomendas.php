<div class="contanier-fluid">
    <div class="row mt-3">
        <div class="col-md-2">
            <?php

            use core\classes\Store;

            include(__DIR__ . '/layouts/admin_menu.php');
            ?>
        </div>
        <div class="col-md-10">
            <h3>Lista de encomendas</h3>
            <hr>
            <div class="row">
                <div class="col">Nome: <strong><?= $cliente->nome_completo ?></strong></div>
                <div class="col">E-mail:<strong> <?= $cliente->email?></strong></div>
                <div class="col">Telefone: <strong><?= $cliente->telefone ?></strong></div>
            </div>
            <hr>
            <div class="row ">
                <?php if (count($cliente_historico_encomendas) == 0) : ?>
                    <hr>

                    <p>Não exitem encomendas registradas</p>
                    <hr>
                <?php else : ?>
                    <table class="table table-sm table-striped" id="tabela-encomendas">
                        <thead class='table-dark'>
                            <tr>
                                <th>Data</th>
                                <th>Endereço</th>
                                <th>Cidade</th>
                                <th>Código</th>
                                <th>Status</th>
                                <th>Mensagem</th>
                                <th>Atualizada em</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cliente_historico_encomendas as $encomenda) : ?>
                                <tr>
                                    <td><?= date('d/m/Y', strtotime($encomenda->data_encomenda)) ?></td>
                                    <td><?= $encomenda->residencia ?></td>
                                    <td><?= $encomenda->cidade ?></td>
                                    <td><?= $encomenda->codigo_encomenda ?></td>
                                    <td><?= $encomenda->status ?></td>
                                    <td><?= $encomenda->mensagem ?></td>
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
    </script>