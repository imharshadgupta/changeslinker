<!--==============================Form=================================-->

<form name="addForm" id="addForm" method="post" action="" enctype="multipart/form-data">
<div class="inner_form">
<h2>Add Details</h2>
<div class="mfrminner">
<div style="color: #0000FF; text-align:center; font-weight:bold;"><?php echo $this->session->flashdata('msg');?><br /><?php echo $message; ?><br /><?php echo validation_errors(); ?></div>
<fieldset><legend>General Details</legend>

<div class="Txtblks">Party Type</div>
<div class="fldblks">
	<select name="cmbPartyType" id="cmbPartyType" class="fild" tabindex="1">
	<option value="">Select Party Type</option>
	<?php 
		$this->db->where('bActive', 1);
		$this->db->where('bDelete', 0);
		$sql =  $this->db->get('party_type_master');  
		if($sql)
		{
			if(($sql->num_rows) > 0)
			{
				$rows = $sql->result_array();
				
				foreach($rows as $row): 
				
				$PartyTypeId = trim($row['iPartyTypeId']);
				$PartyTypeName = trim($row['cPartyTypeName']);
			?>
				<option value="<?php echo $PartyTypeId; ?>"><?php echo $PartyTypeName; ?></option>
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

<div class="Txtblks">Party Name</div>
<div class="fldblks"><input type="text" name="txtPartyName" id="txtPartyName" class="fild" value="<?php echo set_value('txtPartyName'); ?>" tabindex="2" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Address</div>
<div class="fldblks"><textarea name="txtAddress" id="txtAddress" class="fild"  tabindex="3"><?php echo set_value('txtAddress'); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">State</div>
<div class="fldblks">
	<select name="cmbState" id="cmbState" class="fild" tabindex="4" onchange="getDistrictByStateId()">
	<option value="">Select State</option>
	<?php 
		$this->db->where('bActive', 1);
		$this->db->where('bDelete', 0);
		$sql =  $this->db->get('state_master');  
		if($sql)
		{
			if(($sql->num_rows) > 0)
			{
				$rows = $sql->result_array();
				
				foreach($rows as $row): 
				
				$State_Id = trim($row['iStateId']);
				$State_Name = trim($row['cStateName']);
			?>
				<option value="<?php echo $State_Id; ?>"><?php echo $State_Name; ?></option>
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

<div class="Txtblks">District</div>
<div class="fldblks">
	<select name="cmbDistrict" id="cmbDistrict" class="fild" tabindex="5" onchange="getCityByDistrictIdAndStateId()">
	<option value="">Select District</option>
	<select>
</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">City</div>
<div class="fldblks">
	<select name="cmbCity" id="cmbCity" class="fild" tabindex="6">
	<option value="">Select City</option>
	<select>
</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Location</div>
<div class="fldblks"><textarea name="txtLocationName" id="txtLocationName" class="fild" tabindex="7"><?php echo set_value('txtLocationName'); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Landmark</div>
<div class="fldblks"><textarea name="txtLandmark" id="txtLandmark" class="fild" tabindex="8"><?php echo set_value('txtLandmark'); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Contact Person1 Name</div>
<div class="fldblks"><input type="text" name="txtContactPerson1Name" id="txtContactPerson1Name" class="fild" value="<?php echo set_value('txtContactPerson1Name'); ?>" tabindex="9" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Person1 Designation</div>
<div class="fldblks"><input type="text" name="txtContactPerson1Designation" id="txtContactPerson1Designation" class="fild" value="<?php echo set_value('txtContactPerson1Designation'); ?>" tabindex="10" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Person 1 Phone 1</div>
<div class="fldblks"><input type="text" name="txtContactPerson1PhoneNo1" id="txtContactPerson1PhoneNo1" class="fild" value="<?php echo set_value('txtContactPerson1PhoneNo1'); ?>" tabindex="11" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Person 1 Phone 2</div>
<div class="fldblks"><input type="text" name="txtContactPerson1PhoneNo2" id="txtContactPerson1PhoneNo2" class="fild" value="<?php echo set_value('txtContactPerson1PhoneNo2'); ?>" tabindex="12" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Person 1 Email</div>
<div class="fldblks"><input type="text" name="txtContactPerson1Email" id="txtContactPerson1Email" class="fild" value="<?php echo set_value('txtContactPerson1Email'); ?>" tabindex="13" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>


<div class="Txtblks">Contact Person2 Name</div>
<div class="fldblks"><input type="text" name="txtContactPerson2Name" id="txtContactPerson2Name" class="fild" value="<?php echo set_value('txtContactPerson2Name'); ?>" tabindex="14" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Person2 Designation</div>
<div class="fldblks"><input type="text" name="txtContactPerson2Designation" id="txtContactPerson2Designation" class="fild" value="<?php echo set_value('txtContactPerson2Designation'); ?>" tabindex="15" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Person 2 Phone 1</div>
<div class="fldblks"><input type="text" name="txtContactPerson2PhoneNo1" id="txtContactPerson2PhoneNo1" class="fild" value="<?php echo set_value('txtContactPerson2PhoneNo1'); ?>" tabindex="16" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Person 2 Phone 2</div>
<div class="fldblks"><input type="text" name="txtContactPerson2PhoneNo2" id="txtContactPerson2PhoneNo2" class="fild" value="<?php echo set_value('txtContactPerson2PhoneNo2'); ?>" tabindex="17" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Person 2 Email</div>
<div class="fldblks"><input type="text" name="txtContactPerson2Email" id="txtContactPerson2Email" class="fild" value="<?php echo set_value('txtContactPerson2Email'); ?>" tabindex="18" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>



<div class="Txtblks">Contact Person3 Name</div>
<div class="fldblks"><input type="text" name="txtContactPerson3Name" id="txtContactPerson3Name" class="fild" value="<?php echo set_value('txtContactPerson3Name'); ?>" tabindex="19" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Person3 Designation</div>
<div class="fldblks"><input type="text" name="txtContactPerson3Designation" id="txtContactPerson3Designation" class="fild" value="<?php echo set_value('txtContactPerson3Designation'); ?>" tabindex="20" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Person 3 Phone 1</div>
<div class="fldblks"><input type="text" name="txtContactPerson3PhoneNo1" id="txtContactPerson3PhoneNo1" class="fild" value="<?php echo set_value('txtContactPerson3PhoneNo1'); ?>" tabindex="21" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Person 3 Phone 2</div>
<div class="fldblks"><input type="text" name="txtContactPerson3PhoneNo2" id="txtContactPerson3PhoneNo2" class="fild" value="<?php echo set_value('txtContactPerson3PhoneNo2'); ?>" tabindex="22" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Person 3 Email</div>
<div class="fldblks"><input type="text" name="txtContactPerson3Email" id="txtContactPerson3Email" class="fild" value="<?php echo set_value('txtContactPerson3Email'); ?>" tabindex="23" /></div>
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

<div class="submit"><input type="button" name="btnSubmit" class="btn" value="Submit" onclick="FormValidate(this);" />&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/dashboard/listing_party_master"><input type="button" name="btnBack" id="btnBack" class="btn" value="Back" /></a></div>

<div class="clear"></div>
</div>
	<div class="clear"></div>
</div>
</form>

<script type="text/javascript" language="javascript">
function getDistrictByStateId()
{
	$('#cmbDistrict').children('option:not(:first)').remove();
	$('#cmbCity').children('option:not(:first)').remove();
		
	if($("#cmbState").val()=='')
	{	
		alert("Please Select State");
		$("#cmbState").focus();
		return false;
	}
	else
	{
		$.ajax({
			type: "POST",
			dataType: 'json',
			url: "<?php echo base_url();?>index.php/dashboard/getdistrictbystate",
			data: "cmbState="+$("#cmbState").val(),
			success: function(details){
				
				$('#cmbDistrict').children('option:not(:first)').remove();
				
				$.each(details,function(districtid,districtname) {	 
				
					var opt = $('<option />'); 									
					opt.val(districtid);
					opt.text(districtname);
					$('#cmbDistrict').append(opt); 		    			
				});
			}
		});
	}
}	
</script>

<script type="text/javascript" language="javascript">
function getCityByDistrictIdAndStateId()
{
	$('#cmbCity').children('option:not(:first)').remove();
	
	if($("#cmbDistrict").val()=='')
	{	
		alert("Please Select District");
		$("#cmbDistrict").focus();
		return false;
	}
	else
	{
		$.ajax({
			type: "POST",
			dataType: 'json',
			url: "<?php echo base_url();?>index.php/dashboard/getcitybystateanddistrict",
			data: "cmbState="+$("#cmbState").val()+"&cmbDistrict="+$("#cmbDistrict").val(),
			success: function(details){
				
				$('#cmbCity').children('option:not(:first)').remove();
				
				$.each(details,function(cityid,cityname) {	 
				
					var opt = $('<option />'); 									
					opt.val(cityid);
					opt.text(cityname);
					$('#cmbCity').append(opt); 		    			
				});
			}
		});
	}
}	
</script>

<script type="text/javascript" language="javascript">
function FormValidate(btn)
{
    if($("#cmbPartyType").val()=='')
    {	
        alert("Please select Party Type");
        $("#cmbPartyType").focus();
        return false;
    }
	else if($("#txtPartyName").val()=='')
    {	
        alert("Please enter Party Name");
        $("#txtPartyName").focus();
        return false;
    }
    else
    {
		var data = $("#addForm").serialize();
		
		var url = "<?php echo base_url(); ?>index.php/dashboard/add_party_master";

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
					var redirecturl = "<?php echo base_url(); ?>index.php/dashboard/listing_party_master";
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