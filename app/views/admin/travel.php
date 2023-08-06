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
<div class="card card-outline card-success">
	<div class="card-header">
		<h3 class="card-title">LIST OF GO-PISD TRAVEL</h3>
		<div class="card-tools">
			<button class="btn btn-flat btn-success" id = "add_new"><span class="fas fa-plus"></span>  Create New</button>
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
					<col width="3%">
					<col width="8%">
					<col width="20%">
					<col width="20%">
					<col width="15%">
					<col width="15%">
				</colgroup>
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>Control No.</th>
						<th>Destination</th>
						<th>Purpose</th>
						<th>Departure</th>
						<th>Return</th>
						<th>Vehicle</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$i = 1;
					// var_dump($appointments);
						foreach($travels as $row):
					?>
					
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td><?php echo $row['control_no'] ?></td>
							<td><?php echo $row['destination'] ?></td>
							<td><?php echo $row['purpose'] ?></td>
							<td><?php echo date("M d,Y",strtotime($row['date_departure'])) ?></td>
							<td><?php echo date("M d,Y",strtotime($row['date_return'])) ?></td>
							<td><?php echo $row['vehicle'] ?></td>
							
							<td align="center">
								 <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
				                  		Action
				                    <span class="sr-only">Toggle Dropdown</span>
				                  </button>
				                  <div class="dropdown-menu " role="menu">
				                    <a class="dropdown-item view_data bg-success" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"> View</a>
									<div class="divider"></div>
									<a class="dropdown-item bg-success" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>" data-toggle="modal" data-target="#modal_edit<?php echo $row['id'] ?>"> Edit</a>
				                  </div>
							</td>
						</tr>




            
<!-- Modal for Edit New -->
<div class="modal fade" id="modal_edit<?php echo $row['id'] ?>" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg " role="document">
    <div class="modal-content rounded-0">
      <div class="modal-header">
        <center><h5 class="modal-title text-center">Update Travel Order</h5></center>
      </div>
      <div class="modal-body">
			<div class="container-fluid text-dark">
    <form id="travel_add" class="py-2">
    <div class="row" id="appointment">
        <div class="col-6" id="frm-field">
                <div class="form-group">
                    <label for="name" class="control-label">Travel Order:</label>
                    <input type="text" class="form-control" id="m_travel_order" name="to_no" value="<?php echo $row['control_no'] ?>" readonly required>
                </div>
                <div class="form-group">
                    <label for="dob" class="control-label">Date of Departure</label>
                    <input type="date" class="form-control" name="depart" value="<?php echo date("Y-m-d",strtotime($row['date_departure'])) ?>"  required>
                </div>
                <div class="form-group">
                    <label for="dob" class="control-label">Date of Return</label>
                    <input type="date" class="form-control" name="return" value="<?php echo date("Y-m-d",strtotime($row['date_return'])) ?>"  required>
                </div>
                <div class="form-group">
                    <label for="email" class="control-label">Office/Station</label>
                    <input type="text" class="form-control" name="office" value="<?php echo $row['office'] ?>"  required>
                </div>
                <div class="form-group">
                    <label for="contact" class="control-label">Vehicle</label>
                    <input type="text" class="form-control" name="vehicle" value="<?php echo $row['vehicle'] ?>"  required>
                </div>
                <div class="form-group">
                  <div class="row">
                  <div class="col-6">
                     <label for="gender" class="control-label">Type</label>
                    <select type="text" class="custom-select type" name="type" required>
                    <option>Select</option>
                    <option value="1" <?=$row['type']==1? "selected" : ""?>>Individual</option>
                    <option value="2"  <?=$row['type']==2? "selected" : ""?>>Group</option>
                    </select>
                  </div>
                   <div class="col-6 mt-4 d-flex align-items-center">
                    <a type="button" class="btn btn-flat btn-success mt-1 assoc" data-id="<?php echo $row['id'] ?>" data-type="<?php echo $row['type'] ?>">Travel Associate </a>
                   </div>
                   </div>
                </div>
              </div>
        <div class="col-6">
        <div class="form-group">
                    <label for="contact" class="control-label">Report to</label>
                    <input type="text" class="form-control" name="report" value="<?php echo $row['report_to'] ?>"  required>
                </div>
                <div class="form-group">
                    <label for="contact" class="control-label">Chargeable Against</label>
                    <input type="text" class="form-control" name="charge" value="<?php echo $row['charge_to'] ?>"  required>
                </div>
                <div class="form-group">
                    <label for="address" class="control-label">Destination</label>
                    <textarea class="form-control" name="destination" rows="3" required><?php echo $row['destination'] ?></textarea>
                </div>
				<div class="form-group">
                <label for="ailment" class="control-label">Purpose  </label>
                <textarea class="form-control" name="purpose" rows="3"  required><?php echo $row['purpose'] ?></textarea>
            </div>
            <div class="form-group">
                <label for="date_sched" class="control-label">Remarks</label>
                <input type="text" class="form-control" name="remarks" value="<?php echo $row['remarks'] ?>"  >
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






