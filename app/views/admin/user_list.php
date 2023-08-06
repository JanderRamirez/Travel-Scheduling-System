<?php $LAVA = lava_instance() ?>
<!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
<?php require_once('inc/header.php') ?>
  <body class="sidebar-mini layout-fixed control-sidebar-slide-open layout-navbar-fixed light-mode sidebar-mini-md sidebar-mini-xs" data-new-gr-c-s-check-loaded="14.991.0" data-gr-ext-installed="" style="height: auto;">
    <div class="wrapper">
     <?php require_once('inc/topBarNav.php') ?>
     <?php require_once('inc/navigation.php') ?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper bg-light pt-3" style="min-height: 567.854px;">
     
        <!-- Main content -->
        <section class="content  text-dark">
          <div class="container-fluid">
<style>
    .img-avatar{
        width:45px;
        height:45px;
        object-fit:cover;
        object-position:center center;
        border-radius:100%;
    }
</style>
<div class="card card-outline card-success">
	<div class="card-header">
    <div class="row"><div class="col-6"><h3 class="card-title">LIST OF GO-PISD EMPLOYEES</h3></div><div class="col-6 d-flex justify-content-end"><button type="button" class="btn btn-flat btn-success" data-toggle="modal" data-target="#modal_add"><span class="fas fa-plus"></span>  New Employee</button></div></div>
		
		<div class="card-tools">
			<!-- <a href="?page=user/manage_user" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span>  Create New</a> -->
		</div>
	</div>
	<div class="card-body">
		<div class="container-fluid">
        <div class="container-fluid">
        <table class="table table-bordered table-stripped" id="indi-list">
				<thead>
					<tr>
						<th>#</th>
						<th class="text-center">Employee No.</th>
						<th>First Name</th>
						<th>Middle Name</th>
						<th>Last Name</th>
						<th>Position</th>
						<th>Last T.O.</th>
						<th>Action</th> 
					</tr>
				</thead>
				<tbody>
					<?php 
					$i = 1;
						foreach($users as $row):
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td class="text-center"><?=$row['emp_no'] ?></td>
							<td><?php echo ucwords($row['fname']) ?></td>
							<td><?php echo ucwords($row['mname']) ?></td>
							<td><?php echo ucwords($row['lname']) ?></td>
							<td ><p class="m-0 truncate-1"><?php echo strtoupper($row['position'])?></p></td>
							<td ><p class="m-0 truncate-1"><?php echo $row['last_to'] ?></p></td>
							<td class="text-center "><p class="m-0 truncate-1 "><a href="#" class="edit_emp text-success" data-toggle="modal" data-target="#modal_edit<?=$row['id'] ?>"><i class="fa fa-edit"></i></a></p></td>
						</tr>



               <!-- Modal for Add New -->
<div class="modal fade" id="modal_edit<?=$row['id'] ?>" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
    <div class="modal-content rounded-0">
      <div class="modal-header">
        <center><h5 class="modal-title text-center">Update Information</h5></center>
      </div>
      <div class="modal-body">
			<div class="container-fluid text-dark">
    <form id="emp_add" class="py-2 emp_update">
    <div class="row" id="appointment">
        <div class="col-12" id="frm-field">
          <div class="row">
            <div class="form-group col-4">
                    <label for="name" class="control-label">Employee No.</label>
                    <input type="text" class="form-control" id="m_travel_order" name="emp_no" value="<?=$row['emp_no'] ?>"  required>
                    <input type="text" class="form-control" id="m_travel_order" name="id" value="<?=$row['id'] ?>" hidden required>
                </div>
                <div class="form-group col-4">
                    <label for="contact" class="control-label">Position</label>
                    <input type="text" class="form-control" name="pos" value="<?=strtoupper($row['position'])?>"  required>
                </div>
                <div class="form-group col-4">
                    <label for="contact" class="control-label">Last T.O.</label>
                    <input type="date" class="form-control" name="last_to" value="<?=$row['last'] ?>"  required>
                </div>
          </div>
                <div class="row">
                <div class="form-group col-4">
                    <label for="dob" class="control-label">First Name</label>
                    <input type="text" class="form-control" name="fname" value="<?php echo ucwords($row['fname']) ?>"  required>
                </div>
                <div class="form-group col-4">
                    <label for="dob" class="control-label">Middle Name</label>
                    <input type="text" class="form-control" name="mname" value="<?php echo ucwords($row['mname']) ?>"  >
                </div>
                <div class="form-group col-4">
                    <label for="email" class="control-label">Last Name</label>
                    <input type="text" class="form-control" name="lname" value="<?php echo ucwords($row['lname']) ?>"  required>
                </div>
                </div>
              </div>
        <div class="form-group d-flex justify-content-end w-100 form-group">
            <button class="btn-primary btn" type="submit">Save</button>
            <button class="btn-light btn ml-2" type="button" data-dismiss="modal">Cancel</button>
        </div>
        </form>
    </div>
