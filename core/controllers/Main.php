<?php

namespace core\controllers;

use core\classes\Database;
use core\classes\EnviarEmail;
use core\classes\Store;
use core\models\Clientes;
use core\models\Produtos;

class Main
{
    //============================================================
    public function index()
    {

        // apresenta a pagina inicial
        Store::Layout([
            'layouts/html_header',
            'header',
            'inicio',
            'footer',
            'layouts/html_footer',
        ]);
    }
    //============================================================
    public function loja()
    {
        // apresenta a pagina da loja

        // buscar a lista de produtos disponíveis
        $produtos = new Produtos();
        // analisa que categoria ira mostrar

        $c = "todos";
        if (isset($_GET['c'])) {
            $c = $_GET['c'];
        };

        $lista_produtos = $produtos->lista_produtos_disponiveis($c);
        $lista_categorias = $produtos->lista_categorias();
        $dados = [
            'produtos' => $lista_produtos,
            'categorias' => $lista_categorias
        ];
        //Store::printData($lista_produtos);
        Store::Layout([
            'layouts/html_header',
            'header',
            'loja',
            'footer',
            'layouts/html_footer',
        ], $dados);
    }
    //============================================================
    public function novo_cliente()
    {
        // apresenta a pagina para novo cliente

        // verifica se existe um cliente logado
        if (Store::clienteLogado()) {
            $this->index();
            return;
        }

        Store::Layout([
            'layouts/html_header',
            'header',
            'criar_cliente',
            'footer',
            'layouts/html_footer',
        ]);
    }

    public function criar_cliente()
    {

        // verifica se existe um cliente logado
        if (Store::clienteLogado()) {
            $this->index();
            return;
        }

        // verifica ocorreu um submit
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            $this->index();
            return;
        }

        // Criação e registro na db

        // Verifica se txt_senha_1 ==  txt_senha_2
        if ($_POST['text_senha_1'] != $_POST['text_senha_2']) {
            // as senha são diferentes
            $_SESSION['erro'] = 'As senhas não estão iguais.';
            $this->novo_cliente();
            return;
        }

        $cliente = new Clientes;
        if ($cliente->verificar_email_registrado($_POST['text_email'])) {
            $_SESSION['erro'] = 'O já existe um cliente com este e-mail.';
            $this->novo_cliente();
        }

        $purl = $cliente->registar_cliente();
        // criar um link purl

        // enviar um email para o cliente


