<?php use core\classes\Store; ?>
<div class="container-fluid navegacao">
    <div class="row">
        <div class="col-6 text-start p-3">
            <a href="?a=inicio">
                <h3><?= APP_NAME ?></h3>
            </a>
        </div>
        <div class="col-6 text-end p-3">
            <a href="?a=inicio" class="nav-item">Inicio</a>
            <a href="?a=loja" class="nav-item">Loja</a>
            <!-- Verifica se existe cliente na sessão -->
            <?php if(Store::clienteLogado()): ?>
                <a href="?a=minha_conta" class="nav-item">Logout</a>
                <a href="?a=logout" class="nav-item">A minha conta</a>
            <?php else:?>
                <a href="?a=login" class="nav-item">Login</a>
                <a href="?a=novo_cliente" class="nav-item">Criar conta</a>
            <?php endif;?>
            <a href="?a=carrinho"><i class="fas fa-shopping-cart"></i></a>
            <span class="badge bg-warning"></span>
        </div>
    </div>
</div>