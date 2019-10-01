<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="shortcut icon" type="image/x-icon" href="<?php echo BASE_URL ?>public/img/favicon.ico">
  <meta name="description" content="">
  <meta name="author" content="">

  <title><?php echo $this->titulo; ?></title>

  <!-- Custom fonts for this template-->
  <link href="<?php echo BASE_URL ?>public/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="<?php echo BASE_URL ?>public/css/sb-admin-2.min.css" rel="stylesheet">
  <link href="<?php echo BASE_URL ?>public/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

  <link href="<?php echo BASE_URL ?>public/css/bootstrap-datepicker.css" rel="stylesheet">  
  <link href="<?php echo BASE_URL ?>public/css/bootstrap-select.css" rel="stylesheet">  

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-car"></i>
        </div>
        <div class="sidebar-brand-text mx-3">De<sup>parqueo</sup></div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
     <!--  <li class="nav-item active">
       <a class="nav-link" href="index.html">
         <i class="fas fa-fw fa-tachometer-alt"></i>
         <span>Dashboard</span></a>
     </li> -->

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Funciones
      </div>
      
      <?php foreach ($_layoutParams['menu'] as $key => $value) { ?>
        <li class="nav-item <?php if($_layoutParams['item'] == $value['id']){ echo "active";} ?>">
        <a class="nav-link" href="<?php echo $value['enlace'] ?>">
          <i class="fas fa-fw <?php echo $value['icono'] ?>"></i>
          <span><?php echo $value['titulo'] ?></span></a>
      </li>
      <?php } ?>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading  -->
      <?php if(isset($_layoutParams['menuConfiguracion'])){ ?>
        <div class="sidebar-heading">
          Configuraci&oacute;n
        </div>
        <?php foreach ($_layoutParams['menuConfiguracion'] as $key => $value) { ?>
          <li class="nav-item <?php if($_layoutParams['item'] == $value['id']){ echo "active";} ?>">
          <a class="nav-link" href="<?php echo $value['enlace'] ?>">
            <i class="fas fa-fw <?php echo $value['icono'] ?>"></i>
            <span><?php echo $value['titulo'] ?></span></a>
        </li>
        <?php } ?>
        <hr class="sidebar-divider d-none d-md-block">
      <?php } ?>

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo Session::get('nombre') ?></span>
                <!-- <img class="img-profile rounded-circle" src="https://source.unsplash.com/QAB-WJcbgJk/60x60"> -->
                <i class="fas fa-user"></i>
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <!-- <a class="dropdown-item" href="#">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile
                </a> -->
                <a class="dropdown-item" href="<?php echo BASE_URL ?>usuario/cambiar_clave/">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  Cambiar Clave
                </a>
                <!-- <a class="dropdown-item" href="#">
                  <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                  Activity Log
                </a> -->
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Cerrar Sesi&oacute;n
                </a>
              </div>
            </li>

          </ul>

        </nav>

        <div class="ml-4 mr-4">
          <?php if(Session::get('error')): ?>
          <div class="alert alert-danger" role="alert">
            <strong>Error ! </strong><?php echo Session::get('error');Session::destroy("error"); ?>.
          </div>
          <?php endif; ?>
          <?php if(Session::get('mensaje')): ?>
          <div class="alert alert-success" role="alert">
            <strong>Mensaje ! </strong><?php echo Session::get('mensaje');Session::destroy("mensaje"); ?>
          </div>
          <?php endif; ?>
        </div>
        <!-- End of Topbar -->