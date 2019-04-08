<?php

  // Esto le dice a PHP que usaremos cadenas UTF-8 hasta el final
mb_internal_encoding('UTF-8');

// Esto le dice a PHP que generaremos cadenas UTF-8
mb_http_output('UTF-8');
  if (isset($_SERVER['HTTP_ORIGIN'])) {
    // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
    // you want to allow, and if so:
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
  }
  if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

      if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
          // may also be using PUT, PATCH, HEAD etc
          header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

      if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
          header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

      exit(0);
  }

  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;

  require './phpmailer/Exception.php';
  require './phpmailer/PHPMailer.php';
  require './phpmailer/SMTP.php';


  $name = $_POST["name"];

  $lastName = $_POST["last-name"];

  $email = $_POST["email"];

  $phone = $_POST["phone"];

  $message = $_POST["message"];

  $subject = "Formulario de Registro de Posada 2018 Cava de ORO";

  $addressee = "tino.navarro@hotmail.com";
  $addressee_other = "cavadeoro.mail@gmail.com";

  // $addressee_other = "";


function result($msg,$status,$error){
  $res = array(
    msg => $msg,
    status => $status,
    error => $error
  );
  echo json_encode($res, JSON_FORCE_OBJECT);
}

function send($name,$lastName,$email,$phone,$message, $addressee, $addressee_other){

  // echo ('----- send-llega() --- </br>'.$name.'</br>'.$email.'</br>'.$phone.'</br>'.$message.'</br>'.$addressee.'</br>'.$addressee_other.'</br>');
  $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try {
    //Server settings
    $mail->SMTPDebug = 0;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'cavadeoro.sendmail@gmail.com';                 // SMTP username
    $mail->Password = 'DiazN101875*/';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom($email, $name);
    $mail->addAddress($addressee);     // Add a recipient
    $mail->addAddress($addressee_other);
    // $mail->addAddress('ellen@example.com');               // Name is optional
    // $mail->addReplyTo('info@example.com', 'Information');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    //Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->CharSet = 'UTF-8';
    $mail->Subject = 'Correo Enviado desde cavadeoro.mx/posada2018';
    $mail->Body    = " <html>

    <body>

    <h1>Formulario de Registro de Posada 2018 Cava de ORO</h1>

    <p>Informacion enviada por el usuario de la web:</p>

    <p>Nombre: {$name}</p>

    <p>Apellido: {$lastName}</p>

    <p>E-mail: {$email}</p>

    <p>Teléfono: {$phone}</p>

    <p>Mensaje: {$message}</p>

    </body>

    </html>";

    $mail->send();
    result('Registro enviado con éxito,</br> en breve nos pondrémos en contacto con usted',true,null);

} catch (Exception $e) {
  result('Ocurrio un Error al enviar su registro,</br> por favor vuelva a intentarlo',false,$mail->ErrorInfo);
}
}

function veryfy($name,$lastName,$email,$phone,$message, $addressee, $addressee_other){
  // echo ('----- veryfy-llega() --- </br>'.$name.'</br>'.$email.'</br>'.$phone.'</br>'.$message.'</br>'.$addressee.'</br>'.$addressee_other.'</br>');
  if ( !isset($name) || $name =='' || !isset($lastName) || $lastName =='' || !isset($email) || $email =='' || !isset($phone) || $phone == '' || !isset($message) || $message == '' ) {
    result("error",false,"Es necesario completar todos los datos del formulario");
  }else {
    // echo ('----- veryfy-sale() --- </br>'.$name.'</br>'.$email.'</br>'.$phone.'</br>'.$message.'</br>'.$addressee.'</br>'.$addressee_other.'</br>');
    send($name,$lastName,$email,$phone,$message, $addressee, $addressee_other);
  }
}

veryfy($name,$lastName,$email,$phone,$message, $addressee, $addressee_other)

?>
