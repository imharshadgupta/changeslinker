<!--==============================Form=================================-->

<form name="frmChangePassword" id="frmChangePassword" method="post" action="" enctype="multipart/form-data">
<input type="hidden" id="hfUserId" name="hfUserId" value="<?php echo $UserId; ?>" />
<div class="inner_form">
<h2>Change Password</h2>
<div class="mfrminner">
<div style="color: #0000FF; text-align:center; font-weight:bold;"><?php echo $this->session->flashdata('msg');?><br /><?php echo $message; ?><br /><?php echo validation_errors(); ?></div>
<fieldset><legend>Details</legend>

<div class="Txtblks">UserName</div>
<div class="fldblks"><input type="text" name="txtUserName" id="txtUserName" class="fild" value="<?php echo $UserName; ?>" tabindex="1" readonly="readonly" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Old Password</div>
<div class="fldblks"><input type="password" name="txtOldPassword" id="txtOldPassword" class="fild" value="<?php echo set_value('txtOldPassword'); ?>" tabindex="2" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">New Password</div>
<div class="fldblks"><input type="password" name="txtNewPassword" id="txtNewPassword" class="fild" value="<?php echo set_value('txtNewPassword'); ?>" tabindex="3" /></div>
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

<div class="submit"><input type="button" name="btnSubmit" class="btn" value="Submit" onclick="SavePasswordData(this)" /></div>

<div class="clear"></div>
</div>
	<div class="clear"></div>
</div>

</form>

<script type="text/javascript">
function SavePasswordData(btn)
{
	if($("#txtOldPassword").val()=='')
	{	
		alert("Please enter Old Password");
		$("#txtOldPassword").focus();
		return false;
	}
	else if($("#txtNewPassword").val()=='')
	{	
		alert("Please enter New Password");
		$("#txtNewPassword").focus();
		return false;
	}
	else
	{
		var data = $("#frmChangePassword").serialize();
		
		btn.disabled = true;
		btn.value = 'Updating...';
		
		$.post("<?php echo base_url(); ?>index.php/dashboard/changepassword",data,function(responsedata,status){		    
			
		 //alert(responsedata);
		 //exit;		
		    if(responsedata=='true')
			{
				alert("Password Changed Successfullly !"); 
				btn.disabled = false;
				btn.value = 'Submit';
				$("#txtOldPassword").val('');
				$("#txtNewPassword").val('');
				return true;
			}
			else if(responsedata=='noresultfound')
			{
				alert("Please enter correct Old Password !"); 
				btn.disabled = false;
				btn.value = 'Submit';
			  //$("#txtOldPassword").val('');
			  //$("#txtNewPassword").val('');
				return true;
			}
			else
			{
				alert("Error in updating details !"); 
				btn.disabled = false;
				btn.value = 'Submit';
				return false;
			}
		});
	}
}
</script>