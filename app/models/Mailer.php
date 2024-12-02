<?php

require '../app/vendor/autoload.php'; // Autoload přes Composer, jinak použijte require k přímému importu PHPMailer souborů

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer extends Model
{

    private $mailer;

    public function __construct()
    {
        $this->mailer = new PHPMailer(true);
        $this->mailer->isSMTP();
        $this->mailer->Host = SMTP_HOST;
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = SMTP_USER;
        $this->mailer->Password = SMTP_PASS;
        $this->mailer->Port = SMTP_PORT;

        $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $this->mailer->isHTML(true);

        $this->mailer->CharSet = 'UTF-8';
    }
    public function sendEmail($to, $name, $from, $subject, $message): void
    {

        try {
            $this->mailer->setFrom($from, 'EMS');
            $this->mailer->addAddress($to, $name);
            $this->mailer->isHTML(true);
            $this->mailer->Subject = $subject;
            $this->mailer->Body = $message;
            $this->mailer->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$this->mailer->ErrorInfo}";
        }
    }

    public function sendRegisterEmail($to, $name, $token)
    {
        $subject = 'Registrace do EMS';
        $message = "Dobrý den, $name,<br>byl vám vytvořen účet v našem EMS (employee management system) systému. <br>Pro vytvoření hesla do EMS klikněte na následující odkaz: <a href='" . URL . "/account/register/$token'>" . URL . "/account/register/$token</a>";
        $this->sendEmail($to, $name, 'ems@spse.jankarlik.cz', $subject, $message);
    }
}
