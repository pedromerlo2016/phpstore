<div class="contanier-fluid">
    <div class="row mt-3 mb-5">
        <div class="col-md-2">
            <?php

            use core\classes\Store;

            include(__DIR__ . '/layouts/admin_menu.php') ?>
        </div>
        <div class="col-md-10">
            <div class="row">
                <div class="col">
                    <h4>Detalhe da encomenda</h4><span><small><?= $encomenda->codigo_encomenda ?></small></span>
                </div>
                <div class="col text-end">
                    <div class="text-center p-3 badge bg-primary status-clicavel" onclick="apresentarModal()">
                        <?= $encomenda->status ?>
                    </div>
                    <?php if($encomenda->status=="EM_PROCESSAMENTO"):?>
                        <div>
                           <a href="#" class="btn btn-sm btn-primary">PDF</a>
                        </div>
                    <?php endif;?>
                </div>

            </div>
            <hr>
            <div class="row">
                <div class="col">
                    <p>Nome do cliente:<br><strong><?= $encomenda->nome_completo?></strong></p>
                    <p>E-mail:<br><strong><?= $encomenda->email ?> </strong></p>
                    <p>Telefone:<br><strong><?= $encomenda->telefone ?></strong></p>
                </div>
                <div class="col">
                    <p>Data encomenda:<br><strong><?= date('d/m/Y', strtotime($encomenda->data_encomenda)) ?></strong></p>
                    <p>Endereço:<br><strong><?= $encomenda->residencia ?></strong></p>
                    <p>Cidade:<br><strong><?= $encomenda->cidade ?></strong></p>
                </div>
            </div>
            <hr>
            <table class="table table-sm">
                <thead class="table-dark">
                    <tr>
                        <th>Descrição</th>
                        <th class="text-end">Preço unitário</th>
                        <th class="text-center">Quantidade</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lista_produtos as $produto) : ?>
                        <tr>
                            <td><?= $produto->descricao_produto ?></td>
                            <td class="text-end">R$ <?= number_format($produto->preco_unidade, 2, ',', '.') ?></td>
                            <td class="text-center"><?= $produto->quantidade ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalStatus" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Alterar status da encomenda</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
  
            <div class="modal-body">
                <div class="text-center">
                    <?php foreach (STATUS as $status) : ?>
                        <?php if ($encomenda->status == $status) : ?>
                            <p><?= $status ?></p>
                        <?php else : ?>
                            <a href="?a=encomenda_alterar_status&e=<?= $encomenda->id_encomenda ?>&s=<?= $status ?>">
                                <p><?= $status ?></p>
                            </a>
                        <?php endif; ?>
                    <?php endforeach; ?>


                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
            </div>
        </div>
    </div>
</div>

<script>
    function apresentarModal() {
        var modalStatus = new bootstrap.Modal(document.getElementById('modalStatus'));
        modalStatus.show();
    }
</script>