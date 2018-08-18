<script type="text/javascript" language="javascript">
var MenuArray = new Array();
</script>

<div class="inner_form">

<h2>User Rights</h2>

	<div class="mfrminner">
		
		<fieldset><legend>Assign User Rights</legend>
        <div style="color: #0000FF; text-align:center; font-weight:bold;"><?php echo $this->session->flashdata('msg');?><br /><?php echo validation_errors(); ?></div>
		<form name="form1" method="post" action="">
        <input type="hidden" id="hfRightData" name="hfRightData" size="20" />
        <input type="hidden" id="hfAttachmentData" name="hfAttachmentData" size="40" value="" />
        <table cellpadding="0" cellspacing="0" border="0" style="width: 800px;">
		<tr style="height: 30px; color: #660033;">
        <td style="width:35px; text-align:center; color:#FFFFFF;" colspan="5">
        <select name="cmbUser" id="cmbUser" style="width: 300px;" class="fild" onchange="GetUserRightsByUserId()">
        <option value="">Select User</option>
		<?php
	  //$sql = $this->db->query("SELECT iUserId,cName,cUserName FROM user_master WHERE user_master.cUserType='Admin' AND user_master.bActive='1' AND user_master.bDelete='0'");
		
		$sql = $this->db->query("SELECT iUserId,cName,cUserName FROM user_master WHERE user_master.bActive='1' AND user_master.bDelete='0'");
	    
		if($sql)
        {
			if($sql->num_rows() > 0)
			{
				foreach($sql->result_array() as $row)
				{
					if($row['iUserId']!='')
					{
						$UserId = trim($row['iUserId']);
					}
					else
					{
						$UserId="";
					}
					
					if($row['cName']!='')
					{
						$Name = trim($row['cName']);
					}
					else
					{
						$Name="";
					}
					
					if($row['cUserName']!='')
					{
						$UserName = trim($row['cUserName']);
					}
					else
					{
						$UserName="";
					}
					?>
				 	<option value="<?php echo "$UserId~$UserName"; ?>" <?php //if($User_Id==$EmployeeId){ echo 'selected'; } ?>><?php echo $Name." "."($UserName)"; ?></option>
				 <?php
				 }
			 }
			 else
			 {
			 	// No user found
			 }
        }				
        ?>
        </select></td>
		</tr>
		</table>
        
        <table style="width: 800px;" cellpadding="0" cellspacing="0" border="0" bordercolor="#CCCCFF">
        <?php $numrows = $result->num_rows(); ?>
		<input type="hidden" id="hfNumRows" name="hfNumRows" value="<?php echo $numrows; ?>" size="5" />
		<?php		
		$i=0;
		foreach($result->result_array() as $row)
		{
			$parent_id=trim($row['parent_id']);
			$parent_name=trim($row['parent_name']);
			
			if($row['child_id']!='')
			{
				$child_id=trim($row['child_id']);
			}
			else
			{
				$child_id=0;
			}
			
			if($row['child_name']!='')
			{
				$child_name=trim($row['child_name']);
			}
			else
			{
				$child_name="NA";
			}
			
			$add_right=0;
			$edit_right=0;
			$delete_right=0;
		    ?>
			
            <tr>
				<td>
					<input type="hidden" id="hfParentMenuId<?php echo $i ; ?>" name="hfParentMenuId"  value="<?php echo $parent_id; ?>" size="5" /></td>
				<td><input type="hidden" id="hfParentMenuName<?php echo $i ; ?>" name="hfParentMenuName"  value="<?php echo $parent_name; ?>" size="5" /></td>
				<td>
					<input type="hidden" id="hfChildMenuId<?php echo $i ; ?>" name="hfChildMenuId"  value="<?php echo $child_id; ?>" size="5" /></td>
				<td><input type="hidden" id="hfChildMenuName<?php echo $i ; ?>" name="hfChildMenuName"  value="<?php echo $child_name; ?>"size="5" /></td>
		   </tr>
		
		<?php	
			$i++;
		}
		?>
		<script type="text/javascript">
		//AddToArray();
		</script>
	
	<tr>
		<td colspan="5">&nbsp;</td>
	</tr>
	</table>
    
    <table id="tbl" style="width: 800px" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td colspan="5" align="center"><div id="dvMenuDetail"> </div></td>
	</tr>
	</table>
	</form>	
     
	</div>
	<div class="clear"></div>
