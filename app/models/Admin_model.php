<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Admin_model extends Model {
	public function get_appointments(){
        return $this->db->raw('SELECT *  FROM `travel_orders`');
    }
    public function settings(){
        return $this->db->raw('SELECT *  FROM `settings`');
    }
    public function update_settings($to_no){
        return $this->db->table('settings')->where('description', 'control_no')->update(array('val'=>$to_no));
    }

    public function get_to(){
        return $this->db->table('settings')->select('val as control_no')->where('description', 'control_no')->get();
    }

    public function appointment_list(){
        return $this->db->raw('SELECT p.*, a.date_sched, a.status, a.id as aid from  `account` p inner join `appointments` a on p.id = a.patient_id  order by unix_timestamp(a.date_sched) desc ');
    }
    
    public function add_travel($to_no, $depart, $return, $office, $vehicle, $report, $charge, $destination, $purpose, $remarks, $type){
        $bind = array(
            'control_no' => $to_no,
            'destination' => $destination,
            'purpose' => $purpose,
            'date_departure' => $depart,
            'date_return' => $return,
            'office' => $office,
            'vehicle' => $vehicle,
            'report_to' => $report,
            'charge_to' => $charge,
            'remarks' => $remarks,
            'type' => $type,
        );
         $this->db->table('settings')->where('description', 'control_no')->update(array('val'=>$to_no));
         if($this->db->table('travel_orders')->insert($bind)){
            return $this->db->table('travel_orders')->select_max('id', 'id')->get();
         }
    }

    public function save_travelers($to_id, $emp_id, $date){
        $to = $this->db->raw('SELECT MAX(travel_date) as last_to from history WHERE employee = '.$emp_id.' AND travel_date < DATE_FORMAT(now(),"%Y-%m-%d")');
        $bind = array(
            'employee'  => $emp_id,
            'travel_id' => $to_id,
            'travel_date' => $date,
            'last_to' => $to[0]['last_to']
        );
         $this->db->table('travelers')->insert($bind);
         $this->db->table('history')->insert(array('travel_date'=> $date));
    }
    
    public function view_data($id){
        $data['details'] = $this->db->raw("SELECT control_no, destination, purpose, vehicle, report_to, charge_to,office,remarks,type, DATE_FORMAT(date_created, '%M %e, %Y') as date_created, DATE_FORMAT(date_departure, '%M %e, %Y') as date_departure, DATE_FORMAT(date_return, '%M %e, %Y') as date_return  from `travel_orders` where id = '$id' ");
        // $data['names'] = $this->db->raw("SELECT u.*, DATE_FORMAT((SELECT MAX(travel_date) from history WHERE travel_date < DATE_FORMAT(now(),'%Y-%m-%d') AND employee = 't.employee'), '%Y-%m-%d') as last_to FROM travelers as t JOIN users as u  ON t.employee = u.id  where t.travel_id = $id");
        $data['names'] =  $this->db->table('travelers as t')->select('u.*,DATE_FORMAT(t.last_to,"%M %e, %Y") as last, DATE_FORMAT((SELECT MAX(travel_date) from history WHERE employee = u.id and travel_date < DATE_FORMAT(now(),"%Y-%m-%d")) , "%M %e, %Y") as last')->left_join('users as u', 't.employee = u.id')->where('t.travel_id', $id)->get_all();
        return $data;
    }
    public function view_assoc($id){
        $data['ids'] = array();
        $ids = $this->db->table('travelers')->select('employee')->where('travel_id', $id)->get_all();
        foreach($ids as $i){
            array_push($data['ids'], $i['employee']);
        }
        $data['names'] =  $this->db->table('users as u')->select('u.*,DATE_FORMAT(t.last_to,"%M %e, %Y") as last, DATE_FORMAT((SELECT MAX(travel_date) from history WHERE employee = u.id and travel_date < DATE_FORMAT(now(),"%Y-%m-%d")) , "%M %e, %Y") as last')->left_join('travelers as t', 'u.id = t.employee')->get_all();
        return $data;
    }
    
    public function user_list(){
        return $this->db->table('users')->select('users.*, DATE_FORMAT((SELECT MAX(travel_date) from history WHERE employee = users.id and travel_date < DATE_FORMAT(now(),"%Y-%m-%d")) ,"%M %e, %Y") as last_to')->get_all();
    }
    public function emp_list(){
        return $this->db->table('users as u')->select('u.*, DATE_FORMAT((SELECT MAX(travel_date) from history WHERE employee = u.id and travel_date < DATE_FORMAT(now(),"%Y-%m-%d")) , "%M %e, %Y") as last_to, DATE_FORMAT((SELECT MAX(travel_date) from history WHERE employee = u.id and travel_date < DATE_FORMAT(now(),"%Y-%m-%d")) , "%Y-%m-%d") as last')->get_all();
    }
    public  function profile($id){
        return $this->db->table('users')->where('id', $id)->get();
    }

    public function update_profile($data, $id){
        return $this->db->raw('UPDATE users set '.$data.' where id = '.$id);
    }
    public function add_employee($empno, $pos, $fn, $mn, $ln, $last_to){
        $bind = array(
            'emp_no'  => $empno,
            'position' => $pos,
            'fname' => $fn,
            'mname' => $mn,
            'lname' => $ln,
        );
        $this->db->table('history')->insert(array('travel_date'=> $last_to));
        return $this->db->table('users')->insert($bind);
    }
    public function update_employee($id, $empno, $pos, $fn, $mn, $ln, $last_to){
        $val = false;
        $update = array(
            'emp_no'  => $empno,
            'position' => $pos,
            'fname' => $fn,
            'mname' => $mn,
            'lname' => $ln,
        );
        if($this->db->table('history')->insert(array('travel_date'=> $last_to, 'employee' => $id))){
            $val = true;
        }
        if($this->db->table('users')->where('id', $id)->update($update)){
            $val = true;
        }
        return $val;
    }
    
}
?>
