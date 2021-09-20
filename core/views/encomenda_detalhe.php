<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center">Detalhe da encomenda</h1>
            <!-- Dados da encomenda-->
            <div class="row">
                <div class="col">
                    <div class="p-2 my-3">
                        <span><strong>Data da encomenda: </strong></span><br>
                        <?= date('d/m/Y H:i:s', strtotime($dados_encomenda['dados_encomenda']->data_encomenda)) ?>
                    </div>
                    <div class="p-2 my-3">
                        <span><strong>Código da Encomenda </strong></span><br>
                        <?= $dados_encomenda['dados_encomenda']->codigo_encomenda ?>
                    </div>
                    <div class="p-2 my-3">
                        <span><strong>Situação </strong></span><br>
                        <?= $dados_encomenda['dados_encomenda']->status ?>
                    </div>
                </div>
                <div class="col">
                    <div class="p-2 my-3">
                        <span><strong>E-mail </strong></span><br>
                        <?= $dados_encomenda['dados_encomenda']->email ?>
                    </div>
                    <div class="p-2 my-3">
                        <span><strong>Telefone </strong></span><br>
                        <?= !empty($dados_encomenda['dados_encomenda']->telefone) ? $dados_encomenda['dados_encomenda']->telefone : '&nbsp' ?>
                    </div>    
                </div>
                <div class="col">
                    <div class="p-2 my-3">
                        <span><strong>Endereço </strong></span><br>
                        <?= $dados_encomenda['dados_encomenda']->residencia ?>
                    </div>
                    <div class="p-2 my-3">
                        <span><strong>Cidade </strong></span><br>
                        <?= $dados_encomenda['dados_encomenda']->cidade ?>
                    </div>
                    <div  class="p-2 my-3">
                        <span><strong>Total </strong></span><br>   
                        R$ <?= number_format($dados_encomenda['total'], 2, ',', '.') ?>    
                    </div>
                </div>

            </div>
            <hr>
            <!-- lista de produtos da encomenda-->
            <div class='row mb-5'>
                <div class="col">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Descrição</th>
                                <th class="text-center">Quantidade</th>
                                <th class="text-end">Preço Unitário</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($dados_encomenda['detalhes_encomenda'] as $detalhes) : ?>
                                <tr>
                                    <td><?= $detalhes->descricao_produto ?></td>
                                    <td class="text-center"><?= $detalhes->quantidade ?></td>
                                    <td class="text-end">R$ <?= number_format($detalhes->preco_unidade, 2, ',', '.') ?></td>
                                <tr>
                                <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row" style="margin-bottom: 100px;">
                <div class="col text-center">
                    <a href="?a=historico_encomendas" class="btn btn-primary btn-150">Voltar</a>
                </div>
            </div>
        </div>
    </div>
</div>