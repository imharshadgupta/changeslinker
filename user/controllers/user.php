<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class User extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->model('dashboard/dashboard_model');
		$this->load->model('user/user_model');
	}
	
	function get_client_ip() 
	{
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
	
	function userrights()
	{
		$data['result'] = $this->user_model->menus_list_all();
		
		$data['message'] = '';
		
		$data['page_url'] = 'user_rights_view';
		
		$this->load->view('includes/template', $data);		
	}
	
	function get_existing_user_rights_by_userid()
	{
		$UserId = trim($this->input->post('UserId'));
		$UserName = trim($this->input->post('UserName'));
		
		$result=$this->user_model->get_existing_user_rights($UserId,$UserName);
		
		if($result)
		{
			echo $result;	// false
		}
		else
		{
			echo "FALSE"; // true
		}
	}
	
	function userrightssave()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('cmbUser', 'User Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('hfAttachmentData', 'User Data', 'trim|required|xss_clean');

		if($this->form_validation->run() == FALSE)
		{
			$data['page_url'] = 'user_rights_view';
			$this->load->view('includes/template', $data);
		}
		else
		{
			$cmbUser = trim($this->input->post('cmbUser'));
			
			$splitdata = explode('~',$cmbUser);
			
			$UsrId = $splitdata[0];
			
			$UsrName = $splitdata[1];
			
			$hfAttachmentData = trim($this->input->post('hfAttachmentData'));
			
			$new_activity_data = array(
				'dActivityDateTime' => date('Y-m-d H:i:s'),
				'cUserName' => trim($this->session->userdata('UserName')),			
				'cIPAddress' => $this->get_client_ip(),
				'cActivityDesc' => 'Assign User Rights'
			);
			
			$newactivitylogid = $this->dashboard_model->save_activity_details($new_activity_data);
			
			if($newactivitylogid)
			{
				if($hfAttachmentData!='')
				{
					$delres = $this->user_model->delete_existing_user_rights($UsrId,$UsrName);
					
					$saveflag=false;
					
					if($delres)
					{	
						$arr=explode('~UserArray~',$hfAttachmentData);
						
						$SNo=0;
						for($i=0;$i<sizeof($arr);$i++)
						{
							$attachmentdata=explode('~UserData~',$arr[$i]);
							
							$UserId=$attachmentdata[0];
							$ParentId=$attachmentdata[1];
							$ParentName=$attachmentdata[2];
							$ChildId=$attachmentdata[3];
							$ChildName=$attachmentdata[4];
							$ParentMenuAddFlag=$attachmentdata[5];
							$ParentMenuDeleteFlag=$attachmentdata[6];
							$ChildMenuAddFlag=$attachmentdata[7];
							$ChildMenuDeleteFlag=$attachmentdata[8];
							$chkAddVal=$attachmentdata[9];
							$chkEditVal=$attachmentdata[10];
							$chkDeleteVal=$attachmentdata[11];
							
							if(($ParentMenuAddFlag==1) && ($ChildMenuAddFlag==1))
							{
								$userrightsdata = array(
									'iUserId' => trim($UsrId),
									'cUserName' => trim($UsrName),
									'iParentMenuId' => trim($ParentId),
									'iMenuId' => trim($ChildId),
									'bAdd' => trim($chkAddVal),
									'bEdit' => trim($chkEditVal),
									'bDelete' => trim($chkDeleteVal),
                                                                        'bView' => 0
								);
								
								$save = $this->user_model->save_user_rights($userrightsdata);
								
								if($save)
								{
									$saveflag=true;	
								}
							}
						}
					}
					
					if($saveflag=='true')
					{
						echo 'TRUE';
					}
					else
					{
						echo 'FALSE';
					}
				}			
			}

		}
	}	
	
	/*---------------------------------------------------------------------------------------------------------------------------------------------------------------------------*/

	function empuserrights()
	{
		$data['result'] = $this->user_model->emp_menus_list_all();
		
		$data['message'] = '';
		
		$data['page_url'] = 'emp_user_rights_view';
		
		$this->load->view('includes/template', $data);		
	}

	function get_emp_existing_user_rights_by_userid()
	{
		$UserId = trim($this->input->post('UserId'));
		$UserName = trim($this->input->post('UserName'));
		
		$result=$this->user_model->get_emp_existing_user_rights($UserId,$UserName);
		
		if($result)
		{
			echo $result;	// false
		}
		else
		{
			echo "FALSE"; // true
		}
	}

	function empuserrightssave()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('cmbUser', 'User Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('hfAttachmentData', 'User Data', 'trim|required|xss_clean');

		if($this->form_validation->run() == FALSE)
		{
			$data['page_url'] = 'emp_user_rights_view';
			$this->load->view('includes/template', $data);
		}
		else
		{
			$cmbUser = trim($this->input->post('cmbUser'));
			
			$splitdata = explode('~',$cmbUser);
			
			$UsrId = $splitdata[0];
			
			$UsrName = $splitdata[1];
			
			$hfAttachmentData = trim($this->input->post('hfAttachmentData'));
			
			$new_activity_data = array(
				'dActivityDateTime' => date('Y-m-d H:i:s'),
				'cUserName' => trim($this->session->userdata('username')),			
				'cIPAddress' => $this->get_client_ip(),
				'cActivityDesc' => 'Assign Employee User Rights'
			);
			
			$newactivitylogid = $this->employee_model->save_activity_details($new_activity_data);
			
			if($newactivitylogid)
			{
				if($hfAttachmentData!='')
				{
					$delres = $this->user_model->delete_existing_user_rights($UsrId,$UsrName);
					
					$saveflag=false;
					
					if($delres)
					{	
						$arr = explode('~UserArray~',$hfAttachmentData);
						
						$SNo=0;
						for($i=0;$i<sizeof($arr);$i++)
						{
							$attachmentdata=explode('~UserData~',$arr[$i]);
							
							$splitdata = explode('~',$attachmentdata[0]);
			
							$UserId = $splitdata[0];
							$UserName = $splitdata[1];
			
							$UserId = $UserId[0];
							$ParentId = $attachmentdata[1];
							$ParentName = $attachmentdata[2];
							$ChildId = $attachmentdata[3];
							$ChildName = $attachmentdata[4];
							$chkEditVal = $attachmentdata[5];
							$chkViewVal = $attachmentdata[6];
							
							$empuserrightsdata = array(
								'iUserId' => trim($UsrId),
								'cUserName' => trim($UsrName),
								'iParentMenuId' => 0,
								'iMenuId' => trim($ParentId),
								'bEdit' => trim($chkEditVal),
								'bView' => trim($chkViewVal),
							);
							
							$save = $this->user_model->save_user_rights($empuserrightsdata);
							
							if($save)
							{
								$saveflag=true;	
							}
						}
					}
					
					if($saveflag=='true')
					{
						echo 'TRUE';
					}
					else
					{
						echo 'FALSE';
					}
				}			
			}

		}
	}

}  // User Class Closed