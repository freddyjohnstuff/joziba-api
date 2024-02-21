<?php

namespace app\components;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use yii\helpers\Html;

class Mailing
{


    public $_mail;
    /*public string $data = '';
    public string $data = '';
    public string $data = '';
    public string $data = '';*/

    public function get($field)
    {
        return (property_exists($this->_mail,$field) ? $this->$field : null);
    }

    public function set($field, $value)
    {
        if (in_array($field, ['SMTPDebug'])) {
            $this->_mail->$field = $value;
        }
    }

    public function sendMail($to, $subject, $text, $html = null )
    {
        $this->_mail = new PHPMailer(true); // pass true to enable debugging and handle errors
        try {
            $this->_mail->SMTPDebug = SMTP::DEBUG_SERVER; // enable debugging
            $this->_mail->isSMTP(); // use smtp connection to send email
            $this->_mail->Host = 'smtp.gmail.com'; //set up the gmail SMTP host name
            $this->_mail->SMTPAuth = true; // use SMTP Authentication to allow your account to authenticate
            $this->_mail->Username = 'asadova.mtt@gmail.com';
            $this->_mail->Password = 'swAsadovaMtt190##';
            $this->_mail->Port = 587; // set the SMTP port in Gmail
            $this->_mail->SMTPSecure = "tls"; // use TLS when sending the email

            $this->_mail->setFrom('asadova.mtt@gmail.com', 'Joziba LLC'); //defining the sender

            $this->_mail->addAddress($to, 'John Doe');
            $this->_mail->Subject = $subject;

            //Content
            // define the HTML Body. (you can refer this from an HTML file too)
            if(!is_null($html)) {
                $this->_mail->isHTML(true);
                $this->_mail->Body = $html;
                $this->_mail->AltBody = $text;
            } else {
                $this->_mail->isHTML(false);
                $this->_mail->Body = $text;
                $this->_mail->AltBody = $text;
            }

            $this->_mail->send(); //send the emailecho 'The email has been sent';
        } catch (Exception $e) {
            echo "We ran into an error while sending the email: {$this->_mail->ErrorInfo}";
        }
    }

}