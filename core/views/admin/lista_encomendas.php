<div class="contanier-fluid">
    <div class="row mt-3">
        <div class="col-md-3">
            <?php include(__DIR__ . '/layouts/admin_menu.php') ?>
        </div>
        <div class="col-md-9">
             <h3>Lista de encomendas <?=$filtro !=''? $filtro:''?></h3>
            <hr>
                <?php if(count($lista_encomendas)): ?>
                    <p>Não exitem encomendas registradas</p>
                <?php else: ?>
                    <table>
                        <thead>

                        </thead>
                        <tbody></tbody>
                    </table>
                <?php endif;?>
            <hr>
        </div>    
    </div>
</div>