<?php $LAVA = lava_instance() ?>  
 <!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
<?php require_once('inc/header.php') ?>
  <body class="sidebar-mini layout-fixed control-sidebar-slide-open layout-navbar-fixed dark-mode sidebar-mini-md sidebar-mini-xs" data-new-gr-c-s-check-loaded="14.991.0" data-gr-ext-installed="" style="height: auto;">
    <div class="wrapper">
     <?php require_once('inc/topBarNav.php') ?>
     <?php require_once('inc/navigation.php') ?>
              
      <div class="content-wrapper bg-dark pt-3" style="min-height: 567.854px;">
     
        <!-- Main content -->
        <section class="content  text-dark">
          <div class="container-fluid">
          <h1 class="text-light">Welcome to  San Teodoro Municipal Health Office Appointment Scheduling System
</h1>
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
        color: black !important;
        background: var(--light);
        cursor: pointer;
    }
</style>
<?php
// $sched_query = $conn->query("SELECT a.*,p.name FROM `appointments` a inner join `patient_list` p on a.patient_id = p.id"); 
var_dump($appointments);
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
        var scheds = jsonObject.escape($.parseJSON('<?php echo ($sched_arr) ?>'));

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
                        //Random default events
                        events:function(event,successCallback){
                            var days = moment(event.end).diff(moment(event.start),'days')
                            var events = []
                            Object.keys(scheds).map(k=>{
                                var bg = 'var(--primary)';
                                if(scheds[k].status == 0)
                                    bg = 'var(--primary)';
                                if(scheds[k].status == 1)
                                    bg = 'var(--success)';
                                console.log(scheds[k].id)
                                events.push({
                                    id          : scheds[k].id,
                                    title          : scheds[k].name,
                                    start          : moment(scheds[k].date_sched).format('YYYY-MM-DD[T]HH:mm'),
                                    backgroundColor: bg, 
                                    borderColor: bg, 
                                    });
                            })
                            console.log(events)
                            successCallback(events)

                        },
                        eventClick:(info)=>{
                          $.ajax({
                            url:"<?=site_url('Patient/view_appointment/')?>" +info.event.id,
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
                                        console.log(resp[0]['sched']);

                                        $('#v_date').text(resp[0]['sched']);
                                        $('#v_name').text(resp[0]['name']);
                                        $('#v_gender').text(resp[0]['gender']);
                                        $('#v_bd').text(resp[0]['bd']);
                                        $('#v_phone').text(resp[0]['contact']);
                                        $('#v_email').text(resp[0]['email']);
                                        $('#v_add').text(resp[0]['address']);
                                        $('#v_ail').text(resp[0]['ailment']);
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
                            }
                          })
                          $("#view_modal").modal('show');
                            // uni_modal("Appointment Details","appointments/view_details.php?id="+info.event.id)
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
                        // $('#calendar').fullCalendar()
        $('#location').change(function(){
            location.href = "./?lid="+$(this).val();
        })
    })
</script>

          </div>
        </section>



<!-- Modal Body -->
<!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
<div class="modal fade" id="view_modal" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md " role="document">
    <div class="modal-content rounded-0">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitleId">Appointment Details</h5>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <p><b>Appointment Schedule:</b> <span id = "v_date"></span></p>
          <p><b>Patient Name:</b> <span id = "v_name"></span></p>
          <p><b>Gender:</b> <span id = "v_gender"></span></p>
          <p><b>Date of Birth:</b> <span id = "v_bd"></span></p>
          <p><b>Contact #:</b> <span id = "v_phone"></span></p>
          <p><b>Email #:</b> <span id = "v_email"></span></p>
          <p><b>Address:</b> <span id = "v_add"></span></p>
          <p><b>Ailment:</b> <span id = "v_ail"></span></p>
          <p><b>Status:</b><span id = "v_status"></span>
              <?php 
              // switch($status){ 
              //     case(0): 
              //         echo '<span class="badge badge-primary">Pending</span>';
              //     break; 
              //     case(1): 
              //     echo '<span class="badge badge-success">Confirmed</span>';
              //     break; 
              //     case(2): 
              //         echo '<span class="badge badge-danger">Cancelled</span>';
              //     break; 
              //     default: 
              //         echo '<span class="badge badge-secondary">NA</span>';
              // }
              ?>
          </p>
      </div>
      <div class="d-flex justify-content-end">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
      </div>
      
    </div>
  </div>
</div>


<!-- Optional: Place to the bottom of scripts -->
<script>
  const myModal = new bootstrap.Modal(document.getElementById('modalId'), options)

</script>
  
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
</html>
