<?php $LAVA = lava_instance() ?>
<!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
 <?php require_once('inc/header.php') ?>
<body class="hold-transition login-page  light-mode" style="white; background-image:url('<?=BASE_URL . PUBLIC_DIR?>/uploads/capitol.jpg'); background-position: center;
      background-repeat: no-repeat;
      position: relative;">
  <!-- <script>
    start_loader()
  </script> -->
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-success"  style="background-color:#343a40c2">
    <div class="card-header text-center">
      <a href="<?= site_url('Main/login') ?>" class="h1 text-white"><b>Login</b></a>
    </div>
    <div class="card-body">
      <p class="login-box-msg text-white">Sign in to PISD Travel Scheduling System</p>

      <form action="<?= site_url('Main/Auth') ?>" method="post">
      <?=$LAVA->session->flashdata('err') ? '<div class="alert alert-danger text-white err_msg"><i class="fa fa-exclamation-triangle"></i> Registration Unsuccessful</div>':'';?>
      <?=$LAVA->session->flashdata('succ') ? '<div class="alert alert-success text-white err_msg"><i class="fa fa-check"></i> Registration Successful</div>':'';?>
        <div class="input-group mb-3">
          <input type="email" class="form-control" autofocus name="username" placeholder="Email" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" placeholder="Password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <a href="<?=site_url('Main/Register')?>">Create Account</a>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-success btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <!-- /.social-auth-links -->

      <!-- <p class="mb-1">
        <a href="forgot-password.html">I forgot my password</a>
      </p> -->
      
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>

<!-- <script>
  $(document).ready(function(){
    end_loader();
  })
</script> -->
</body>
</html>