<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
include 'pdf/vendor/autoload.php';
class Main extends Controller {
    public function __construct()
    {
        parent::__construct();
        $this->call->helper(array('form', 'alert'));
        $this->call->model('Main_model');
        $this->call->model('Admin_model');
    }
    
    public function index() {
        $data['appointments'] = $this->Admin_model->get_appointments();
        $this->call->view('homepage', $data);
    }

    public function dashboard() {
        if(!$this->session->userdata('id')){
            redirect('Main/login');
        }
        else if($this->session->userdata('user_type')){
            redirect('Admin/index');
        }
        else{
            redirect('Patient/index');
        }
    }

    public function login(){
        $this->call->view('login');
    }

    public function logout(){
        $array_items = array('id', 'fn', 'ln', 'user_type', 'image');
        $this->session->unset_userdata($array_items);
        $this->call->view('login');
    }

    public function auth(){ 
        $password = $this->io->post('password');
        $user = $this->io->post('username');
        $user_info =  $this->Main_model->login($user);
        if($user_info){
            if(password_verify($password, $user_info['password'])){
                $this->session->set_userdata(array('id' => $user_info['id'], 'fn' => $user_info['fname'], 'ln' => $user_info['lname']));
	            redirect('Admin/index');
            }
        }
        else{
            echo "no data";
        }
    }
    public function register(){
        $this->call->view('register');
    }
    public function signup(){
        $password = $this->io->post('password');
        $user = $this->io->post('username');
        $name = $this->io->post('name');
        $email = $this->io->post('email');
        $contact = $this->io->post('contact');
        $gender = $this->io->post('gender');
        $address = $this->io->post('address');
        $bdate = $this->io->post('birthdate');
        $insert = $this->Main_model->register(password_hash($password, PASSWORD_DEFAULT), $user, $name, $email, $contact, $gender, $address, $bdate);
        if($insert){
            $this->session->set_flashdata('succ','Registration Successful');
            redirect('Main/Login');
        }
        else{
            $this->session->set_flashdata('err','Registration Unsuccessful');
            redirect('Main/register');
        }
    }

    public function pdf($id){
        
      
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->showImageErrors = true;
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [215.9, 330.2]]);
        // $mpdf->Image( BASE_URL . PUBLIC_DIR . "/uploads/pio", 0, 0, 210, 297, 'jpg', '', true, false);
        $TO="21-23";
        $usermail="ramirezjander09@gmail.com";
        $residence="baco";
        $userstory="story";
        
        $infor ='';
        $dir = BASE_URL . PUBLIC_DIR . "/uploads/OMP.png";
        $mpdf->SetHTMLHeader('<img style="width:100px;margin-left:40px" src="' .$dir .'"/>');
        $infor .='<div style = "background-image: url("'.$dir.'");"><p style="text-align: center;font-size:16px; font-family: arial;padding-bottom:0px;"><strong>PROVINCIAL GOVERNMENT OF ORIENTAL MINDORO</strong><br>
        <span style="text-align: center;font-size:14px; font-family: arial;padding-top:0px">Provincial Capitol Complex, Calapan 5200, Oriental Mindoro</p></span>
       
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
        for($x=0;$x<10;$x++){
            $infor .='<tr>
                        <td style="border-bottom:1pt solid black;">JANDER RAMIREZ</td>
                        <td></td>
                        <td style="border-bottom:1pt solid black;">SAO</td>
                        <td></td>
                        <td style="border-bottom:1pt solid black;">March 27, 2023</td>
                        </tr>';
        }
                        
        $infor .= '</tbody>
                    </table><br>';
        $infor .='<table style="font-family: arial;" width="100%"><tbody><tr><td style="text-align:left"  width="20%">OFFICE/STATION:</td><td style="border-bottom:1pt solid black;text-align:left" width="80%">GO-PISD</td></tr></tbody></table>';
        $infor .='<table style="font-family: arial;" width="100%"><tbody><tr><td style="text-align:left"  width="15%">DESTINATION:</td><td style="border-bottom:1pt solid black;text-align:left" width="85%">GO-PISD</td></tr></tbody></table>';
        $infor .='<table  style="font-family: arial;;padding-bottom:0px" width="100%"><tbody><tr><td style="text-align:left"  width="25%">DATE OF DEPARTURE:</td><td style="border-bottom:1pt solid black;text-align:left" width="25%">GO-PISD</td><td style="text-align:left"  width="21%">DATE OF RETURN:</td><td style="border-bottom:1pt solid black;text-align:left" width="29%">GO-PISD</td></tr></tbody></table>';
        $infor .='<p style="text-align: left;padding-left:5px;padding-top:0px">PURPOSE OF TRAVEL:<br>Coverage of food packs distribution to oil spill affected barangay</p><br/><br><br><br><br><br>';
        $infor .='<table style="font-family: arial;" width="100%"><tbody><tr><td style="text-align:left"  width="32%">THE USE OF A SERVICE VEHICLE</td><td style="border-bottom:1pt solid black;text-align:CENTER" width="68%">GO-PISD</td></tr></tbody></table>';
        $infor .='<table style="font-family: arial;" width="100%"><tbody><tr><td style="text-align:left"  width="32%">IS HEREBY REQUESTED</td><td style="font-size:12px;text-align:CENTER" width="68%">Brand/Type/Plate No.</td></tr></tbody></table>';
        $infor .='<table style="font-family: arial;" width="100%"><tbody><tr><td style="text-align:left"  width="12%">REPORT TO:</td><td style="border-bottom:1pt solid black;text-align:LEFT" width="87%">Activity Coordinator</td></tr></tbody></table>';
        $infor .='<table style="font-family: arial;" width="100%"><tbody><tr><td style="text-align:left"  width="24%">CHARGEABLE AGAINST:</td><td style="border-bottom:1pt solid black;text-align:LEFT" width="76%">Activity Coordinator</td></tr></tbody></table>';
        $infor .='<table style="font-family: arial;" width="100%"><tbody><tr><td style="text-align:left"  width="8%">REMARKS:</td><td style="border-bottom:1pt solid black;text-align:LEFT" width="92%">OFFICIAL BUSINESS</td></tr></tbody></table>';
        $infor .='<br><br><p style="font-size:14px;text-align:left;">RECOMMENDED BY:</p>';
        $infor .='<br><p style="font-size:14px;text-align:left;">MARIA FE A. DE LEON <br>Department/Office Head</p>';
        $infor .='<p style="font-size:14px;text-align:center;">APPROVED:</p><br>';
        $infor .='<table style="font-size:14px;text-align:center" width="100%"><tr><td  width="50%"></td><td style="text-align:center">HUMERLITO A. DOLOR, MPA, PhD</td></tr></table>';
        $infor .='<table style="font-size:14px;text-align:center" width="100%"><tr><td  width="50%"></td><td style="text-align:center">Provincial Governor</td></tr></table>';
        $infor .='<p style="font-size:11px;text-align:center;">[ All employees listed above shall secure their respective certificate of appearance. ]</p><br>';

        $infor .='</div>';

        
        $mpdf->WriteHTML($infor);
        $mpdf->Output();
  
}
	
}
?>