</div>
</div>
    </div>
  </div>
</div>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('.delete_data').click(function(){
			_conf("Are you sure to delete this User permanently?","delete_user",[$(this).attr('data-id')])
		})
		$('.table').dataTable();
	})
	function delete_user($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Users.php?f=delete",
			method:"POST",
			data:{id: $id},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("An error occured.",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status == 'success'){
					location.reload();
				}else{
					alert_toast("An error occured.",'error');
					end_loader();
				}
			}
		})
	}
</script>
          </div>
        </section>
        <!-- /.content -->
  <div class="modal fade" id="confirm_modal" role='dialog'>
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Confirmation</h5>
      </div>
      <div class="modal-body">
        <div id="delete_content"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id='confirm' onclick="">Continue</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="uni_modal" role='dialog'>
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title"></h5>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id='submit' onclick="$('#uni_modal form').submit()">Save</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="uni_modal_right" role='dialog'>
    <div class="modal-dialog modal-full-height  modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="fa fa-arrow-right"></span>
        </button>
      </div>
      <div class="modal-body">
      </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="viewer_modal" role='dialog'>
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
              <button type="button" class="btn-close" data-dismiss="modal"><span class="fa fa-times"></span></button>
              <img src="" alt="">
      </div>
    </div>
  </div>
      </div>

      
     <!-- Modal for Add New -->
<div class="modal fade" id="modal_add" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
    <div class="modal-content rounded-0">
      <div class="modal-header">
        <center><h5 class="modal-title text-center">Add New Employee</h5></center>
      </div>
      <div class="modal-body">
			<div class="container-fluid text-dark">
    <form id="emp_add" class="py-2">
    <div class="row" id="appointment">
        <div class="col-12" id="frm-field">
          <div class="row">
            <div class="form-group col-4">
                    <label for="name" class="control-label">Employee No.</label>
                    <input type="text" class="form-control" id="m_travel_order" name="emp_no" value=""  required>
                </div>
                <div class="form-group col-4">
                    <label for="contact" class="control-label">Position</label>
                    <input type="text" class="form-control" name="pos" value=""  required>
                </div>
                <div class="form-group col-4">
                    <label for="contact" class="control-label">Last T.O.</label>
                    <input type="date" class="form-control" name="last_to" value=""  required>
                </div>
          </div>
                <div class="row">
                <div class="form-group col-4">
                    <label for="dob" class="control-label">First Name</label>
                    <input type="text" class="form-control" name="fname" value=""  required>
                </div>
                <div class="form-group col-4">
                    <label for="dob" class="control-label">Middle Name</label>
                    <input type="text" class="form-control" name="mname" value=""  >
                </div>
                <div class="form-group col-4">
                    <label for="email" class="control-label">Last Name</label>
                    <input type="text" class="form-control" name="lname" value=""  required>
                </div>
                </div>
              </div>
        <div class="form-group d-flex justify-content-end w-100 form-group">
            <button class="btn-primary btn" type="submit">Save</button>
            <button class="btn-light btn ml-2" type="button" data-dismiss="modal">Cancel</button>
        </div>
        </form>
    </div>
</div>
</div>
    </div>
  </div>
</div>
      
      
      
      
      <!-- /.content-wrapper -->
      <?php require_once('inc/footer.php') ?>

      <script>
            $(function(){
    $('#emp_add').submit(function(e){
      start_loader();
        e.preventDefault();
            var _this = $(this)
        $.ajax({
				url:"<?=site_url('Admin/add_employee')?>",
				data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
				error:err=>{
					console.log(err)
					alert_toast("An error occured",'error');
					end_loader();
				},
				success:function(resp){
                    console.log(resp);
					if(typeof resp =='object' && resp.status == 'success'){
                       location.reload()
					}else if(resp.status == 'failed'){
            alert_toast(resp.msg,'error');
                            
                    }else{
						alert_toast("An error occured",'error');
                        console.log(resp)
					}
						end_loader();
				}
			})
      
			 $('.err-msg').remove();
			
		
    })

    $('.emp_update').submit(function(e){
      start_loader();
        e.preventDefault();
            var _this = $(this)
        $.ajax({
				url:"<?=site_url('Admin/update_employee')?>",
				data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
				error:err=>{
					console.log(err)
					alert_toast("An error occured",'error');
					end_loader();
				},
				success:function(resp){
                    console.log(resp);
					if(typeof resp =='object' && resp.status == 'success'){
                       location.reload()
					}else if(resp.status == 'failed'){
            alert_toast(resp.msg,'error');
                            
                    }else{
						alert_toast("An error occured",'error');
                        console.log(resp)
					}
						end_loader();
				}
			})
      
			 $('.err-msg').remove();
			
		
    })
});
      </script>
  </body>
</html>