</div>

<script type="text/javascript"  language="javascript">
function GetUserRightsByUserId()
{
	if($('#cmbUser').val()!='')
	{
		var splitval =  $('#cmbUser option:selected').val().split('~'); 
		var UserId = splitval[0];
		var UserName = splitval[1];
		
		AddToArray();
		
		$.ajax({
			type: "POST",
			url: "<?php  echo base_url();?>index.php/user/get_existing_user_rights_by_userid",
			data: "UserId="+UserId+"&UserName="+UserName,
			success: function(data){
				//alert(data);
				if(data!='FALSE')
				{
					$("#hfRightData").val(data);
					EditTableLoad();
				}
				else
				{
				   $("#hfRightData").val('');
				}
			}
		});
	}
	else
	{
		MenuArray.length=0;
		$('#hfRightData').val(''); 
		$('#hfAttachmentData').val(''); 
		$('#dvMenuDetail').text('');
	}
}
</script>

<script type="text/javascript" language="javascript">
function AddToArray()
{
	var hfNumRows = $('#hfNumRows').val();

	var hfParentId = document.getElementsByName('hfParentMenuId'); 
	var hfParentName = document.getElementsByName('hfParentMenuName'); 
	var hfChildId = document.getElementsByName('hfChildMenuId');
	var hfChildName = document.getElementsByName('hfChildMenuName');  
		
	var Addflag=true;

	if(hfNumRows>0)
	{
		if(Addflag==true)
		{
			for(x=0;x<hfNumRows;x++)
			{
				MenuArray[x] = new Array();				
			 		
			    MenuArray[x][0]=  $('#cmbUser option:selected').val(); //UserId
				MenuArray[x][1] = parseInt(hfParentId[x].value);  // ParentId
				MenuArray[x][2] = hfParentName[x].value; 		  // ParentName
				MenuArray[x][3] = parseInt(hfChildId[x].value);   // ChildId
				MenuArray[x][4] = hfChildName[x].value;           // ChildName
				MenuArray[x][5] = 0;  	//Add Parent Flag
				MenuArray[x][6] = 0;  	//Remove Parent Flag
				MenuArray[x][7] = 0;  	//Add Child Flag
				MenuArray[x][8] = 0;  	//Remove Child Flag
				MenuArray[x][9] = 0;  	//Add Permission Flag
				MenuArray[x][10] = 0; 	//Edit Permission Flag
				MenuArray[x][11] = 0; 	//Delete Permission Flag	
			}		
		}
	}
	DisplayItems();
}
</script>

