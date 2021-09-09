<div class="container espaco-fundo">
    <div class="row">
        <div class="div col-12 text-center my-5">
            <a href="?a=loja&c=todos" class="btn btn-primary">Todos</a>
            <a href="?a=loja&c=homem" class="btn btn-primary">Homem</a>
            <a href="?a=loja&c=mulher" class="btn btn-primary">Mulher</a>
        </div>
    </div>
     <!-- Produtos -->
    <div class="row">

       <?php foreach($produtos as $produto): ?>
       <div class="col-sm-4 col-6 p-2">
           <div class="text-center p-3 box-produto">
               <img src="assets/images/produtos/<?= $produto->imagem?>" width="100" class="img-fluid">
               <p><?= $produto->nome?></p>
               <p><?= 'R$ '.$produto->preco?></p>
                <div>
                   <button>Adicionar ao carrinho</button>
               </div>
           </div>
       </div>
       <?php endforeach;?>
    </div>
</div>

<!-- 
    [id_produto] => 1
    [categoria] => homem
    [nome] => tshirt azul
    [descricao] => Ao contrário do que se acredita, Lorem Ipsum não é simplesmente um texto randômico.
    [imagem] => tshirt_blue.png
    [preco] => 47.50
    [stock] => 100
    [visivel] => 1
    [created_at] => 2021-09-09 10:44:44
    [updated_at] => 2021-09-09 10:44:44
    [deleted_at] =>
 -->