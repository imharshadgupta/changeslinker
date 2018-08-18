<?php

class Login_model extends CI_Model {

	function validate()
	{
		$username = $this->security->xss_clean($this->input->post('txtUserName'));
        $password = $this->security->xss_clean($this->input->post('txtPassword'));
		
		$this->db->where('cUserName', $username);
		$this->db->where('cPassword', $password);
		$this->db->where('bActive', 1);
		$this->db->where('bDelete', 0);
		$query = $this->db->get('user_master');
		
		if($query->num_rows == 1)
		{
			return $query->row_array();
		}
	}
	
	function save_activity_details($new_activity_data)
	{
		$insert = $this->db->insert('activity_log_master', $new_activity_data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}
}