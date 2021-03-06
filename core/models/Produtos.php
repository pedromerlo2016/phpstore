<?php

namespace core\models;

use core\classes\Database;
use core\classes\Store;

class Produtos
{
    //============================================================
    public function lista_todo_estoque()
    {
        // buscar todas as informações de todos os produtos na base de dados 
        $db = new Database();
        $sql = "SELECT * FROM produtos";
        $produtos = $db->select($sql);
        return $produtos;
    }

    //============================================================
    public function detalhe_item_estoque($id_produto)
    {
        // buscar todos os detalhes do item na base de dados 
        $db = new Database();
        $parametros = [
            ':id_produto' => $id_produto,
        ];
        $sql = "SELECT * FROM produtos where id_produto=:id_produto";
        $item = $db->select($sql, $parametros);
        return $item;
    }


    //============================================================
    public function cadastra_produto_estoque($dados)
    {
        //Store::printData($dados);
        $preco  = str_replace('R$ ', '', $dados['preco']);
        $preco  = str_replace('.', '', $preco);
        $preco  = str_replace(',', '.', $preco);
        $preco = (float)$preco;
        //Store::printData($preco, false);

        $parametros = [];

        $db = new Database();
        $sql = '';
        if ($dados['imagem'] != '') {
            $parametros = [
                ':categoria' => $dados['categoria'],
                ':nome' => $dados['nome'],
                ':descricao' => $dados['descricao'],
                ':preco' => $preco,
                ':stock' => (integer)$dados['stock'],
                ':visivel' => $dados['visivel'],
                ':imagem' => $dados['imagem']
            ];
            //// $sql = "INSERT INTO produtos (categoria, nome, descricao, preco, stock, visivel, imagem) VALUES (:categoria, :nome, :descricao , :preco, :stock, :visivel, :imagem)";
            $sql = "INSERT INTO produtos (categoria, nome, descricao, preco, stock, visivel, imagem) VALUES (:categoria, :nome, :descricao , :preco, :stock, :visivel, :imagem)";
        } else {
            $parametros = [
                ':categoria' => $dados['categoria'],
                ':nome' => $dados['nome'],
                ':descricao' => $dados['descricao'],
                ':preco' => $preco,
                ':stock' => (integer)$dados['stock'],
                ':visivel' => $dados['visivel']
            ];
            $sql = "INSERT INTO produtos (categoria, nome, descricao, preco, stock, visivel) VALUES (:categoria, :nome, :descricao , :preco, :stock, :visivel)";
        }

        $retorno = $db->insert($sql, $parametros);
    }

    //============================================================
    public function altera_produto_estoque($dados)
    {
        //Store::printData($dados);
        $preco  = str_replace('R$ ', '', $dados['preco']);
        $preco  = str_replace('.', '', $preco);
        $preco  = str_replace(',', '.', $preco);
        Store::printData($preco, false);

        $parametros = [];

        $db = new Database();
        $sql = '';
        if ($dados['imagem'] != '') {
            $parametros = [
                ':id_produto' => $dados['id_produto'],
                ':categoria' => $dados['categoria'],
                ':nome' => $dados['nome'],
                ':descricao' => $dados['descricao'],
                ':preco' => $preco,
                ':stock' => $dados['stock'],
                ':visivel' => $dados['visivel'],
                ':imagem' => $dados['imagem']
            ];
            $sql = "UPDATE produtos set categoria=:categoria, nome=:nome, descricao=:descricao , preco=:preco, stock=:stock, visivel =:visivel, imagem=:imagem WHERE id_produto =:id_produto";
        } else {
            $parametros = [
                ':id_produto' => $dados['id_produto'],
                ':categoria' => $dados['categoria'],
                ':nome' => $dados['nome'],
                ':descricao' => $dados['descricao'],
                ':preco' => $preco,
                ':stock' => $dados['stock'],
                ':visivel' => $dados['visivel']
            ];

            $sql = "UPDATE produtos set categoria=:categoria, nome=:nome, descricao=:descricao , preco=:preco, stock=:stock, visivel =:visivel WHERE id_produto =:id_produto";
        }

        $retorno = $db->update($sql, $parametros);
    }

    //============================================================
    public function reduz_produto_estoque($dados)
    {
        $db = new Database();
        foreach ($dados as $key => $value) {
            $estoque = $db->select("SELECT stock FROM produtos where id_produto=$key")[0];
            $quantidade = $estoque->stock;
            $quantidade -= $value;
            if ($quantidade >= 0) {
                $db->update("UPDATE produtos set stock = $quantidade WHERE id_produto=$key");
            }
        }
        return true;
    }


    //============================================================
    public function lista_produtos_disponiveis($categoria)
    {
        // buscar todas as informações dos produtos disponivéis na base de dados 

        $db = new Database();
        $categorias = $this->lista_categorias();
        $sql = "SELECT * FROM produtos ";
        $sql .= "WHERE visivel = 1 ";
        if (in_array($categoria, $categorias)) {
            $sql .= "AND categoria = '$categoria'";
        }

        $produtos = $db->select($sql);
        return $produtos;
    }

    //============================================================
    public function lista_categorias()
    {
        // buscar todas as categorias dos produtos disponivéis na base de dados  
        $db = new Database();
        $sql = "SELECT DISTINCT categoria FROM produtos ";
        $resultados = $db->select($sql);
        $categorias = [];
        foreach ($resultados as $resultado) {
            array_push($categorias, $resultado->categoria);
        }
        return $categorias;
    }

    //============================================================
    public function verifica_stock_produto($id_produto)
    {
        $db = new Database();
        $parametros = [':id_produto' => $id_produto];
        $sql = 'SELECT * FROM produtos WHERE id_produto = :id_produto 
        AND visivel = 1 AND stock > 0 ';
        $resultados = $db->select($sql, $parametros);
        return count($resultados) != 0 ? true : false;
    }

    //============================================================
    public function buscar_produtos_por_ids($ids)
    {
        $db = new Database();
        return $db->select("SELECT * FROM produtos WHERE id_produto IN($ids)");
    }

    //============================================================
    public function repoe_estoque_encomenda_cancelada($id_encomenda)
    {
        $id_encomenda = Store::aesDesencriptar($id_encomenda);
        $db = new Database();
        $produtos = $db->select("SELECT descricao_produto, quantidade FROM encomenda_produto WHERE id_encomenda = $id_encomenda");
        $dados_produto = [];
        foreach ($produtos as $item) {
            array_push($dados_produto, $db->select("SELECT id_produto, stock FROM produtos WHERE nome = '$item->descricao_produto'"));
        }

        for ($i = 0; $i < sizeof($produtos); $i++) {

            $item = $dados_produto[$i][0]->stock;
            $quantidade = $produtos[$i]->quantidade;
            $item += $quantidade;
            $db->update("UPDATE produtos SET stock = $item WHERE id_produto =" . $dados_produto[$i][0]->id_produto);
        }
        return;
    }
}
