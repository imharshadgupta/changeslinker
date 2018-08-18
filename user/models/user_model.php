<?php
class User_model extends CI_Model {
	
	function __construct(){
		parent::__construct();
	}

	/*----------------------------------------------------------- Manager Rights --------------------------------------------------------------------------------------*/

	function menus_list_all()
	{	
		$query = $this->db->query("select root.`iMenuId` as parent_id,root.cMenuName as parent_name,child.iMenuId as child_id,child.cMenuName as child_name from menu_master as root left outer join menu_master as child on child.iParentMenuId=root.iMenuId where root.iParentMenuId='0' and root.bActive='1' and child.bActive='1' order by root.iDisplaySequence,
 child.iDisplaySequence");
		
		if($query)
		{
			//return $query->result_array();
			return $query; 
		}
	}
	
	function get_existing_user_rights($UserId,$UserName)
	{
		$Data="";
		
		$sql = $this->db->query("SELECT * FROM user_rights_details WHERE user_rights_details.iUserId=\"$UserId\" AND user_rights_details.cUserName=\"$UserName\"");  
		
		if($sql)
		{
			if($sql->num_rows > 0)
			{
				foreach($sql->result_array() as $row)
				{		
					$UserId = trim($row['iUserId']);
					$UserName = trim($row['cUserName']);
					$ParentMenuId = trim($row['iParentMenuId']);
					$MenuId = trim($row['iMenuId']);
					$Add = trim($row['bAdd']);
					$Edit = trim($row['bEdit']);
					$Delete = trim($row['bDelete']);
					
					$sql1 = $this->db->query("SELECT cMenuName as cParentName FROM menu_master WHERE menu_master.iMenuId=\"$ParentMenuId\"");  
					
					if($sql1)
					{
						if($sql1->num_rows > 0)
						{
							$row1 = $sql1->row_array();
							
							$ParentName=$row1['cParentName'];
						}
					}
					
					$sql2 = $this->db->query("SELECT cMenuName as cChildName FROM menu_master WHERE menu_master.iMenuId=\"$MenuId\"");  
					
					if($sql2)
					{
						if($sql2->num_rows > 0)
						{
							$row2 = $sql2->row_array();
							
							$ChildName=$row2['cChildName'];
						}
					}
					
					if($Data=='')
					{
						$Data="$UserId~RightData~$ParentMenuId~RightData~$ParentName~RightData~$MenuId~RightData~$ChildName~RightData~0~RightData~0~RightData~0~RightData~0~RightData~$Add~RightData~$Edit~RightData~$Delete";
					}
					else
					{
						$Data.="~RightArray~$UserId~RightData~$ParentMenuId~RightData~$ParentName~RightData~$MenuId~RightData~$ChildName~RightData~0~RightData~0~RightData~0~RightData~0~RightData~$Add~RightData~$Edit~RightData~$Delete";
					}
				}
				
				return $Data;
			}
			else
			{
				return  FALSE;
			}
		}
		else
		{
			return  FALSE;
		}
	}
	
	function delete_existing_user_rights($UserId,$UserName)
	{
		$this->db->where('iUserId', $UserId);
		$this->db->where('cUserName', $UserName);
		$query = $this->db->get('user_rights_details');
		
		if($query->num_rows > 0)
		{
			$this->db->where('iUserId', $UserId);
			$this->db->where('cUserName', $UserName);
			$delete = $this->db->delete('user_rights_details');
			
			if($delete)
			{
				return TRUE;
			} 
			else 
			{
				return FALSE;
			}
		} 
		else
		{
			return TRUE;
		}
	}	
	
	function save_user_rights($userrightsdata)
	{
		$insert = $this->db->insert('user_rights_details', $userrightsdata);
		
		if($insert)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	/*-------------------------------------------------------- Employee User Rights -------------------------------------------------------------------------------------*/

	function emp_menus_list_all()
	{	
		$query = $this->db->query("select root.`iMenuId` as parent_id,root.cMenuName as parent_name,child.iMenuId as child_id,child.cMenuName as child_name from menu_master as root left outer join menu_master as child on child.iParentMenuId=root.iMenuId where root.iMenuId='64' and root.bActive='1' order by root.iDisplaySequence,child.iDisplaySequence");
		
		if($query)
		{
		  //return $query->result_array();
			return $query; 
		}
	}
		
	function get_emp_existing_user_rights($UserId,$UserName)
	{
		$Data="";
		
		$sql = $this->db->query("SELECT * FROM user_rights_details WHERE user_rights_details.iUserId=\"$UserId\" AND user_rights_details.cUserName=\"$UserName\"");  
		
		if($sql)
		{
			if($sql->num_rows > 0)
			{
				foreach($sql->result_array() as $row)
				{		
					$UserId = trim($row['iUserId']);
					$UserName = trim($row['cUserName']);
					$ParentMenuId = trim($row['iParentMenuId']);
					$MenuId = trim($row['iMenuId']);
					$Edit = trim($row['bEdit']);
					$View = trim($row['bView']);
					
					$sql1 = $this->db->query("SELECT cMenuName as cParentName FROM menu_master WHERE menu_master.iMenuId=\"$ParentMenuId\"");  
					
					if($sql1)
					{
						if($sql1->num_rows > 0)
						{
							$row1 = $sql1->row_array();
							
							$ParentName=$row1['cParentName'];
						}
					}
					
					$sql2 = $this->db->query("SELECT cMenuName as cChildName FROM menu_master WHERE menu_master.iMenuId=\"$MenuId\"");  
					
					if($sql2)
					{
						if($sql2->num_rows > 0)
						{
							$row2 = $sql2->row_array();
							
							$ChildName=$row2['cChildName'];
						}
					}
					
					if($Data=='')
					{
						$Data="$UserId~RightData~$ParentMenuId~RightData~$ParentName~RightData~$MenuId~RightData~$ChildName~RightData~$Edit~RightData~$View";
					}
					else
					{
						$Data."~RightArray~$UserId~RightData~$ParentMenuId~RightData~$ParentName~RightData~$MenuId~RightData~$ChildName~RightData~$Edit~RightData~$View";
					}
				}
				
				return $Data;
			}
			else
			{
				return  FALSE;
			}
		}
		else
		{
			return  FALSE;
		}
	}
}
?>