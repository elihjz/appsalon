<?php
namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email{
    public $email;
    public $nombre;
    public $token;

    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion(){
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host='sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Username='ac7c49566a38e2';
        $mail->Password='7bd373a5c5d92e';
        $mail->SMTPSecure = 'tls';
        $mail->Port=465;

        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com','AppSalon.com');
        $mail->Subject = 'Confirma tu cuenta';

        $mail->isHTML(TRUE);
        $mail->CharSet ='UTF-8';

        $contenido = "<html>";
        $contenido .= "<p>Hola <strong>" .$this->email. "</strong> has creado tu cuenta en AppSalon, confirmala presionando el siguiente enlace</p>";
        $contenido .="<p>Presiona aqui: <a href='http://localhost:3000/confirmar-cuenta?token=".$this->token."'>Confirmar cuenta</a></p>";
        $contenido .= "<p>Si tu no solicitaste este correo, ignoralo.</p>";
        $contenido .= "</html>";
        $mail->Body = $contenido;

        $mail->send();//Enviamos el mail
    }
}