<?php

namespace core\classes;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class EnviarEmail
{
    //============================================================
    public function enviar_email_confirmacao_novo_cliente($email_cliente, $purl)
    {
        //============================================================
        //Envia um e-mail paa o novo cliente confirma 
        $mail = new PHPMailer(true);

        try {
            //Opções do servidor
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->isSMTP();
            $mail->Host       = EMAIL_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = EMAIL_USER;
            $mail->Password   = EMAIL_PASS;
            $mail->Port       = EMAIL_PORT;
            $mail->CharSet    = 'UTF-8';

            //Emissor e receptor
            $mail->setFrom(EMAIL_FROM, APP_NAME);
            $mail->addAddress($email_cliente);

            //Assunto
            $mail->isHTML(true);
            $mail->Subject = APP_NAME . ' - Confirmação de e-mail.';
            //Mensagens
            $html = '<p>Seja  bem vindo a nossa loja ' . APP_NAME . '.</p>';
            $html .= '<p>Para pode acessar nosssa loja, é necessário confirmar seu e-mail.</p>';
            $html .= '<p>Para confirmar o e-mail, click no link abaixo: </p>';
            $html .= '<p><a href="' . BASE_URL . '?a=confirmar_email&purl=' . $purl . '" >Confirmar E-mail</a></p>';
            $html .= '<p><i><small>' . APP_NAME . '</small></i></p>';
            $mail->Body    = $html;
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    //============================================================
    public function enviar_email_confirmacao_encomenda($email_cliente, $dados_encomenda)
    {
        //============================================================
        //Envia um e-mail para confirmar a encomenda 
        $mail = new PHPMailer(true);


        try {
            //Opções do servidor
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->isSMTP();
            $mail->Host       = EMAIL_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = EMAIL_USER;
            $mail->Password   = EMAIL_PASS;
            $mail->Port       = EMAIL_PORT;
            $mail->CharSet    = 'UTF-8';

            //Emissor e receptor
            $mail->setFrom(EMAIL_FROM, APP_NAME);
            $mail->addAddress($email_cliente);

            //Assunto
            $mail->isHTML(true);
            $mail->Subject = APP_NAME . ' - Confirmação de encomenda - ' . $dados_encomenda['dados_pagamento']['codigo_encomenda'];
            //Mensagens
            $html = '<p>Prezado(a): ' . $dados_encomenda['nome_cliente'] . '</p>';
            $html .= '<p>Este e-mail serve para confirmar a sua encomenda.</p>';
            $html .= '<p>Dados da encomenda:</p>';
            // lista dos produtos
            $html .= '<ul>';
            foreach ($dados_encomenda['lista_produtos'] as $produto) {
                $html .= '<li>' . $produto . '</li>';
            }
            $html .= '</ul>';
            // total
            $html .= '<p>Total: <strong>' . $dados_encomenda['total'] . '<strong></p>';
            // dados do pagamento
            $html .= '<hr>';
            $html .= '<p>DADOS DE PAGAMENTO:</p>';
            $html .= '<p>Número da conta: <strong>' . $dados_encomenda['dados_pagamento']['numero_da_conta'] . '</strong></p>';
            $html .= '<p>Código da encomenda: <strong>' . $dados_encomenda['dados_pagamento']['codigo_encomenda'] . '</strong></p>';
            $html .= '<p>Valor a pagar: <strong>' . $dados_encomenda['dados_pagamento']['total'] . '</strong></p>';
            $html .= '<hr>';
            // nota importante
            $html .= '<p>NOTA: A sua encomenda sómente será processada após o pagamento.</p>';
            $html .= '<p>Caso ' . $dados_encomenda['nome_cliente'] . ' não  seja você, por favor desconsidere a mensagem.</p>';
            $mail->Body    = $html;

            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    //============================================================
    public function envia_email_confirmando_pagamento($encomenda, $totalEncomenda ){
         //============================================================
        //Envia um e-mail para confirmar pagamento 
        $mail = new PHPMailer(true);

        //Store::printData($encomenda);

        try {
            //Opções do servidor
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->isSMTP();
            $mail->Host       = EMAIL_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = EMAIL_USER;
            $mail->Password   = EMAIL_PASS;
            $mail->Port       = EMAIL_PORT;
            $mail->CharSet    = 'UTF-8';

            //Emissor e receptor
            $mail->setFrom(EMAIL_FROM, APP_NAME);
            $mail->addAddress($encomenda->email);
            //$mail->addAddress($resulatdo->);

            //Assunto
            $mail->isHTML(true);
            $mail->Subject = APP_NAME . ' - Confirmação de pagamento ';

            $html = 'TESTE';
            //Mensagens
            $html = '<p>Prezado(a) Cliente. </p>';
            $html .= '<p>Este e-mail serve para confirmar o pagamento de sua encomenda.</p>';
            //Store::printData($encomenda);
            $html .= "<p>Código: <strong> $encomenda->codigo_encomenda</strong></p>";
            $valor = number_format($totalEncomenda->totalEncomenda,2,',','.');
            $html .= "<p>Valor: <strong>R$ $valor </strong></p>";
            
            // dados do pagamento
            $html .= '<hr>';
            $html .= '<p>Sua encomenda já está em processamento e, em breve, enviaremos os dados do envio.</p>';
            $html .= '<p>Desde já agradecemos a preferência.</p>' ;

            $mail->Body    = $html;
            //Store::printData($totalEncomenda->totalEncomenda);
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }

    }

    //============================================================
    public function enviar_enviar_pdf_encomenda_para_cliente($email_cliente, $arquivo)
    {
        //Envia um e-mail paa o novo cliente confirma 
        $mail = new PHPMailer(true);

        try {
            //Opções do servidor
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->isSMTP();
            $mail->Host       = EMAIL_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = EMAIL_USER;
            $mail->Password   = EMAIL_PASS;
            $mail->Port       = EMAIL_PORT;
            $mail->CharSet    = 'UTF-8';

            //Emissor e receptor
            $mail->setFrom(EMAIL_FROM, APP_NAME);
            $mail->addAddress($email_cliente);

            //Assunto
            $mail->isHTML(true);
            $mail->Subject = APP_NAME . ' - Envio de PDF com detalhe de encomenda.';
            //Mensagens
            $html = '<p>Segue em anexo o PDF com os detalhes da encomenda.</p>';
            $html .= '<p><i><small>' . APP_NAME . '</small></i></p>';
            $mail->Body    = $html;
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            // incluir anexo
            $mail->addAttachment(PDF_PATH . $arquivo);

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    
    //============================================================
    public function enviar_email_cancelamento_encomenda($id_encomenda)
    {
        $id_encomenda=Store::aesDesencriptar($id_encomenda);
        $db = new Database();
        $dados = $db->select("SELECT * FROM encomendas WHERE id_encomenda =".$id_encomenda)[0];
        
        //Envia um e-mail para o cliente avisando do cancelamento 
        $mail = new PHPMailer(true);
        try {
            //Opções do servidor
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->isSMTP();
            $mail->Host       = EMAIL_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = EMAIL_USER;
            $mail->Password   = EMAIL_PASS;
            $mail->Port       = EMAIL_PORT;
            $mail->CharSet    = 'UTF-8';

            //Emissor e receptor
            $mail->setFrom(EMAIL_FROM, APP_NAME);
            $mail->addAddress($dados->email);

            //Assunto
            $mail->isHTML(true);
            $mail->Subject = APP_NAME . ' - Notificação de cancelamento de encomenda.';
            //Mensagens
            $html= "<p>Prezado cliente: </p>";
            $html.= "<p>Informamos que sua encomenda código $dados->codigo_encomenda foi cancelada.</p>";
            $html.= "<p>Se for de seu interesse, solicitamos que retorne à loja e refaça seu pedido</p>";
            $html.= '<p><i><small>' . APP_NAME . '</small></i></p>';
            $mail->Body    = $html;
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

          
            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

}
