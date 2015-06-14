<?php

class Mail
{

    private static $listAccounts = array();

    public function addAccount($config = array())
    {

        $total = count($config);

        self::$listAccounts[] = $config;

        /*
        $post=array(
            'Host'=>'smtp1.example.com;smtp2.example.com',
            'Username'=>'username',
            'Password'=>'password',
            'SMTPSecure'=>'tls',
            'Port'=>587
        );

        Mail::addAccount($post);


        $post=array(
            'Host'=>'smtp1.example.com;smtp2.example.com',
            'Username'=>'username',
            'Password'=>'password',
            'SMTPSecure'=>'tls',
            'Port'=>587
        );

        Mail::addAccount($post);

        */


    }

    public function send($inputData=array())
    {
        
        self::sendMail(array(
            'smtpAddress'=>$inputData['smtpAddress'],
            'smtpUser'=>$inputData['smtpUser'],
            'smtpPass'=>$inputData['smtpPass'],
            'smtpPort'=>$inputData['smtpPort'],
            'fromEmail'=>$inputData['fromEmail'],
            'fromName'=>$inputData['fromName'],
            'toEmail'=>$inputData['toEmail'],
            'toName'=>$inputData['toName'],
            'subject'=>$inputData['subject'],
            'message'=>$inputData['content']
            ));

    }

    public function sendMail($accountPosition = 0)
    {
        $mailConfig = $this->listAccounts[$accountPosition];

        require INCLUDES_PATH . 'extentions/PHPMailer/PHPMailerAutoload.php';

        $mail = new PHPMailer;


//$mail->SMTPDebug = 3;                               // Enable verbose debug output

        $mail->isSMTP(); // Set mailer to use SMTP
        $mail->Host = $mailConfig['Host']; // Specify main and backup SMTP servers
        $mail->SMTPAuth = true; // Enable SMTP authentication
        $mail->Username = $mailConfig['Username']; // SMTP username
        $mail->Password = $mailConfig['Password']; // SMTP password
        $mail->SMTPSecure = $mailConfig['SMTPSecure']; // Enable TLS encryption, `ssl` also accepted
        $mail->Port = $mailConfig['Port']; // TCP port to connect to


        /*
        $mail->From = $mailConfig['From'];
        $mail->FromName = 'Mailer';
        $mail->addAddress('joe@example.net', 'Joe User');     // Add a recipient
        $mail->addAddress('ellen@example.com');               // Name is optional
        $mail->addReplyTo('info@example.com', 'Information');
        $mail->addCC('cc@example.com');
        $mail->addBCC('bcc@example.com');

        $mail->WordWrap = 50;                                 // Set word wrap to 50 characters
        $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = 'Here is the subject';
        $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        if(!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Message has been sent';
        }

        */

        return $mail;


    }


}

?>