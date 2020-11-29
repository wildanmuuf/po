<?php
 
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>HRD | Sanggar Liza</title>
  <!-- Tell the browser to be responsive to screen width -->
  <link rel="shortcut icon" href="favicon.ico">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="stylesheet" href="dist/css/style.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!--Smart Wizard -->
  <link href="https://cdn.jsdelivr.net/npm/smartwizard@5/dist/css/smart_wizard_all.min.css" rel="stylesheet" type="text/css" />
 
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-danger navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <p style="font-family: 'Source Sans Pro', sans-serif; color:white; font-size:16px; transform: translate( -0%, 35%);" class="text-left" id="clock"></p>
    </ul>
    <div class="navbar-nav mx-auto">
      <p style="font-family: 'Source Sans Pro', sans-serif; color:white; font-size:16px; transform: translate( 5%, 35%);" class="text-right" id="good">
      </p>
    </div>
  <?php 
    
  ?>
    <ul class="navbar-nav ml-auto" id="notifikasi">
      <!-- Messages Dropdown Menu -->
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="." class="brand-link navbar-danger">
      <img src="images/logo.png" alt="Sanggar Liza Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">HRD</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="images/pegawai/pas_foto/<?php echo $r['foto'];?>" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block text-wrap"><?php echo $nama_lengkap;?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <?php 
            $id_user = $_SESSION["id_user"];
            $sql1="SELECT m.* FROM tb_permission as p
              JOIN tb_roles as r ON p.id_role=r.id_role
              JOIN tb_menu as m ON p.id_menu=m.id_menu
              JOIN tb_users as u ON r.id_role=u.id_role
            where u.id_user='$id_user' and m.parent_id='*' and m.aktif='Y' order by m.sequence";
            $query1 = $dbcon->prepare($sql1);
            $query1->execute();
            while($menu = $query1->fetch(PDO::FETCH_ASSOC)){
              //$sql_sub = "SELECT * FROM tb_menu where aktif='Y' and parent_id='$menu[id_menu]'";
              $sql_sub = "SELECT m.* FROM tb_permission as p
              JOIN tb_roles as r ON p.id_role=r.id_role
              JOIN tb_menu as m ON p.id_menu=m.id_menu
              JOIN tb_users as u ON r.id_role=u.id_role
            where u.id_user='$id_user' and m.parent_id='$menu[id_menu]' and m.aktif='Y' order by m.menu_name";
              $query_sub = $dbcon->prepare($sql_sub);
              $query_sub->execute();
              $active = "";
              $menu_open = "";
              if($aktif == $menu['id_menu']){
                $menu_open = "menu-open";
              }

              if($aktif_sub == $menu['id_menu']){
                $active = "active";
              }
              if($query_sub->rowCount() == 0){
                echo '<li class="nav-item" >
                  <a href="'.$menu['url'].'" class="nav-link '.$active.'">
                    <i class="nav-icon '.$menu['icon'].'"></i>
                    <p>'.$menu['menu_name'].'</p>
                  </a>
                </li>';
              }else{
                echo '<li class="nav-item has-treeview '.$menu_open.'">
                <a href="'.$menu['url'].'" class="nav-link">
                  <i class="nav-icon '.$menu['icon'].'"></i>
                  <p>
                  '.$menu['menu_name'].'
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>';
                while($sub_menu = $query_sub->fetch(PDO::FETCH_ASSOC)){
                  if($aktif_sub == $sub_menu['id_menu']){
                    $active = "active";
                  }else{
                    $active ="";
                  }
                  echo '<ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="'.$sub_menu['url'].'" class="nav-link '.$active.'">
                      <i class = "nav-icon '.$sub_menu['icon'].'"></i>
                      <p>'.$sub_menu['menu_name'].'</p>
                    </a>
                  </li>
                </ul>';
                }
                echo '</li>';
              }
            }
          ?>
         
            <li class="nav-item">
              <a href="logout.php" class="nav-link">
                <i class="nav-icon fas fa-sign-out-alt"></i>
                <p>Keluar</p>
              </a>
            </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>