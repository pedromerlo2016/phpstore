<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center">Detalhe da encomenda</h1>
            <!-- Dados da encomenda-->
            <div >
                <p>Data: <strong><?= date('d/m/Y H:i:s', strtotime($dados_encomenda['dados_encomenda']->data_encomenda)) ?></strong> </p>
                <p>Codigo: <strong><?= $dados_encomenda['dados_encomenda']->codigo_encomenda ?></strong> </p>
                <p>Status: <strong><?= $dados_encomenda['dados_encomenda']->status ?></strong> </p>
                <p>Endereço: <strong><?= $dados_encomenda['dados_encomenda']->residencia ?></strong> </p>
                <p>Cidade: <strong><?= $dados_encomenda['dados_encomenda']->cidade ?></strong> </p>
                <p>Telefone: <strong><?= $dados_encomenda['dados_encomenda']->telefone ?></strong> </p>
                <p>E-mail: <strong><?= $dados_encomenda['dados_encomenda']->email ?></strong> </p>
                <p>Mensagem: <strong><?= $dados_encomenda['dados_encomenda']->mensagem ?></strong> </p>
                <p>Total: <strong>R$ <?= number_format($dados_encomenda['total'],2,',','.')?></strong> </p>
            </div>
            <hr>
            <!-- lista de produtos da encomenda-->
            <div class='mb-5'>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Descrição</th>
                            <th>Preço Unitário</th>
                            <th>Quantidade</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($dados_encomenda['detalhes_encomenda'] as $detalhes) : ?>
                            <tr>
                                <td><?= $detalhes->descricao_produto ?></td>
                                <td>R$ <?= number_format($detalhes->preco_unidade,2,',','.') ?></td>
                                <td><?= $detalhes->quantidade ?></td>
                            <tr>
                            <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>