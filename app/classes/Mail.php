<?php
/**
 * Created by PhpStorm.
 * User: wizdom75
 * Date: 31/03/2018
 * Time: 23:26
 */

namespace App\Classes;
use PHPMailer\PHPMailer\PHPMailer;


class Mail
{
    protected $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);
    }

    /**
     *
     */
    public function setUp()
    {

        $this->mail->isSMTP();                                      // Set mailer to use SMTP
        $this->mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
        $this->mail->SMTPAuth = true;                               // Enable SMTP authentication
        $this->mail->Username = getenv('EMAIL_USERNAME');                 // SMTP username
        $this->mail->Password = getenv('EMAIL_PASSWORD');                           // SMTP password
        $this->mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $this->mail->Port = 587;                                    // TCP port to connect to




        $environment = getenv('APP_ENV');

        if($environment === 'local'){
            $this->mail->SMTPDebug = '';
        }


        $this->mail->isHTML(true);
        $this->mail->SingleTo = true;

        //Sender information
        $this->mail->From = getenv('ADMIN_EMAIL');
        $this->mail->FromName = getenv('APP_NAME');

    }

    public function send($data)
    {
        $this->setUp();
        $this->mail->addAddress($data['to'], $data['name']);
        $this->mail->Subject = $data['subject'];
        $this->mail->Body = make($data['view'], array('data' => $data['body']));

        return $this->mail->send();

    }


}