<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();

class Login extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->model('login/login_model');
		$this->load->model('dashboard/dashboard_model');
		
		//date_default_timezone_set('Asia/Kolkata');
		date_default_timezone_set('Asia/Calcutta');
	}
		
	function index()
	{
		$this->load->view('login_form');		
	}
	
 // Function to get the client ip address
	function get_client_ip() {
	  $ipaddress = '';
		if (getenv('HTTP_CLIENT_IP'))
			$ipaddress = getenv('HTTP_CLIENT_IP');
		else if(getenv('HTTP_X_FORWARDED_FOR'))
			$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
		else if(getenv('HTTP_X_FORWARDED'))
			$ipaddress = getenv('HTTP_X_FORWARDED');
		else if(getenv('HTTP_FORWARDED_FOR'))
			$ipaddress = getenv('HTTP_FORWARDED_FOR');
		else if(getenv('HTTP_FORWARDED'))
			$ipaddress = getenv('HTTP_FORWARDED');
		else if(getenv('REMOTE_ADDR'))
			$ipaddress = getenv('REMOTE_ADDR');
		else
			$ipaddress = 'UNKNOWN';
	
		return $ipaddress; 
	}
	
	function validate()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('txtUserName', 'Username', 'trim|required|xss_clean');
		$this->form_validation->set_rules('txtPassword', 'Password', 'trim|required|xss_clean|callback_check_database');
		
		if($this->form_validation->run() == FALSE)
		{			
			$this->load->view('login_form');
		}
		else
		{
		    $UserId = $this->session->userdata('UserId');
				
		  redirect("dashboard");	
		  
			//redirect("dashboard/userpendingtasklist");	
		}
	}	
		
	function check_database()
	{
		$rowuser = $this->login_model->validate();
		
		if($rowuser) // if the user's credentials validated...
		{			
			$new_activity_data = array(
				'dActivityDateTime' => date('Y-m-d H:i:s'),
				'cUserName' => trim($rowuser['cUserName']),			
				'cIPAddress' => $this->get_client_ip(),
				'cActivityDesc' => 'User Login',
			);
			
			$activitylogid = $this->login_model->save_activity_details($new_activity_data);
			
			if($activitylogid)
			{				
				$data = array(
					'UserId' => trim($rowuser['iUserId']),
					'UserDeptId' => trim($rowuser['iDepartmentId']),
					'Name' => trim($rowuser['cName']),
					'MobileNo' => trim($rowuser['iMobileNo']),
					'EmailAddress' => trim($rowuser['cEmailAddress']),
					'UserName' => trim($rowuser['cUserName']),
					'UserType' => trim($rowuser['cUserType']),
					'activitylogid' => $activitylogid,
					'is_logged_in' => true
				);
				
				$this->session->set_userdata($data);
				return TRUE;
			}			
		}
		else
		{
			$this->form_validation->set_message('check_database', 'Invalid username or password');
      		return FALSE;
		}            
	}
		
	function is_logged_in()
	{
		$is_logged_in = $this->session->userdata('is_logged_in');
		if(!isset($is_logged_in) || $is_logged_in != true)
		{
			echo 'You don\'t have permission to access this page. <a href="../login">Login</a>';	
			die();		
			//$this->load->view('login_form');
		}		
	}
	
	function logout()
	{
		$new_activity_data = array(
			'dActivityDateTime' => date('Y-m-d H:i:s'),
			'cUserName' => $this->session->userdata('UserName'),			
			'cIPAddress' => $this->get_client_ip(),
			'cActivityDesc' => 'User Logout',
		);
				
		$activitylogid = $this->login_model->save_activity_details($new_activity_data);
		
		if($activitylogid)
		{	
			$this->session->sess_destroy();
			$this->index();
		}
	}
}