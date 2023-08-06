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
<?php endif;?>
<style>
#selectAll{
	top:0
}
</style>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">List of Appointments</h3>
		<div class="card-tools">
			<button class="btn btn-flat btn-primary" data-toggle="modal" data-target="#modalId"><span class="fas fa-plus"></span>  Create New</button>
		</div>
	</div>
	<div class="card-body">
        <div class="container-fluid">
			<div class="row" style="display:none" id="selected_opt">
				<div class="w-100 d-flex">
					<div class="col-2">
						<label for="" class="controllabel"> With Selected:</label>
					</div>
					<div class="col-3">
						<select id="w_selected" class="custom-select select" >
							<option value="pending">Mark as Pending</option>
							<option value="confirmed">Mark as Confirmed</option>
							<option value="cancelled">Mark as Cancelled</option>
							<option value="delete">Delete</option>
						</select>
					</div>
					<div class="col">
						<button class="btn btn-primary" type="button" id="selected_go">Go</button>
					</div>
				</div>
			</div>
			<table class="table table-bordered table-stripped" id="indi-list">
				<colgroup>
					<col width="5%">
					<col width="25%">
					<col width="25%">
					<col width="20%">
					<col width="20%">
				</colgroup>
				<thead>
					<tr>
						<!-- <td class="text-center"><div class="form-check">
								<input type="checkbox" class="form-check-input" id="selectAll">
							</div></td> -->
						<th class="text-center">#</th>
						<th>Name</th>
						<th>Schedule</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$i = 1;
						foreach($appointments as $row):
					?>
					
						<tr>
							<!-- <td class="text-center">
							<div class="form-check">
								<input type="checkbox" class="form-check-input invCheck" value="<?php echo $row['id'] ?>">
							</div>
							</td> -->
							<td class="text-center"><?php echo $i++; ?></td>
							<td><?php echo $row['name'] ?></td>
							<td><?php echo date("M d,Y h:i A",strtotime($row['date_sched'])) ?></td>
							<td class="text-center">
								<?php 
								switch($row['status']){ 
									case(0): 
										echo '<span class="badge badge-primary">Pending</span>';
									break; 
									case(1): 
									echo '<span class="badge badge-success">Confirmed</span>';
									break; 
									case(2): 
										echo '<span class="badge badge-danger">Cancelled</span>';
									break; 
									default: 
										echo '<span class="badge badge-secondary">NA</span>';
                                } 
								?>
							</td>
							<td align="center">
								 <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
				                  		Action
				                    <span class="sr-only">Toggle Dropdown</span>
				                  </button>
				                  <div class="dropdown-menu" role="menu">
				                    <a class="dropdown-item view_data" href="javascript:void(0)" data-id="<?php echo $row['aid'] ?>"> View</a>
									<div class="divider"></div>
									<?=$row['status']==0 ? '<a class="dropdown-item edit_data" href="javascript:void(0)" data-id="' .$row["aid"] .'"> Edit</a>' : ""?>
				                  </div>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>



<!-- Modal -->
<div class="modal fade  " id="modalId" tabindex="-1" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
	<div class="modal-dialog modal-sm modal-dialog-centered " role="document">
		<div class="modal-content ">
				<div class="modal-header">
						<h5 class="modal-title text-white" id="modalTitleId">Appointment Form</h5>
					</div>
			<div class="modal-body">
			<div class="container-fluid">
			<form id="appointment_form" class="py-2" ><!--  method="post" action="<?=site_url('Admin/add_appointment')?>"-->
			<div class="row text-white" id="appointment">
				<div class="col-12">
            <div class="form-group">
                <label for="date_sched" class="control-label">Appointment</label>
                <input type="datetime-local" class="form-control" name="date_sched" id = "date_sched"value="" required>
            </div>
        </div>
        <div class="form-group d-flex justify-content-end w-100 form-group">
            <button type="submit" class="btn btn-primary btn" >Submit Appointment</button>
            <!-- <a class="btn btn-primary btn" onclick="submitForm()">Add Appointment</a> -->
            <button class="btn-light btn ml-2" type="button" data-dismiss="modal">Cancel</button>
        </div>
        </form>
    </div>
