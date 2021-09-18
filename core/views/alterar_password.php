<div class="container">
    <div class="row-my-5">
        <div class="col-md-6 offset-md-3 col-sm-8 offset-sm-2 col-10 offset-1">
            <form action="?a=alterar_password_submit" method="post">
                <div class="form-group">
                    <label for="text_senha_atual">Senha atual:</label>
                    <input type="password" name="text_senha_atual" class="form-control" maxlength="30" required>
                </div>
                <div class="form-group">
                    <label for="text_nova_senha">Nova senha:</label>
                    <input type="password" name="text_nova_senha" class="form-control" maxlength="30" required>
                </div>
                <div class="form-group">
                    <label for="text_repitir_nova_senha">Repitir nova senha:</label>
                    <input type="password" name="text_repetir_nova_senha" class="form-control" maxlength="30" required>
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