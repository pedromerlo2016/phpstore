<div class="contanier-fluid">
    <div class="row mt-3">
        <div class="col-md-3">
            <?php include(__DIR__ . '/layouts/admin_menu.php') ?>
        </div>
        <div class="col-md-9">
            <!-- Apresenta informações sobre o total das encomendas PENDENTES -->
            <?php if ($total_encomendas_pendentes == 0) : ?>
                <p>Não exitem encomendas pendentes</p>
            <?php else : ?>
                <div class="alert-info p-2 text-center">
                    <span>Existem conomendas pendentes: <strong><?= $total_encomendas_pendentes ?></strong></span>
                    <a href="?a=lista_encomendas&f=pendentes"><i class="fas fa-eye me-2"></i>Ver</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>