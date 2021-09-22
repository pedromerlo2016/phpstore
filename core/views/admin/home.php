<div class="contanier-fluid">
    <div class="row mt-3">
        <div class="col-md-2">
            <?php include(__DIR__ . '/layouts/admin_menu.php') ?>
        </div>
        <div class="col-md-10">
            <!-- Apresenta informações sobre o total das encomendas PENDENTES -->
            <h4>Encomendas Pendentes</h4>
            <hr>
            <?php if ($total_encomendas_pendentes == 0) : ?>
                <p class="text-a1a1a1">Não exitem encomendas pendentes</p>
            <?php else : ?>
                <div class="alert-info p-2 ">
                    <span>Existem encomendas pendentes: <strong><?= $total_encomendas_pendentes ?></strong></span>
                    <a href="?a=lista_encomendas&f=pendentes"><i class="fas fa-eye me-2"></i>Ver</a>
                </div>
            <?php endif; ?>

            <!-- Apresenta informações sobre o total das encomendas Em PROCESSAMENTO -->
            <h4>Encomendas em processamento</h4>
            <hr>
            <?php if ($total_encomendas_em_processamento == 0) : ?>
                <p class="text-a1a1a1">Não exitem encomendas em processamento</p>
            <?php else : ?>
                <div class="alert-info p-2 ">
                    <span>Existem encomendas em processamento: <strong><?= $total_encomendas_em_processamento ?></strong></span>
                    <a href="?a=lista_encomendas&f=em_processamento"><i class="fas fa-eye me-2"></i>Ver</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>