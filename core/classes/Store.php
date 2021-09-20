<?php

namespace core\classes;

use Exception;

class Store
{

    //============================================================
    public static function Layout($estruturas, $dados = null)
    {
        // verifica se estrutura é um array
        if (!is_array($estruturas)) {
            throw new Exception("Coleção de estruturas inválidas");
        }
        // variáveis
        if (!empty($dados) && is_array($dados)) {
            extract($dados);
        }

        // apresentar as views da aplicação
        foreach ($estruturas as $estrutura) {
            include("../core/views/$estrutura.php");
        }
    }

     //============================================================
     public static function Layout_admin($estruturas, $dados = null)
     {
         // verifica se estrutura é um array
         if (!is_array($estruturas)) {
             throw new Exception("Coleção de estruturas inválidas");
         }
         // variáveis
         if (!empty($dados) && is_array($dados)) {
             extract($dados);
         }
 
         // apresentar as views da aplicação
         foreach ($estruturas as $estrutura) {
             include("../../core/views/$estrutura.php");
         }
     }

    //============================================================
    public static function clienteLogado()
    {
        // verifica se existe um cliente com sessão
        return (isset($_SESSION['cliente']));
    }
    //============================================================
    public static function criarHash($num_caracteres = 12)
    {
        // criar hashes
        $chars = 'ancdefghijklnmoprrstuvwxyzancdefghijklnmoprrstuvwxyzANCDEFGHIJKLNMOPRRSTUVWXYZANCDEFGHIJKLNMOPRRSTUVWXYZ12345678901234567890';
        return substr(str_shuffle($chars), 0, $num_caracteres);
    }
    //============================================================
    public static function redirect($rota = "")
    {
        // Faz o redirecionamento para rota desejada
        header("Location: " . BASE_URL . "?a=$rota");
    }
    //============================================================
    public static function gerarCódigoEncomenda()
    {
        // gerar um código de encomenda
        $codigo = "";
        // A-Z e 100000 999999
        $chars="ABCDEFGHIJKLMNOPQRSTUVXYWZABCDEFGHIJKLMNOPQRSTUVXYWZABCDEFGHIJKLMNOPQRSTUVXYWZ";
        $codigo = substr(str_shuffle($chars),0,2);
        $codigo.= rand(100000, 999999);
        return $codigo;
    }
    //============================================================
    public static function printData($data)
    {
        if (is_array($data) || is_object($data)) {
            echo '<pre>';
            print_r($data);
        } else {
            echo '<pre>';
            echo $data;
        }

        die('Terminado');
    }

     //============================================================
     public static function aesEncriptar($valor){
         return bin2hex(openssl_encrypt($valor,'aes-256-cbc',AES_KEY, OPENSSL_RAW_DATA,AES_IV));
     }

      //============================================================
      public static function aesDesencriptar($valor){
        return openssl_decrypt(hex2bin($valor),'aes-256-cbc',AES_KEY, OPENSSL_RAW_DATA,AES_IV);
    }
}
