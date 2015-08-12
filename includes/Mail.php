<?php

class Mail
{

    private static $listAccounts = array();

    public function verify($toemail, $fromemail, $getdetails = false){

        $details='';        
        $email_arr = explode("@", $toemail);
        $domain = array_slice($email_arr, -1);
        $domain = $domain[0];
        // Trim [ and ] from beginning and end of domain string, respectively
        $domain = ltrim($domain, "[");
        $domain = rtrim($domain, "]");
        if( "IPv6:" == substr($domain, 0, strlen("IPv6:")) ) {
            $domain = substr($domain, strlen("IPv6") + 1);
        }
        $mxhosts = array();
        if( filter_var($domain, FILTER_VALIDATE_IP) )
            $mx_ip = $domain;
        else
            getmxrr($domain, $mxhosts, $mxweight);
        if(!empty($mxhosts) )
            $mx_ip = $mxhosts[array_search(min($mxweight), $mxhosts)];
        else {
            if( filter_var($domain, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) ) {
                $record_a = dns_get_record($domain, DNS_A);
            }
            elseif( filter_var($domain, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) ) {
                $record_a = dns_get_record($domain, DNS_AAAA);
            }
            if( !empty($record_a) )
                $mx_ip = $record_a[0]['ip'];
            else {
                $result   = "invalid";
                $details .= "No suitable MX records found.";
                return ( (true == $getdetails) ? array($result, $details) : $result );
            }
        }



        $connect = @fsockopen($mx_ip, 25); 
        if($connect){ 
            if(preg_match("/^220/i", $out = fgets($connect, 1024))){
                fputs ($connect , "HELO $mx_ip\r\n"); 
                $out = fgets ($connect, 1024);
                $details .= $out."\n";
     
                fputs ($connect , "MAIL FROM: <$fromemail>\r\n"); 
                $from = fgets ($connect, 1024); 
                $details .= $from."\n";
                fputs ($connect , "RCPT TO: <$toemail>\r\n"); 
                $to = fgets ($connect, 1024);
                $details .= $to."\n";
                fputs ($connect , "QUIT"); 
                fclose($connect);
                if(!preg_match("/^250/i", $from) || !preg_match("/^250/i", $to)){
                    $result = "invalid"; 
                }
                else{
                    $result = "valid";
                }
            } 
        }
        else{
            $result = "invalid";
            $details .= "Could not connect to server";
        }
        if($getdetails){
            return array($result, $details);
        }
        else{
            return $result;
        }
    }

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