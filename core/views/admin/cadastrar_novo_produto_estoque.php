<div class="contanier-fluid">
    <div class="row mt-3">
        <div class="col-md-2">
            <?php include(__DIR__ . '/layouts/admin_menu.php') ?>
        </div>
        <div class="col-md-10">
        <h2 class="text-start">Novo produto no estoque</h2>
            <hr>
            <div class="row my-5">

                <!-- <div class="col-md-6 offset-md-3 col-sm-8 offset-sm-2 col-10 offset-1"> -->
                <div class="col-md-6 col-sm-8  col-10 ">
                    <form action="?a=cadastrar_novo_produto_estoque_submit" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="text_id_produto" value="<?= $dados->id_produto ?>">
                        <div class="row">
                            <div class="col-2  align-self-center text-end"><label for="text_categoria">Categoria</label></div>
                            <div class="col-10"><input type="text" name="text_categoria" class="form-control" maxlength="50" required value="<?= $dados->categoria ?>"></div>
                        </div>
                        <div class="row">
                            <div class="col-2 text-end"><label for="text_nome">Nome</label></div>
                            <div class="col-10"><input type="text" name="text_nome" class="form-control" maxlength="50" required value="<?= $dados->nome ?>"></div>
                        </div>

                        <div class="row">
                            <div class="col-2 align-self-center text-end">
                                <label for="text_descricao">Descrição</label>
                            </div>
                            <div class="col-10">
                                <textarea class="form-control" name="text_descricao" id="text_descricao"><?= $dados->descricao ?></textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-2 align-self-center text-end">
                                <label for="text_preco">Preço</label>
                            </div>
                            <div class="col-3">
                                <input type="text" name="text_preco" class="form-control" maxlength="50" required value="R$ <?= number_format($dados->preco, 2, ',', '.') ?>">
                            </div>
                            <div class="col-2 align-self-center  text-end">
                                <label for="text_stock">Estoque</label>
                            </div>
                            <div class="col-3">
                                <input type="text" name="text_stock" class="form-control" maxlength="50" required value="<?= $dados->stock ?>">
                            </div>
                            <div class="col input-group-text">
                                <input class="form-check-input mt-0 me-3" type="checkbox" name="ckb_visivel" value="1" <?= $dados->visivel ? 'checked' : '' ?> aria-label="Checkbox for following text input">
                                <label for="ckb_visivel">Visivel</label>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-2">
                                <img src="/assets/images/produtos/<?= $dados->imagem ?>" width="100" class="img-fluid">
                            </div>
                            <div class="col-10 align-self-center ">
                                <!-- <input type="hidden" name="MAX_FILE_SIZE" value="30000" /> -->
                                <input class="form-control" type="file" id="imagem" name="imagem" accept="image/png, image/jpeg" />
                            </div>

                        </div>
                        <div class="text-center my-4">
                            <a href="?a=lista_produtos_estoque" class="btn btn-100 btn-primary">Cancelar/Voltar</a>
                            <input type="submit" value="Salvar" class="btn btn-100 btn-primary">
                       </div>
                    </form>
                    <div class="mb-5">
                        <?php if (isset($_SESSION['msg'])) : ?>
                            <div class="alert alert-primary text-center p-2">
                                <?= $_SESSION['msg']  ?>
                                <?php unset($_SESSION['msg']); ?>
                            </div>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>