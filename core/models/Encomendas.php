<?php

namespace core\models;

use core\classes\Database;
use core\classes\Store;

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
        for ($n = 0; $n < $num; $n++) {
            $paramentros = [
                ':id_encomenda' => $id_encomenda,
                ':descricao_produto' => $dados_produtos[$n]['designacao_produto'],
                ':preco_unidade' => $dados_produtos[$n]['preco_unidade'],
                ':quantidade' => $dados_produtos[$n]['quantidade']
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

    //============================================================
    public function buscar_hitorico_encomendas($id_cliente)
    {
        // buscar historico de encomendas do cliente = id_cliente
        $paramentros = [
            ':id_cliente' => $id_cliente,
        ];

        $db = new Database();
        $resultados = $db->select("SELECT 
        id_encomenda, 
        data_encomenda, 
        codigo_encomenda, 
        status FROM encomendas WHERE id_cliente = :id_cliente
        ORDER BY data_encomenda DESC
        ", $paramentros);

        return $resultados;
    }

    //============================================================
    public function verifica_encomenda_cliente($id_cliente, $id_encomenda)
    {

        $paramentros = [
            ':id_cliente' => $id_cliente,
            ':id_encomenda' => $id_encomenda,
        ];
        $db = new Database();
        $resultados = $db->select("SELECT id_encomenda FROM encomendas 
        WHERE id_cliente = :id_cliente AND id_encomenda = :id_encomenda", $paramentros);

        return count($resultados);
    }

    //============================================================
    public function detalhes_da_encomenda($id_encomenda)
    {
        // dados da encomenda
        $parametros = ['id_encomenda' => $id_encomenda];
        $db= new Database();
        $dados_encomenda =  $db->select("SELECT * FROM encomendas WHERE id_encomenda = :id_encomenda", $parametros)[0];
        
        // dados dos produtos da encomenda
        $detalhes_encomenda =$db->select("SELECT * FROM encomenda_produto WHERE id_encomenda = :id_encomenda",$parametros);
        $total = 0.0;
        foreach($detalhes_encomenda as $encomenda){
            $total += $encomenda->preco_unidade * $encomenda->quantidade;
        }

        
        
        return [
            'dados_encomenda' => $dados_encomenda,
            'detalhes_encomenda'=> $detalhes_encomenda,
            'total'=> $total,
        ];
    }
}
