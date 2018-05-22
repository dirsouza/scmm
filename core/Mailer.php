<?php

namespace Core;

use Slim\Slim;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer
{
    const USERNAME = "scmm.suporte@gmail.com";
    const PASSWORD = "@dm1n1st4@d04";
    const NAME_FROM = "SCMM";

    private $mail;

    public function __construct($toAddress, $toName, $subject, array $data = array())
    {
        // Template do E-mail
        /**/
        ob_start();
        require_once(APP_PATH . '/forgot/forgot.php');
        $html = ob_get_contents();
        ob_end_clean();
        
        // Cria uma nova instância do PHPMailer
        $this->mail = new PHPMailer(true);

        // Habilita o uso do SMTP
        $this->mail->isSMTP();

        /**
         * Ativar depuração de SMTP
         * 0 - off
         * 1 - on para cliente
         * 2 - on para cliente e servidor
         */
        $this->mail->SMTPDebug = 0;

        // Definição de CharSet
        $this->mail->CharSet = 'UTF-8';

        // Solicitar saída de depuração compatível com HTML
        $this->mail->Debugoutput = 'html';

        // Definir o nome do host do servidor de email
        $this->mail->Host = 'smtp.gmail.com';

        // Definir o número da porta SMTP - 587 para TLS autenticado, submissão SMTP a.k.a. RFC4409
        $this->mail->Port = 587;

        // Definir o sistema de criptografia para usar - ssl (reprovado) ou tls
        $this->mail->SMTPSecure = 'tls';

        // Se deseja usar a autenticação SMTP
        $this->mail->SMTPAuth = true;

        // Nome de usuário para usar na autenticação SMTP
        $this->mail->Username = Mailer::USERNAME;

        // Senha para usar para autenticação SMTP
        $this->mail->Password = Mailer::PASSWORD;

        // Defina para quem a mensagem deve ser enviada
        $this->mail->setFrom(Mailer::USERNAME, Mailer::NAME_FROM);

        // Defina para quem a mensagem deve ser enviada
        $this->mail->addAddress($toAddress, $toName);

        // Definir a linha de assunto
        $this->mail->Subject = $subject;

        // converte HTML em um corpo alternativo de texto simples básico
        $this->mail->msgHTML($html);

        // Substitua o corpo do texto simples por um criado manualmente
        $this->mail->AltBody = 'E-mail de Recuperação de Senha no SCMM';
    }

    // envia a mensagem
    public function send()
    {
        return $this->mail->send();
    }
}