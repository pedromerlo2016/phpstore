<?php

namespace core\models;

use core\classes\Database;
use core\classes\Store;

class Clientes
{
    //============================================================
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
    //============================================================
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
    //============================================================
    public function validar_email($purl){
        // registro do novo cliente
        $db = new Database;
        $parametros  = [
            'purl' => $purl,
        ];
        $resultados = $db->select('SELECT * FROM clientes WHERE purl = :purl', $parametros);
        // Verifica se foi encontrado o cliente
        if(count($resultados)!=1){
            return false;
        }

        $id_cliente  = $resultados[0]->id_cliente;
        // Atualiza dados do cliente
        $parametros =[
            ':id_cliente'=>$id_cliente,
        ];
        $db->update('UPDATE clientes SET purl= null, ativo=1 , updated_at=NOW() WHERE id_cliente  = :id_cliente' , $parametros);

        return true;
    }

     //============================================================
     public function validar_login($email, $senha)
     {
        $db= new Database();
        // verifica se o usuario e login são válidos
        $parametros=[
            ':email'=> $email,
        ];
        $resultado = $db->select("SELECT * FROM clientes WHERE 
        email = :email AND ativo = 1 AND deleted_at IS NULL", $parametros);

        if(count($resultado)!= 1){
            // usuário não existe
            $_SESSION['erro']="Login Inválido";
            return false;
        }else{
            // temos um usuário
            $usuario = $resultado[0];
            // verificar a senha
            if(!password_verify($senha , $usuario->senha)){
                // senha inválida
                $_SESSION['erro']="Login Inválido";
                return false;
            }else{
                // login válido
                return $usuario;
            }
        }
     }
}
