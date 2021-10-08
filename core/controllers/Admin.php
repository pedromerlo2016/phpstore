<?php

namespace core\controllers;

use core\classes\EnviarEmail;
use core\classes\PDF;
use core\classes\Store;
use core\models\Admin as ModelsAdmin;
use core\models\Database;
use core\models\Produtos;

class Admin
{
    //=============================================================
    // senha admin1@teste.com e admin2@teste.com
    // $2y$10$6OVgc./1NbJs/RAU8QJWXuVdB0hcDJI57KDVSC9rS7Pe8QrjQxlHC
    // senha 123456
    //=============================================================
    public function index()
    {
        //temp
        // echo password_hash('123456', PASSWORD_DEFAULT);
        // die();
        // verifica se já exite sessão aberta
        if (!Store::adminLogado()) {
            Store::redirect('admin_login', true);
            return;
        }

        // verificar se exitem encomendas com status=PENDENTES
        $admin = new ModelsAdmin();
        $total_encomendas_pendentes = $admin->total_encomendas_pendente();
        $total_encomendas_em_processamento = $admin->total_encomendas_em_processamento();

        $dados = [
            'total_encomendas_pendentes' => $total_encomendas_pendentes,
            'total_encomendas_em_processamento' => $total_encomendas_em_processamento
        ];




        // $dados =[
        //     'encomendas_pendentes'=> $encomendas_pendentes,
        // ]; 
        // já existe un admin logado
        // apresenta a pagina inicial do backoffice
        Store::Layout_admin([
            'admin/layouts/html_header',
            'admin/header',
            'admin/home',
            'admin/footer',
            'admin/layouts/html_footer',
        ], $dados);
    }
    //============================================================
    public function admin_login()
    {
        if (Store::adminLogado()) {
            Store::redirect('inicio', true);
            return;
        }
        // apresenta a pagina de login
        Store::Layout_admin([
            'admin/layouts/html_header',
            'admin/header',
            'admin/login_frm',
            'admin/footer',
            'admin/layouts/html_footer',
        ]);
    }

    //============================================================
    public function admin_login_submit()
    {
        // verifica se já exite um usuario logado
        if (Store::adminLogado()) {
            Store::redirect('inicio', true);
            return;
        }

        // valida se as informações chegaram corretamente preenchidas
        if (
            !isset($_POST['text_admin']) ||
            !isset($_POST['text_senha']) ||
            !filter_var(trim($_POST['text_admin']), FILTER_VALIDATE_EMAIL)
        ) {
            // erro de preenchimento de formulário
            $_SESSION['erro'] = 'login inválido';
            Store::redirect('admin_login', true);
            return;
        }
        // prepara dados para o model
        $email_admin = trim(strtolower($_POST['text_admin']));
        $senha = trim($_POST['text_senha']);

        $admin = new ModelsAdmin();
        $resultado = $admin->validar_login($email_admin, $senha);
        if (is_bool($resultado)) {
            // login inválido
            $_SESSION['erro'] = 'login invalido';
            Store::redirect('login', true);
            return;
        } else {
            if (!password_verify($senha, $resultado->senha)) {
                // senha incorreta
                $_SESSION['erro'] = 'login invalido';
                Store::redirect('login', true);
                return;
            }
            // login válido
            $_SESSION['admin'] = $resultado->id_admin;
            $_SESSION['usuario'] = $resultado->usuario;
            // redireciona para pagina inicial do backoffice
            Store::redirect('inicio', true);
        }
    }

    //============================================================
    public function admin_logout()
    {
        // faz o logout do admin na sessão

        unset($_SESSION['admin']);
        unset($_SESSION['admin_usuario']);
        unset($_SESSION['usuario']);
        Store::redirect('inicio', true);
        return;
    }

    //============================================================
    // Cleintes
    //============================================================

    //============================================================
    public function lista_clientes()
    {

        // verifica se já exite um usuario logado
        if (!Store::adminLogado()) {
            Store::redirect('inicio', true);
            return;
        }

        // pegar alista de clientes
        $clientes = ModelsAdmin::lista_clientes();
        $dados = [
            'clientes' => $clientes
        ];


        // apresenta a pagina das encomendas
        Store::Layout_admin([
            'admin/layouts/html_header',
            'admin/header',
            'admin/lista_clientes',
            'admin/footer',
            'admin/layouts/html_footer',
        ], $dados);
    }

