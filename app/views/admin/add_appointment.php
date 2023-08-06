<style>
#uni_modal .modal-content>.modal-footer{
    display:none;
}
#uni_modal .modal-body{
    padding-top:0 !important;
}
</style>
<div class="container-fluid">
    <form id="appointment_forms" class="py-2" method="post" action="<?=site_url('Admin/add_appointment')?>">
    <div class="row" id="appointment">
        <div class="col-6" id="frm-field">
            <input type="hidden" name="patient_id" value="">
                <div class="form-group">
                    <label for="name" class="control-label">Fullname</label>
                    <input type="text" class="form-control" name="name" value="" required>
                </div>
                <div class="form-group">
                    <label for="email" class="control-label">Email</label>
                    <input type="email" class="form-control" name="email" value=""  required>
                </div>
                <div class="form-group">
                    <label for="contact" class="control-label">Contact</label>
                    <input type="text" class="form-control" name="contact" value=""  required>
                </div>
                <div class="form-group">
                    <label for="gender" class="control-label">Gender</label>
                    <select type="text" class="custom-select" name="gender" required>
                    <option>Male</option>
                    <option>Female</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="dob" class="control-label">Date of Birth</label>
                    <input type="date" class="form-control" name="dob" value=""  required>
                </div>
        </div>
        <div class="col-6">
                
                <div class="form-group">
                    <label for="address" class="control-label">Address</label>
                    <textarea class="form-control" name="address" rows="3" required></textarea>
                </div>
            <div class="form-group">
                <label for="date_sched" class="control-label">Appointment</label>
                <input type="datetime-local" class="form-control" name="date_sched" value="" required>
            </div>
                <input type="hidden" name="status" value="0">
        </div>
        <div class="form-group d-flex justify-content-end w-100 form-group">
            <button class="btn-primary btn">Submit Appointment</button>
            <button class="btn-light btn ml-2" type="button" data-dismiss="modal">Cancel</button>
        </div>
        </form>
    </div>
</div>
<script>
$(function(){
    $('#appointment_form').submit(function(e){
        e.preventDefault();
            var _this = $(this)
            console.log('huhheheheh');
			 $('.err-msg').remove();
			start_loader();
			$.ajax({
				url:<?=site_url('Admin/add_appointment')?>,
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


