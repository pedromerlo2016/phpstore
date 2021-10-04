<?php

namespace core\controllers;

use core\classes\EnviarEmail;
use core\classes\Store;
use core\models\Encomendas;
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
                            'id_produto' => $id_produto,
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
            foreach ($dados_tmp as $item) {
                $total_da_compra  += $item['preco'];
            }
            array_push($dados_tmp, $total_da_compra);
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
    public function remover_produto_carrinho()
    {
        // pega o id do produto na query string
        if (isset($_GET['id_produto'])) {
            $id_produto = $_GET['id_produto'];
            $carrinho = $_SESSION['carrinho'];
            unset($carrinho[$id_produto]);
            $_SESSION['carrinho'] = $carrinho;
            $this->carrinho();
        }
    }
    //============================================================
    public function finalizar_encomenda()
    {
        // Verifica se exite cliente logado
        if (!isset($_SESSION['cliente'])) {
            //coloca na sessão um "referrer" temporário
            $_SESSION['tmp_carrinho'] = true;
            //redireciona para login
            Store::redirect('login');
            return;
        } else {
            Store::redirect('finalizar_encomenda_resumo');
            return;
        }
    }

    //============================================================
    public function finalizar_encomenda_resumo()
    {
        // verifica se usuario logado
        if (!isset($_SESSION['cliente'])) {
            Store::redirect('inicio');
            return;
        }

        // verifica se pode avançar para gravação de encomenda

        if (!isset($_SESSION['carrinho']) || count($_SESSION['carrinho']) == 0) {
            Store::redirect('inicio');
            return;
        }

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
                        'id_produto' => $id_produto,
                        'imagem' => $imagem,
                        'titulo' => $titulo,
                        'quantidade' => $quantidade,
                        'preco' => $preco
                    ]);
                    break;
                }
            }
        }


        // calcula o total da encomenda
        $total_da_compra = 0;
        foreach ($dados_tmp as $item) {
            $total_da_compra  += $item['preco'];
        }
        array_push($dados_tmp, $total_da_compra);

        // colocar o preço total na sessão
        $_SESSION['valor_total'] = $total_da_compra;
        // Preparar os dados da view
        $dados = [];
        $dados['carrinho'] = $dados_tmp;
        // buscar informações do cliente
        $cliente = new Clientes();
        $dados_cliente = $cliente->buscar_dados_cliente($_SESSION['cliente']);
        $dados['cliente'] = $dados_cliente[0];
        // gerar o código da encomenda
        if (!isset($_SESSION['codigo_encomenda'])) {
            $codigo_encomenda =  Store::gerarCódigoEncomenda();
            $_SESSION['codigo_encomenda'] = $codigo_encomenda;
        }
        // apresenta a pagina do resumo da encomenda
        Store::Layout([
            'layouts/html_header',
            'header',
            'encomenda_resumo',
            'footer',
            'layouts/html_footer',
        ], $dados);
    }

    //============================================================
    public function confirmar_encomenda()
    {
        // verifica se usuario logado
        if (!isset($_SESSION['cliente'])) {
            Store::redirect('inicio');
            return;
        }
        // verifica se pode avançar para gravação de encomenda
        if (!isset($_SESSION['carrinho']) || count($_SESSION['carrinho']) == 0) {
            Store::redirect('inicio');
            return;
        }

        // guardar na base da dados a encomenda
        $dados_encomenda = [];
        // Guardar dados na sessão
        $codigo_encomenda = $_SESSION['codigo_encomenda'];
        $total_encomenda = $_SESSION['valor_total'];
        $dados = [
            'codigo_encomenda' => $codigo_encomenda,
            'total_encomenda' => $total_encomenda
        ];

        // Criar uma lista de produtos + quantidade + preço por unidade 
        $ids = [];

        foreach ($_SESSION['carrinho'] as $id_produto => $quatidade) {
            array_push($ids, $id_produto);
        }

       




        // Store::printData($_SESSION);
        $dados_encomenda['nome_cliente'] = $_SESSION['nome_cliente'];
        //transforma o array em string
        $ids = implode(',', $ids);
        //busca informação dos produtos do carrinho
        $produtos = new Produtos();
        $produtos_da_encomenda = $produtos->buscar_produtos_por_ids($ids);
        //Store::printData($_SESSION['carrinho'][3]);
        $tring_produtos = [];
        foreach ($produtos_da_encomenda as $resultado) {
            // quantidade 
            $quantidade = $_SESSION['carrinho'][$resultado->id_produto];

            $string_produtos[] = "$quantidade x $resultado->nome - R$ " . number_format($resultado->preco, 2, ',', '.') . " /unid";
        }
        //lista de produto para e-mail
        $dados_encomenda['lista_produtos'] = $string_produtos;
        // preço total da encomenda para e-mail
        $dados_encomenda['total'] = 'R$ ' . number_format($_SESSION['valor_total'], 2, ',', '.');

        // Dados do pagamento
        $dados_encomenda['dados_pagamento'] = [
            'numero_da_conta' => '123456789',
            'codigo_encomenda' => $_SESSION['codigo_encomenda'],
            'total' => 'R$ ' . number_format($_SESSION['valor_total'], 2, ',', '.'),
        ];


        // enviar email para o cliente com os dados da encomenda e pagamento
        if (EMAIL_ENVIAR == false) {
            $email = new EnviarEmail();
            $resultado = $email->enviar_email_confirmacao_encomenda($_SESSION['usuario'], $dados_encomenda);
        }

        // - Lista de produtos + quantidade  + preço/inid 
        //   2 x [nome do produto] - repco/unid
        //   1 x [nome do produto] - repco/unid
        //   total da encomenda : valor

        // Dados do pagamento
        // - numero da conta (123456789)
        // - codigo da encomenda
        // - total

        // guardar encomenda no DB
        $dados_encomenda = [''];
        // id_cliente
        $dados_encomenda['id_cliente'] = $_SESSION['cliente'];
        // Residência
        if (isset($_SESSION['dados_alternativos']) && !empty($_SESSION['dados_alternativos']['residencia'])) {
            // considera o endereço alternativo
            $dados_encomenda['endereco'] = $_SESSION['dados_alternativos']['residencia'];
            $dados_encomenda['cidade'] = $_SESSION['dados_alternativos']['cidade'];
            $dados_encomenda['email'] = $_SESSION['dados_alternativos']['email'];
            $dados_encomenda['telefone'] = $_SESSION['dados_alternativos']['telefone'];
        } else {
            // considera o endereço cadastrado no DB
            $cliente = new Clientes();
            $dados_cliente = $cliente->buscar_dados_cliente($_SESSION['cliente']);
            $dados_encomenda['endereco'] = $dados_cliente[0]->endereco;
            $dados_encomenda['cidade'] = $dados_cliente[0]->cidade;
            $dados_encomenda['email'] = $dados_cliente[0]->email;
            $dados_encomenda['telefone'] = $dados_cliente[0]->telefone;
        }
        // Código da encomenda
        $dados_encomenda['codigo_encomenda'] = $_SESSION['codigo_encomenda'];
        // Status inicial PENDENTE
        // PENDENTE
        // PAGO
        // EM TRATAMENTO
        // ENVIADA
        // CANCELADO
        // ENTREGUE

        // Status
        $dados_encomenda['status'] = 'PENDENTE';
        $dados_encomenda['mensagem'] = '';

        // Reduz a quantidade de produtos no estoque 
        $produtos->reduz_produto_estoque($_SESSION['carrinho']);



        // Dados dos produtos
        $dados_produtos = [];
        foreach ($produtos_da_encomenda as $produto) {
            $dados_produtos[] = [
                'designacao_produto' => $produto->nome,
                'preco_unidade' => $produto->preco,
                'quantidade' => $_SESSION['carrinho'][$produto->id_produto],
            ];
        }

        // Limpar todos os dados da encomenda que estão no carrinho
        unset($_SESSION['carrinho']);
        unset($_SESSION['valor_total']);
        unset($_SESSION['codigo_encomenda']);
        unset($_SESSION['dados_alternativos']);


        $encomenda = new Encomendas();
        $encomenda->guardar_encomenda($dados_encomenda, $dados_produtos);

        // Aprensentar mensagem sobre encomenda confirmada
        Store::Layout([
            'layouts/html_header',
            'header',
            'encomenda_confirmada',
            'footer',
            'layouts/html_footer',
        ], $dados);
    }

    //============================================================
    public function residencia_alternativa()
    {
        // recebe os dados via AJAX(axios)
        $post = json_decode(file_get_contents('php://input'), true);
        $_SESSION['dados_alternativos'] = [
            'residencia' => $post['text_residencia'],
            'cidade' => $post['text_cidade'],
            'email' => $post['text_email'],
            'telefone' => $post['text_telefone'],
        ];
    }
}
