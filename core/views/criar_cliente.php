<div class="container">
    <div class="row my-5">
        <div class="col-sm-6 offset-sm-3">
            <h3 class="text-center">Registro de Novo Cliente</h3>
            <form action="a?=criar_cliente" method="POST">
                <div class="my-3">
                    <!-- email -->
                    <label class="form-label" for="text_email">E-mail</label>
                    <input class="form-control" type="email" name="text_email" required placeholder="E-mail">
                </div>
                <div class="my-3">
                    <!-- senha_1 -->
                    <label class="form-label" for="text_senha_1">Senha</label>
                    <input class="form-control" type="password" name="text_senha_1" required placeholder="Senha">
                </div>
                <div class="my-3">
                    <!-- senha_2 -->
                    <label class="form-label" for="text_senha_2">Repitir a senha</label>
                    <input class="form-control" type="password" name="text_senha_2" required placeholder="Repitir a senha">
                </div>
                <div class="my-3">
                    <!-- nome_completo -->
                    <label class="form-label" for="text_nome_completo">Nome completo</label>
                    <input class="form-control" type="text" name="text_nome_completo" required placeholder="Nome completo">
                </div>
                <div class="my-3">
                    <!-- endereco -->
                    <label class="form-label" for="text_endereco">Endereço</label>
                    <input class="form-control" type="text" name="text_endereco" required placeholder="Endereço">
                </div>
                <div class="my-3">
                    <!-- cidade -->
                    <label class="form-label" for="text_cidade">Cidade</label>
                    <input class="form-control" type="text" name="text_cidade" required placeholder="Cidade">
                </div>
                <div class="my-3">
                    <!-- telefone -->
                    <label class="form-label" for="text_telefone">Telefone</label>
                    <input class="form-control" type="text" name="text_telefone" placeholder="Telefone">
                </div>
               <div class="my-4">
                    <!-- submit -->
                    <input type="submit" value="Criar conta" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>
</div>

<!-- tabela clientes
---------------
 
  email *
  senha_1 *
  senha_2 *
  nome_completo * 
  endereco *
  cidade *
  telefone *
  
-->