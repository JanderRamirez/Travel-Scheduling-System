<?php $LAVA = lava_instance() ?>  

 <!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
<?php require_once('inc/header.php') ?>
  <body class="sidebar-mini layout-fixed control-sidebar-slide-open layout-navbar-fixed light-mode sidebar-mini-md sidebar-mini-xs" data-new-gr-c-s-check-loaded="14.991.0" data-gr-ext-installed="" style="height: auto;">
    <div class="wrapper">
     <?php require_once('inc/topBarNav.php') ?>
     <?php require_once('inc/navigation.php') ?>
              
      <div class="content-wrapper bg-light text-dark pt-3" style="min-height: 567.854px;">
     
        <!-- Main content -->
        <section class="content  text-dark">
          <div class="container-fluid">
            <div class="row">
              <div class="col-10">
                <h1 class="text-dark">Welcome to Travel Scheduling System</h1>
              </div>
              <!-- <div class="card-tools">
			<button class="btn btn-flat btn-primary" id = "add_new"><span class="fas fa-plus"></span>  Create New</button>
		</div> -->
              <div class="col-2 d-flex justify-content-end card-tools">
                <button class="btn btn-flat btn-success" id = "add_new"><span class="fas fa-plus"></span>  Create New</button>
              </div>
            </div>
          
<?php
 $sched_arr=array();
?>

<hr>
<div class="container">
  <div class="card">
    <div class="card-body">
        <div id="calendar"></div>
    </div>
  </div>
</div>

<style>
    .fc-event:hover, .fc-event-selected {
        color: black !important;
    }
    a.fc-list-day-text {
        color: black !important;
    }
    .fc-event:hover, .fc-event-selected {
        color: white !important;
        background: var(--dark);
        cursor: pointer;
    }
    .fc-day-past .fc-daygrid-event-dot{
      border-color: var(--danger) !important;
    }
    /* .card{
      background-image: url("<?=BASE_URL . PUBLIC_DIR?>/uploads/pio.jpg");
      background-position: center;
      background-repeat: no-repeat;
      background-size: cover;
      position: relative;
      opacity: 0.1;
    }
    .card-body{
      opacity: 1;
    } */
</style>
<?php
$sched_arr = json_encode($appointments);
?>
<script>
    $(function(){
        $('.select2').select2()
        var Calendar = FullCalendar.Calendar;
        var date = new Date()
        var d    = date.getDate(),
            m    = date.getMonth(),
            y    = date.getFullYear()
        var scheds = $.parseJSON('<?php echo ($sched_arr) ?>');

        var calendarEl = document.getElementById('calendar');

        var calendar = new Calendar(calendarEl, {
                        initialView:"dayGridMonth",
                        headerToolbar: {
                            right : "dayGridWeek,dayGridMonth,listDay prev,next"
                        },
                        buttonText:{
                            dayGridWeek :"Week",
                            dayGridMonth :"Month",
                            listDay :"Day",
                            listWeek :"Week",
                        },
                        themeSystem: 'bootstrap',
                        // height: '1500px',
                        //Random default events
                        events:function(event,successCallback){
                            var days = moment(event.end).diff(moment(event.start),'days')
                            var events = []
                            Object.keys(scheds).map(k=>{
                                var bg = 'var(--success)';
                                if(scheds[k].date_departure == 0)
                                    bg = 'var(--primary)';
                                if(scheds[k].date_departure == 1)
                                    bg = 'var(--success)';
                                console.log(bg)
                                events.push({
                                    id          : scheds[k].id,
                                    title          : scheds[k].destination,
                                    start          : moment(scheds[k].date_departure).format('YYYY-MM-DD[T]HH:mm'),
                                    backgroundColor: bg, 
                                    borderColor: bg, 
                                    });
                            })
                            console.log(events)
                            successCallback(events)

                        },
                        
                        eventClick:(info)=>{
                          $.ajax({
                            url:"<?=site_url('Admin/view_travel/')?>" +info.event.id,
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
                        },
                        editable  : false,
                        selectable: true,
                        selectAllow: function(select) {
                                console.log(moment(select.start).format('dddd'))
                            if(moment().subtract(1, 'day').diff(select.start) < 0 && (moment(select.start).format('dddd') != 'Saturday' && moment(select.start).format('dddd') != 'Sunday'))
                                return true;
                            else
                                return false;
                        }

                        });

                        calendar.render();
        // $(element).find(".fc-event-time").remove();
                        // $('#calendar').fullCalendar()
        $('#location').change(function(){
            location.href = "./?lid="+$(this).val();
        })
    })
    
</script>

          </div>
        </section>


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
            <table class="table " width="100%">
              <thead>
                <tr>
                  <th scope="col">Name</th>
                  <th scope="col">Last Travel</th>
                </tr>
              </thead>
              <tbody class = "group">
              <?php foreach ($employees as $employee){?>
                <tr class="">
                  <td scope="row">
                  <div class="form-check">
                    <input class="form-check-input cb_name" type="checkbox" value=" <?=$employee['id']?>" id="">
                    <label class="form-check-label" for="">
                      <?=$employee['fname'] . ' ' . $employee['lname']?>
                    </label>
                  </div>
                  </td>
                  <td><?=$employee['last_to']?></td>
                </tr>
                <?php } ?>
              </tbody>
              <tbody class = "individual">
              <?php foreach ($employees as $employee){?>
                <tr class="">
                  <td scope="row">
                  <div class="form-check">
                    <input class="form-check-input rd_name" type="radio" name="radio" value=" <?=$employee['id']?>" id="">
                    <label class="form-check-label" for="">
                      <?=$employee['fname'] . ' ' . $employee['lname']?>
                    </label>
                  </div>
                  </td>
                  <td><?=$employee['last_to']?></td>
                </tr>
                <?php } ?>
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
</div>



      </div>
      <!-- /.content-wrapper -->
      <?php require_once('inc/footer.php') ?>
      <script>
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


var id = [];
    $('.type').on('change', function() {
      id = [];
      $('.cb_name').prop('checked', false);
      $('.rd_name').prop('checked', false);
      if($(this).val() == '1') {  
        $('.group').hide();
        $('.individual').show();
        $("#modal_emp").modal('show');
      }
      else if($(this).val() == '2'){
        $('.individual').hide();
        $('.group').show();
        $("#modal_emp").modal('show');
      }
      
      
    });

    

    $('.cb_name').on('change', function() {
      if (this.checked) {
        id.push($(this).val())
    } else {
      id.splice($.inArray($(this).val(), id), 1);
    }
      $('.ids').val(id);
      console.log($('.ids').val());
    })

    $('.rd_name').on('change', function() {
      if (this.checked) {
        id=[]
        id.push($(this).val())
    } 
      $('.ids').val(id);
      console.log($('.ids').val());
    })




    $(function(){
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
  </body>
</html>
