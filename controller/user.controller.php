<?php
class UserController
{
  private $master;
  private $doizer;
  function __CONSTRUCT()
  {
    $this->master =  MasterModel();
    $this->doizer =  new DoizerController;
  }
  function main()
  {
    if (isset($_SESSION['USER']['ROL']) && $_SESSION['USER']['ROL'] == 2) {
      require_once "views/include/scope.header.php";
      // require_once "views/include/scope.menutop.php";
      // require_once "views/include/scope.navigator.php";
      require_once "views/modules/user/index.php";
      require_once "views/include/scope.footer.php";
    } else {
      session_destroy();
      header("Location: inicio");
    }
  }
  function createUser()
  {
    $data = $_POST['user'];
    $data[] = "Activo";
    $i = 0;
    // se validan los datos
    foreach ($data as $input) {
      if (trim($data[$i]) == '') {
        echo json_encode('Campos vacios');
        return;
      }
      if ($i == 4) { } else {
        $result = $this->doizer->specialCharater($data[$i]);
        if ($result == false) {
          echo json_encode('los campos no deben tener caracteres especiales');
          return;
        }
      }
      $i++;
    }
    if ($this->doizer->onlyNumbers($data[5]) == true && $this->doizer->onlyNumbers($data[8]) == true) {
      if ($this->doizer->validateEmail($data[4]) == true) {
        $password = $this->doizer->validateSecurityPassword($data[6]);
        if ($data[6] == $data[7]) {
          if (is_array($password)) {
            // se envian las variables y nombre del procedimiento almacenado al metodo que lo ejecuta
            $result = $this->master->procedure->NRP("sp_crear_usuario", array($data[0], $data[1], $data[2], $data[3], $data[4], $data[5], "Activo", $data[8]));
            if ($result == 1) {
              $token = $this->doizer->randAlphanum(50);
              $dataUser = $this->master->procedure->PRByAll("sp_consultar_usuario", array($data[4]));
              // se envian las variables y nombre del procedimiento almacenado al metodo que lo ejecuta

              $result = $this->master->procedure->NRP("sp_crear_acceso", array($token, $dataUser[0]['id'], $password[1]));
              if ($result == 1) {
                $resultGroup =  $this->registrarUsuarioGrupo($dataUser[0]['id'],$data[9]);
                if($resultGroup){
                  echo json_encode(true);

                }else {
                  echo json_encode($resultGroup);
                }
              } else {
                //se envia mensaje generico del doizer 
                echo json_encode("ocurrio un error al registar acceso: " . $this->doizer->knowError($result));
              }
            } else {
              echo json_encode("ocurrio un error al registar usuario: " . $result);
            }
          } else {
            echo json_encode("La contraseña no  cumple con los requisitos: " . $password);
          }
        } else {
          echo json_encode("Las contraseñas no son iguales");
        }
      } else {
        echo json_encode("Formato del correo no valido.");
      }
    } else {

      echo json_encode("Datos no validos");
    }
  }


  function update()
  {
    $data = $_POST['user'];
    $i = 0;
    // se validan los datos
    foreach ($data as $input) {
      if (!$i == 1 || !$i == 3) {
        if (trim($data[$i]) == '') {
          echo json_encode('Campos vacios');
          return;
        }
      }
      if ($i == 4) { } else {
        $result = $this->doizer->specialCharater($data[$i]);
        if ($result == false) {
          echo json_encode('los campos no deben tener caracteres especiales');
          return;
        }
      }
      $i++;
    }
    if ($this->doizer->validateEmail($data[4]) == true) {
      // se envian las variables y nombre del procedimiento almacenado al metodo que lo ejecuta
      $result = $this->master->procedure->NRP("sp_actualizar_usuario", array($data[0], $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $_SESSION['USER_UPDATE']));
      if ($result == 1) {
        echo json_encode(true);
      } else {
        //se envia mensaje generico del doizer 
        echo json_encode("Error al modificar: " . $this->doizer->knowError($result));
      }
    } else {
      echo json_encode("Formato del correo no valido.");
    }
  }
  function updateProfile()
  {
    $data = $_POST['user'];
    $i = 0;
    // se validan los datos
    foreach ($data as $input) {
      if (!$i == 1 || !$i == 3) {
        if (trim($data[$i]) == '') {
          echo json_encode('Campos vacios');
          return;
        }
      }
      if ($i == 4) { } else {
        $result = $this->doizer->specialCharater($data[$i]);
        if ($result == false) {
          echo json_encode('los campos no deben tener caracteres especiales');
          return;
        }
      }
      $i++;
    }
    if ($this->doizer->validateEmail($data[4]) == true) {
      // se envian las variables y nombre del procedimiento almacenado al metodo que lo ejecuta
      $result = $this->master->procedure->NRP("sp_editar_perfil", array($_SESSION['USER_UPDATE'], $data[0], $data[1], $data[2], $data[3], $data[4]));
      if ($result == 1) {
        $_SESSION['USER']['NAME'] = $data[0];
        $_SESSION['USER']['LAST_NAME'] = $data[2];
        echo json_encode(true);
      } else {
        //se envia mensaje generico del doizer 
        echo json_encode("Error al modificar: " . $this->doizer->knowError($result));
      }
    } else {
      echo json_encode("Formato del correo no valido.");
    }
  }

  function changeStatus()
  {
    $user = $_POST['user'];
    $estado = $_POST['estado'];
    // se validan los datos
    if (trim($user) != "" && trim($estado) != "") {
      // se envian las variables y nombre del procedimiento almacenado al metodo que lo ejecuta
      $result = $this->master->procedure->NRP("sp_cambiar_estado_usuario", array($user, $estado));
      if ($result == 1) {
        echo json_encode(true);
      } else {
        //se envia mensaje generico del doizer 
        echo json_encode($this->doizer->knowError($result));
      }
    } else {
      echo json_encode("no existen datos para realizar la operacion");
    }
  }

  function updatePassword()
  {
    $data = $_POST['data'];
    // $dataReal = $this->master->selectBy("acceso", array("usu_codigo", $_SESSION['USER']['ID']));
    $dataReal = $this->master->procedure->PRByAll("sp_consultar_acceso", array($_SESSION['USER']['ID']));
    if (password_verify($data[0], $dataReal[0]['contrasena'])) {
      $password = $this->doizer->validateSecurityPassword($data[1]);
      if (is_array($password)) {
        // se envian las variables y nombre del procedimiento almacenado al metodo que lo ejecuta
        $result = $this->master->procedure->NRP("sp_modificar_acceso", array($_SESSION['USER']['ID'], $password[1]));
        if ($result == true) {
          echo json_encode(true);
        } else {
          //se envia mensaje generico del doizer 
          echo json_encode($this->doizer->knowError($result));
        }
      } else {
        echo json_encode($password);
      }
    } else {
      echo json_encode("la contraseña actual no es valida.");
    }
  }
}
