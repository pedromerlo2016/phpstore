<div class="container">
<div class="row my-5">
    <div class="col text-center">
        <h3>Encomenda confirmada</h3>
        <p>Obrigado pela sua encomenda.</p>
        <div class="my-5">
            <h4>Dados de pagamento</h4>
            <p>Conta bancaria: 123456789</p>
            <p>Código da encomenda: <strong><?=$codigo_encomenda ?></strong></p>
            <p>Total da encomenda: R$ <strong><?= number_format($total_encomenda,2,',','.') ?></strong></p>
        </div>
        <p>Receberá um e-mail com a confirmação da encomenda e os dados de pagamento.<br>
    <br>A sua encomenda só será processada após confirmação do pagamento</p>
        <p><small>favor verifique se o e-mail aparece em sua caixa postal ou se foi para a pasta de SPAM</small></p>
        <div class="my-5">
            <a href="?a=inicio" class="btn btn-primary">Voltar</a>
        </div>
    </div>
</div>
</div>