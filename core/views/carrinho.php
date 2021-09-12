<div class="container">
    <div class="row">
        <div class="col">
            <h3 class="my-3">A sua compra</h3>
            <hr>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col">
            <?php if ($carrinho == null) : ?>
                <p class="text-center fs-2">Não exitem produtos no carrinho</p>
                <div class="mt-4 text-center">
                    <a href="?a=loja" class="btn btn-primary">Loja</a>
                </div>
            <?php else : ?>
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Produto</th>
                            <th>Unidades</th>
                            <th class="text-end">Valor</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $contador  =  count($carrinho) ?>
                        <?php for ($i = 0; $i < $contador; $i++) :
                            $produto = $carrinho[$i];
                            if ($i < $contador - 1) : ?>
                                <tr>
                                    <td><img src="assets/images/produtos/<?= $produto['imagem'] ?>" class="img-fluid" width="50"></td>
                                    <td class="align-middle fs-5"><?= $produto['titulo'] ?></td>
                                    <td class='text-center align-middle col-sm-1 fs-5'><?= $produto['quantidade'] ?></td>
                                    <td class="text-end col-sm-2 align-middle fs-5">R$ <?= number_format($produto['preco'], 2, ',', '.') ?></td>
                                    <td class="align-middle text-center">
                                        <a href="?a=remover_produto_carrinho&id_produto=<?=$produto['id_produto']?>" class="btn btn-sm btn-danger">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    </td>

                                </tr>
                            <?php else : ?>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td class="fw-bold text-end fs-4">Total:</td>
                                    <td class="text-end fw-bold fs-4">R$ <?= number_format($produto, 2, ',', '.') ?></td>
                                    <td></td>
                                </tr>
                            <?php endif ?>
                        <?php endfor ?>
                    </tbody>
                </table>
                <div class="row">
                    <div class="col">
                        <!-- <a href="?a=limpar_carrinho" class="btn btn-sm btn-primary">Limpar carrinho</a> -->
                        <button class="btn btn-sm btn-primary" onclick="limpar_carrinho()">Limpar carrinha</button>
                        <span id="confirma_limpar_carrinho" style="display:none;" class="ms-3">Confirma?
                            <button onclick="limpar_carrinho_off()" class="btn btn-sm btn-primary">Não</button>
                            <a href="?a=limpar_carrinho" class="btn btn-sm btn-primary">Sim</a>
                        </span>
                    </div>
                    <div class="col text-end">
                        <a href="?a=loja" class="btn btn-sm btn-primary">Continuar comprando</a>
                        <a href="?a=finalizar_encomenda" class="btn btn-sm btn-primary">Finalizar encomenda</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>