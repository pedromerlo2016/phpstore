<?php

namespace core\classes;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class EnviarEmail
{
    public function enviar_email_confirmacao_novo_cliente($email_cliente, $purl )
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
            $mail->CharSet    ='UTF-8'; 

            //Emissor e receptor
            $mail->setFrom(EMAIL_FROM, APP_NAME);
            $mail->addAddress($email_cliente);     

            //Assunto
            $mail->isHTML(true);                  
            $mail->Subject = APP_NAME.' - Confirmação de e-mail.';
             //Mensagens
            $html = '<p>Seja  bem vindo a nossa loja '.APP_NAME .'.</p>';
            $html.= '<p>Para pode acessar nosssa loja, é necessário confirmar seu e-mail.</p>';
            $html.= '<p>Para confirmar o e-mail, click no link abaixo: </p>';
            $html.= '<p><a href="'.BASE_URL.'?a=confirmar_email&purl='.$purl.'" >Confirmar E-mail</a></p>';
            $html.= '<p><i><small>'.APP_NAME.'</small></i></p>';
            $mail->Body    = $html;
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

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
            $mail->CharSet    ='UTF-8'; 

            //Emissor e receptor
            $mail->setFrom(EMAIL_FROM, APP_NAME);
            $mail->addAddress($email_cliente);     

            //Assunto
            $mail->isHTML(true);                  
            $mail->Subject = APP_NAME.' - Confirmação de encomenda - '.$dados_encomenda['dados_pagamento']['codigo_encomenda'];
             //Mensagens
            $html = '<p>Este e-mail serve para confirmar a sua encomenda</p>';
            $html.= '<p>Dados da encomenda:</p>';
            // lista dos produtos
            $html.= '<ul>';
            foreach($dados_encomenda['lista_produtos'] as $produto){
                $html.= '<li>'.$produto.'</li>';
            }
            $html.= '</ul>';
            // total
            $html.= '<p>Total: <strong>'.$dados_encomenda['total'].'<strong></p>';
            // dados do pagamento
            $html.='<hr>';
            $html.= '<p>DADOS DE PAGAMENTO:</p>';
            $html.= '<p>Número da conta: <strong>'.$dados_encomenda['dados_pagamento']['numero_da_conta'].'</strong></p>';
            $html.= '<p>Código da encomenda: <strong>'.$dados_encomenda['dados_pagamento']['codigo_encomenda'].'</strong></p>';
            $html.= '<p>Valor a pagar: <strong>'.$dados_encomenda['dados_pagamento']['total'].'</strong></p>';
            $html.='<hr>';
            // nota importante
            $html.= '<p>NOTA: A sua encomenda sómente será processada após o pagamento.</p>';
            $mail->Body    = $html;
            
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
