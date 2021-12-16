<?php
class Login_model extends CI_Model{
  
    public function checkUserLogin($data){
        $this->db->where($data);
        $this->db->where('tbl_login.login_status',1);
        $query = $this->db->get('tbl_login');
        if($query->num_rows() == 1){
            $this->session->set_userdata($query->row_array());
            return true;
        }
        else{
            return false;
        }
    }
}
?>
