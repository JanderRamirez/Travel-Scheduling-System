<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
include 'pdf/vendor/autoload.php';
class Admin extends Controller {
	
    public function __construct()
    {
        parent::__construct();
        $this->call->helper(array('form', 'alert'));
        $this->call->model('Main_model');
        $this->call->model('Admin_model');
        
    }
    public function test(){
        // var_dump($this->Admin_model->get_to($a));
    }
    public function settings(){
        $data['settings'] = $this->Admin_model->settings();
        var_dump($data['settings']);
    }
    public function update_settings(){
        $cn = $_POST['control_no'];
        if($this->Admin_model->update_settings($cn)){
            $resp['status'] = 'success';
			$resp['msg'] = "Control Number Updated Successfully!";
			echo json_encode($resp);
            exit;
        }
        else{
            $resp['status'] = 'failed';
			$resp['msg'] = "Failed to Update Control Number! Please try again!";
			echo json_encode($resp);
            exit;
        }
    }
    public function add_travel(){
        $ids = explode(",",str_replace(' ', '', $this->io->post('ids')));
        $to_no = $this->io->post('to_no');
        $depart = $this->io->post('depart');
        $return = $this->io->post('return');
        $office = $this->io->post('office');
        $vehicle = $this->io->post('vehicle');
        $report = $this->io->post('report');
        $charge = $this->io->post('charge');
        $destination = $this->io->post('destination');
        $purpose = $this->io->post('purpose');
        $remarks = $this->io->post('remarks');
        $type = $this->io->post('type');
        $res = $this->Admin_model->add_travel($to_no, $depart, $return, $office, $vehicle, $report, $charge, $destination, $purpose, $remarks, $type);
        if($res){
            foreach ($ids as $id){
                $this->Admin_model->save_travelers($res['id'], $id, $depart);
            }
            $resp['status'] = 'success';
			$resp['msg'] = "New Travel Order Created!";
			echo json_encode($resp);
            exit;
        }
        else{
            $resp['status'] = 'failed';
			$resp['msg'] = "Failed to create travel order! Please try again!";
			echo json_encode($resp);
            exit;
        }
    }
    public function index() {
        if(!$this->session->userdata('id')){
            redirect('Main/login');
        }
        $data['appointments'] = $this->Admin_model->get_appointments();
        $data['employees'] = $this->Admin_model->user_list();
        $data['active'] = 1;
        $this->call->view('admin/index', $data);
    }

    public function get_to(){
        echo json_encode($this->Admin_model->get_to());
    }
    public function travels() {
        if(!$this->session->userdata('id')){
            redirect('Main/login');
        }
        $data['travels'] = $this->Admin_model->get_appointments();
        $data['employees'] = $this->Admin_model->user_list();
        $data['active'] = 2;
        $this->call->view('admin/travel', $data);
    }
    
    public function view_travel($id){
        echo json_encode($this->Admin_model->view_data($id));
    }
    public function view_assoc($id){
        echo json_encode($this->Admin_model->view_assoc($id));
    }