<script type="text/javascript"  language="javascript">
function DisplayItems()
{
	var attachData="<table width=\"750\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\" border=\"1\" bordercolor=\"#000000\">";
		attachData+="<tr>";
	<!--attachData+="<td width=\"50\" align=\"center\"><b>S.No.</b></td>";-->
		attachData+="<td width=\"50\" align=\"center\"><b>&nbsp;</b></td>";
		attachData+="<td width=\"100\" align=\"left\"><b>Parent Menu</b></td>";
		attachData+="<td width=\"50\" align=\"center\"><b>&nbsp;</b></td>";
		attachData+="<td width=\"50\" align=\"center\"><b>&nbsp;</b></td>";
		attachData+="<td width=\"200\" align=\"left\"><b>Child Menu</b></td>";
		attachData+="<td width=\"50\" align=\"center\"><b>Add</b></td>";
		attachData+="<td width=\"50\" align=\"center\"><b>Edit</b></td>";
		attachData+="<td width=\"50\" align=\"center\"><b>Delete</b></td>";
		attachData+="</tr>";
		attachData+="<tr>";
		attachData+="<td colspan=\"8\">&nbsp;</td>";
		attachData+="</tr>";
		
		var previous='';
		
		for(i=0;i<MenuArray.length;i++)	
		{
			attachData+="<tr>";
		<!--attachData+="<td width=\"50\" align=\"center\">"+(i+1)+"</td>";-->
			
			var current=MenuArray[i][1];
			
			if(current==previous)
			{
				attachData+="<td width=\"50\" align=\"center\"><input type=\"checkbox\" id=\"chkParent"+i+"\" name=\"chkParent\" onclick=\"AddRemoveParentMenu("+i+")\" value="+MenuArray[i][1]+"  style=\"visibility: hidden\" /></td>";
				
				attachData+="<td width=\"100\" style=\"visibility: hidden\">"+MenuArray[i][2]+"</td>";
			}
			else
			{
				attachData+="<td width=\"50\" align=\"center\"><input type=\"checkbox\" id=\"chkParent"+i+"\" name=\"chkParent\" onclick=\"AddRemoveParentMenu("+i+")\" value="+MenuArray[i][1]+"  style=\"visibility: visibile\" /></td>";
				
				attachData+="<td width=\"100\" style=\"visibility: visibile\">"+MenuArray[i][2]+"</td>";
			}
			
			previous=current;
			
			
			if(MenuArray[i][4]=='NA') // No child menu exists.
			{
			
				attachData+="<td width=\"50\" align=\"center\">&nbsp;</td>";
			
				attachData+="<td width=\"50\" align=\"center\"><input type=\"checkbox\" id=\"chkChild"+i+"\" onclick=\"AddRemoveChildMenu("+i+")\" value="+MenuArray[i][3]+" style=\"visibility: hidden\" /></td>";
				
				attachData+="<td width=\"200\" style=\"visibility: hidden\">"+MenuArray[i][4]+"</td>";
							
				attachData+="<td width=\"50\" align=\"center\"><input type=\"checkbox\" id=\"chkAdd"+i+"\" onclick=\"ChangeAddPermission("+i+")\" style=\"visibility: hidden\" /></td>";
			
				attachData+="<td width=\"50\" align=\"center\"><input type=\"checkbox\" id=\"chkEdit"+i+"\" onclick=\"ChangeEditPermission("+i+")\" style=\"visibility: hidden\" /></td>";
			
				attachData+="<td width=\"50\" align=\"center\"><input type=\"checkbox\" id=\"chkDelete"+i+"\" onclick=\"ChangeDeletePermission("+i+")\" style=\"visibility: hidden\" /></td>";
			
			}
			else
			{
				attachData+="<td width=\"50\" align=\"center\"><span class=\"ui-icon ui-icon-triangle-1-e\"></span></td>";
				
				attachData+="<td width=\"50\" align=\"center\"><input type=\"checkbox\" id=\"chkChild"+i+"\" onclick=\"AddRemoveChildMenu("+i+")\" value="+MenuArray[i][3]+" style=\"visibility: visible\" /></td>";
				
				attachData+="<td width=\"200\" style=\"visibility: visible\">"+MenuArray[i][4]+"</td>";
				
				if((MenuArray[i][2]=='MASTERS')||(MenuArray[i][3]=='11')) //Child MenuName=='Client'	
				{		
					attachData+="<td width=\"50\" align=\"center\"><input type=\"checkbox\" id=\"chkAdd"+i+"\" onclick=\"ChangeAddPermission("+i+")\" style=\"visibility: visible\" /></td>";
				
					attachData+="<td width=\"50\" align=\"center\"><input type=\"checkbox\" id=\"chkEdit"+i+"\" onclick=\"ChangeEditPermission("+i+")\" style=\"visibility: visible\" /></td>";
				
					attachData+="<td width=\"50\" align=\"center\"><input type=\"checkbox\" id=\"chkDelete"+i+"\" onclick=\"ChangeDeletePermission("+i+")\" style=\"visibility: visible\" /></td>";
				}
				else
				{
					attachData+="<td width=\"50\" align=\"center\"><input type=\"checkbox\" id=\"chkAdd"+i+"\" onclick=\"ChangeAddPermission("+i+")\" style=\"visibility: hidden\" /></td>";
				
					attachData+="<td width=\"50\" align=\"center\"><input type=\"checkbox\" id=\"chkEdit"+i+"\" onclick=\"ChangeEditPermission("+i+")\" style=\"visibility: hidden\" /></td>";
				
					attachData+="<td width=\"50\" align=\"center\"><input type=\"checkbox\" id=\"chkDelete"+i+"\" onclick=\"ChangeDeletePermission("+i+")\" style=\"visibility: hidden\" /></td>";
				}
			}
			
			attachData+="</tr>";
		}
		
		attachData+="<tr>";
		attachData+="<td colspan=\"8\">&nbsp;</td>";
		attachData+="</tr>";
		
		attachData+="<tr>";
		attachData+="<td colspan=\"8\">&nbsp;</td>";
		attachData+="</tr>";
		
		attachData+="<tr>";
		attachData+="<td colspan=\"8\">&nbsp;</td>";
		attachData+="</tr>";
		
		attachData+="<tr>";
		attachData+="<td colspan=\"8\" align=\"center\"><input type=\"button\" id=\"btnSave\" class=\"btn\" value=\"Save Data\" onclick=\"SaveMenuData()\" style=\"width:100px;height:28px;\" /></td>";
		attachData+="</tr>";
		
		attachData+="<tr>";
		attachData+="<td colspan=\"8\">&nbsp;</td>";
		attachData+="</tr>";
		
		attachData+="<tr>";
		attachData+="<td colspan=\"8\">&nbsp;</td>";
		attachData+="</tr>";
		attachData+="</table>";
		
		document.getElementById('dvMenuDetail').innerHTML=attachData;
}	
</script>