    //============================================================
    public function detalhe_cliente()
    {
        // verifica se já exite um usuario logado
        if (!Store::adminLogado()) {
            Store::redirect('inicio', true);
            return;
        }
        // verifica se exite um id de cliente 
        if (!isset($_GET['c'])) {
            Store::redirect('inicio', true);
            return;
        };

        $id_cliente = Store::aesDesencriptar($_GET['c']);
        // testa se o id_cliente é válido
        if (empty($id_cliente)) {
            Store::redirect('inicio', true);
            return;
        };


        $cliente_detalhe =  ModelsAdmin::detalhe_cliente($id_cliente);
        $total_encomendas = ModelsAdmin::total_encomendas($id_cliente);
        $dados = [
            'cliente_detalhe' => $cliente_detalhe,
            'total_encomendas' => $total_encomendas
        ];

        // apresenta a pagina das encomendas
        Store::Layout_admin([
            'admin/layouts/html_header',
            'admin/header',
            'admin/detalhe_cliente',
            'admin/footer',
            'admin/layouts/html_footer',
        ], $dados);
    }

    //============================================================
    public function cliente_alterar_status_ativar()
    {
        // verifica se já exite um usuario logado
        if (!Store::adminLogado()) {
            Store::redirect('inicio', 1);
            return;
        }
        // verifica se exite um id de cliente 
        if (!isset($_GET['c'])) {
            Store::redirect('inicio', true);
            return;
        };

        $id_cliente = Store::aesDesencriptar($_GET['c']);

        ModelsAdmin::altera_status_cliente(true,  $id_cliente);

        return Store::redirect('detalhe_cliente&c='.$_GET['c'], true);

    }

     //============================================================
     public function cliente_alterar_status_desativar()
     {
         // verifica se já exite um usuario logado
         if (!Store::adminLogado()) {
             Store::redirect('inicio', true);
             return;
         }
         // verifica se exite um id de cliente 
         if (!isset($_GET['c'])) {
             Store::redirect('inicio', true);
             return;
         };
 
         $id_cliente = Store::aesDesencriptar($_GET['c']);
 
         ModelsAdmin::altera_status_cliente(0,  $id_cliente);
         return Store::redirect('detalhe_cliente&c='.$_GET['c'], true);
     }

      //============================================================
      public function cliente_excluir()
      {
          // verifica se já exite um usuario logado
          if (!Store::adminLogado()) {
              Store::redirect('inicio', true);
              return;
          }
          // verifica se exite um id de cliente 
          if (!isset($_GET['c'])) {
              Store::redirect('inicio', true);
              return;
          };
  
          $id_cliente = Store::aesDesencriptar($_GET['c']);
  
          ModelsAdmin::cliente_excluir( $id_cliente);
          return Store::redirect('detalhe_cliente&c='.$_GET['c'], true);
      }

    //============================================================
    // Encomendas
    //============================================================

    //============================================================
    public function cliente_historico_encomendas()
    {
        // verifica se já exite um usuario logado
        if (!Store::adminLogado()) {
            Store::redirect('inicio', true);
            return;
        }
        // verifica se exite um id de cliente 
        if (!isset($_GET['c'])) {
            Store::redirect('inicio', true);
            return;
        };

        $id_cliente = Store::aesDesencriptar($_GET['c']);
        // testa se o id_cliente é válido
        if (empty($id_cliente)) {
            Store::redirect('inicio', true);
            return;
        };


        $cliente_historico_encomendas  = ModelsAdmin::cliente_historico_encomendas($id_cliente);
        $cliente = ModelsAdmin::detalhe_cliente($id_cliente);
        $dados = [
            'cliente_historico_encomendas' => $cliente_historico_encomendas,
            'cliente' => $cliente,
        ];
        // apresenta a pagina das encomendas
        Store::Layout_admin([
            'admin/layouts/html_header',
            'admin/header',
            'admin/cliente_historico_encomendas',
            'admin/footer',
            'admin/layouts/html_footer',
        ], $dados);
    }

