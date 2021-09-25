<div class="contanier-fluid">
    <div class="row mt-3 mb-5">
        <div class="col-md-2">
            <?php include(__DIR__ . '/layouts/admin_menu.php') ?>
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
                </div>

            </div>
            <hr>
            <div class="row">
                <div class="col">
                    <p>Nome do cliente:<br><strong>Nome do cliente</strong></p>
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
                        <th>Preço unitário</th>
                        <th class="text-center">Quantidade</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lista_produtos as $produto) : ?>
                        <tr>
                            <td><?= $produto->descricao_produto ?></td>
                            <td>R$ <?= number_format($produto->preco_unidade, 2, ',', '.') ?></td>
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
        <a href="#">Status</a><br>
        <a href="#">Status</a><br>
        <a href="#">Status</a><br>
        <a href="#">Status</a><br>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
    </div>
  </div>
</div>

<script>
    function apresentarModal(){
        var modalStatus = new bootstrap.Modal(document.getElementById('modalStatus'));
        modalStatus.show();
    }
</script>