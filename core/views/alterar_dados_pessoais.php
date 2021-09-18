<div class="container">
    <div class="row-my-5">
        <div class="col-md-6 offset-md-3 col-sm-8 offset-sm-2 col-10 offset-1">
            <form action="?a=alterar_dados_pessoais_submit" method="post">
                <div class="form-group">
                    <label for="text_email">E-mail</label>
                    <input type="text" name="text_email" class="form-control" maxlength="50" required value="<?= $dados_pessoais->email ?>">
                </div>
                <div class="form-group">
                    <label for="text_mome_completo">Nome completo</label>
                    <input type="text" name="text_mome_conpleto" class="form-control" maxlength="50" required value="<?= $dados_pessoais->nome_completo ?>">
                </div>
                <div class="form-group">
                    <label for="text_endereco">Endereco</label>
                    <input type="text" name="text_endereco" class="form-control" maxlength="100" required value="<?= $dados_pessoais->endereco ?>">
                </div>
                <div class="form-group">
                    <label for="text_cidade">Cidade</label>
                    <input type="text" name="text_cidade" class="form-control" maxlength="50" required value="<?= $dados_pessoais->cidade ?>">
                </div>
                <div class="form-group">
                    <label for="text_telefone">Telefone</label>
                    <input type="text" name="text_telefone" class="form-control" maxlength="20" value="<?= $dados_pessoais->telefone ?>">
                </div>
                <div class="text-center my-4">
                    <a href="?a=perfil" class="btn btn-100 btn-primary">Cancelar</a>
                    <input type="submit" value="Salvar" class="btn btn-100 btn-primary">
                </div>
                <?php if (isset($_SESSION['erro'])) : ?>
                    <div class="alert alert-danger text-center p-2">
                        <?= $_SESSION['erro']  ?>
                        <?php unset($_SESSION['erro']); ?>
                    </div>
                    
                <?php endif; ?>

            </form>


        </div>
    </div>
</div>