</div>
			</div>
		</div>
	</div>
</div>



<!-- Modal Body -->
<!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
<div class="modal fade" id="view_modal" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md " role="document">
    <div class="modal-content rounded-0">
      <div class="modal-header">
        <h5 class="modal-title text-white" id="modalTitleId">Appointment Details</h5>
      </div>
      <div class="modal-body">
        <div class="container-fluid text-white">
          <p><b>Appointment Schedule: </b> <span id = "v_date"></span></p>
          <p><b>Patient Name: </b> <span id = "v_name"></span></p>
          <p><b>Gender: </b> <span id = "v_gender"></span></p>
          <p><b>Date of Birth: </b> <span id = "v_bd"></span></p>
          <p><b>Contact #: </b> <span id = "v_phone"></span></p>
          <p><b>Email #: </b> <span id = "v_email"></span></p>
          <p><b>Address: </b> <span id = "v_add"></span></p>
          <p><b>Ailment: </b> <span id = "v_ail"></span></p>
          <p><b>Prescription: </b> <span id = "v_presc"></span></p>
          <p><b>Status: </b><span id = "v_status"></span></p>
      </div>
      <div class="d-flex justify-content-end">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
      </div>
      
    </div>
  </div>
</div>
</div>

<div class="modal fade" id="edit_modal" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg " role="document">
    <div class="modal-content rounded-0">
      <div class="modal-header">
        <h5 class="modal-title text-white" id="modalTitleId">Appointment Details</h5>
      </div>
      <div class="modal-body">
        
<div class="container-fluid">
    <form id="appointment_update" class="py-2">
    <div class="row" id="appointment">
        <div class="col-6 text-white" id="frm-field">
                <div class="form-group">
                    <label for="name" class="control-label">Fullname</label>
                    <input type="text" class="form-control" name="name" id = "e_name" value="" required readonly>
                    <input type="text" class="form-control" name="id" id = "e_id" value="" required hidden>
                </div>
                <div class="form-group">
                    <label for="email" class="control-label">Email</label>
                    <input type="email" class="form-control" name="email" id = "e_email" value=""  required readonly>
                </div>
                <div class="form-group">
                    <label for="contact" class="control-label">Contact</label>
                    <input type="text" class="form-control" name="contact" value="" id = "e_phone"  required readonly>
                </div>
                <div class="form-group">
                    <label for="gender" class="control-label">Gender</label>
                    <input type="text" class="custom-select" id= "e_gender" name="gender" required readonly>
                </div>
                <div class="form-group">
                    <label for="dob" class="control-label">Date of Birth</label>
                    <input type="date" class="form-control" name="dob" value="" id = "e_bd"  required readonly>
                </div>
        </div>
        <div class="col-6 text-white">
                
                <div class="form-group">
                    <label for="address" class="control-label">Address</label>
                    <textarea class="form-control" name="address" id = "e_add" rows="3" required readonly></textarea>
                </div>

            <div class="form-group">
                <label for="ailment" class="control-label">Ailment</label>
                <textarea class="form-control" name="ailment" rows="3" id = "e_ail" required readonly></textarea>
            </div>
            <div class="form-group">
                <label for="date_sched" class="control-label">Appointment</label>
                <input type="datetime-local" class="form-control" id = "e_sched" name="date_sched" value="" required>
            </div>
        </div>
        <div class="form-group d-flex justify-content-end w-100 form-group">
            <button class="btn-primary btn">Submit Update</button>
            <button class="btn-light btn ml-2" type="button" data-dismiss="modal">Cancel</button>
        </div>
        </form>
    </div>
</div>
      </div>
      
    </div>
  </div>
</div>
</div>


<!-- Optional: Place to the bottom of scripts -->
<script>
	const myModal = new bootstrap.Modal(document.getElementById('modalId'), options)

</script>

