<!--==============================Form=================================-->

<form name="addForm" id="addForm" method="post" action="" enctype="multipart/form-data">
<div class="inner_form">
<h2>Add Details</h2>
<div class="mfrminner">
<div style="color: #0000FF; text-align:center; font-weight:bold;"><?php echo $this->session->flashdata('msg');?><br /><?php echo $message; ?><br /><?php echo validation_errors(); ?></div>
<fieldset><legend>General Details</legend>

<div class="Txtblks">Name</div>
<div class="fldblks"><input type="text" name="txtName" id="txtName" class="fild" value="<?php echo set_value('txtName'); ?>" tabindex="1" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Designation</div>
<div class="fldblks"><input type="text" name="txtDesignation" id="txtDesignation" class="fild" value="<?php echo set_value('txtDesignation'); ?>" tabindex="2" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Department</div>
<div class="fldblks">
	<select name="cmbDepartment" id="cmbDepartment" class="fild" tabindex="3">
	<option value="">Select Department</option>
	<?php 
		$this->db->where('bActive', 1);
		$this->db->where('bDelete', 0);
		$sql =  $this->db->get('department_master');  
		if($sql)
		{
			if(($sql->num_rows) > 0)
			{
				$rows = $sql->result_array();
				
				foreach($rows as $row): 
				
				$Department_Id = trim($row['iDepartmentId']);
				$Department_Name = trim($row['cDepartmentName']);
			?>
				<option value="<?php echo $Department_Id; ?>"><?php echo $Department_Name; ?></option>
			<?php
				endforeach;	
			}
		}
	?>
	<select>
</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Address</div>
<div class="fldblks"><textarea name="txtAddress" id="txtAddress" class="fild" tabindex="4"><?php echo set_value('txtAddress'); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Mobile No.</div>
<div class="fldblks"><input type="text" name="txtMobileNo" id="txtMobileNo" class="fild" value="<?php echo set_value('txtMobileNo'); ?>" tabindex="5" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Email</div>
<div class="fldblks"><input type="text" name="txtEmailAddress" id="txtEmailAddress" class="fild" value="<?php echo set_value('txtEmailAddress'); ?>" tabindex="6" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Emergency Contact Name</div>
<div class="fldblks"><input type="text" name="txtEmergencyContactName" id="txtEmergencyContactName" class="fild" value="<?php echo set_value('txtEmergencyContactName'); ?>" tabindex="7" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Emergency Contact Phone No.</div>
<div class="fldblks"><input type="text" name="txtEmergencyContactPhoneNo" id="txtEmergencyContactPhoneNo" class="fild" value="<?php echo set_value('txtEmergencyContactPhoneNo'); ?>" tabindex="8" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Emergency Contact Email</div>
<div class="fldblks"><input type="text" name="txtEmergencyContactEmailAddress" id="txtEmergencyContactEmailAddress" class="fild" value="<?php echo set_value('txtEmergencyContactEmailAddress'); ?>" tabindex="9" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">UserName</div>
<div class="fldblks"><input type="text" name="txtUserName" id="txtUserName" class="fild" value="<?php echo set_value('txtUserName'); ?>" tabindex="10" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Password</div>
<div class="fldblks"><input type="password" name="txtPassword" id="txtPassword" class="fild" value="<?php echo set_value('txtPassword'); ?>" tabindex="11" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Picture</div>
<div class="fldblks"><input type="file" name="txtUserPic" id="txtUserPic" class="fild" value="<?php echo set_value('txtUserPic'); ?>" tabindex="12" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Active</div>
<div class="fldblks"><input type="checkbox" name="chkActive" id="chkActive" value="1" <?php echo set_checkbox('chkActive', '1', TRUE); ?> /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

</fieldset>

<!------------------------------------------------------------------------------------------------------------------------------------------------------------>

<div class="submit"><input type="button" name="btnSubmit" class="btn" value="Submit" onclick="FormValidate(this);" />&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/dashboard/listing_user_master"><input type="button" name="btnBack" id="btnBack" class="btn" value="Back" /></a></div>

<div class="clear"></div>
</div>
	<div class="clear"></div>
</div>
</form>

<script type="text/javascript" language="javascript">
function FormValidate(btn)
{
    if($("#txtName").val()=='')
    {	
        alert("Please enter Name");
        $("#txtName").focus();
        return false;
    }
    else
    {
		var data = $("#addForm").serialize();
		
		var url = "<?php echo base_url(); ?>index.php/dashboard/add_user_master";

		btn.disabled = true;
		btn.value = 'Submitting...';
	
		$.post(url,data,function(data){	
			
		    if(data)
			{
				if(data.status == 1)
				{					
					btn.disabled = false;
					btn.value = 'Submit';
					alert(data.msg);
					var redirecturl = "<?php echo base_url(); ?>index.php/dashboard/listing_user_master";
					$(location).attr('href',redirecturl);	
				}	
				else
				{
					btn.disabled = false;
					btn.value = 'Submit';
					alert(data.msg);
				} 
			}
		},'json');
    }
}
</script>