        // apresentar uma mensagem indicando para validar seu e-mail
        $enviarEmail =  new EnviarEmail;
        $reultado =  $enviarEmail->enviar_email_confirmacao_novo_cliente(strtolower(trim($_POST['text_email'])), $purl);
        if ($reultado) {
            // apresenta a pagina do cliente criado com sucesso
            Store::Layout([
                'layouts/html_header',
                'header',
                'criar_cliente_sucesso',
                'footer',
                'layouts/html_footer',
            ]);
            return;
        } else {
            echo 'Ocorreu um erro';
        }
    }
    //============================================================
    public function confirmar_email()
    {
        // verifica se existe um cliente logado
        if (Store::clienteLogado()) {
            $this->index();
            return;
        }

        // Verificar se exite na query string um purl
        if (!isset($_GET['purl'])) {
            $this->index();
            return;
        }
        $purl  = $_GET['purl'];
        // verifica se o purl válido
        if (strlen($purl) != 12) {
            $this->index();
            return;
        }

        $cliente = new Clientes;
        $resultado = $cliente->validar_email($purl);
        // apresentar o layout para informar que a conta foi validada
        if ($resultado) {
            Store::Layout([
                'layouts/html_header',
                'header',
                'conta_confirmada',
                'footer',
                'layouts/html_footer',
            ]);
        } else {
            // Redirecionar para a pagina inicial
            Store::redirect();
            return;
        }
    }
    //============================================================
    public function login()
    {
        // verifica se existe um cliente logado
        if (Store::clienteLogado()) {
            Store::redirect();
            return;
        }
        // Apresenta o formulario de login
        Store::Layout([
            'layouts/html_header',
            'header',
            'login_frm',
            'footer',
            'layouts/html_footer',
        ]);
    }
    //============================================================
    public function login_submit()
    {
        // verifica se já exite um cliente logado
        if (Store::clienteLogado()) {
            Store::redirect();
            return;
        }
        // verifica se foi efetuado um post do formulario de login
        if ($_SERVER['REQUEST_METHOD'] != "POST") {
            Store::redirect();
            return;
        }
        // Verifica se o login é válido
        // Validar se os campos vieram corretamente preenchidos
        if (
            !isset($_POST['text_usuario']) ||
            !isset($_POST['text_senha']) ||
            !filter_var(trim($_POST['text_usuario']), FILTER_VALIDATE_EMAIL)
        ) {
            // erro de preenchimento de formulario
            $_SESSION['erro'] = 'Login inválido';
            Store::redirect('login');
            return;
        }

        // Consultar ao DB
        // prepara os dados para o modelo
        $email = trim(strtolower($_POST['text_usuario']));
        $senha = trim(strtolower($_POST['text_senha']));
        // carrega o model e verifica se o login é válido
        $cliente  = new Clientes();
        $resultado = $cliente->validar_login($email, $senha);
        // analisa o resultado

        if (is_bool($resultado)) {
            // Login Inválido
            Store::redirect('login');
            return;
        } else {
            // Criar sessão de cliente
            $_SESSION['cliente'] = $resultado->id_cliente;
            $_SESSION['usuario'] = $resultado->email;
            $_SESSION['nome_cliente'] = $resultado->nome_completo;


            if (isset($_SESSION['tmp_carrinho'])) {
                // remove a variavel da sessão e redireciona para o resumo da encomenda
                unset($_SESSION['tmp_carrinho']);
                Store::redirect('finalizar_encomenda_resumo');
                return;
            } else {
                // redireciona para a loja
                Store::redirect();
                return;
            }
        }
    }

    //============================================================
    public function logout()
    {
        // remove as variaveis de sessão
        // Criar sessão de cliente
        unset($_SESSION['cliente']);
        unset($_SESSION['usuario']);
        unset($_SESSION['nome_cliente']);
        Store::redirect();
        return;
    }

    //============================================================
    // Perfil do usuário
    //============================================================

    public function perfil()
    {
        // verifica se exite um cliente logado
        if (!Store::clienteLogado()) {
            Store::redirect();
            return;
        }
        // carrega informações do cliente
        $cliente  = new Clientes();
        // $dados =[
        //     'dados_cliente' => $cliente->buscar_dados_cliente($_SESSION['cliente'])
        // ];
        // Apresenta o paginal de perfil

        $dtemp = $cliente->buscar_dados_cliente($_SESSION['cliente']);
        $dados_cliente = [
            'Email' => $dtemp[0]->email,
            'Nome completo' => $dtemp[0]->nome_completo,
            'Endereço' => $dtemp[0]->endereco,
            'Cidade' => $dtemp[0]->cidade,
            'Telefone' => $dtemp[0]->telefone,
        ];
        $dados = [
            'dados_cliente' => $dados_cliente,
        ];


        Store::Layout([
            'layouts/html_header',
            'header',
            'perfil_navegacao',
            'perfil',
            'footer',
            'layouts/html_footer',
        ], $dados);
    }

    //============================================================
    public function alterar_dados_pessoais()
    {
        // verifica se exite um cliente logado (midlleware do Laravel)
        if (!Store::clienteLogado()) {
            Store::redirect();
            return;
        }
        // carrega informações do cliente
        $cliente  = new Clientes();
        $dtemp = $cliente->buscar_dados_cliente($_SESSION['cliente'])[0];
        $dados_pessoais = [
            'email' => $dtemp->email,
            'nome_completo' => $dtemp->nome_completo,
            'endereco' => $dtemp->endereco,
            'cidade' => $dtemp->cidade,
            'telefone' => $dtemp->telefone,
        ];

        $dados = [
            'dados_pessoais' => (object)$dados_pessoais,
        ];

        // Apresenta o paginal de perfil
        Store::Layout([
            'layouts/html_header',
            'header',
            'perfil_navegacao',
            'alterar_dados_pessoais',
            'footer',
            'layouts/html_footer',
        ], $dados);
    }

    //============================================================
    public function alterar_dados_pessoais_submit()
    {
        // verifica se exite um cliente logado (midlleware do Laravel)
        if (!Store::clienteLogado()) {
            Store::redirect();
            return;
        }
        // verificar a submissão do formulário
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            Store::redirect();
            return;
        }
        // validar dados
        $email = trim(strtolower($_POST['text_email']));
        $nome_completo = trim($_POST['text_nome_completo']);
        $endereco = trim($_POST['text_endereco']);
        $cidade = trim($_POST['text_cidade']);
        $telefone = trim($_POST['text_telefone']);

        // validar se é email válido
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['erro'] = "Endereço de e-mail inválido.";
            $this->alterar_dados_pessoais();
            return;
        }

        // vai buscar os dados pessoais no db
        $cliente = new Clientes();
        $dados = [
            'dados_pessoais' => $cliente->buscar_dados_cliente($_SESSION['cliente'])[0],
        ];

        // validar os restantes dos campos obrigatórios
        if (empty($nome_completo) || empty($endereco) || empty($cidade)) {
            $_SESSION['erro'] = "Preencha corretamente o formulário.";
            $this->alterar_dados_pessoais();
            return;
        }

        // validar se é email está sendo utilizado
        $cliente = new Clientes();
        $exiteEmail = $cliente->verifica_se_email_ja_existe($_SESSION['cliente'], $email);
        if ($exiteEmail == true) {
            $_SESSION['erro'] = "O e-mail já pertence a outro cliente.";
            $this->alterar_dados_pessoais();
            return;
        }

        // Atualizar os dados do cliente no DB
        $cliente->atualizar_dados_cliente($email, $nome_completo, $endereco, $cidade, $telefone);
        // Atualizar os dados na sessão
        $_SESSION['usuario'] = $email;
        $_SESSION['nome_cliente'] = $nome_completo;

        // Apresenta o paginal de perfil
        Store::redirect('perfil');
        return;
    }

    //============================================================
    public function alterar_password()
    {
        // verifica se exite um cliente logado (midlleware do Laravel)
        if (!Store::clienteLogado()) {
            Store::redirect();
            return;
        }

        // Apresenta o paginal de alterar a senha
        Store::Layout([
            'layouts/html_header',
            'header',
            'perfil_navegacao',
            'alterar_password',
            'footer',
            'layouts/html_footer',
        ]);
    }

    //============================================================
    public function alterar_password_submit()
    {
        // verifica se exite um cliente logado (midlleware do Laravel)
        if (!Store::clienteLogado()) {
            Store::redirect();
            return;
        }
        // verificar a submissão do formulário
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            Store::redirect();
            return;
        }
        // validar os dados 
        $senha_atual = trim($_POST['text_senha_atual']);
        $nova_nova_senha = trim($_POST['text_nova_senha']);
        $repetir_nova_senha = trim($_POST['text_repetir_nova_senha']);
        // verifica se a senha atual está correta
        

        // verifica se a nova senha e repetir nova senha são iguais
        if ($nova_nova_senha != $repetir_nova_senha) {
            $_SESSION['erro'] = "Senha e sua repetição são diferentes.";
            $this->alterar_password();
            return;
        }

        echo "alterar password submit";
        Store::printData($_POST);
    }


    //============================================================
    public function historico_encomendas()
    {
        echo "histórico encomendas";
    }
}
