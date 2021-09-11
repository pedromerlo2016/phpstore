<h3>Carrinho</h3>
<a href="?a=limpar_carrinho" class="btn btn-sm btn-primary">Limpar carrinho</a>
<div class="container">
    <div class="row">
        <div class="col">
            <?php if ($carrinho == null) : ?>
                <p>Carrihno vazio</p>
                <p><a href="?a=loja" class="btn btn-primary">Loja</a></p>
            <?php else : ?>
                <table class="table table-striped table-sm">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Produto</th>
                            <th>Unidades</th>
                            <th class="text-end">Valor</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $contador  =  count($carrinho) ?>
                        <?php for ($i = 0; $i < $contador; $i++) :
                            $produto = $carrinho[$i];
                            if ($i < $contador-1) : ?>
                                <tr>
                                    <td><img src="assets/images/produtos/<?= $produto['imagem']?>" class="img-fluid" width="50"></td>
                                    <td><?= $produto['titulo'] ?></td>
                                    <td class='text-center col-sm-1'><?= $produto['quantidade'] ?></td>
                                    <td class="text-end col-sm-1"><?=number_format($produto['preco'],2,',','.') ?></td>
                                    <td><a href="" class="btn btn-sm btn-danger"><i class="fas fa-times"></i></a> </td>
                                </tr>
                            <?php else : ?>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td class="fw-bold">Total</td>
                                    <td class="text-end fw-bold"><?=number_format($produto,2,',','.') ?></td>
                                    <td></td>
                                </tr>
                            <?php endif ?>
                        <?php endfor ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>