<div class="contanier-fluid">
    <div class="row mt-3 mb-5">
        <div class="col-md-2">
            <?php include(__DIR__ . '/layouts/admin_menu.php') ?>
        </div>
        <div class="col-md-10">
            <h4>Detalhe da encomenda</h4><span><small><?= $encomenda->codigo_encomenda ?></small></span>
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
                       <?php foreach($lista_produtos as $produto): ?>
                        <tr>
                            <td><?=$produto->descricao_produto ?></td>
                            <td>R$ <?=number_format($produto->preco_unidade,2,',','.') ?></td>
                            <td class="text-center"><?=$produto->quantidade ?></td>
                        </tr>
                       <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
</div>