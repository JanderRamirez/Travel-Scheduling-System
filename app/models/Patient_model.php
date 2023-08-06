<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Patient_model extends Model {
	public function get_appointments($id){
        return $this->db->raw('SELECT a.*, p.name FROM `account` p inner join `appointments` a on p.id = a.patient_id WHERE p.id = ?', array($id));
    }
    public function appointment_list($id){
        return $this->db->raw('SELECT p.*, a.date_sched, a.status, a.id as aid from  `account` p inner join `appointments` a on p.id = a.patient_id where p.id=?  order by unix_timestamp(a.date_sched) desc ', array($id));
    }
    public function check($date_sched, $id){
        return $this->db->raw("SELECT * FROM `appointments` where ".strtotime($date_sched)." Between unix_timestamp(date_sched) and unix_timestamp(DATE_ADD(date_sched, interval 30 MINUTE)) and id != $id");
    }
    public function save_sched($date_sched,$patient_id, $status){
        return $this->db->raw("INSERT INTO `appointments` set date_sched = '$date_sched', patient_id = '$patient_id',`status` = '$status'");
    }
    public function view_data($id){
        return $this->db->raw("SELECT *, DATE_FORMAT(date_sched, '%M %d, %Y') as sched, DATE_FORMAT(birthdate, '%M %d, %Y') as bd, a.id as app_id, u.id as pid from `appointments` a inner join account u on a.patient_id = u.id where a.id = '$id' ");
    }
    public function update_sched($date, $id){
        // return $this->db->raw("UPDATE `appointments` SET date_sched = `$date` WHERE id = $id ");
        return $this->db->table('appointments')->where('id', $id)->update(array('date_sched' => $date));
    }
    public function profile($id){
        return $this->db->table('account')->select('*, DATE_FORMAT(birthdate, "%d/%e/%Y") as birth')->where('id', $id)->get();
    }
    public function update_profile($data, $id){
        return $this->db->raw('UPDATE account set '.$data.' where id = '.$id);
    }
}
?>
