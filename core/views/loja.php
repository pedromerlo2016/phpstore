<?php
// print_r($_SESSION);
?>
<div class="container espaco-fundo">
    <div class="row">
        <div class="div col-12 text-center my-5">
            <a href="?a=loja&c=todos" class="btn btn-primary">Todos</a>
            <?php foreach ($categorias as $categoria) : ?>
                <a href="?a=loja&c=<?= $categoria ?>" class="btn btn-primary"><?= ucfirst(preg_replace("/\_/", " ", $categoria)) ?></a>
            <?php endforeach ?>
        </div>
    </div>
    <!-- Produtos -->
    <div class="row">
        <?php if (count($produtos) == 0) : ?>
            <div class="text-center my-5">
                <h3>Não exitem produto disponíveis</h3>
            </div>
        <?php else : ?>
            <!-- cliclo de apresentação de produtos -->
            <?php foreach ($produtos as $produto) : ?>
                <div class="col-sm-4 col-6 p-2">
                    <div class="text-center p-3 box-produto">
                        <img src="assets/images/produtos/<?= $produto->imagem ?>" width="100" class="img-fluid">
                        <p><?= $produto->nome ?></p>
                        <p><?= 'R$ ' . $produto->preco ?></p>
                        <div>
                            <?php if($produto->stock > 0 ): ?>
                                <button class="btn btn-primary btn-sm" onclick="adicionar_carrinho(<?=$produto->id_produto ?>)"><i class="fas fa-shopping-cart me-2"></i>Adicionar ao carrinho</button>
                            <?php else :?>
                                <button class="btn btn-danger btn-sm"><i class="fas fa-shopping-cart me-2"></i>Sem estoque</button>
                            <?php endif?>
                           
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif ?>
    </div>
</div>