<!-- Modal For Details -->
<div class="modal fade" id="view_modal" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg " role="document">
    <div class="modal-content rounded-0">
      <div class="modal-header">
        <center><h5 class="modal-title text-center">Travel Details</h5></center>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row">
          <div class="col-6">
            <p><b>Date Created:</b> <span id = "v_cdate"></span></p>
            <p><b>Destination:</b> <span id = "v_desig"></span></p>
            <p><b>Date of Departure:</b> <span id = "v_depart"></span></p>
            <p><b>Date of Return:</b> <span id = "v_return"></span></p>
            <p><b>Purpose:</b> <span id = "v_purpose"></span></p>
          </div>   
          <div class="col-6">
            <p><b>Office/Station:</b> <span id = "v_office"></span></p>
            <p><b>Vehicle:</b> <span id = "v_vehicle"></span></p>
            <p><b>Report to:</b> <span id = "v_report"></span></p>
            <p><b>Chargeable Against:</b> <span id = "v_charge"></span></p>
            <p><b>Remarks:</b> <span id = "v_remarks"></span></p>
          </div>
        </div>
          <table class="table mytable">
          <colgroup>
					<col width="40%">
					<col width="30%">
					<col width="30%">
				</colgroup>
            <thead class="text-bold">
              <tr>
                <td>Name</td>
                <td>Position/Designation</td>
                <td>Date of Last T.O.</td>
                <tr>
            </thead>
            <tbody>

            </tbody>
          </table>
      </div>
      <div class="d-flex justify-content-end">
        <a name="" id="print" class="btn btn-success mr-1" href="#" target="_blank" role="button">Print</a>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
      </div>
      
    </div>
  </div>
</div>
</div>



