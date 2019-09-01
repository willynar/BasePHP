<?php
// echo json_encode($dataproyect);





?>
<h1 class="title">Gestionar usuarios</h1>
<div class="container">
  <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Usuarios</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Crear usuarios</a>
    </li>
  </ul>
</div>
<div class="tab-content" id="pills-tabContent">
  <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
    <div class="table-responsive">
      <table class="table table-striped" id="tableUser">
        <thead>
          <tr>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Correo</th>
            <th>Estado</th>
            <th>Acciones</th>
            <th>Estado</th>
          </tr>
        </thead>
        <tbody>
          <?php
          // se consultan y traen los datos de la bd y se envian a la tabla
          $userId = $_SESSION['USER']['ID'];
          foreach ($dataUsers as $row) { ?>
            <tr>
              <td><?php echo $row['nombre'] ?></td>
              <td><?php echo $row['apellido'] ?></td>
              <td><?php echo $row['correo'] ?></td>
              <td><?php echo $row['estado'] ?></td>
              <td class="actions">
                <div>
                  <?php
                  // if ($row['id'] != 1 && $row['id'] != $userId) { 
                  ?>
                  <a href="editar-usuario-<?php echo $row['id'] ?>"><i class="fas fa-user-edit" style="color:aqua"></i></a>
                  <?php
                  // }
                  ?>

                </div>

              </td>
              <td class="text-center">
                <div>
                  <?php if ($row['id'] != 1 && $row['id'] != $userId) {
                    if ($row['estado'] == "Activo") { ?>
                      <a href="#" onclick="cambiarEstado(<?php echo $row['id'] ?>,'Inactivo')"><i class="fas fa-user-alt-slash"></i></a>
                    <?php } else { ?>
                      <a href="#" onclick="cambiarEstado(<?php echo $row['id'] ?>,'Activo')"><i class="fas fa-user-check"></i></a>
                    <?php }
                  } ?>
                </div>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
  <div class="tab-pane fade container" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
    <form id="createUser" class="form justify-content-xl-center">
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="nameUser">Nombre:</label>
          <input type="text" id="nameUser" class="form-control">
        </div>
        <div class="form-group col-md-6">
          <label for="SnameUser">Segundo nombre:</label>
          <input type="text" id="SnameUser" class="form-control">
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="lastnameUser">apellido</label>
          <input type="text" id="lastnameUser" class="form-control">
        </div>
        <div class="form-group col-md-6">
          <label for="SlastnameUser">Segundo apellido:</label>
          <input type="text" id="SlastnameUser" class="form-control">
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="emailUser">Email</label>
          <input type="email" id="emailUser" class="form-control">
        </div>
        <div class="form-group col-md-6">
          <label for="nivelUser">Nivel educativo:</label>
          <select id="nivelUser" class="form-control">
            <option value="1">Tecnico</option>
            <option value="2">Tecnologo</option>
            <option value="3">Profesional</option>
            <option value="4">Especialista</option>
            <option value="5">Maestria</option>
            <option value="6">Doctorado</option>
          </select>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="rolUser">rol</label>
          <select id="rolUser" class="form-control">
            <option value="1">administrador</option>
            <option value="2">usuario</option>
          </select>
        </div>
        <div class="form-group col-md-6">
          <label for="groupUser">Grupo de investigacion:</label>
          <?php if (isset($_SESSION['USER_TYPE']) && $_SESSION['USER_TYPE'] == "spa") {
            ?>
            <select id="groupUser" class="form-control">
              <?php
              foreach ($dataGroups as $rowG) { ?>
                <option value="<?php echo $rowG["id"] ?>"><?php echo $rowG["nombre"] ?></option>
              <?php }
            } else {
              ?>
              <select id="groupUser" class="form-control">
                <option value="<?php echo $_SESSION['USER_GROUP']['id'] ?>"><?php echo $_SESSION['USER_GROUP']['name'] ?></option>
              <?php
              } ?>
            </select>
        </div>
      </div>

      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="passUser">Contraseña</label>
          <input type="password" id="passUser" class="form-control">
        </div>
        <div class="form-group col-md-6">
          <label for="repPassUser">Repetir contraseña</label>
          <input type="password" id="repPassUser" class="form-control">
        </div>
      </div>
      <input type="submit" value="registrar" class="btn btn-success">
    </form>
  </div>
</div>