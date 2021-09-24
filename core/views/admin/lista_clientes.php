<div class="contanier-fluid">
    <div class="row mt-3">
        <div class="col-md-2">
            <?php

            use core\classes\Store;

            include(__DIR__ . '/layouts/admin_menu.php') ?>
        </div>
        <div class="col-md-10">
            <h3>Lista de clientes</h3>
            <hr>
            <?php if (count($clientes) == 0) : ?>
                <p class="text-start text-a1a1a1">Não existem clientes cadastrados.</p>
            <?php else : ?>
                <!-- Apresentsa a tabela de clientes -->function
                <table class="table table-sm" id="tabela-clientes">
                    <thead class=table-dark>
                        <tr>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Telefone</th>
                            <th class="text-center">Encomendas</th>
                            <!-- Ativo/Inativo -->
                            <th class="text-center">Ativo</th>
                            <!-- deleted_at -->
                            <th class="text-center">Excluído</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($clientes as $cliente) : ?>
                            <tr>
                                <td>
                                    <a href="?a=detalhe_cliente&c=<?= Store::aesEncriptar($cliente->id_cliente) ?>">
                                        <?= $cliente->nome_completo ?>
                                    </a>
                                </td>
                                <td><?= $cliente->email ?></td>
                                <td><?= $cliente->telefone ?></td>
                                <td class="text-center">
                                    <?php if ($cliente->total_encomendas == 0) : ?>
                                        ---
                                    <?php else : ?>
                                        <a href="#"><?= $cliente->total_encomendas ?></a>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($cliente->ativo == 1) : ?>
                                        <i class="fas fa-check-circle text-success"></i>
                                    <?php else : ?>
                                        <i class="fas fa-times-circle text-danger"></i>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($cliente->deleted_at == null) : ?>
                                        <i class="fas fa-times-circle text-success"></i>
                                    <?php else : ?>
                                        <i class="fas fa-check-circle text-danger"></i>

                                    <?php endif; ?>
                                </td>
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
        $('#tabela-clientes').DataTable({
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