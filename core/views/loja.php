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
            <?php foreach ($produtos as $produto) : ?>
                <div class="col-sm-4 col-6 p-2">
                    <div class="text-center p-3 box-produto">
                        <img src="assets/images/produtos/<?= $produto->imagem ?>" width="100" class="img-fluid">
                        <p><?= $produto->nome ?></p>
                        <p><?= 'R$ ' . $produto->preco ?></p>
                        <div>
                            <button>Adicionar ao carrinho</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif ?>
    </div>
</div>