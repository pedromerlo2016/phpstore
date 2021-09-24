<div class="contanier-fluid">
    <div class="row mt-3">
        <div class="col-md-2">
            <?php include(__DIR__ . '/layouts/admin_menu.php') ?>
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
                <div class="col-9 fw-bold"><?= $cliente_detalhe->ativo==0 ? "<i class='fas fa-times-circle text-danger'></i>" :  "<i class='fas fa-check-circle text-success'></i>" ?></div>
                <!-- created_at-->
                <div class="col-3 text-end">Cliente desde: </div>
                <div class="col-9 fw-bold"><?= date('d/m/Y',strtotime($cliente_detalhe->created_at) )  ?></div>
            </div>
        </div>
    </div>
</div>