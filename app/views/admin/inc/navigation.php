</style>
<!-- Main Sidebar Container -->
      <aside class="main-sidebar sidebar-light-primary elevation-4 sidebar-no-expand">
        <!-- Brand Logo -->
        <a href="<?= site_url('admin/index') ?>" class="brand-link bg-success text-sm">
        <img src="<?=BASE_URL . PUBLIC_DIR .'/uploads/pio.jpg'?>" alt="Store Logo" class="brand-image rounded-circle" style="opacity: .8;width: 2.5rem;height: 2.5rem;max-height: unset">
        <span class="brand-text font-weight-light">GO-PISD</span>
        </a>
        <!-- Sidebar -->
        <div class="sidebar os-host os-theme-light os-host-overflow os-host-overflow-y os-host-resize-disabled os-host-transition os-host-scrollbar-horizontal-hidden">
          <div class="os-resize-observer-host observed">
            <div class="os-resize-observer" style="left: 0px; right: auto;"></div>
          </div>
          <div class="os-size-auto-observer observed" style="height: calc(100% + 1px); float: left;">
            <div class="os-resize-observer"></div>
          </div>
          <div class="os-content-glue" style="margin: 0px -8px; width: 249px; height: 646px;"></div>
          <div class="os-padding">
            <div class="os-viewport os-viewport-native-scrollbars-invisible" style="overflow-y: scroll;">
              <div class="os-content" style="padding: 0px 8px; height: 100%; width: 100%;">
                <!-- Sidebar user panel (optional) -->
                <div class="clearfix"></div>
                <!-- Sidebar Menu -->
                <nav class="mt-4">
                   <ul class="nav nav-pills nav-sidebar flex-column text-sm nav-compact nav-flat nav-child-indent nav-collapse-hide-child" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item dropdown">
                      <a href="./" class="nav-link nav-home <?=$active==1 ? 'active' :''?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                          Dashboard
                        </p>
                      </a>
                    </li> 
                    <li class="nav-item dropdown">
                      <a href="<?= site_url('admin/travels') ?>" class="nav-link nav-appointments <?=$active==2 ? 'active' :''?>">
                        <i class="nav-icon fas fa-calendar"></i>
                        <p>
                          Travel List
                        </p>
                      </a>
                    </li>
                    
                    <!-- <li class="nav-item dropdown">
                      <a href="<?= site_url('admin/sched_settings') ?>" class="nav-link nav-schedule_settings">
                        <i class="nav-icon fas fa-calendar-day"></i>
                        <p>
                          Schedule Settings
                        </p>
                      </a>
                    </li> -->
                    <li class="nav-item dropdown">
                      <a href="<?= site_url('Admin/user_list') ?>" class="nav-link nav-user_list <?=$active==3 ? 'active' :''?>">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                          Employee List
                        </p>
                      </a>
                    </li>
                    <li class="nav-item dropdown">
                      <a href="#" class="nav-link nav-system_info last_t">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>
                          Last T.O. No
                        </p>
                      </a>
                    </li>
                  </ul>
                </nav>
                <!-- /.sidebar-menu -->
              </div>
            </div>
          </div>
          <div class="os-scrollbar os-scrollbar-horizontal os-scrollbar-unusable os-scrollbar-auto-hidden">
            <div class="os-scrollbar-track">
              <div class="os-scrollbar-handle" style="width: 100%; transform: translate(0px, 0px);"></div>
            </div>
          </div>
          <div class="os-scrollbar os-scrollbar-vertical os-scrollbar-auto-hidden">
            <div class="os-scrollbar-track">
              <div class="os-scrollbar-handle" style="height: 55.017%; transform: translate(0px, 0px);"></div>
            </div>
          </div>
          <div class="os-scrollbar-corner"></div>
        </div>
        <!-- /.sidebar -->
      </aside>

     <!-- Modal for Add New -->
     <div class="modal fade" id="modal_to" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm" role="document">
    <div class="modal-content rounded-0">
      <div class="modal-header">
        <center><h5 class="modal-title text-center">Last T.O. Control No.</h5></center>
      </div>
      <div class="modal-body">
			<div class="container-fluid text-dark">
    <form id="update_settings" class="py-2 emp_update">
    <div class="row" id="appointment">
        <div class="col-12" id="frm-field">
          <div class="row">
            <div class="form-group col-12">
                    <label for="name" class="control-label">Last T.O. Control No.</label>
                    <input type="text" class="form-control" id="m_travelorder" name="control_no" value=""  required>
                </div>
          </div>
              </div>
        <div class="form-group d-flex justify-content-end w-100 form-group">
            <button class="btn-primary btn" type="submit">Update</button>
            <button class="btn-light btn ml-2" type="button" data-dismiss="modal">Cancel</button>
        </div>
        </form>
    </div>
</div>
</div>
    </div>
  </div>
</div>


<script>
    // $(document).ready(function(){
    //   var page = '<?php echo isset($_GET['page']) ? $_GET['page'] : 'home' ?>';
    //   var s = '<?php echo isset($_GET['s']) ? $_GET['s'] : '' ?>';
    //   page = page.replace(/\//g,'_');

    //   if($('.nav-link.nav-'+page).length > 0){
    //          $('.nav-link.nav-'+page).addClass('active')
    //     if($('.nav-link.nav-'+page).hasClass('tree-item') == true){
    //         $('.nav-link.nav-'+page).closest('.nav-treeview').siblings('a').addClass('active')
    //       $('.nav-link.nav-'+page).closest('.nav-treeview').parent().addClass('menu-open')
    //     }
    //     if($('.nav-link.nav-'+page).hasClass('nav-is-tree') == true){
    //       $('.nav-link.nav-'+page).parent().addClass('menu-open')
    //     }

    //   }
     
    // })

    $('.last_t').click(function(){
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
            $('#m_travelorder').val(parseInt(resp['control_no'].substr(0,resp['control_no'].indexOf('-'))) +'-'+ new Date().getFullYear().toString().substr(-2));
          }
          else{
            $('#m_travelorder').val(1 +'-'+ new Date().getFullYear().toString().substr(-2));
          }
					// $('#m_travel_order').val(resp['control_no']);
						end_loader();
						$("#modal_to").modal('show');
				}
			})
		})


    $('#update_settings').submit(function(e){
      start_loader();
        e.preventDefault();
            var _this = $(this)
        $.ajax({
				url:"<?=site_url('Admin/update_settings')?>",
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
            $("#modal_to").modal('hide');
            alert_toast(resp.msg,'success');
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
  </script>