<!-- Modal for Add New -->
<div class="modal fade" id="modal_add" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg " role="document">
    <div class="modal-content rounded-0">
      <div class="modal-header">
        <center><h5 class="modal-title text-center">New Travel Order</h5></center>
      </div>
      <div class="modal-body">
			<div class="container-fluid text-dark">
    <form id="travel_add" class="py-2">
    <div class="row" id="appointment">
        <div class="col-6" id="frm-field">
                <div class="form-group">
                    <label for="name" class="control-label">Travel Order:</label>
                    <input type="text" class="form-control" id="m_travel_order" name="to_no" value="" readonly required>
                </div>
                <div class="form-group">
                    <label for="dob" class="control-label">Date of Departure</label>
                    <input type="date" class="form-control" name="depart" value=""  required>
                </div>
                <div class="form-group">
                    <label for="dob" class="control-label">Date of Return</label>
                    <input type="date" class="form-control" name="return" value=""  required>
                </div>
                <div class="form-group">
                    <label for="email" class="control-label">Office/Station</label>
                    <input type="text" class="form-control" name="office" value="GO-PISD"  required>
                </div>
                <div class="form-group">
                    <label for="contact" class="control-label">Vehicle</label>
                    <input type="text" class="form-control" name="vehicle" value=""  required>
                </div>
                <div class="form-group">
                    <label for="gender" class="control-label">Type</label>
                    <select type="text" class="custom-select type" name="type" required>
                    <option>Select</option>
                    <option value="1">Individual</option>
                    <option value="2">Group</option>
                    </select>
                </div>
              </div>
        <div class="col-6">
        <div class="form-group">
                    <label for="contact" class="control-label">Report to</label>
                    <input type="text" class="form-control" name="report" value="Activity Coordinator"  required>
                </div>
                <div class="form-group">
                    <label for="contact" class="control-label">Chargeable Against</label>
                    <input type="text" class="form-control" name="charge" value="PISD Travelling/Information Management"  required>
                </div>
                <div class="form-group">
                    <label for="address" class="control-label">Destination</label>
                    <textarea class="form-control" name="destination" rows="3" required></textarea>
                </div>
				<div class="form-group">
                <label for="ailment" class="control-label">Purpose  </label>
                <textarea class="form-control" name="purpose" rows="3"  required></textarea>
            </div>
            <div class="form-group">
                <label for="date_sched" class="control-label">Remarks</label>
                <input type="text" class="form-control" name="remarks" value=""  >
            </div>
            <input class="form-check-input ids" type="text" value="" name = "ids" id="id[]" hidden>
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
                    <input type="text" class="form-control" name="name" id = "e_name" value="" required>
                    <input type="text" class="form-control" name="id" id = "e_id" value="" required hidden>
                    <input type="text" class="form-control" name="pid" id = "p_id" value="" required hidden>
                </div>
                <div class="form-group">
                    <label for="email" class="control-label">Email</label>
                    <input type="email" class="form-control" name="email" id = "e_email" value=""  required >
                </div>
                <div class="form-group">
                    <label for="contact" class="control-label">Contact</label>
                    <input type="text" class="form-control" name="contact" value="" id = "e_phone"  required >
                </div>
                <div class="form-group">
                    <label for="gender" class="control-label">Gender</label>
                    <input type="text" class="custom-select" id= "e_gender" name="gender" required >
                </div>
                <div class="form-group">
                    <label for="dob" class="control-label">Date of Birth</label>
                    <input type="date" class="form-control" name="dob" value="" id = "e_bd"  required >
                </div>
				
				<div class="form-group">
                <label for="date_sched" class="control-label">Appointment</label>
                <input type="datetime-local" class="form-control" id = "e_sched" name="date_sched" value="" required>
            </div>
        </div>
        <div class="col-6 text-white">
                
                <div class="form-group">
                    <label for="address" class="control-label">Address</label>
                    <textarea class="form-control" name="address" id = "e_add" rows="3" required ></textarea>
                </div>

            <div class="form-group">
                <label for="ailment" class="control-label">Ailment</label>
                <textarea class="form-control" name="ailment" rows="3" id = "e_ail" required></textarea>
            </div>
			<?php if($LAVA->session->userdata('user_type') == 'doctor') {?>
			<div class="form-group">
                <label for="ailment" class="control-label">Prescription</label>
                <textarea class="form-control" name="presc" rows="3" id = "e_presc" ></textarea>
            </div>
			<?php } 
			?>
			<div class="form-group">
                <label for="status" class="control-label">Status</label>
                <select name="status" id="e_status" class="custom custom-select">
                    <option id="e_0" value="0">Pending</option>
                    <option id="e_1" value="1">Confirmed</option>
                    <option id="e_2" value="2">Cancelled</option>
                </select>
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



