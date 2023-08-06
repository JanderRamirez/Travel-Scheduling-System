<?php $LAVA = lava_instance() ?>
<!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
 <?php require_once('inc/header.php') ?>
<body class="hold-transition login-page  dark-mode">
  <!-- <script>
    start_loader()
  </script> -->
<div class="login-box" style="width:400px;!important">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="<?= site_url('Main/Register') ?>" class="h1"><b>Register</b></a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Fill this form to create a new account</p></p>

      <form action="<?= site_url('Main/Signup') ?>" method="post">
  <?=$LAVA->session->flashdata('err') ? '<div class="alert alert-danger text-white err_msg"><i class="fa fa-exclamation-triangle"></i> Registration Unsuccessful</div>':'';?>
      
        <div class="input-group mb-3">
          <input type="text" class="form-control" autofocus name="username" placeholder="Username" required>
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
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="name" placeholder="Full Name" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
      </div>
      <div class="input-group mb-3">
          <input type="email" class="form-control" name="email" placeholder="Email" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
      </div>
      <div class="input-group mb-3">
          <input type="text" class="form-control" name="contact" placeholder="Contact" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-address-book"></span>
            </div>
          </div>
      </div>
      <div class="input-group mb-3">
          <select type="text" class="form-control" name="gender"  required>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
          </select>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-venus-mars"></span>
            </div>
          </div>
      </div>
      <div class="input-group mb-3">
          <input type="text" class="form-control" name="address" placeholder="Address" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-map"></span>
            </div>
          </div>
      </div>
      <div class="input-group mb-3">
          <input type="date" class="form-control" name="birthdate"  required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-calendar"></span>
            </div>
          </div>
      </div>
        <div class="row">
          <div class="col-8">
          <small>Already have an account? Click <a href="<?=site_url('Main/Login')?>">here</a></small> 
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Sign Up</button>
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