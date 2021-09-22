<div class="contanier-fluid">
    <div class="row mt-3">
        <div class="col-md-2">
            <?php include(__DIR__ . '/layouts/admin_menu.php') ?>
        </div>
        <div class="col-md-10">
            <h3>Lista de encomendas <?= $filtro != '' ? $filtro : '' ?></h3>
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
                                <td><?= $encomenda->status ?></td>
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