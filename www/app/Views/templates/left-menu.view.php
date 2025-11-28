<!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="<?php echo $_ENV['host.folder'] ?>" class="nav-link <?php echo $_SERVER['REQUEST_URI'] === $_ENV['host.folder'] . 'inicio' ? 'active' : ''; ?>">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Inicio
              </p>
            </a>
          </li> 
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item <?php echo (in_array($_SERVER['REQUEST_URI'], [$_ENV['host.folder'] . 'demo-proveedores'])) ? 'menu-open' : '';?>">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Panel de control
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo $_ENV['host.folder'] ?>demo-proveedores" class="nav-link <?php echo $_SERVER['REQUEST_URI'] === $_ENV['host.folder'] . 'demo-proveedores' ? 'active' : ''; ?>">
                  <i class="fas fa-laptop-code nav-icon"></i>
                  <p>Demo Proveedores</p>
                </a>
              </li>
                <li class="nav-item">
                    <a href="<?php echo $_ENV['host.folder'] ?>trabajadores1" class="nav-link <?php echo $_SERVER['REQUEST_URI'] === $_ENV['host.folder'] . 'trabajadores1' ? 'active' : ''; ?>">
                        <i class="fas fa-laptop-code nav-icon"></i>
                        <p>Trabajadores 1</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo $_ENV['host.folder'] ?>trabajadores2" class="nav-link <?php echo $_SERVER['REQUEST_URI'] === $_ENV['host.folder'] . 'trabajadores2' ? 'active' : ''; ?>">
                        <i class="fas fa-laptop-code nav-icon"></i>
                        <p>Trabajadores 2</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo $_ENV['host.folder'] ?>trabajadores3" class="nav-link <?php echo $_SERVER['REQUEST_URI'] === $_ENV['host.folder'] . 'trabajadores3' ? 'active' : ''; ?>">
                        <i class="fas fa-laptop-code nav-icon"></i>
                        <p>Trabajadores 3</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo $_ENV['host.folder'] ?>trabajadores4" class="nav-link <?php echo $_SERVER['REQUEST_URI'] === $_ENV['host.folder'] . 'trabajadores4' ? 'active' : ''; ?>">
                        <i class="fas fa-laptop-code nav-icon"></i>
                        <p>Trabajadores 4</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo $_ENV['host.folder'] ?>trabajadores" class="nav-link <?php echo $_SERVER['REQUEST_URI'] === $_ENV['host.folder'] . 'trabajadores' ? 'active' : ''; ?>">
                        <i class="fas fa-laptop-code nav-icon"></i>
                        <p>Trabajadores</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo $_ENV['host.folder'] ?>nombreUsuarioSesion" class="nav-link <?php echo $_SERVER['REQUEST_URI'] === $_ENV['host.folder'] . 'nombreUsuarioSesion' ? 'active' : ''; ?>">
                        <i class="fas fa-laptop-code nav-icon"></i>
                        <p>Nombre usuario sesion</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo $_ENV['host.folder'] ?>login" class="nav-link <?php echo $_SERVER['REQUEST_URI'] === $_ENV['host.folder'] . 'login' ? 'active' : ''; ?>">
                        <i class="fas fa-laptop-code nav-icon"></i>
                        <p>Login</p>
                    </a>
                </li>
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->