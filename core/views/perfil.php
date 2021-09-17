<div class="container">
    <div class="row my-5">
        <div class="col">
            <table class="table table-striped">
                <?php foreach ($dados_cliente as $key => $value) : ?>
                    <tr>
                        <td class="text-end" with=40%><?= $key ?>:</td>
                        <td width=60%><strong><?= $value ?></strong></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>