<script type="text/javascript"  language="javascript">
function EditTableLoad()
{
	if($('#hfRightData').val()!='')
	{
		//alert('hi');
		//MenuArray.length=0;
		var arr=$('#hfRightData').val().split('~RightArray~');
		
		for(i=0;i<MenuArray.length;i++)
		{
			//alert(MenuArray[i][1]);	
			for(j=0;j<arr.length;j++)
			{
				var arrdata=(arr[j]).split('~RightData~');
				
				var getUserId=arrdata[0];
				var getParentId=arrdata[1];
				var getParentName=arrdata[2];
				var getChildId=arrdata[3];
				var getChildName=arrdata[4];
				var getAddParentFlag=arrdata[5];
				var getRemoveParentFlag=arrdata[6];
				var getAddChildFlag=arrdata[7];
				var getRemoveChildFlag=arrdata[8];
				var getAdd=arrdata[9];
				var getEdit=arrdata[10];
				var getDelete=arrdata[11];
				
				if((MenuArray[i][1]==getParentId) && (MenuArray[i][3]==getChildId))
				{
					document.getElementById('chkParent'+i).checked = true;
					AddRemoveParentMenu(i);
					
					document.getElementById('chkChild'+i).checked = true;
					AddRemoveChildMenu(i);
						
					if(getAdd==1)
					{
						document.getElementById('chkAdd'+i).checked = true;
						ChangeAddPermission(i);
					}
	
					if(getEdit==1)
					{
						document.getElementById('chkEdit'+i).checked = true;
						ChangeEditPermission(i);
					}
					
					if(getDelete==1)
					{
						document.getElementById('chkDelete'+i).checked = true;
						ChangeDeletePermission(i);
					}
				}				
			}
		}
	}
}
//EditTableLoad();
</script>