<script>
	var modalId = document.getElementById('modalId');

	modalId.addEventListener('show.bs.modal', function (event) {
		  // Button that triggered the modal
		  let button = event.relatedTarget;
		  // Extract info from data-bs-* attributes
		  let recipient = button.getAttribute('data-bs-whatever');

		// Use above variables to manipulate the DOM
	});
</script>



<script>
	var indiList;
	$(document).ready(function(){
		$('.view_data').click(function(){
			console.log($(this).attr('data-id'));
			$.ajax({
				url:"<?=site_url('Patient/view_appointment/')?>" + $(this).attr('data-id'),
				data: [],
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
                    
					$('#v_date').text(resp[0]['sched']);
						$('#v_name').text(resp[0]['name']);
						$('#v_gender').text(resp[0]['gender']);
						$('#v_bd').text(resp[0]['bd']);
						$('#v_phone').text(resp[0]['contact']);
						$('#v_email').text(resp[0]['email']);
						$('#v_add').text(resp[0]['address']);
						$('#v_ail').text(resp[0]['ailment']);
						$('#v_presc').text(resp[0]['prescription']);
						if(resp[0]['status']==0){
							$('#v_status').removeClass();
							$('#v_status').addClass("badge badge-primary");
							$('#v_status').text("Pending");
						}
						if(resp[0]['status']==1){
							$('#v_status').removeClass();
							$('#v_status').addClass("badge badge-success");
							$('#v_status').text("Confirmed");
						}
						if(resp[0]['status']==2){
							$('#v_status').removeClass();
							$('#v_status').addClass("badge badge-danger");
							$('#v_status').text("Cancelled");
						}
						if(resp[0]['status']==3){
							$('#v_status').removeClass();
							$('#v_status').addClass("badge badge-secondary");
							$('#v_status').text("NA");
						}
						end_loader();
						$("#view_modal").modal('show');
				}
			})
		})
		$('#create_new').click(function(){
			uni_modal("Appointment Form","add_appointment.php",'mid-large')
		})
		$('.edit_data').click(function(){
			console.log($(this).attr('data-id'));
			$.ajax({
				url:"<?=site_url('Patient/view_appointment/')?>" + $(this).attr('data-id'),
				data: [],
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
					var bday = new Date(resp[0]['birthdate']).toISOString().split('T')[0];
					var sched = new Date(resp[0]['date_sched']).toISOString();
						$('#e_sched').val(resp[0]['date_sched']);
						$('#e_name').val(resp[0]['name']);
						$('#e_bd').val(bday);
						$('#e_phone').val(resp[0]['contact']);
						$('#e_gender').val(resp[0]['gender']);
						$('#e_email').val(resp[0]['email']);
						$('#e_add').val(resp[0]['address']);
						$('#e_ail').val(resp[0]['ailment']);
						$('#e_id').val(resp[0]['app_id']);
						if(resp[0]['status']==0){
							$('#v_status').removeClass();
							$('#v_status').addClass("badge badge-primary");
							$('#v_status').text("Pending");
						}
						if(resp[0]['status']==1){
							$('#v_status').removeClass();
							$('#v_status').addClass("badge badge-success");
							$('#v_status').text("Confirmed");
						}
						if(resp[0]['status']==2){
							$('#v_status').removeClass();
							$('#v_status').addClass("badge badge-danger");
							$('#v_status').text("Cancelled");
						}
						if(resp[0]['status']==3){
							$('#v_status').removeClass();
							$('#v_status').addClass("badge badge-secondary");
							$('#v_status').text("NA");
						}
						end_loader();
						$("#edit_modal").modal('show');
				}
			})
		})
		$('#selectAll').change(function(){
			// if($(this).is(":checked") == true){
			// 	$('.invCheck').prop("checked",true)
			// }else{
			// 	$('.invCheck').prop("checked",false)
			// }
			var _this = $(this)
			count = indiList.api().rows().data().length
			for($i = 0 ; $i < count; $i++){
				var node = indiList.api().row($i).node()
				console.log($(node).find('.invCheck'))
				if(_this.is(":checked") == true){
					$(node).find('.invCheck').prop("checked",true)
					$('#selected_opt').show('slow')
				}else{
					$(node).find('.invCheck').prop("checked",false)
					$('#selected_opt').hide('slow')
				}
			}
		})
		
	})
	$(function(){
		indiList = $('#indi-list').dataTable({
			columnDefs:[{
				targets:[0,5],
				orderable:false
			}],
			order:[[1,'asc']],
		});
		// console.log(indiList)
		$(indiList.fnGetNodes()).find('.invCheck').change(function(){
			if($(this).is(":checked")==true){
				if($('#selected_opt').is(':visible') == false){
					$('#selected_opt').show('slow')
				}
				
			}else{
				if($(indiList.fnGetNodes()).find('.invCheck:checked').length <= 0){
					if($('#selected_opt').is(':visible') == true){
						$('#selected_opt').hide('slow')
					}
				}
			}
			if($(indiList.fnGetNodes()).find('.invCheck:checked').length == $(indiList.fnGetNodes()).find('.invCheck').length){
				$('#selectAll').prop('checked',true)
			}else if($(indiList.fnGetNodes()).find('.invCheck:checked').length <= 0){
				$('#selectAll').prop('checked',false)
			}else{
				$('#selectAll').prop('checked',false)
			}
		})

		$('#selected_go').click(function(){
			start_loader();
			var ids = [];
			$(indiList.fnGetNodes()).find('.invCheck:checked').each(function(){
				ids.push($(this).val())
			})
			var _action = $('#w_selected').val()
			$.ajax({
				url:_base_url_+'classes/Master.php?f=multiple_action',
				method:"POST",
				data:{ids:ids,_action:_action},
				dataType:'json',
				error:err=>{
					console.log(err)
					alert_toast("An error occured",'error');
					end_loader();
				},
				success:function(resp){
					if(typeof resp =='object' && resp.status == 'success'){
						location.reload();
					}else if(resp.status == 'failed' && !!resp.msg){
						alert_toast(resp.msg,'error');
                            end_loader()
                    }else{
						alert_toast("An error occured",'error');
						end_loader();
                        console.log(resp)
					}
				}
			})
		})
	})
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
      <!-- /.content-wrapper -->
      <?php require_once('inc/footer.php') ?>
  </body>
  <script>

