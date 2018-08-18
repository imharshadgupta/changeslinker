<!--==============================Form=================================-->

<form name="editForm" id="editForm" method="post" action="" enctype="multipart/form-data">
<input type="hidden" name="hfUserId" id="hfUserId" value="<?php echo set_value('hfUserId',$UserId); ?>"/>
<input type="hidden" name="hfActive" id="hfActive" value="<?php echo set_value('hfActive',$Active); ?>" />
<div class="inner_form">
<h2>Edit Details</h2>
<div class="mfrminner">
<div style="color: #0000FF; text-align:center; font-weight:bold;"><?php echo $this->session->flashdata('msg');?><br /><?php echo $message; ?><br /><?php echo validation_errors(); ?></div>
<fieldset><legend>General Details</legend>

<div class="Txtblks">Name</div>
<div class="fldblks"><input type="text" name="txtName" id="txtName" class="fild" value="<?php echo set_value('txtName',$Name); ?>" tabindex="1" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Designation</div>
<div class="fldblks"><input type="text" name="txtDesignation" id="txtDesignation" class="fild" value="<?php echo set_value('txtDesignation',$Designation); ?>" tabindex="2" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Department</div>
<div class="fldblks">
	<select name="cmbDepartment" id="cmbDepartment" class="fild" tabindex="3">
	<option value="">Select Department</option>
	<?php  
		   $this->db->where('bActive','1');
		   $this->db->where('bDelete','0');
    $sql = $this->db->get('department_master');  
    if($sql)
    {
        if(($sql->num_rows) > 0)
        {
            $rows=$sql->result_array();
            
            foreach($rows as $row): 
            
                $Department_Id = trim($row['iDepartmentId']);
                $Department_Name = trim($row['cDepartmentName']);
            ?>
            <option value="<?php echo $Department_Id; ?>" <?php echo set_select("cmbDepartment","$Department_Id",($DepartmentId=="$Department_Id" ? TRUE:'')); ?>><?php echo $Department_Name; ?></option>
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
<div class="fldblks"><textarea name="txtAddress" id="txtAddress" class="fild" tabindex="4"><?php echo set_value('txtAddress',$Address); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Mobile No.</div>
<div class="fldblks"><input type="text" name="txtMobileNo" id="txtMobileNo" class="fild" value="<?php echo set_value('txtMobileNo',$MobileNo); ?>" tabindex="5" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Email</div>
<div class="fldblks"><input type="text" name="txtEmailAddress" id="txtEmailAddress" class="fild" value="<?php echo set_value('txtEmailAddress',$EmailAddress); ?>" tabindex="6" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Emergency Contact Name</div>
<div class="fldblks"><input type="text" name="txtEmergencyContactName" id="txtEmergencyContactName" class="fild" value="<?php echo set_value('txtEmergencyContactName',$EmergencyContactName); ?>" tabindex="7" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Emergency Contact Phone No.</div>
<div class="fldblks"><input type="text" name="txtEmergencyContactPhoneNo" id="txtEmergencyContactPhoneNo" class="fild" value="<?php echo set_value('txtEmergencyContactPhoneNo',$EmergencyContactPhoneNo); ?>" tabindex="8" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Emergency Contact Email</div>
<div class="fldblks"><input type="text" name="txtEmergencyContactEmailAddress" id="txtEmergencyContactEmailAddress" class="fild" value="<?php echo set_value('txtEmergencyContactEmailAddress',$EmergencyContactEmailAddress); ?>" tabindex="9" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">UserName</div>
<div class="fldblks"><input type="text" name="txtUserName" id="txtUserName" class="fild" value="<?php echo set_value('txtUserName',$UserName); ?>" tabindex="10" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Password</div>
<div class="fldblks"><input type="password" name="txtPassword" id="txtPassword" class="fild" value="<?php echo set_value('txtPassword',$Password); ?>" tabindex="11" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Picture</div>
<div class="fldblks"><input type="file" name="txtUserPic" id="txtUserPic" class="fild" value="<?php echo set_value('txtUserPic'); ?>" tabindex="12" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Active</div>
<div class="fldblks"><input type="checkbox" name="chkActive" id="chkActive" onclick="ChangeActive();" value="1" <?php echo set_checkbox('chkActive', '1', ($Active=='1' ? TRUE:'')); ?> /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

</fieldset>

<!----------------------------------------------------------------------------------->

<div class="submit"><input type="button" name="btnSubmit" class="btn" value="Submit" onclick="FormValidate(this)" />&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/dashboard/listing_user_master"><input type="button" name="btnBack" id="btnBack" class="btn" value="Back" /></a></div>

<div class="clear"></div>

</div>
	<div class="clear"></div>
</div>
</form>

<script type="text/javascript" language="javascript">
function ChangeActive()
{
	if(document.getElementById('chkActive').checked == true)
	{
		$("#hfActive").val(1);
	}
	else
	{
		$("#hfActive").val(0);
	}
}
</script>

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
		var data = $("#editForm").serialize();
		
		btn.disabled = true;
		btn.value = 'Submitting...';
		
		var url = "<?php echo base_url(); ?>/index.php/dashboard/edit_user_master";
		
		$.post(url,data,function(responsedata,status){	
			//alert(responsedata);
		    if(responsedata)
			{
				if(responsedata.status==1)
				{					
					btn.disabled = false;
					btn.value = 'Submit';
					alert(responsedata.msg);
					var redirecturl = "<?php echo base_url(); ?>/index.php/dashboard/listing_user_master";
					$(location).attr('href',redirecturl);	
				}	
				else
				{
					btn.disabled = false;
					btn.value = 'Submit';
					alert(responsedata.msg);
				} 
			}
		},'json'); 
    }
}
</script>