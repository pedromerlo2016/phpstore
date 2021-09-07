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
}
