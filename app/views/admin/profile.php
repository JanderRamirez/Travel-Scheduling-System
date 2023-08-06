<?php $LAVA = lava_instance() ?>  
 <!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
<?php require_once('inc/header.php') ?>
  <body class="sidebar-mini layout-fixed control-sidebar-slide-open layout-navbar-fixed dark-mode sidebar-mini-md sidebar-mini-xs" data-new-gr-c-s-check-loaded="14.991.0" data-gr-ext-installed="" style="height: auto;">
    <div class="wrapper">
     <?php require_once('inc/topBarNav.php') ?>
     <?php require_once('inc/navigation.php') ?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper bg-dark pt-3" style="min-height: 567.854px;">
     
        <!-- Main content -->
        <section class="content  text-dark">
          <div class="container-fluid">
            
            
<?php if($LAVA->session->flashdata('success')): ?>
<script>
	alert_toast("<?php echo $LAVA->session->flashdata('success') ?>",'success')
</script>
<?php  endif;?>
<div class="card card-outline card-primary">
	<div class="card-body">
		<div class="container-fluid">
			<div id="msg"></div>
			<form action="" id="manage-user">	
				<input type="hidden" name="id" value="<?=$profile['id'] ?>">
				<div class="form-group">
					<label for="name">First Name</label>
					<input type="text" name="firstname" id="firstname" class="form-control" value="<?=$profile['firstname'] ?>" required>
				</div>
				<div class="form-group">
					<label for="name">Last Name</label>
					<input type="text" name="lastname" id="lastname" class="form-control" value="<?=$profile['lastname'] ?>" required>
				</div>
				<div class="form-group">
					<label for="username">Username</label>
					<input type="text" name="username" id="username" class="form-control" value="<?=$profile['username'] ?>" required  autocomplete="off">
				</div>
				<div class="form-group">
					<label for="password">Password</label>
					<input type="password" name="password" id="password" class="form-control" value="" autocomplete="off">
					<small><i>Leave this blank if you dont want to change the password.</i></small>
				</div>
				<div class="form-group">
					<label for="" class="control-label">Avatar</label>
					<div class="custom-file">
		              <input type="file" class="custom-file-input rounded-circle" id="customFile" name="img" onchange="displayImg(this,$(this))">
		              <label class="custom-file-label" for="customFile">Choose file</label>
		            </div>
				</div>
				<div class="form-group d-flex justify-content-center">
					<img src="<?=$profile['avatar'] ? BASE_URL . PUBLIC_DIR ."/uploads/".$profile['avatar'] :BASE_URL . PUBLIC_DIR . '/uploads/no-image-available.png' ?>" alt="" id="cimg" class="img-fluid img-thumbnail">
				</div>
			</form>
		</div>
	</div>
	<div class="card-footer">
			<div class="col-md-12">
				<div class="row">
					<button class="btn btn-sm btn-primary" form="manage-user">Update</button>
				</div>
			</div>
		</div>
</div>
<style>
	img#cimg{
		height: 15vh;
		width: 15vh;
		object-fit: cover;
		border-radius: 100% 100%;
	}
</style>
<script>
	function displayImg(input,_this) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	        	$('#cimg').attr('src', e.target.result);
	        }

	        reader.readAsDataURL(input.files[0]);
	    }
	}
	$('#manage-user').submit(function(e){
		e.preventDefault();
var _this = $(this)

		start_loader()
        console.log("ahuah")
		$.ajax({
			url:'<?=site_url('Admin/update_profile/')?>',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
                console.log(resp);
				if(resp ==1){
					$('#msg').html('<div class="alert alert-success">Profile Updated Successfully!</div>')
					location.reload()
				}else{
					$('#msg').html('<div class="alert alert-danger">Something went wrong!</div>')
					end_loader()
				}
			}
		})
	})

</script>
          </div>

        </section>
      </div>
      </div>
      <?php require_once('inc/footer.php') ?>
</body>
<!-- Optional: Place to the bottom of scripts -->
<script>
	const myModal = new bootstrap.Modal(document.getElementById('modalId'), options)

</script>

<script>
	// var modalId = document.getElementById('modalId');

	// modalId.addEventListener('show.bs.modal', function (event) {
	// 	  // Button that triggered the modal
	// 	  let button = event.relatedTarget;
	// 	  // Extract info from data-bs-* attributes
	// 	  let recipient = button.getAttribute('data-bs-whatever');

	// 	// Use above variables to manipulate the DOM
	// });
</script>

</html>