<script type="text/javascript"  language="javascript">
function AddRemoveParentMenu(rowno)
{ 
    if(document.getElementById('chkParent'+rowno).checked==true)
	{
		var childid=document.getElementById('chkChild'+rowno).value;
		if(childid==0)
		{
			document.getElementById('chkChild'+rowno).checked = true;
			MenuArray[rowno][7]=1;    // Add flag=1
		  	MenuArray[rowno][8]=0;	  // Del flag=0
		}
		
		var chkParent = document.getElementsByName('chkParent');
		var countchecked=0;	
		for(var i=0;i<chkParent.length;i++)
		{
			var currval = chkParent[i].value;
			
			if(currval==document.getElementById('chkParent'+rowno).value)
			{
				chkParent[i].checked = true;
				
				MenuArray[i][5]=1;    // Add flag=1
		  		MenuArray[i][6]=0;	  // Del flag=0  
				
				countchecked++;
			}
		}			
	}
	else
	{ 
		var childid=document.getElementById('chkChild'+rowno).value;
		if(childid==0)
		{
			document.getElementById('chkChild'+rowno).checked = false;
			 MenuArray[rowno][7]=0;	 // Add flag=0 
		 	 MenuArray[rowno][8]=1;  // Del flag=1
		}
		
		var chkParent = document.getElementsByName('chkParent');
		var countchecked=0;	
		for(var i=0;i<chkParent.length;i++)
		{
			var currval = chkParent[i].value;
			
			if(currval==document.getElementById('chkParent'+rowno).value)
			{
				chkParent[i].checked = false;
				
				 MenuArray[i][5]=0;	 // Add flag=0 
		 		 MenuArray[i][6]=1;  // Del flag=1
				
				countchecked++;
			}
		}
	}
}
</script>
<script type="text/javascript"  language="javascript">
function AddRemoveChildMenu(rowno)
{ 
    if(document.getElementById('chkChild'+rowno).checked==true)
	{
		  MenuArray[rowno][7]=1;    // Add flag=1
		  MenuArray[rowno][8]=0;	// Del flag=0
	}
	else
	{
		 MenuArray[rowno][7]=0;	 // Add flag=0 
		 MenuArray[rowno][8]=1;  // Del flag=1
	}
}
</script>
<script type="text/javascript"  language="javascript">
function ChangeAddPermission(rowno)
{ 
    if(document.getElementById('chkAdd'+rowno).checked==true)
	{
		  MenuArray[rowno][9]=1;   // Add Permission flag=1
	}
	else
	{
		 MenuArray[rowno][9]=0;	   // Add Permission flag=0
	}
}
</script>
<script type="text/javascript"  language="javascript">
function ChangeEditPermission(rowno)
{ 
    if(document.getElementById('chkEdit'+rowno).checked==true)
	{
		  MenuArray[rowno][10]=1;    // Edit Permission flag=1
	}
	else
	{
		 MenuArray[rowno][10]=0;	 // Edit Permission flag=0
	}
}
</script>
<script type="text/javascript"  language="javascript">
function ChangeDeletePermission(rowno)
{ 
    if(document.getElementById('chkDelete'+rowno).checked==true)
	{
		  MenuArray[rowno][11]=1;    // Delete Permission flag=1
	}
	else
	{
		 MenuArray[rowno][11]=0;	 // Delete Permission flag=0 
	}
}
</script>
<script type="text/javascript"  language="javascript">
function Concate()
{
	var Data="";

	for(i=0;i<MenuArray.length;i++)	
	{
		if(Data=='')
		{
			Data=MenuArray[i][0]+"~UserData~"+MenuArray[i][1]+"~UserData~"+MenuArray[i][2]+"~UserData~"+MenuArray[i][3]+"~UserData~"+MenuArray[i][4]+"~UserData~"+MenuArray[i][5]+"~UserData~"+MenuArray[i][6]+"~UserData~"+MenuArray[i][7]+"~UserData~"+MenuArray[i][8]+"~UserData~"+MenuArray[i][9]+"~UserData~"+MenuArray[i][10]+"~UserData~"+MenuArray[i][11];
		}
		else
		{
			Data+="~UserArray~"+MenuArray[i][0]+"~UserData~"+MenuArray[i][1]+"~UserData~"+MenuArray[i][2]+"~UserData~"+MenuArray[i][3]+"~UserData~"+MenuArray[i][4]+"~UserData~"+MenuArray[i][5]+"~UserData~"+MenuArray[i][6]+"~UserData~"+MenuArray[i][7]+"~UserData~"+MenuArray[i][8]+"~UserData~"+MenuArray[i][9]+"~UserData~"+MenuArray[i][10]+"~UserData~"+MenuArray[i][11];
		}
	}
	//alert(Data);
	$('#hfAttachmentData').val(Data); 
}
</script>
<script type="text/javascript"  language="javascript">
function SaveMenuData()
{
   var Saveflag=true;
	
	Concate();
	
    if(Saveflag==true)
	{
		//alert($('#hfAttachmentData').val());
		//exit;
		$.post('<?php echo base_url(); ?>index.php/user/userrightssave', {cmbUser:$('#cmbUser option:selected').val(),hfAttachmentData:$('#hfAttachmentData').val()},function(responsedata,status) {
		    //alert(responsedata);	
		    //exit;
	   	    
                    var responsedatas = responsedata.trim();
	   	    if(responsedatas=='TRUE')
			{
				alert("User Data Saved");
				$("#cmbUser").val('');
				$('#hfRightData').val('');
				$('#hfAttachmentData').val('');
				$('#dvMenuDetail').text('');
				MenuArray.length=0;	
			  //ChangeUrl('user_rights_master.php?UserId='+<?php //echo $UserId; ?>);
			}
			else
			{
				alert("Error in saving details");
			}
		});
	}	
}
</script>