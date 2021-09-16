<?php

namespace core\models;

use core\classes\Database;

class Encomendas
{
    //============================================================
    public function guardar_encomenda($dados_encomenda, $dados_produtos)
    {
        $db = new Database();
        // Guardar os dados da encomenda
        $parametros = [
            ':id_cliente' => $dados_encomenda['id_cliente'],
            ':residencia' => $dados_encomenda['endereco'],
            ':cidade' => $dados_encomenda['cidade'],
            ':email' => $dados_encomenda['email'],
            ':telefone' => $dados_encomenda['telefone'],
            ':codigo_encomenda' => $dados_encomenda['codigo_encomenda'],
            ':status' => $dados_encomenda['status'],
            ':mensagem' => $dados_encomenda['mensagem'],
        ];
        $db->insert("INSERT INTO encomendas 
         VALUES(
            0,
            :id_cliente,
            NOW(),
            :residencia,
            :cidade,
            :email,
            :telefone,
            :codigo_encomenda, 
            :status,
            :mensagem,
            NOW(),
            NOW()
        );", $parametros);

        // Guardar o id da encomenda
        $id_encomenda = $db->SELECT("SELECT MAX(id_encomenda) AS id_encomenda FROM encomendas")[0]->id_encomenda;
        // Guardar os dados dos produtos
        $num =  count($dados_produtos);
        for($n=0; $n < $num ; $n++){
            $paramentros =[
                ':id_encomenda'=>$id_encomenda,
                ':descricao_produto'=>$dados_produtos[$n]['designacao_produto'],
                ':preco_unidade'=>$dados_produtos[$n]['preco_unidade'],
                ':quantidade'=>$dados_produtos[$n]['quantidade']
            ];   
            $db->insert("INSERT INTO encomenda_produto VALUES(
                0,
                :id_encomenda,
                :descricao_produto,
                :preco_unidade,
                :quantidade,
                NOW()
            );", $paramentros); 
        }
        
    }

}