<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h3 class="text-center">Histórico de encomendas</h3>
            <?php if (count($historico_encomendas) == 0) : ?>
                <p class="text-center">Não exitem encomendas registradas.</p>
            <?php else : ?>
                <table>


                </table>
                <p>Total:  0</p>
            <?php endif; ?>



            <?php
            echo "<pre>";
            print_r($historico_encomendas);
            echo "</pre>";
            ?>
        </div>
    </div>
</div>