// FOR ADDING APPOINTMENT
$(function(){
    $('#appointment_form').submit(function(e){
        e.preventDefault();
            var _this = $(this)
            console.log('huhheheheh');
			 $('.err-msg').remove();
			start_loader();
			$.ajax({
				url:"<?=site_url('Patient/add_appointment')?>",
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
					}else if(resp.status == 'failed' && !!resp.msg){
                        var el = $('<div>')
                            el.addClass("alert alert-danger err-msg").text(resp.msg)
                            _this.prepend(el)
                            el.show('slow')
                            $("html, body").animate({ scrollTop: $('#uni_modal').offset().top }, "fast");
                    }else{
						alert_toast("An error occured",'error');
                        console.log(resp)
					}
						end_loader();
				}
			})
    })
    $('#uni_modal').on('hidden.bs.modal', function (e) {
        if($('#appointment_form').length <= 0)
            location.reload()
    })
});


// FOR UPDATING APPOINTMENT

$(function(){
    $('#appointment_update').submit(function(e){
        e.preventDefault();
            var _this = $(this)
            console.log('huhheheheh');
			 $('.err-msg').remove();
			start_loader();
			$.ajax({
				url:"<?=site_url('Patient/update_appointment')?>",
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
					}else if(resp.status == 'failed' && !!resp.msg){
                        var el = $('<div>')
                            el.addClass("alert alert-danger err-msg").text(resp.msg)
                            _this.prepend(el)
                            el.show('slow')
                            $("html, body").animate({ scrollTop: $('#uni_modal').offset().top }, "fast");
                    }else{
						alert_toast("An error occured",'error');
                        console.log(resp)
					}
						end_loader();
				}
			})
    })
    $('#uni_modal').on('hidden.bs.modal', function (e) {
        if($('#appointment_form').length <= 0)
            location.reload()
    })
});
    </script>

</html>
