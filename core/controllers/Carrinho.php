<?php

namespace core\controllers;

use core\classes\Store;
use core\models\Clientes;
use core\models\Produtos;

class Carrinho
{
    //============================================================

    public function adicionar_carrinho()
    {


        // adiciona/gestão da variável de SESSÃO do carrinho
        /*
        1. puxar o arry do carrinho da sessão pra o código
        2. gerir o array do carrinho
        3. recolocar o array na sessão
        */

        // vai busrcar o id_produto na query string
        if (!isset($_GET['id_produto'])) {
            echo isset($_SESSION['carrinho']) ? count($_SESSION['carrinho']) : '';
            header('Location: ') . BASE_URL . 'index.php?a=loja';
            return;
        }

        // define o id do produto
        $id_produto = $_GET['id_produto'];

        $produtos = new Produtos();
        $resultados = $produtos->verifica_stock_produto($id_produto);

        if (!$resultados) {
            header('Location: ') . BASE_URL . 'index.php?a=loja';
            echo isset($_SESSION['carrinho']) ? count($_SESSION['carrinho']) : '';
            return;
        }

        $carrinho = [];
        if (isset($_SESSION['carrinho'])) {
            $carrinho = $_SESSION['carrinho'];
            //echo count($_SESSION['carrinho']);
            //return;
        }



        // adicionar o produto ao carrinho
        // caso já exista, soma mais um

        //$carrinho=$_SESSION['carrinho'];
        if (key_exists($id_produto, $carrinho)) {
            // já exite o produto, Acrescenta mais uma unidade
            $carrinho[$id_produto]++;
        } else {
            // caso não exista, adiciona novo produto ao carrinho
            $carrinho[$id_produto] = 1;
        }
        // Atualiza os dados do corrinho na sessão
        $_SESSION['carrinho'] = $carrinho;

        /*
        carrinho[
            [3]->2,
            [4]->1,
        ]
        */

        // devolve a resposta (número de produtos no carrinho)

        $total_produtos = 0;
        foreach ($carrinho as $produto_quantidade) {
            $total_produtos += $produto_quantidade;
        }


        echo $total_produtos;
    }
    //============================================================
    public function limpar_carrinho()
    {
        // limpa o carrinho de todos os produtos
        unset($_SESSION['carrinho']);

        // recarrega carrinho
        $this->carrinho();
    }

    //============================================================
    public function carrinho()
    {

        // Verifica se emxite carrinho
        if (!isset($_SESSION['carrinho']) || count($_SESSION['carrinho']) == 0) {
            $dados = [
                'carrinho' => null,
            ];
        } else {
            //buscar os dados dos produtos do carrinho
            $ids = [];

            foreach ($_SESSION['carrinho'] as $id_produto => $quatidade) {
                array_push($ids, $id_produto);
            }
            //transforma o array em string
            $ids = implode(',', $ids);
            //busca informação dos produtos do carrinho
            $produtos = new Produtos();
            $resultados = $produtos->buscar_produtos_por_ids($ids);

            // Criar um ciclo por cada produto do carrinho
            // identificar os dados do produtos
            // Criar uma coleção de dados para a página
            // imagem | titulo | quantidade | preço | eliminar |mudar a quantidade 

            $dados_tmp = [];
            foreach ($_SESSION['carrinho'] as $id_produto => $quantidade_carrinho) {
                // imagem
                foreach ($resultados as $produto) {
                    if ($produto->id_produto == $id_produto) {
                        $id_produto = $produto->id_produto;
                        $imagem = $produto->imagem;
                        $titulo = $produto->nome;
                        $quantidade = $quantidade_carrinho;
                        $preco = $produto->preco * $quantidade;
                        // colocar o produto na coleção $dados_temp
                        array_push($dados_tmp, [
                            'id_produto'=> $id_produto,
                            'imagem' => $imagem,
                            'titulo' => $titulo,
                            'quantidade' => $quantidade,
                            'preco' => $preco
                        ]);
                        break;
                    }
                }
            }
            $total_da_compra = 0;
            foreach($dados_tmp as $item){
                $total_da_compra  += $item['preco'];
            }
            array_push($dados_tmp,$total_da_compra);
           $dados = [
               'carrinho' => $dados_tmp
           ];
        }

        // apresenta a pagina do carrinho
        Store::Layout([
            'layouts/html_header',
            'header',
            'carrinho',
            'footer',
            'layouts/html_footer',
        ], $dados);
    }
    //============================================================
    public function remover_produto_carrinho(){
        // pega o id do produto na query string
        if(isset($_GET['id_produto'])){
            $id_produto= $_GET['id_produto'];
            $carrinho = $_SESSION['carrinho'];
            unset($carrinho[$id_produto]);
            $_SESSION['carrinho']=$carrinho;
            $this->carrinho();
        }    
    }
}