    //============================================================
    public function detalhe_encomenda()
    {
        // verifica se já exite um usuario logado
        if (!Store::adminLogado()) {
            Store::redirect('inicio', true);
            return;
        }
        // verifica se exite um id de cliente 
        if (!isset($_GET['e'])) {
            Store::redirect('inicio', true);
            return;
        };

        $id_encomenda = Store::aesDesencriptar($_GET['e']);
        if (gettype($id_encomenda) != 'string') {
            Store::redirect('inicio', true);
            return;
        }

        $dados =  ModelsAdmin::detalhe_encomenda($id_encomenda);

        // apresenta a pagina das encomendas
        Store::Layout_admin([
            'admin/layouts/html_header',
            'admin/header',
            'admin/encomenda_detalhe',
            'admin/footer',
            'admin/layouts/html_footer',
        ], $dados);
    }

    //============================================================
    public function lista_encomendas()
    {
        // verifica se exite filtro na query STRING
        $filtros = [
            'pendente' => 'PENDENTE',
            'em_processamento' => 'EM_PROCESSAMENTO',
            'cancelada' => 'CANCELADO',
            'enviada' => 'ENVIADA',
            'concluida' => 'CONCLUIDA',
        ];

        $filtro = "";
        $id_cliente = null;
        if (isset($_GET['f'])) {
            // verifica se a variavel é uma key dos filtros
            if (key_exists($_GET['f'], $filtros)) {
                $filtro = $filtros[$_GET['f']];
            }
        }
        // busca o id_cliente se existir na query string
        if (isset($_GET['c'])) {
            $id_cliente = Store::aesDesencriptar($_GET['c']);
            // verifica se id_cliente é valido
            if (gettype($id_cliente) != "string") {
                Store::redirect('inicio', true);
            };
        }
        // carregamento dos dados
        $admin_model = new ModelsAdmin();
        $lista_encomendas = $admin_model->lista_encomendas($filtro, $id_cliente);
        //Store::printData($lista_encomendas);
        $dados = [
            'lista_encomendas' => $lista_encomendas,
            'filtro' => $filtro,
        ];

        // apresenta a pagina das encomendas
        Store::Layout_admin([
            'admin/layouts/html_header',
            'admin/header',
            'admin/lista_encomendas',
            'admin/footer',
            'admin/layouts/html_footer',
        ], $dados);
    }

    //============================================================
    public function encomenda_alterar_status()
    {
        $status = null;
        // Verifica se veio um status na query string
        if (isset($_GET['s'])) {
            $status = $_GET['s'];
            // Substitui o espaço por underline
            $status = str_replace(' ', '_', $status);
        } else {
            Store::redirect('inicio', true);
            return;
        };

        // Verifica se o status esta definido
        if (!in_array($status, STATUS)) {
            Store::redirect('inicio', true);
            return;
        }




        // Atualiza o status da encomenda
        $id_encomenda = Store::aesEncriptar($id_encomenda = $_GET['e']);
        if (!ModelsAdmin::altera_status_encomenda($id_encomenda, $status)) {
            $_SESSION['erro'] = "Encomenda cancelada não pode ser modificada!";
            Store::redirect('detalhe_encomenda&e=' . $id_encomenda, true);
        }

        // executar ações após alteração do status
        switch ($status) {
            case 'PENDENTE':
                // não exitem ações
                break;
            case 'EM_PROCESSAMENTO':
                // não exitem ações
                break;
            case 'ENVIADA':
                //  enviar e-mail com notificação 
                if (EMAIL_ENVIAR == true) {
                    $this->operacao_enviar_email_encomenda_enviada($id_encomenda);
                }

                break;
            case 'CANCELADO':
                // CANCELADO para encomenda com devolução do estoque e bloqueio de nova alteração de status
                $produtos = new Produtos();
                $produtos->repoe_estoque_encomenda_cancelada($id_encomenda);
                if (EMAIL_ENVIAR == true) {
                    $email = new EnviarEmail();
                    $email->enviar_email_cancelamento_encomenda($id_encomenda);
                }

                break;
            case 'CONCLUIDA':
                // não exitem ações
                break;
        }

        // Redireciona para a pagina da proria encomenda
        Store::redirect('detalhe_encomenda&e=' . $id_encomenda, true);
    }

