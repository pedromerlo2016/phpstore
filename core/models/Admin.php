<?php

namespace core\models;

use core\classes\Database;
use core\classes\Store;

class Admin
{
    //============================================================
    public function validar_login($email_admin, $senha)
    {
        $db = new Database();
        // verifica se o usuario e login são válidos
        $parametros = [
            ':usuario' => $email_admin,
        ];
        $resultado = $db->select("SELECT * FROM admins WHERE usuario = :usuario AND deleted_at IS NULL", $parametros);

        if (count($resultado) != 1) {
            // usuário não existe
            $_SESSION['erro'] = "Login Inválido";
            return false;
        } else {
            // temos um usuário
            $usuario = $resultado[0];
            // verificar a senha
            if (!password_verify($senha, $usuario->senha)) {
                // senha inválida
                $_SESSION['erro'] = "Login Inválido";
                return false;
            } else {
                // login válido
                return $usuario;
            }
        }
    }

    //============================================================
    public function total_encomendas_pendente()
    {
        // recupera o valor total de encomendas pendentes
        $db = new Database();
        $resultados = $db->select("SELECT COUNT(*) as total FROM encomendas WHERE status='PENDENTE'");
        return $resultados[0]->total;
    }

    //============================================================
    public function total_encomendas_em_processamento()
    {
        // recupera o valor total de encomendas em processamento
        $db = new Database();
        $resultados = $db->select("SELECT COUNT(*) as total FROM encomendas WHERE status='EM PROCESSAMENTO'");
        return $resultados[0]->total;
    }

    //============================================================
    public function lista_encomendas_pendentes()
    {
        // lista as encomendas com status=PENDENTE
        $db = new Database();
        return $resultado  = $db->select("SELECT * FROM encomendas where status='PENDENTE' ",);
    }
}
