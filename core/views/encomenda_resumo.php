<div class="container">
    <div class="row">
        <div class="col">
            <h3 class="my-3">A sua compra - Resumo</h3>
            <hr>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Unidades</th>
                        <th class="text-end">Valor</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $contador  =  count($carrinho) ?>
                    <?php for ($i = 0; $i < $contador; $i++) :
                        $produto = $carrinho[$i];
                        if ($i < $contador - 1) : ?>
                            <tr>
                                <td class="align-middle fs-6"><?= $produto['titulo'] ?></td>
                                <td class='text-center align-middle col-sm-1 fs-6'><?= $produto['quantidade'] ?></td>
                                <td class="text-end col-sm-2 align-middle fs-6">R$ <?= number_format($produto['preco'], 2, ',', '.') ?></td>
                            </tr>
                        <?php else : ?>
                            <tr>
                                <td></td>
                                <td class="fw-bold text-end fs-5">Total:</td>
                                <td class="text-end fw-bold fs-5">R$ <?= number_format($produto, 2, ',', '.') ?></td>
                            </tr>
                        <?php endif; ?>
                    <?php endfor ?>
                </tbody>
            </table>


            <h5 class="bg-dark text-white p-2">Dados do cliente</h5>
            <div class="row">
                <div class="col">
                    <p>Nome : <strong><?= $cliente->nome_completo ?></strong></p>
                    <p>Endereço: <strong><?= $cliente->endereco ?></strong></p>
                    <p>Cidade : <strong><?= $cliente->cidade ?></strong></p>
                </div>
                <div class="col">
                    <p>Email: <strong><?= $cliente->email ?></strong></p>
                    <p>Telefone: <strong><?= $cliente->telefone ?></strong></p>
                </div>
            </div>
            <div class="form-check">
                <label for="check_residencia_alternatida" class="form-check-label">Utilizar residência alternativa</label>              
                <input type="checkbox" onchange="usar_residencai_alternativa()" name="check_residencia_alternatida" id="check_residencia_alternatida" class="form-check-input">
            </div>

            <div id="residencia_alternativa" style="display:none">
                residência alternativa
            </div>                



            <div class="row my-5">
                <div class="col">
                    cancelar
                </div>
                <div class="col text-end">
                    escolher método de pagamento
                </div>
            </div>
        </div>
    </div>
</div>