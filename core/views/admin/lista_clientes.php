<div class="contanier-fluid">
    <div class="row mt-3">
        <div class="col-md-2">
            <?php include(__DIR__ . '/layouts/admin_menu.php') ?>
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
                            <th>Residência</th>
                            <th>Cidade</th>
                            <th>Telefone</th>
                            <!-- Ativo/Inativo -->
                            <th>Ativo</th>
                            <!--created_at -->
                            <th>Registrado em</th>
                            <!-- deleted_at -->
                            <th>Excluído</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($clientes as $cliente) : ?>
                            <tr>
                                <td><?= $cliente->nome_completo ?></td>
                                <td><?= $cliente->email ?></td>
                                <td><?= $cliente->endereco ?></td>
                                <td><?= $cliente->cidade ?></td>
                                <td><?= $cliente->telefone ?></td>
                                <?php if ($cliente->ativo == 1) : ?>
                                    <td>Ativo</td>
                                <?php else : ?>
                                    <td>Inativo</td>
                                <?php endif; ?>
                                <td><?= date('d/m/Y', strtotime($cliente->created_at)) ?></td>
                                <?php if ($cliente->deleted_at == null) : ?>
                                    <td></td>
                                <?php else : ?>
                                    <td><?= date('d/m/Y', strtotime($cliente->deleted_at)) ?></td>
                                <?php endif; ?>
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