    //============================================================
    // Operações privadas após mudanças de status
    //============================================================


    //============================================================

    private function operacao_enviar_email_encomenda_enviada($id_encomenda)
    {
        // executar as operações para enviar e-mail ao cliente

    }

    //============================================================
    public function criar_pdf_encomenda()
    {
        $id_encomenda = null;
        if (!isset($_GET['e'])) {
            Store::redirect('inicio', true);
            return;
        }
        $id_encomenda = Store::aesDesencriptar($_GET['e']);
        if (gettype($id_encomenda) != 'string') {
            Store::redirect('inicio', true);
            return;
        }

        // obter as informações da encomenda
        $admin = new ModelsAdmin();
        $encomenda = $admin->detalhe_encomenda($id_encomenda);

        // echo"<pre>";
        //  var_dump ($encomenda['encomenda']->nome_completo);
        // echo"</pre>";

        // die();

        // criar o pdf
        $pdf =  new PDF();
        $pdf->set_template(getcwd() . '/assets/templates_pdf/encomenda_em_processamento.pdf');
        // preparar as opções base
        $pdf->set_texto_familia('Arial');
        $pdf->set_texto_tamanho('16px');
        $pdf->set_texto_tipo('bold');

        // data da encomenda
        $pdf->posicao_dimensao(305, 244, 120, 24);
        $pdf->escrever(date('d/m/Y', strtotime($encomenda['encomenda']->data_encomenda)));
        // codigo encomenda
        $pdf->posicao_dimensao(600, 244, 120, 24);
        $pdf->escrever($encomenda['encomenda']->codigo_encomenda);
        // nome completo
        $pdf->posicao_dimensao(87, 305, 500, 24);
        $pdf->escrever($encomenda['encomenda']->nome_completo);
        // Endereço - Cidade
        $pdf->posicao_dimensao(87, 330, 400, 24);
        $pdf->escrever($encomenda['encomenda']->residencia . " - " . $encomenda['encomenda']->cidade);
        // e-mail e telefone
        $pdf->posicao_dimensao(87, 355, 400, 24);
        $pdf->escrever($encomenda['encomenda']->email . ($encomenda['encomenda']->telefone == null ? '' : ' - ' . $encomenda['encomenda']->telefone));

        // lista dos profutos encomendados
        // quantidade x produtos ----- total
        $y = 450; // incrementando por linha 25
        $total = 0;
        foreach ($encomenda['lista_produtos'] as $produto) :
            $pdf->posicao_dimensao(87, $y, 500, 24);
            $pdf->set_texto_tipo('normal');
            $pdf->set_alinhamento('left');
            $pdf->escrever($produto->quantidade . ' x ' . $produto->descricao_produto);
            $pdf->posicao_dimensao(600, $y, 150, 24);
            $pdf->set_alinhamento('right');
            $pdf->escrever('R$ ' . number_format($produto->preco_unidade, 2, ',', '.'));
            $y += 25;
            $total += ($produto->preco_unidade * $produto->quantidade);
        endforeach;

        // Apresenta o total
        // posiçãop y = 840
        $pdf->posicao_dimensao(87, $y, 500, 24);
        $pdf->set_texto_tamanho('20px');
        $pdf->set_texto_tipo('bold');
        $pdf->set_alinhamento('right');
        $pdf->set_cor('white');
        $pdf->posicao_dimensao(87, 843, 660, 24);
        $pdf->escrever('Total da encomenda: R$ ' . number_format($total, 2, ',', '.'));
        // apresentar pdf

        $pdf->apresentar_pdf();
    }

