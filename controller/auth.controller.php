<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class AuthController
{
  private $master;
  private $doizer;
  function __CONSTRUCT()
  {
    $this->master =  MasterModel();
    $this->doizer =  new DoizerController;
  }
  function logIn()
  {
    $email = $_POST['user'];
    $pass = $_POST['pass'];
    // se validan los datos
    if ($email != "" && $email != " " && $pass !=  "" && $pass !=  " ") {
      // se envian las datos y nombre del procedimiento almacenado al metodo que lo ejecuta
      $issetUser = $this->master->procedure->PRByAll("sp_consultar_usuario", array($email));
      if ($issetUser != array()) {
        // se valida que el usuario este activo
        if ($issetUser[0]['estado'] == "Activo") {
          // se envian las datos y nombre del procedimiento almacenado al metodo que lo ejecuta
          $dataAcesso = $this->master->procedure->PRByAll("sp_consultar_acceso", array($issetUser[0]['id']));
          if (password_verify($pass, $dataAcesso[0]['contrasena'])) {
            $_SESSION['USER']['ID'] = $issetUser[0]['id'];
            $_SESSION['USER']['NAME'] = $issetUser[0]['nombre'];
            $_SESSION['USER']['LAST_NAME'] = $issetUser[0]['apellido'];
            $_SESSION['USER']['ROL'] = $issetUser[0]['rol'];
            $_SESSION['USER_MAIL'] = $email;
     
            if ($_SESSION['USER']['ROL'] == 1) {
              $_SESSION['INCLUDE']['ASIDE'] = 'navigator';
              echo json_encode("admin");
            } else {
              $_SESSION['INCLUDE']['ASIDE'] = 'user-navigator';
              echo json_encode("user");
            }
          } else {
            echo json_encode("La contraseña es incorrecta.");
          }
        } else {
          echo json_encode("Usuario Inactivado.");
        }
      } else {
        echo json_encode("El Usuario no existe.");
      }
    } else {
      echo json_encode("Los campos son requeridos.");
    }
  }
  function logOut()
  {
    session_destroy();
    header("Location: inicio");
  }
  function recuperarContraseña()
  {
    $data = $_POST['data'];


    // se conmprueba si  la contraseña se desea actualizar por el admin (1) o recuperar por el usuario
    if ($data[0] == 1) {
      $password = $data[2];
      $id = $_SESSION['USER_UPDATE'];
    } else {
      // se comprueba que existe el usuario 
      $issetUser = $this->master->procedure->PRByAll("sp_consultar_usuario", array($data[1]));
      if ($issetUser != array()) {
        // se genera una contraseña nueva
        $password = $this->doizer->randAlphanum(10);
        $id = $issetUser[0]['id'];
      } else {
        echo json_encode("El Usuario no existe.");
        return;
      }
    }
    // se encripta la contraseña
    $passwordEncript = $this->doizer->passwordEncrypt($password);
    if ($passwordEncript) {
      // se envian las variables y nombre del procedimiento almacenado al metodo que lo ejecuta
      $result = $this->master->procedure->NRP("sp_modificar_acceso", array($id, $passwordEncript));
      if ($result == true) {
        $resultC = $this->enviarCorreo($data[1], $password);
        if ($resultC) {
          // header('Location: inicio');
          // echo "<script>window.location.assign('inicio')</script>";
          echo json_encode(true);
          // echo '<script language="javascript">alert("se envio un correo a la direccion con la nueva contraseña");</script>'; 
        } else {
          echo json_encode("Ocurrio un error al enviar correo contacte con el administrador de la pagina para mas informacion");
        }
      } else {
        //se envia mensaje generico del doizer 
        echo json_encode($this->doizer->knowError($result));
      }
    } else {
      echo json_encode($this->doizer->knowError($password));
    }
  }
  function enviarCorreo($para, $contraseña)
  {
    // Load Composer's autoloader
    require 'views/assets/lib/mailer/vendor/autoload.php';

    try {
      // Instantiation and passing `true` enables exceptions
      $mail = new PHPMailer(true);
      //Server settings
      // $mail->SMTPDebug = 2;                                       // Enable verbose debug output
      $mail->isSMTP();                                            // Set mailer to use SMTP
      $mail->Host       = 'smtp.gmail.com';  // Specify main and backup SMTP servers
      $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
      $mail->Username   = 'willynargame@gmail.com';                     // SMTP username
      $mail->Password   = '89101253920';                               // SMTP password
      $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
      $mail->Port       = 587;                                    // TCP port to connect to

      //Recipients
      $mail->setFrom('willynargame@gmail.com', 'Biomatic');
      $mail->addAddress($para);     // Add a recipient


      // // Attachments
      // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
      // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

      // Content
      $mail->isHTML(true);                                  // Set email format to HTML
      $mail->Subject = 'Cambio de clave';
      $mail->Body    = 'Buen dia  se ha solicitado el cambio de contraseña su nueva contraseña es: <b>' . $contraseña . '</b>';
      $mail->AltBody = 'Si no solicito con anterioridad el cambio de contraseña por fabor contacte al administrador de el sitio gracias.';

      $mail->send();
      return true;
    } catch (Exception $e) {
      echo json_encode($mail->ErrorInfo);
      // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
  }
}
