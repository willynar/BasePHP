<aside class="left-sidebar aside">
  <div class="navigator--profile">
    <nav class="sidebar-nav">
      <ul id="sidebarnav">
        <li>
          <div class="user-profile d-flex no-block dropdown m-t-20">
            <div class="user-pic ">
              <img src="views/assets/image/icono.png" alt="logo" width="40">
            </div>
            <div class=" user-content hide-menu m-l-10 alinear">
              <a class="text-light" href="user">

                <h2 class="hide-menu">BIOMATIC</h2>
              </a>
            </div>
          </div>
        </li>
      </ul>
    </nav>

  </div>

  <!-- Sidebar scroll-->
  <div class="scroll-sidebar">
    <!-- Sidebar navigation-->
    <nav class="sidebar-nav">
      <ul id="sidebarnav">
        <li>
          <!-- User Profile-->
          <div class="user-profile d-flex no-block dropdown m-t-20">
            <div class="user-pic"><img src="views/assets/image/iconoUser.png" alt="users" class="rounded-circle" width="40" /></div>
            <div class="user-content hide-menu m-l-10">
              <a href="javascript:void(0)" class="" id="Userdd" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <h5 class="m-b-0 user-name font-medium"><?php echo substr($_SESSION['USER']['NAME'] . " " . $_SESSION['USER']['LAST_NAME'], 0,15); ?> <i class="fa fa-angle-down"></i></h5>
                <span class="op-5 user-email">
                  <? echo $_SESSION['USER_MAIL'] ?></span>
              </a>
              <div class="dropdown-menu dropdown-menu-right menuAside" aria-labelledby="Userdd">
                <!-- <a class="dropdown-item" href="mi-perfil"><i class="ti-user m-r-5 m-l-5"></i> Mi perfil</a> -->
                <a class="dropdown-item" href="finalizar"><i class="fa fa-power-off m-r-5 m-l-5"></i> Logout</a>
                <!-- <a class="dropdown-item" href="#"><i class="ti-email m-r-5 m-l-5"></i> Ayuda</a> -->
              </div>
            </div>
          </div>
          <!-- End User Profile-->
        </li>
        <!-- User Profile-->
        <!-- <li class="sidebar-item">
          <a class="sidebar-link waves-effect waves-dark sidebar-link" aria-expanded="false" href="gesition-usuarios">
            <i class="fas fa-user"></i>
            <span class="hide-menu">Gestion usuarios</span>
          </a>
        </li> -->        
      </ul>
    </nav>
  </div>
</aside>