    //============================================================
    public function enviar_pdf_encomenda()
    {
        $id_encomenda = null;
        if (!isset($_GET['e'])) {
            Store::redirect('inicio', true);
            return;
        }
        $id_encomenda = Store::aesDesencriptar($_GET['e']);
        if (gettype($id_encomenda) != 'string') {
            Store::redirect('inicio', true);
            return;
        }

        // obter as informações da encomenda
        $admin = new ModelsAdmin();
        $encomenda = $admin->detalhe_encomenda($id_encomenda);

        // criar o pdf
        $pdf =  new PDF();
        $pdf->set_template(getcwd() . '/assets/templates_pdf/encomenda_em_processamento.pdf');
        // preparar as opções base
        $pdf->set_texto_familia('Arial');
        $pdf->set_texto_tamanho('16px');
        $pdf->set_texto_tipo('bold');

        // data da encomenda
        $pdf->posicao_dimensao(305, 244, 120, 24);
        $pdf->escrever(date('d/m/Y', strtotime($encomenda['encomenda']->data_encomenda)));
        // codigo encomenda
        $pdf->posicao_dimensao(600, 244, 120, 24);
        $pdf->escrever($encomenda['encomenda']->codigo_encomenda);
        // nome completo
        $pdf->posicao_dimensao(87, 305, 500, 24);
        $pdf->escrever($encomenda['encomenda']->nome_completo);
        // Endereço - Cidade
        $pdf->posicao_dimensao(87, 330, 400, 24);
        $pdf->escrever($encomenda['encomenda']->residencia . " - " . $encomenda['encomenda']->cidade);
        // e-mail e telefone
        $pdf->posicao_dimensao(87, 355, 400, 24);
        $pdf->escrever($encomenda['encomenda']->email . ($encomenda['encomenda']->telefone == null ? '' : ' - ' . $encomenda['encomenda']->telefone));

        // lista dos profutos encomendados
        // quantidade x produtos ----- total
        $y = 450; // incrementando por linha 25
        $total = 0;
        foreach ($encomenda['lista_produtos'] as $produto) :
            $pdf->posicao_dimensao(87, $y, 500, 24);
            $pdf->set_texto_tipo('normal');
            $pdf->set_alinhamento('left');
            $pdf->escrever($produto->quantidade . ' x ' . $produto->descricao_produto);
            $pdf->posicao_dimensao(600, $y, 150, 24);
            $pdf->set_alinhamento('right');
            $pdf->escrever('R$ ' . number_format($produto->preco_unidade, 2, ',', '.'));
            $y += 25;
            $total += ($produto->preco_unidade * $produto->quantidade);
        endforeach;

        // Apresenta o total
        // posiçãop y = 840
        $pdf->posicao_dimensao(87, $y, 500, 24);
        $pdf->set_texto_tamanho('20px');
        $pdf->set_texto_tipo('bold');
        $pdf->set_alinhamento('right');
        $pdf->set_cor('white');
        $pdf->posicao_dimensao(87, 843, 660, 24);
        $pdf->escrever('Total da encomenda: R$ ' . number_format($total, 2, ',', '.'));
        // configura permissões e proteção
        $permissoes = [
            //'copy',
            'print',
            //'modify',
            //'annot_forms',
            //'fill_forms',
            //'extraxt',
            //'assemble',
            //'print-highres',

        ];


        $pdf->set_permissoes($permissoes);

        // guardar pdf
        $arquivo = $encomenda['encomenda']->codigo_encomenda . '_' . date('YmdHis') . '.pdf';
        $pdf->gravar_pdf($arquivo);

        // enviar o email com o arquivo em anexo
        $enviarEmail =  new EnviarEmail;
        $reultado =  $enviarEmail->enviar_enviar_pdf_encomenda_para_cliente($encomenda['encomenda']->email, $arquivo);

        if ($reultado) {
            unlink(PDF_PATH . $arquivo);
            // retorn para a pagina do detalhe da encomenda
            Store::redirect('detalhe_encomenda&e=' . $_GET['e'], true);
        } else {
            echo 'Ocorreu um erro';
        }
    }


    //============================================================
    // Operações com estoque 
    //============================================================

    //============================================================
    public function lista_produtos_estoque()
    {
        // verifica se já exite um usuario logado
        if (!Store::adminLogado()) {
            Store::redirect('inicio', true);
            return;
        }

        $produtos =  new Produtos();

        $dados  = $produtos->lista_todo_estoque();

        // apresenta a pagina das encomendas
        Store::Layout_admin([
            'admin/layouts/html_header',
            'admin/header',
            'admin/lista_estoque',
            'admin/footer',
            'admin/layouts/html_footer',
        ], $dados);
    }

