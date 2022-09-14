<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'phpmailer/Exception.php';
    require 'phpmailer/PHPMailer.php';
    require 'phpmailer/SMTP.php';

    // Please replace your email address below in $recip_address field to start receiving form responses.

    $recip_address = "contacto@busing.cl";

    // If you want to add multiple recipient, then you should uncomment two lines that are line no. 14 and 39. Change your e-mail ID in line no. 14
    //$recip_address1 = "info1@yourdomain.com"; 
    $name    = addslashes(strip_tags($_POST['name'])); 
    $sub    = addslashes(strip_tags($_POST['subject']));
    $email   = addslashes(strip_tags($_POST['email'])); 
    $message  = addslashes(strip_tags($_POST['message']));     

    if ( empty($name) OR !filter_var($email, FILTER_VALIDATE_EMAIL) OR empty($message)) {
          http_response_code(400);
          $msg = 'Complete todos los campos';
          echo $msg;
          exit;
    }

    $mail = new PHPMailer();
    $mail->SMTPOptions = array(
       'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
       )
     );

    //Recipients
    $mail->setFrom($email, $name);
    $mail->addAddress($recip_address);   // Add a recipient
    //$mail->addAddress($recip_address1);   // Add a recipient 

    //Content
    $mail->Subject = $sub;
    $mail->Body  = "Ud. ha sido contactado por: ".$name. "
    <br>E-mail: ".$email. "
    <br>Message: ".$message;
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    $mail->isHTML(true);          // Set email format to HTML
     
    if (!$mail->send()) {
      echo "Oops! Algo sucedió no pudimos enviar su mensaje";
    } else {
      echo "Gracias, su mensaje ha sido enviado!";
    }
?>