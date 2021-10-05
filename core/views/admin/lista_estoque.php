<div class="contanier-fluid">
    <div class="row mt-3">
        <div class="col-md-2">
            <?php

use core\classes\Store;

include(__DIR__ . '/layouts/admin_menu.php') ?>
        </div>
        <div class="col-md-10">
            <h3>Lista de produtos no estoque</h3>
            <a href="?a=cadastrar_novo_produto_estoque" class="btn btn-sm btn-primary">Adicionar novo produto ao estoque <span class="fas fa-plus-circle" ></span>  </a>
            <table class='table table-sm table-striped' id="tabela-estoque">
                <thead class='table-dark'>
                    <tr>
                        <th>Categoria</th>
                        <th>Nome</th>
                        <th class="text-center">Quantidade</th>
                        <th class="text-end">Preço</th>
                        <th class="text-center">Visivel</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($dados as $item): ?>
                        <tr>
                            <td><?= $item->categoria?></td>
                            <td><a href="?a=detalhe_produto_estoque&i=<?=Store::aesEncriptar( $item->id_produto) ?>"> <?= $item->nome?></a></td>
                            <td class="text-center"><?= $item->stock?></td>
                            <td class="text-end">R$ <?= number_format($item->preco,2,',','.')?></td>
                            <?php if($item->visivel == 0):?> 
                                <td class="text-center"><i class="fas fa-times  text-danger"></i></td>
                            <?php else: ?> 
                                <td class="text-center "><i class="fas fa-check-circle text-primary"></i></td>
                            <?php endif; ?> 
                            
                            
                        </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>

        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#tabela-estoque').DataTable({
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