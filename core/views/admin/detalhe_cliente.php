<?php

use core\classes\Store;

include(__DIR__ . '/layouts/admin_menu.php') ?>
<div class="contanier-fluid">
    <div class="row mt-3">
        <div class="col-md-2">

        </div>
        <div class="col-md-10">
            <h1>Detalhe do cliente</h1>
            <hr>
            <div class="row mt-3">
                <!-- Nome Completo-->
                <div class="col-3 text-end">Nome completo:</div>
                <div class="col-9 fw-bold"><?= $cliente_detalhe->nome_completo ?></div>
                <!-- Endereço-->
                <div class="col-3 text-end">Endereço:</div>
                <div class="col-9 fw-bold"><?= $cliente_detalhe->endereco ?></div>
                <!-- Cidade-->
                <div class="col-3 text-end">Cidade:</div>
                <div class="col-9 fw-bold"><?= $cliente_detalhe->cidade ?></div>
                <!-- Telefone-->
                <div class="col-3 text-end">Telefone:</div>
                <div class="col-9 fw-bold"><?= $cliente_detalhe->telefone ? $cliente_detalhe->telefone : '-' ?></div>
                <!-- E-mail-->
                <div class="col-3 text-end">E-mail:</div>
                <div class="col-9 fw-bold"><?= $cliente_detalhe->email ?></div>
                <!-- E-mail-->
                <div class="col-3 text-end">Ativo:</div>
                <div class="col-9 fw-bold"><?= $cliente_detalhe->ativo == 0 ? "<i class='fas fa-times-circle text-danger'></i>" :  "<i class='fas fa-check-circle text-success'></i>" ?></div>
                <!-- created_at-->
                <div class="col-3 text-end">Cliente desde: </div>
                <div class="col-9 fw-bold"><?= date('d/m/Y', strtotime($cliente_detalhe->created_at))  ?></div>
                <!-- deleted_at -->
                <?php if($cliente_detalhe->deleted_at != null): ?>
                    <div class="col-3 text-end">Excluído em: </div>
                    <div class="col-9 fw-bold"><?= date('d/m/Y', strtotime($cliente_detalhe->deleted_at))  ?></div>
                <?php endif;?>
            </div>
            <div class="row mt-3">
                <div class="col-9 offset-3">
                    <div class="col text-a1a1a1">
                        <?php if ($total_encomendas->total == 0) : ?>
                            <!-- Não exite encomendas -->
                            <p>Não exitem encomendas deste clientes</p>
                        <?php else : ?>
                            <!-- Exite(m) encomenda(s) -->
                            <a href="?a=cliente_historico_encomendas&c=<?= Store::aesEncriptar($cliente_detalhe->id_cliente) ?>" class="btn btn-sm btn-primary">Ver histórico de encomendas...</a>
                        <?php endif ?>
                        <?php if ($cliente_detalhe->deleted_at == null) : ?>
                            <?php if ($cliente_detalhe->ativo == 0) : ?>
                                <a href="?a=cliente_alterar_status_ativar&c=<?= Store::aesEncriptar($cliente_detalhe->id_cliente) ?> " class="btn btn-sm btn-info">Ativar</a>
                            <?php else : ?>
                                <a href="?a=cliente_alterar_status_desativar&c=<?= Store::aesEncriptar($cliente_detalhe->id_cliente) ?>" class="btn btn-sm btn-warning">Desativar</a>
                            <?php endif; ?>
                        <?php endif;?>    
                        
                        <?php if ($cliente_detalhe->deleted_at == null) : ?>
                            <a href="?a=cliente_excluir&c=<?= Store::aesEncriptar($cliente_detalhe->id_cliente) ?>" class="btn btn-sm btn-danger">Excluir</a>
                        <?php endif;?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>