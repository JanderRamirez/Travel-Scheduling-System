<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Main_model extends Model {
	public function get_sysinfo(){
        return $this->db->table('system_info')->get_all();
    }
    public function login($user) {
        return $this->db->table('admin')->where(array('email' => $user))->get();
    }
    public function login_patient($password, $user) {
        return $this->db->table('admin')->where(array('email' => $user, 'password' => md5($password)))->get();
    }
    public function register($password, $user, $name, $email, $contact, $gender, $address, $bdate){
        $bind = array(
			'username'    => $user,
			'password'  => $password,
			'name'     => $name,
			'email'     => $email,
			'contact'     => $contact,
			'gender'     => $gender,
			'address'     => $address,
			'birthdate'     => $bdate
		);
        return $this->db->table('account')->insert($bind);
    }
   
}

?>