    public function add_employee(){
        $empno = $this->io->post('emp_no');
        $pos = $this->io->post('pos');
        $fn = $this->io->post('fname');
        $mn = $this->io->post('mname');
        $ln = $this->io->post('lname');
        $last_to = $this->io->post('last_to');
        if($this->Admin_model->add_employee($empno,$pos,$fn,$mn,$ln, $last_to)){
            $resp['status'] = 'success';
			$resp['msg'] = "New employee added successfully!";
			echo json_encode($resp);
            exit;
        }
        else{
            $resp['status'] = 'failed';
			$resp['msg'] = "Failed to add new employee! Please try again!";
			echo json_encode($resp);
            exit;
        }
    }
    public function update_employee(){
        $id = $this->io->post('id');
        $empno = $this->io->post('emp_no');
        $pos = $this->io->post('pos');
        $fn = $this->io->post('fname');
        $mn = $this->io->post('mname');
        $ln = $this->io->post('lname');
        $last_to = $this->io->post('last_to');
        if($this->Admin_model->update_employee($id,$empno,$pos,$fn,$mn,$ln,$last_to)){
            $resp['status'] = 'success';
			$resp['msg'] = "Employee's information updated successfully!";
			echo json_encode($resp);
            exit;
        }
        else{
            $resp['status'] = 'failed';
			$resp['msg'] = "Failed to employee's information! Please try again!";
			echo json_encode($resp);
            exit;
        }
    }

    
    public function user_list(){
        if(!$this->session->userdata('id')){
            redirect('Main/login');
        }
       $data['users'] = $this->Admin_model->emp_list();
       $data['active'] = 3;
       $this->call->view('admin/user_list', $data);

    }
    public function profile(){
        $id = $this->session->userdata('id');
        $data['active'] =0;
        $data['profile'] = $this->Admin_model->profile($id);
        $this->call->view('admin/profile', $data);
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
                $this->session->set_userdata(array('image' =>$this->upload->get_filename(), 'name' => $_POST['firstname'] . $_POST['lastname'], 'username' => $_POST['username']));
            }
        }
        if($_POST['password']){
            $pass = md5($_POST['password']);
            $data.= " , password = '{$pass}'";
        }
        $res = $this->Admin_model->update_profile($data, $id);
        $this->session->set_userdata(array('name' => $_POST['firstname'] . $_POST['lastname'], 'username' => $_POST['username']));
        
        echo $res;
    }

    public function encrypt($password){
        echo strlen(md5($password));
    }

    public function print($id, $type){
        if($type == '2'){
            $this->pdf($id);
        }
        else if($type == '1'){
            $this->solo_pdf($id);
        }
    }



    public function hehe(){
        require('fpdm.php');

        $fields = array(
            'name'    => 'My name',
            'address' => 'My address',
            'city'    => 'My city',
            'phone'   => 'My phone number'
        );

        $pdf = new FPDM('template.pdf');
        $pdf->Load($fields, false); // second parameter: false if field values are in ISO-8859-1, true if UTF-8
        $pdf->Merge();
        $pdf->Output();
    }

    public function pdf($id){
        
        $travel = $this->Admin_model->view_data($id);
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->showImageErrors = true;
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [215.9, 330.2]]);
        // $mpdf->AddFont('font_name', '', 'micross.ttf', 32);
        // $mpdf->Image( BASE_URL . PUBLIC_DIR . "/uploads/pio", 0, 0, 210, 297, 'jpg', '', true, false);
        $mpdf->WriteHTML('<link rel="stylesheet" href="'. BASE_URL . PUBLIC_DIR .'/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">');
        $mpdf->WriteHTML('<script src="'. BASE_URL . PUBLIC_DIR .'/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>');
        $TO=$travel['details'][0]['control_no'];
        
        $infor ='';
        $dir = BASE_URL . PUBLIC_DIR . "/uploads/OMP.png";
        $mpdf->SetHTMLHeader('<img style="width:100px;margin-left:40px" src="' .$dir .'"/>');
        $infor .='<div style = "background-image: url("'.$dir.'");"><p style="text-align: center;font-size:16px; font-family: microsoft sans serif ;padding-bottom:0px;"><strong>PROVINCIAdL GOVERNMENT OF ORIENTAL MINDORO</strong><br>
        <span style="text-align: center;font-size:12px; font-family: arial;padding-top:0px">Provincial Capitol Complex, Calapan 5200, Oriental Mindoro</p></span>
       
        </div> <div style="text-align: center;font-size:14px; font-family: arial;padding-top:0px">';
        
        $infor .='<strong>TRAVEL ORDER  </strong><u>' . $TO . '</u><br/>';
        $infor .='<p style="text-align: right;">Date: <u>' . date("F d, Y") .'</u></p><br/>';
        $infor .='<table style="width:100%;font-family: arial;font-size:14px;">
                    <thead style="text-align:center">
                    <tr>
                        <td style="width:40%">NAME</td><td  style="width:2%"></td><td style="width:29%;text-align:left">POSITION/DESIGNATION</td><td  style="width:2%"></td><td style="width:27%;text-align:left">DATE OF LAST T.O.</td>
                    </tr>
                    </thead>
                    <tbody>';
                    foreach ($travel['names'] as $name) {
                        $infor .='<tr>
                        <td style="border-bottom:1pt solid black;">'.strtoupper($name['fname']). ' '.substr($name['mname'],0,1).'. '.strtoupper($name['lname']).'</td>
                        <td></td>
                        <td style="border-bottom:1pt solid black;">SAO</td>
                        <td></td>
                        <td style="border-bottom:1pt solid black;">'.$name['last'].'</td>
                        </tr>';
                    }
                    if(count($travel['names'])<10){
                        for($x=0;$x<10-count($travel['names']);$x++){
                            $infor .='<tr>
                                    <td style="border-bottom:1pt solid black;color:white;">SAMPLE</td>
                                    <td></td>
                                    <td style="border-bottom:1pt solid black;"></td>
                                    <td></td>
                                    <td style="border-bottom:1pt solid black;"></td>
                                    </tr>';
                                }
                    }
        
        $infor .='</tbody>
                 </table><br>';
        $infor .='<table style="font-family: arial;" width="100%"><tbody><tr><td style="text-align:left"  width="15%">OFFICE/STATION:</td><td style="border-bottom:1pt solid black;text-align:left" width="85%">'.$travel['details'][0]['office'].'</td></tr></tbody></table>';
        $infor .='<table style="font-family: arial;" width="100%"><tbody><tr><td style="text-align:left"  width="15%">DESTINATION:</td><td style="border-bottom:1pt solid black;text-align:left" width="85%">'.$travel['details'][0]['destination'].'</td></tr></tbody></table>';
        $infor .='<table  style="font-family: arial;;padding-bottom:0px" width="100%"><tbody><tr><td style="text-align:left"  width="25%">DATE OF DEPARTURE:</td><td style="border-bottom:1pt solid black;text-align:left" width="25%">'.$travel['details'][0]['date_departure'].'</td>
                <td style="text-align:left"  width="21%">DATE OF RETURN:</td><td style="border-bottom:1pt solid black;text-align:left" width="29%">'.$travel['details'][0]['date_return'].'</td></tr></tbody></table>';
        $infor .='<p style="text-align: left;padding-left:5px;padding-top:0px">PURPOSE OF TRAVEL:<br>'.$travel['details'][0]['purpose'].'</p><br/><br><br><br><br><br>';
        $infor .='<table style="font-family: arial;" width="100%"><tbody><tr><td style="text-align:left"  width="32%">THE USE OF A SERVICE VEHICLE</td><td style="border-bottom:1pt solid black;text-align:CENTER" width="68%">'.$travel['details'][0]['vehicle'].'</td></tr></tbody></table>';
        $infor .='<table style="font-family: arial;" width="100%"><tbody><tr><td style="text-align:left"  width="32%">IS HEREBY REQUESTED</td><td style="font-size:12px;text-align:CENTER" width="68%">Brand/Type/Plate No.</td></tr></tbody></table>';
        $infor .='<table style="font-family: arial;" width="100%"><tbody><tr><td style="text-align:left"  width="12%">REPORT TO:</td><td style="border-bottom:1pt solid black;text-align:LEFT" width="87%">'.$travel['details'][0]['report_to'].'</td></tr></tbody></table>';
        $infor .='<table style="font-family: arial;" width="100%"><tbody><tr><td style="text-align:left"  width="24%">CHARGEABLE AGAINST:</td><td style="border-bottom:1pt solid black;text-align:LEFT" width="76%">'.$travel['details'][0]['charge_to'].'</td></tr></tbody></table>';
        $infor .='<table style="font-family: arial;" width="100%"><tbody><tr><td style="text-align:left"  width="8%">REMARKS:</td><td style="border-bottom:1pt solid black;text-align:LEFT" width="92%">'.$travel['details'][0]['remarks'].'</td></tr></tbody></table>';
        $infor .='<br><br><p style="font-size:14px;text-align:left;">RECOMMENDED BY:</p>';
        $infor .='<br><p style="font-size:14px;text-align:left;">  MARIA FE A. DE LEON <br>Department/Office Head</p>';
        $infor .='<p style="font-size:14px;text-align:center;">APPROVED:</p><br>';
        $infor .='<table style="font-size:14px;text-align:center;font-family: arial;" width="100%"><tr><td  width="50%"></td><td style="text-align:center">HUMERLITO A. DOLOR, MPA, PhD<br>Provincial Governor</td></tr></table>';
        $infor .='<p style="font-size:11px;text-align:center;">[ All employees listed above shall secure their respective certificate of appearance. ]</p>';
        $infor .='</div>';
        $mpdf->SetTitle('TRAVEL ORDER '.$travel['details'][0]['control_no']);
        $mpdf->WriteHTML($infor);
        $mpdf->Output();
  
}