<div class="modal fade" id="modal_emp" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md " role="document">
    <div class="modal-content rounded-0">
      <div class="modal-header">
        <center><h5 class="modal-title text-center">Travel Order</h5></center>
      </div>
      <div class="modal-body">
			<div class="container-fluid text-dark">
    <form id="" class="py-2" method="post" action="<?=site_url('Admin/add_emp')?>">
    <div class="row" id="appointment">
        <div class="col-12">
          <div class="table-responsive">
            <table class="table mytable" width="100%">
              <thead>
                <tr>
                  <th scope="col">Name</th>
                  <th scope="col">Last Travel</th>
                </tr>
              </thead>
              <tbody class = "group">
              </tbody>
            </table>
          </div>
          
          
            <!-- <input class="form-check-input ids" type="text" value="" name = "ids" id="id[]" hidden> -->
          </div>
        </div>
        <div class="form-group d-flex justify-content-end w-100 form-group">
            <button class="btn-success btn ml-2" type="button" data-dismiss="modal">OK</button>
        </div>
        </form>
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
				url:"<?=site_url('Admin/view_travel/')?>" + $(this).attr('data-id'),
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
                                      $('.mytable > tbody tr').remove();
                                      for(let x in resp['names']){
                                          console.log(name['fname']); 
                                        $(".mytable > tbody").append("<tr><td>"+resp['names'][x]['fname'] + " " + resp['names'][x]['lname']+"</td><td>"+resp['names'][x]['position']+"</td><td>"+resp['names'][x]['last']+"</td></tr>");
                                        }
                                        $('#v_cdate').text(resp['details'][0]['date_created']);
                                        $('#v_desig').text(resp['details'][0]['destination']);
                                        $('#v_depart').text(resp['details'][0]['date_departure']);
                                        $('#v_return').text(resp['details'][0]['date_return']);
                                        $('#v_purpose').text(resp['details'][0]['purpose']);
                                        $('#v_office').text(resp['details'][0]['office']);
                                        $('#v_vehicle').text(resp['details'][0]['vehicle']);
                                        $('#v_report').text(resp['details'][0]['report_to']);
                                        $('#v_charge').text(resp['details'][0]['charge_to']);
                                        $('#v_remarks').text(resp['details'][0]['remarks']);
                                        $("#print").attr('href', '<?=site_url('Admin/print/')?>'+info.event.id + '/' + resp['details'][0]['type'] )
                                        
                                        
                                end_loader();
                            }
                          })
                          $("#view_modal").modal('show');
			})
		})


    $(document).ready(function(){
		$('.assoc').click(function(){
			console.log($(this).attr('data-id'));
			console.log($(this).attr('data-type'));
      ty = $(this).attr('data-type');
			$.ajax({
				url:"<?=site_url('Admin/view_assoc/')?>" + $(this).attr('data-id'),
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
                                      $('.mytable > tbody tr').remove();
                                      if(ty=='2'){
                                        for(let x in resp['names']){
                                          console.log(resp['ids']);
                                          if(resp['ids'].includes(resp['names'][x]['id'])){
                                            $(".mytable > tbody").append("<tr>" + '<td scope="row"><div class="form-check"><input checked class="form-check-input cb_name" type="checkbox" value="' +resp['names'][x]['id']+ '" id=""><label class="form-check-label" for=""></label></div></td>' + "<td>"+resp['names'][x]['fname'] + " " + resp['names'][x]['lname']+"</td><td>"+resp['names'][x]['position']+"</td><td>"+resp['names'][x]['last']+"</td></tr>");
                                          }
                                          else{
                                            $(".mytable > tbody").append("<tr>" + '<td scope="row"><div class="form-check"><input  class="form-check-input cb_name" type="checkbox" value="' +resp['names'][x]['id']+ '" id=""><label class="form-check-label" for=""></label></div></td>' + "<td>"+resp['names'][x]['fname'] + " " + resp['names'][x]['lname']+"</td><td>"+resp['names'][x]['position']+"</td><td>"+resp['names'][x]['last']+"</td></tr>");
                                          }
                                        }
                                      }
                                      else{
                                        for(let x in resp['names']){
                                          console.log(resp['ids']);
                                          if(resp['ids'].includes(resp['names'][x]['id'])){
                                            $(".mytable > tbody").append("<tr>" + '<td scope="row"><div class="form-check"><input checked class="form-check-input cb_name" type="radio" name = "cb_id" value="' +resp['names'][x]['id']+ '" id=""><label class="form-check-label" for=""></label></div></td>' + "<td>"+resp['names'][x]['fname'] + " " + resp['names'][x]['lname']+"</td><td>"+resp['names'][x]['position']+"</td><td>"+resp['names'][x]['last']+"</td></tr>");
                                          }
                                          else{
                                            $(".mytable > tbody").append("<tr>" + '<td scope="row"><div class="form-check"><input  class="form-check-input cb_name" type="radio" value="' +resp['names'][x]['id']+ '" id=""><label class="form-check-label" for=""></label></div></td>' + "<td>"+resp['names'][x]['fname'] + " " + resp['names'][x]['lname']+"</td><td>"+resp['names'][x]['position']+"</td><td>"+resp['names'][x]['last']+"</td></tr>");
                                          }
                                        }
                                      }
                                      
                                        
                                end_loader();
                            }
                          })
                          $("#modal_emp").modal('show');
			})
		})


		$('#create_new').click(function(){
			uni_modal("Appointment Form","add_appointment.php",'mid-large')
		})
		$('.edit_data').click(function(){
			// console.log($(this).attr('data-id'));
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
                    // console.log(resp);
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
						$('#p_id').val(resp[0]['pid']);
						$('#e_presc').val(resp[0]['prescription']);
						console.log(resp[0]['status']);
						if(resp[0]['status']==0){
							$('#e_1').removeAttr("selected");
							$('#e_2').removeAttr("selected");
							$('#e_1').attr("selected", "selected");
						}
						if(resp[0]['status']==1){
							$('#e_0').removeAttr("selected");
							$('#e_2').removeAttr("selected");
							$('#e_1').attr("selected", "selected");
						}
						if(resp[0]['status']==2){
							$('#e_1').removeAttr("selected");
							$('#e_0').removeAttr("selected");
							$('#e_2').attr("selected", "selected");
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
				url:"<?=site_url('Admin/multiple_action')?>",
				method:"POST",
				data:{ids:ids,_action:_action},
				dataType:'json',
				error:err=>{
					console.log(err)
					alert_toast("An error occured",'error');
					// end_loader();
				},
				success:function(resp){
                        console.log(resp)
					if(typeof resp =='object' && resp.status == 'success'){
						location.reload();
					}else if(resp.status == 'failed' && !!resp.msg){
						alert_toast(resp.msg,'error');
                            // end_loader()
                    }else{
						alert_toast("An error occured",'error');
						// end_loader();/
                        console.log(resp)
					}
				}
			})
		})
	})


	$(function(){
		$('#add_new').click(function(){
          start_loader();
			$.ajax({
				url:"<?=site_url('Admin/get_to')?>",
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
          if(resp['control_no'].substr(resp['control_no'].indexOf('-')+1)==new Date().getFullYear().toString().substr(-2)){
            console.log(new Date().getFullYear().toString().substr(-2));
            $('#m_travel_order').val(parseInt(resp['control_no'].substr(0,resp['control_no'].indexOf('-')))+1 +'-'+ new Date().getFullYear().toString().substr(-2));
          }
          else{
            $('#m_travel_order').val(1 +'-'+ new Date().getFullYear().toString().substr(-2));
          }
					// $('#m_travel_order').val(resp['control_no']);
						end_loader();
						$("#modal_add").modal('show');
				}
			})
		})

    $('#travel_add').submit(function(e){
      start_loader();
        e.preventDefault();
            var _this = $(this)
      if(id.length===0){
        alert_toast("No Employee Selected",'error');
        end_loader();
      }
      else{
        $.ajax({
				url:"<?=site_url('Admin/add_travel')?>",
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
      }
			 $('.err-msg').remove();
			
		
    })
});
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
    $('#appointment_add').submit(function(e){
        e.preventDefault();
            var _this = $(this)
            console.log('huhheheheh');
			 $('.err-msg').remove();
			start_loader();
			$.ajax({
				url:"<?=site_url('Admin/add_appointment')?>",
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
    // $('#uni_modal').on('hidden.bs.modal', function (e) {
    //     if($('#appointment_form').length <= 0)
    //         location.reload()
    // })
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
				url:"<?=site_url('Admin/update_appointment')?>",
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
