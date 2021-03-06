<?php

namespace core\models;

use core\classes\Database;
use core\classes\Store;
use DateTime;

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
    // CLIENTES
    //============================================================

    public static function lista_clientes()
    {
        // recupera todos sos clientes na DB
        $db = new Database();
        $sql = "SELECT 
            clientes.id_cliente,
            clientes.email,
            clientes.nome_completo,
            clientes.telefone,
            clientes.ativo,
            clientes.deleted_at,
            COUNT(encomendas.id_encomenda) total_encomendas
            FROM clientes LEFT JOIN encomendas ON clientes.id_cliente = encomendas.id_cliente
            GROUP BY clientes.Id_cliente";
        $resultados = $db->select($sql);
        return $resultados;
    }

    //============================================================
    public static function detalhe_cliente($id_cliente)
    {
        // recupera todos sos clientes na DB
        $db = new Database();
        $parametros = [
            ':id_cliente' => $id_cliente,
        ];

        $sql = "SELECT * FROM clientes WHERE id_cliente = :id_cliente";
        $resultado = $db->select($sql, $parametros);

        return $resultado[0];
    }

    //============================================================      
    public static function total_encomendas($id_cliente)
    {
        // consulta o total de encomendas do cliente
        $db = new Database();
        $parametros = [
            ':id_cliente' => $id_cliente,
        ];

        $sql = "SELECT COUNT(*) total FROM encomendas WHERE id_cliente = :id_cliente";
        $resultado = $db->select($sql, $parametros)[0];

        return $resultado;
    }

    //============================================================     
    public static  function buscar_encomendas_cliente($id_cliente)
    {
        // buscar todas as  encomendas do cliente
        $db = new Database();
        $parametros = [
            ':id_cliente' => $id_cliente,
        ];

        $sql = "SELECT * FROM encomendas WHERE id_cliente = :id_cliente";
        $resultado = $db->select($sql, $parametros)[0];
        Store::printData($resultado);
        return $resultado;
    }

    //============================================================ 
    public static function altera_status_cliente($status, $id_cliente)
    {
       
        $db = new Database();
        $parametros = [
            ':id_cliente' => $id_cliente,
            ':status' => $status
        ];

        $sql = "UPDATE clientes SET ATIVO=:status WHERE id_cliente =:id_cliente";
        $resultado = $db->update($sql, $parametros);
        return;
    }

    public static function cliente_excluir($id_cliente)
    {
          
          $data= Date('Y-m-d H:i:s') ;
          $db = new Database();
          $parametros = [
              ':id_cliente' => $id_cliente,
              ':deleted_at' => $data,
              ':status'=> 0

          ];
  
          $sql = "UPDATE clientes SET ATIVO=:status, deleted_at=:deleted_at WHERE id_cliente =:id_cliente";
          $resultado = $db->update($sql, $parametros);
          return;
    }


    //============================================================
    // ENCOMENDAS
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
        $resultados = $db->select("SELECT COUNT(*) as total FROM encomendas WHERE status='EM_PROCESSAMENTO'");
        return $resultados[0]->total;
    }

    //============================================================
    public function lista_encomendas($filtro = "", $id_cliente)
    {
        // lista as encomendas com status=PENDENTE
        $db = new Database();

        $sql = "SELECT e.*, c.nome_completo FROM encomendas e LEFT JOIN clientes c";
        $sql .= " ON e.id_cliente  = c.id_cliente WHERE 1";

        if ($filtro != '') {
            $sql .= " AND e.status='$filtro'";
        }
        if (!empty($id_cliente)) {
            $sql .= " AND e.id_cliente = $id_cliente";
        }

        $sql .= " ORDER BY e.id_encomenda DESC";

        return $db->select($sql);
    }

    //============================================================
    public function lista_encomendas_old($filtro = "")
    {
        // lista as encomendas com status=PENDENTE
        $db = new Database();

        $sql = "SELECT encomendas.*, clientes.nome_completo FROM encomendas, clientes WHERE 1";

        if ($filtro != '') {
            $sql .= " AND encomendas.status='$filtro'";
        }
        $sql .= " AND clientes.id_cliente=encomendas.id_cliente ORDER BY encomendas.id_encomenda DESC";

        return $db->select($sql);
    }

    //============================================================
    public static function  cliente_historico_encomendas($id_cliente)
    {
        // lista as encomendas com status=PENDENTE
        $db = new Database();

        $sql = "SELECT e.*, c.nome_completo FROM encomendas e LEFT JOIN clientes c";
        $sql .= " ON e.id_cliente  = c.id_cliente";
        $sql .= " WHERE e.id_cliente=$id_cliente";
        $sql .= " ORDER BY e.id_encomenda DESC";

        return $db->select($sql);
    }

    //============================================================
    public static function detalhe_encomenda($id_encomenda)
    {
        // lista detalhes dos produtos da encomenda e dados da encomenda
        $db = new Database();
        $parametros = [
            ':id_encomenda' => $id_encomenda,
        ];

        $sql = "SELECT clientes.nome_completo, encomendas.* FROM clientes, encomendas
        WHERE encomendas.id_encomenda = :id_encomenda
        AND clientes.id_cliente = encomendas.id_cliente ";
        $encomenda = $db->select($sql, $parametros);
        $sql = "SELECT * FROM encomenda_produto WHERE id_encomenda =:id_encomenda";
        $lista_produtos =  $db->select($sql, $parametros);

        $dados = [
            'encomenda' => $encomenda[0],
            'lista_produtos' => $lista_produtos
        ];
        return $dados;
    }

    //============================================================
    public static function altera_status_encomenda($id_encomenda, $status)
    {
        $db = new Database();
        $id_encomenda = Store::aesDesencriptar($id_encomenda);
        // Veirfica status atual da encomenda 
        $parametros = [
            ':id_encomenda' => $id_encomenda
        ];
        $sql = ("SELECT status from  encomendas WHERE id_encomenda = :id_encomenda");
        $statusAtual = $db->select($sql, $parametros)[0];


        if ($statusAtual->status == 'CANCELADO') {
            return false;
        }

        $parametros = [
            ':status' => $status,
            ':id_encomenda' => $id_encomenda
        ];
        $sql = ("UPDATE encomendas SET status=:status WHERE id_encomenda = :id_encomenda");
        $db->update($sql, $parametros);
        return true;
    }
}
