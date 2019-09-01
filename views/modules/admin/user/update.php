<h1 class="title">editar usuarios</h1>

<a href="gesition-usuarios"><i class="fas fa-chevron-left"> Atras</i></a>
<br>
<div class="container">
  <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Actualizar datos usuario</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Actualizar contraseña</a>
    </li>
    <!--
    <li class="nav-item">
      <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Generar reporte</a>
    </li> -->
  </ul>
</div>
<div class="tab-content" id="pills-tabContent">
  <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
    <div class="container">
      <form id="updateUser" class="form justify-content-xl-center">
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="nameUserUp">Nombre:</label>
            <input type="text" id="nameUserUp" value="<?php echo $data[0]['nombre'] ?>" class="form-control">
          </div>
          <div class="form-group col-md-6">
            <label for="SnameUserUp">Segundo nombre:</label>
            <input type="text" id="SnameUserUp" value="<?php echo $data[0]['segundo_nombre'] ?>" class="form-control">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="lastnameUserUp">Apellido</label>
            <input type="text" id="lastnameUserUp" value="<?php echo $data[0]['apellido'] ?>" class="form-control">
          </div>
          <div class="form-group col-md-6">
            <label for="SlastnameUserUp">Segundo apellido:</label>
            <input type="text" id="SlastnameUserUp" value="<?php echo $data[0]['segundo_apellido'] ?>" class="form-control">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="emailUserUp">Correo</label>
            <input type="email" id="emailUserUp" value="<?php echo $data[0]['correo'] ?>" class="form-control">
          </div>
          <div class="form-group col-md-6">
            <label for="rolUserUp">Rol</label>
            <select id="rolUserUp" class="form-control">
              <?php
              if ($data[0]['rol'] == 1) {
                echo '<option value="1" selected>administrador</option>';
                echo '<option value="2">usuario</option>';
              } else {
                echo '<option value="1">administrador</option>';
                echo '<option value="2" selected>usuario</option>';
              }
              ?>
            </select>
          </div>
        </div>
        <div class="form-row">
          <label for="estadoUserUp">Estado</label>
          <select id="estadoUserUp" class="form-control">
            <?php
            if ($data[0]['estado'] == "Activo") {
              echo '<option value="Activo" selected>Activo</option>';
              echo '<option value="Inactivo">Inactivo</option>';
            } else {
              echo '<option value="Activo">Activo</option>';
              echo '<option value="Inactivo" selected>Inactivo</option>';
            }
            ?>
          </select>
        </div>
        <br>
        <input type="submit" value="Modificar" class="btn btn-success">
      </form>
    </div>
  </div>
  <div class="tab-pane fade container" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
    <div class="container">
      <form id="updateUserPass" class="form justify-content-xl-center">
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="Password">Contraseña:</label>
            <input type="password" id="Password" value="" class="form-control">
          </div>
          <div class="form-group col-md-6">
            <label for="ValidatePassword">Repetir contraseña:</label>
            <input type="password" id="ValidatePassword" value="" class="form-control">
          </div>
        </div>
        <br>
        <input type="submit" value="Modificar" class="btn btn-success">
      </form>
    </div>
  </div>
</div>