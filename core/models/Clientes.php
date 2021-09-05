<?php

namespace core\models;

use core\classes\Database;
use core\classes\Store;

class Clientes
{
    public function verificar_email_registrado($email)
    {
        //============================================================
        // Verifica na db se exite cliente com mesmo e-mail
        $db = new Database();
        $parametros = [
            ':email' => strtolower(trim($email)),
        ];

        $resultado = $db->select("SELECT email FROM clientes WHERE email=:email", $parametros);

        // se o email já existe
        if (count($resultado) != 0) {
            return true;
        } else {
            return false;
        }
    }

    public function registar_cliente()
    {
        // registro do novo cliente
        $db = new Database;

        // criação do purl
        $purl =  Store::criarHash();

        // criação de parâmetro
        $parametros = [
            ':email' => strtolower(trim($_POST['text_email'])),
            ':senha' => password_hash(trim($_POST['text_senha_1']), PASSWORD_DEFAULT),
            ':nome_completo' => trim($_POST['text_nome_completo']),
            ':endereco' => trim($_POST['text_endereco']),
            ':cidade' => trim($_POST['text_cidade']),
            ':telefone' => trim($_POST['text_telefone']),
            ':purl' => $purl,
            ':ativo' => 0
        ];

        // gravar dados na tabela
        $db->insert('INSERT INTO clientes (email, senha, nome_completo,endereco, cidade, telefone, purl, ativo) VALUES(:email,:senha,:nome_completo,:endereco,:cidade,:telefone,:purl,:ativo)', $parametros);
        // retorna p purl criado
        return $purl;
    }
}