    //============================================================
    public function detalhe_produto_estoque()
    {
        // verifica se já exite um usuario logado
        if (!Store::adminLogado()) {
            Store::redirect('inicio', true);
            return;
        }

        // verifica se exite um item na query string
        if (!isset($_GET['i'])) {
            Store::redirect('inicio', true);
            return;
        }

        $id_produto = Store::aesDesencriptar($_GET['i']);
        if (gettype($id_produto) != 'string') {
            Store::redirect('inicio', true);
            return;
        }

        $produto =  new Produtos();

        $dados = $produto->detalhe_item_estoque($id_produto)[0];

        Store::Layout_admin([
            'admin/layouts/html_header',
            'admin/header',
            'admin/detalhe_item_estoque',
            'admin/footer',
            'admin/layouts/html_footer',
        ], $dados);
    }

    //============================================================
    public function detalhe_produto_estoque_submit()
    {

        // verifica se já exite um usuario logado
        if (!Store::adminLogado()) {
            Store::redirect('inicio', true);
            return;
        }

        // verifica se a origem da requisição foI um POST
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            Store::redirect('inicio', true);
            return;
        }

        // verifica se a requisição POST possui informações
        if (!isset($_POST)) {
            Store::redirect('inicio', true);
            return;
        }

        $dados = [
            'id_produto' => $_POST['text_id_produto'],
            'categoria' => $_POST['text_categoria'],
            'nome' => $_POST['text_nome'],
            'descricao' => $_POST['text_descricao'],
            'preco' => $_POST['text_preco'],
            'stock' => $_POST['text_stock'],
            'visivel' => isset($_POST['ckb_visivel']) ? 1 : 0,
            'imagem' => isset($_FILES['imagem']) ? $_FILES['imagem']['name'] : '',
        ];


        $produto_estoque  =  new Produtos();
        $produto_estoque->altera_produto_estoque($dados);
        $id_produto = Store::aesEncriptar($_POST['text_id_produto']);

        $_SESSION['msg'] = 'Item de estoque alterado com sucesso!';
        Store::redirect("detalhe_produto_estoque&i=$id_produto", true);
    }

    //============================================================
    public function cadastrar_novo_produto_estoque()
    {
        // Cadastro de novo produto no estoque
        // verifica se já exite um usuario logado
        if (!Store::adminLogado()) {
            Store::redirect('inicio', true);
            return;
        }
        Store::Layout_admin([
            'admin/layouts/html_header',
            'admin/header',
            'admin/cadastrar_novo_produto_estoque',
            'admin/footer',
            'admin/layouts/html_footer',
        ]);
    }
    //============================================================
    public function cadastrar_novo_produto_estoque_submit()
    {
        // Cadastro de novo produto no estoque
        // verifica se já exite um usuario logado
        if (!Store::adminLogado()) {
            Store::redirect('inicio', true);
            return;
        }

        // verifica se a origem da requisição foI um POST
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            Store::redirect('inicio', true);
            return;
        }

        //verifica se exite informação no $_POST

        // verifica se a requisição POST possui informações
        if (!isset($_POST)) {
            Store::redirect('inicio', true);
            return;
        }

        $dados = [
            'id_produto' => 0,
            'categoria' => $_POST['text_categoria'],
            'nome' => $_POST['text_nome'],
            'descricao' => $_POST['text_descricao'],
            'preco' => $_POST['text_preco'],
            'stock' => $_POST['text_stock'],
            'visivel' => isset($_POST['ckb_visivel']) ? 1 : 0,
            'imagem' => isset($_FILES['imagem']) ? $_FILES['imagem']['name'] : '',
        ];

        // Store::printData($dados);

        $produto_estoque  =  new Produtos();
        $produto_estoque->cadastra_produto_estoque($dados);

        Store::redirect('lista_produtos_estoque', true);

        // Store::Layout_admin([
        //     'admin/layouts/html_header',
        //     'admin/header',
        //     'admin/lista_produtos_estoque',
        //     'admin/footer',
        //     'admin/layouts/html_footer',
        // ]);

    }
}
