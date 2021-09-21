<div class="contanier-fluid">
    <div class="row mt-3">
        <div class="col-md-3">
            <?php include(__DIR__ . '/layouts/admin_menu.php') ?>

        </div>
        <div class="col-md-9">
            <?php if (count($encomendas_pendentes)>0 ) : ?>
                <h3>Encomendas pendentes</h3>
            <?php else : ?>
                <h3>Não há encomendas pendentes</h3>
            <?php endif; ?>
        </div>
    </div>
</div>