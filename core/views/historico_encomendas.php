<?php 
    use  core\classes\Store;

?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h3 class="text-center">Histórico de encomendas</h3>
            <?php if (count($historico_encomendas) == 0) : ?>
                <p class="text-center">Não exitem encomendas registradas.</p>
            <?php else : ?>
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Data da encomendas</th>
                            <th>Codigo da Encomenda</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($historico_encomendas as $encomenda): ?>
                            <tr>
                                <td><?= date('d/m/Y H:i:s', strtotime($encomenda->data_encomenda)) ?></td>
                                <td><?= $encomenda->codigo_encomenda ?></td>
                                <td><?= $encomenda->status ?></td>
                                <td><a href="?a=detalhe_encomenda&id=<?= Store::aesEncriptar($encomenda->id_encomenda) ?>">Detalhes</a></td>
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
                <p class="text-end">Total de encomendas: <strong><?= count($historico_encomendas)?></strong></p>
            <?php endif; ?>
        </div>
    </div>
</div>