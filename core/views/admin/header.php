<?php

use core\classes\Store;
?>
<div class="container-fluid navegacao">
    <div class="row">
        <div class="col-6 text-start p-3 text-start">
            <h3>PHP STORE</h3>
        </div>
        <div class="col-6 text-start p-3 text-end align-self-center">
            <?php if (Store::adminLogado()) : ?>
                <i class="fas fa-user me-2"></i>
                <?= $_SESSION['usuario'] ?>
                <a href="?a=admin_logout">
                    <i class="fas fa-sign-out-alt ms-3"></i>Logout</a>
            <?php endif; ?>
        </div>
    </div>
</div>