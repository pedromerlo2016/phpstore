<div class="container">
    <div class="row-my-5">
        <div class="col-md-6 offset-md-3 col-sm-8 offset-sm-2 col-10 offset-1">
            <form action="" method="post">
                <div class="form-group">
                    <label for="text_email">E-mail</label>
                    <input type="email" name="text_email" class="form-control" required value="<?= $dados_pessoais->email ?>">
                </div>
                <div class="form-group">
                    <label for="text_mome_completo">Nome completo</label>
                    <input type="text" name="text_mome_conpleto" class="form-control" required value="<?= $dados_pessoais->email ?>">
                </div>
                <div class="form-group">
                    <label for="text_residencia">Residência</label>
                    <input type="text" name="text_residencia" class="form-control" required value="<?= $dados_pessoais->email ?>">
                </div>
                <div class="form-group">
                    <label for="text_cidade">Cidade</label>
                    <input type="text" name="text_cidade" class="form-control" required value="<?= $dados_pessoais->email ?>">
                </div>
                <div class="form-group">
                    <label for="text_telefone">Telefone</label>
                    <input type="text" name="text_telefone" class="form-control" value="<?= $dados_pessoais->email ?>">
                </div>
                <div class="text-center my-4">
                    <a href="?a=perfil" class="btn btn-primary">Cancelar</a>
                    <input type="submit" value="Salvar" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>
</div>