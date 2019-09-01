<!DOCTYPE html>
<html lang="ES" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Biomatic</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="views/assets/lib/bootstrap/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="views/assets/css/login.css">
</head>

<body>
  <div class="contenedor container">
    <section class="section one">
      <div class="one--content">
        
        <h2>Bienvenido a nuestro grupo de</h2>
        <h1>investigadores.</h1>
      </div>
      <button type="button" class="btn btn-primary boton" data-toggle="modal" data-target="#exampleModalCenter">
        Iniciar sesion
      </button>
    </section>
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <div class="text-center">
              
            </div>

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>

          </div>
          <form id="formLogin">
            <div class="modal-body">
              <div class="form-group">
                <label for="email">Correo:</label>
                <input type="email" id="email" class=" form-control" required>
              </div>
              <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" class=" form-control" required>
              </div>
              <div class="form-group">
                <a href="" class="" data-toggle="modal" data-dismiss="modal" data-target="#exampleModalCenterR" >
                  Recuperar Contraseña
                </a>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <input type="submit" value="ingresar" class="btn btn-primary btn-success">
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="modal fade" id="exampleModalCenterR" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <div class="text-center">
              <img src="views/assets/image/logo.png" alt="logo Responsive image" class="container--modal-img rounded">
            </div>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>

          </div>
          <form id="formRecuperate">
            <div class="modal-body">
              <div class="text-center">
                <label >Ingrese el correo con el que se encuentra registrado</label>                
              </div>
              <div class="form-group">
                <label for="email">Correo:</label>
                <input type="email" id="emailRec" class=" form-control" required>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal" data-toggle="modal" data-target="#exampleModalCenter">Atras</button>
              <input type="submit" value="Enviar" class="btn btn-primary btn-success">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>


  <script src="views/assets/lib/jquery.js"></script>
  <script type="text/javascript">

  </script>
 
  <script src="views/assets/lib/datatables/jquery.dataTables.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="views/assets/lib/bootstrap/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

  <script src="views/assets/js/main.js"></script>

</body>

</html>