public function solo_pdf($id){
        
        $travel = $this->Admin_model->view_data($id);
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->showImageErrors = true;
        $defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];

        $defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'Letter', 'margin_left' => 25,'margin_top' => 25, 'margin_right' => 15]);
        // $mpdf->AddFont('microsoft_sans_serif', '', 'micross.ttf', 32, true);
        // $mpdf->Image( BASE_URL . PUBLIC_DIR . "/uploads/pio", 0, 0, 210, 297, 'jpg', '', true, false);
        $TO=$travel['details'][0]['control_no'];
        
        $infor ='';
        $dir = BASE_URL . PUBLIC_DIR . "/uploads/dark.jpg";
        $mpdf->SetHTMLHeader('<img style="width:93px;margin-left:38px;margin-top:28px" src="' .$dir .'"/>');
        $infor .='<div style = "padding-left:70px"><p style="text-align: center;font-size:18px; font-family: Arial;padding-bottom:0px;" ><strong>PROVINCIAL GOVERNMENT OF ORIENTAL MINDORO</strong><br>
        <span style="text-align: center;font-size:12px; font-family: arial;padding-top:0px;">Provincial Capitol Complex, Calapan 5200, Oriental Mindoro</p></span>
       
        </div>
        <style>
        table{
            font-size:18px !important;
            border-color: #00145c !important;
        }
        tr{
            line-height: 10px !important;
        }
        td{
            
        }
        </style>
         <div style="text-align: center;font-size:19px; font-family: Microsoft Sans Serif;padding-top:0px">';
        $infor .='<strong>TRAVEL ORDER  </strong><u>' . $TO . '</u><br/>';
        $infor .='<p style="text-align: right;font-size:14px;">Date: <u>' . date("F d, Y") .'</u></p>';
        $infor .='<table style="width:100%;font-family: arial;">
                    <tbody>
                    <tr>
                    <td width="9%">NAME: </td> 
                    <td style="border-bottom:1pt solid #00145c;">'.strtoupper($travel['names'][0]['fname']). ' '.substr($travel['names'][0]['mname'],0,1).'. '.strtoupper($travel['names'][0]['lname']).'</td>    
                    </tr>
                    </tbody>
                 </table>';
        $infor .='<table style="width:100%;font-family: arial;">
                 <tbody>
                 <tr>
                 <td width="32%">POSITION/DESIGNATION: </td> 
                 <td style="border-bottom:1pt solid #00145c;">'.strtoupper($travel['names'][0]['position']). '</td>    
                 </tr>
                 </tbody>
              </table>';
        $infor .='<table style="font-family: arial;" width="100%"><tbody><tr><td style="text-align:left"  width="15%">OFFICE/STATION:</td><td style=" border-color: #00145c;border-bottom:1pt solid #00145c;text-align:left" width="85%">'.$travel['details'][0]['office'].'</td></tr></tbody></table>';
        $infor .='<table style="font-family: arial;" width="100%"><tbody><tr><td style="text-align:left"  width="15%">DESTINATION:</td><td style="border-bottom:1pt solid #00145c;text-align:left" width="85%">'.$travel['details'][0]['destination'].'</td></tr></tbody></table>';
        $infor .='<table  style="font-family: arial;;padding-bottom:0px" width="100%"><tbody><tr><td style="text-align:left"  width="28%">DATE OF DEPARTURE:</td><td style="border-bottom:1pt solid #00145c;text-align:left" width="22%">'.$travel['details'][0]['date_departure'].'</td>
                <td style="text-align:left"  width="25%">DATE OF RETURN:</td><td style="border-bottom:1pt solid #00145c;text-align:left" width="25%">'.$travel['details'][0]['date_return'].'</td></tr></tbody></table>';
        // $infor .='<p style="text-align: left;padding-left:5px;padding-top:0px">PURPOSE OF TRAVEL:<br><span style="font-size:12px;">'.$travel['details'][0]['purpose'].'</span></p><br><br>';
        $infor .='<table style="font-family: arial;" width="100%"><tbody><tr><td style="text-align:left"  width="35%">PURPOSE OF TRAVEL:<br><span style="font-size:14px;">'.$travel['details'][0]['purpose'].'</span></td><td width="68%"></td></tr></tbody></table>';
        $infor .='<br><br><table style="font-family: arial;" width="100%"><tbody><tr><td style="text-align:left"  width="41%">THE USE OF A SERVICE VEHICLE</td><td style="border-bottom:1pt solid #00145c;text-align:CENTER" width="68%">'.$travel['details'][0]['vehicle'].'</td></tr></tbody></table>';
        $infor .='<table style="font-family: arial;" width="100%"><tbody><tr><td style="text-align:left"  width="32%">IS HEREBY REQUESTED</td><td style="font-size:12px;text-align:CENTER" width="68%">Brand/Type/Plate No.</td></tr></tbody></table>';
        $infor .='<table style="font-family: arial;" width="100%"><tbody><tr><td style="text-align:left"  width="16%">REPORT TO:</td><td style="border-bottom:1pt solid #00145c;text-align:LEFT" width="87%">'.$travel['details'][0]['report_to'].'</td></tr></tbody></table>';
        $infor .='<table style="font-family: arial;" width="100%"><tbody><tr><td style="text-align:left"  width="30%">CHARGEABLE AGAINST:</td><td style="border-bottom:1pt solid #00145c;text-align:LEFT" width="76%">'.$travel['details'][0]['charge_to'].'</td></tr></tbody></table>';
        $infor .='<table style="font-family: arial;" width="100%"><tbody><tr><td style="text-align:left"  width="8%">REMARKS:</td><td style="border-bottom:1pt solid #00145c;text-align:LEFT" width="92%">'.$travel['details'][0]['remarks'].'</td></tr></tbody></table>';
        $infor .='<p class="pt-4" style="font-size:16px;text-align:left;padding-top:20px"><strong>RECOMMENDED BY:</strong></p>';
        $infor .='<p style="font-size:18px;text-align:left;">  MARIA FE A. DE LEON <br><span  style="font-size:14px;text-align:left;">Department/Office Head</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size:16px;text-align:center;padding-left:100px"><strong>APPROVED:</strong></span></p>';
        $infor .='<table style="font-size:18px;text-align:center;font-family: arial;" width="100%"><tr><td  width="50%"></td><td style="text-align:center"><strong>HUMERLITO A. DOLOR, MPA, PhD</strong><br><span  style="font-size:14px;text-align:left;">Provincial Governor</span></td></tr></table>';
        $infor .='<p style="font-size:16px;text-align:center;margin:0;padding:0;padding-top:10px; line-height : 20px;">CERTIFICATE OF APPEARANCE</p>';
        $infor .='<p style="font-size:12px;text-align:left;text-indent:30px;margin : 0; padding-top:0;">I hereby certify that the above personnel appeared at the place/s on the date/s and for the purpose indicated to the T.O. and detail of travle below.</p>';
        $infor .='<table style="font-family: arial;table-layout:fixed;" width="100%"><tbody><tr>
                    <td style="text-align:center;font-size:16px ;" width="30%">DATE APPEARED</td>
                    <td></td>
                    <td style="text-align:center;font-size:16px;" width="30%">OFFICE</td>
                    <td></td>
                    <td style="text-align:center;font-size:16px;" width="30%">NAME/DESIGNATION</td>
                    </tr><tr>
                    <td style="border-bottom:1pt solid #00145c;color:white;font-size:10px;" width="30%">SAMPLE</td>
                    <td></td>
                    <td style="border-bottom:1pt solid #00145c;" width="30%"></td>
                    <td></td>
                    <td style="border-bottom:1pt solid #00145c;" width="30%"></td>
                    </tr><tr>
                    <td style="border-bottom:1pt solid #00145c;color:white;font-size:10px;" width="30%">SAMPLE</td>
                    <td></td>
                    <td style="border-bottom:1pt solid #00145c;" width="30%"></td>
                    <td></td>
                    <td style="border-bottom:1pt solid #00145c;" width="30%"></td>
                    </tr><tr>
                    <td style="border-bottom:1pt solid #00145c;color:white;font-size:10px;" width="30%">SAMPLE</td>
                    <td></td>
                    <td style="border-bottom:1pt solid #00145c;" width="30%"></td>
                    <td></td>
                    <td style="border-bottom:1pt solid #00145c;" width="30%"></td>
                    </tr></tbody></table>';
        $infor .='</div>';
        $mpdf->SetTitle('TRAVEL ORDER '.$travel['details'][0]['control_no']);
        $mpdf->WriteHTML($infor);
        $mpdf->Output();
  
}
}
?> 
