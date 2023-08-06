<?php $LAVA = lava_instance() ?>
<!doctype html>
<html lang="en">


<?php require_once('admin/inc/header.php') ?>
<body>

  <div class="container-fluid">
    <!-- <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container">
        <a class="navbar-brand" href="#">
          <img src="<?=BASE_URL . PUBLIC_DIR .'/uploads/logo.png'?>" width="30" height="30" class="d-inline-block align-top" alt="">
          
      </div>
    </nav> -->
    <!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <!-- Container wrapper -->
  <div class="container-fluid">
    <!-- Toggle button -->
    <button
      class="navbar-toggler"
      type="button"
      data-mdb-toggle="collapse"
      data-mdb-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <i class="fas fa-bars"></i>
    </button>

    <!-- Collapsible wrapper -->
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <!-- Navbar brand -->
      <a class="navbar-brand mt-2 mt-lg-0" href="#">
        <img
          src="<?=BASE_URL . PUBLIC_DIR .'/uploads/pio.jpg'?>"
          height="70"
          alt="MDB Logo"
          loading="lazy"
        />
      </a>
      <!-- Left links -->
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="<?=site_url('Main/dashboard')?>">Dashboard</a>
        </li>
      </ul>
      <!-- Left links -->
    </div>
    <!-- Collapsible wrapper -->

    <!-- Right elements -->
    <div class="d-flex align-items-center">
      <!-- Icon -->
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
        <?= ($LAVA->session->has_userdata('id')) ?
          "<a class=' btn btn-success' href='" . site_url('Main/Logout') . "'>Logout</a>" : "<a class=' btn btn-success' href='" . site_url('Main/Login') . "'>Login</a>"; ?>
        </li>
      </ul>
    </div>
    <!-- Right elements -->
  </div>
  <!-- Container wrapper -->
</nav>
<!-- Navbar -->
<section class="content  text-dark">
          <div class="container-fluid">
          <h1 class="text-dark">Welcome to  PISD Travel Scheduling System
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
                                        $(".mytable > tbody").append("<tr><td>"+resp['names'][x]['fname'] + " " + resp['names'][x]['lname']+"</td><td>"+resp['names'][x]['position']+"</td><td>"+resp['names'][x]['last_to']+"</td></tr>");
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
            <p><b>Designation:</b> <span id = "v_desig"></span></p>
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
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
      </div>
      
    </div>
  </div>
</div>
        
  </div>
  
  <?php require_once('admin/inc/footer.php') ?>

  <!-- Image and text -->



  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
</body>
</html>