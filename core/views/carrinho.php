<h3>Carrinho</h3>
<a href="?a=limpar_carrinho" class="btn btn-sm btn-primary">Limpar carrinho</a>
<div class="container">
    <div class="row">
        <div class="col">
            <?php if($carrinho == null) :?>
                <p>Carrihno vazio</p>
                <p><a href="?a=loja" class="btn btn-primary">Loja</a></p>
            <?php else:?>
            <?php endif;?>
        </div>
    </div>
</div>

