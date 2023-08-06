<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Patient extends Controller {
	
    public function __construct()
    {
        parent::__construct();
        $this->call->helper(array('form', 'alert'));
        $this->call->model('Patient_model');
        $this->call->model('Admin_model');
    }

    public function index(){
        if(!$this->session->userdata('id')){
            redirect('Main/login');
        }
        $id = $this->session->userdata('id');
        $data['appointments'] = $this->Patient_model->get_appointments($id);
        $data['active'] = 1;
        $this->call->view('patient/index', $data);
    }

    public function appointment() {
        if(!$this->session->userdata('id')){
            redirect('Main/login');
        }
        $id = $this->session->userdata('id');
        $data['appointments'] = $this->Patient_model->appointment_list($id);
        $data['active'] = 2;
        $this->call->view('patient/appointment', $data);
    }

    public function add_appointment(){
        if(!$this->session->userdata('id')){
            redirect('Main/login');
        }
        $resp = array();
        $id = $this->session->userdata('id');
        $sched = $this->Admin_model->sched_set();
        foreach($sched as $schedule){
            $sched_set[$schedule['meta_field']] = $schedule['meta_value'];
        }
        $morning_start = date("Y-m-d ") . explode(',',$sched_set['morning_schedule'])[0];
		$morning_end = date("Y-m-d ") . explode(',',$sched_set['morning_schedule'])[1];
		$afternoon_start = date("Y-m-d ") . explode(',',$sched_set['afternoon_schedule'])[0];
		$afternoon_end = date("Y-m-d ") . explode(',',$sched_set['afternoon_schedule'])[1];
		$sched_time = date("Y-m-d ") . date("H:i",strtotime($_POST['date_sched']));
        if(!in_array(strtolower(date("l",strtotime($_POST['date_sched']))),explode(',',strtolower($sched_set['day_schedule'])))){
			$resp['status'] = 'failed';
			$resp['msg'] = "Selected Schedule Day of Week is invalid.";
			echo json_encode($resp);
			exit;
		}
        if(!( (strtotime($sched_time) >= strtotime($morning_start) && strtotime($sched_time) <= strtotime($morning_end)) || (strtotime($sched_time) >= strtotime($afternoon_start) && strtotime($sched_time) <= strtotime($afternoon_end)) )){
			$resp['status'] = 'failed';
			$resp['msg'] = "Selected Schedule Time is invalid.";
			echo json_encode($resp);
			exit;
		}
        $check = $this->Patient_model->check($_POST['date_sched'], $id);
        if(sizeof($check) > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "Selected Schedule DateTime conflicts to other appointment.";
            $resp['data'] = $check;
			echo json_encode($resp);
			exit;
		}
        else{
            $save_sched = $this->Patient_model->save_sched($_POST['date_sched'], $id,0);
			if($save_sched){
				$resp['status'] = 'success';
				$resp['name'] = $this->session->userdata('name');
				$this->session->set_flashdata('success',' Appointment successfully saved');
			}else{
				$resp['status'] = 'failed';
				$resp['msg'] = "There's an error while submitting the data.";
			}

		}
		echo json_encode($resp);
    
    }

    public function update_appointment(){
        $resp = array();
        $id = $this->session->userdata('id');
        $sched = $this->Admin_model->sched_set();
        foreach($sched as $schedule){
            $sched_set[$schedule['meta_field']] = $schedule['meta_value'];
        }
        $morning_start = date("Y-m-d ") . explode(',',$sched_set['morning_schedule'])[0];
		$morning_end = date("Y-m-d ") . explode(',',$sched_set['morning_schedule'])[1];
		$afternoon_start = date("Y-m-d ") . explode(',',$sched_set['afternoon_schedule'])[0];
		$afternoon_end = date("Y-m-d ") . explode(',',$sched_set['afternoon_schedule'])[1];
		$sched_time = date("Y-m-d ") . date("H:i",strtotime($_POST['date_sched']));
        if(!in_array(strtolower(date("l",strtotime($_POST['date_sched']))),explode(',',strtolower($sched_set['day_schedule'])))){
			$resp['status'] = 'failed';
			$resp['msg'] = "Selected Schedule Day of Week is invalid.";
			echo json_encode($resp);
			exit;
		}
        if(!( (strtotime($sched_time) >= strtotime($morning_start) && strtotime($sched_time) <= strtotime($morning_end)) || (strtotime($sched_time) >= strtotime($afternoon_start) && strtotime($sched_time) <= strtotime($afternoon_end)) )){
			$resp['status'] = 'failed';
			$resp['msg'] = "Selected Schedule Time is invalid.";
			echo json_encode($resp);
			exit;
		}
        $check = $this->Patient_model->check($_POST['date_sched'], $id);
        if(sizeof($check) > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "Selected Schedule DateTime conflicts to other appointment.";
            $resp['data'] = $check;
			echo json_encode($resp);
			exit;
		}
        else{
            $update_sched = $this->Patient_model->update_sched($_POST['date_sched'], $_POST['id']);
			if($update_sched){
				$resp['status'] = 'success';
				$resp['name'] = $this->session->userdata('name');
				$this->session->set_flashdata('success',' Appointment successfully updated');
			}else{
				$resp['status'] = 'failed';
				$resp['msg'] = "There's an error while submitting the data.";
			}

		}
		echo json_encode($resp);
    
    }
    public function view_appointment($id){
        echo json_encode($this->Patient_model->view_data($id));
    }
    public function profile(){
        if(!$this->session->userdata('id')){
            redirect('Main/login');
        }
        $id = $this->session->userdata('id');
        $data['profile'] = $this->Patient_model->profile($id);
        $data['active'] = 0;
        $this->call->view('patient/profile', $data);
    }
    public function update_profile(){
        $id = $this->session->userdata('id');
        $data = "";
        extract($_POST);
        foreach($_POST as $k => $v){
			if(!in_array($k,array('id','password'))){
				if(!empty($data)) $data .=" , ";
				$data .= " {$k} = '{$v}' ";
			}
		}
        if(isset($_FILES['img']) && $_FILES['img']['tmp_name'] != ''){
            $this->call->library('upload', $_FILES['img']);
            $this->upload->max_size(3)->set_dir('public/uploads')->allowed_extensions(array('jpg', 'png'))->is_image()->encrypt_name();
            if($this->upload->do_upload()){
                $data .=" , avatar = '{$this->upload->get_filename()}' ";
                $this->session->set_userdata(array('image' =>$this->upload->get_filename(), 'name' => $_POST['name'], 'username' => $_POST['username']));
            }
        }
        if($_POST['password']){
            $pass = md5($_POST['password']);
            $data.= " , password = '{$pass}'";
        }
        $res = $this->Patient_model->update_profile($data, $id);
        $this->session->set_userdata(array('name' => $_POST['name'], 'username' => $_POST['username']));
        echo $res;
    }

}
?>
