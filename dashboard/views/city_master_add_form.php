<!--==============================Form=================================-->

<form name="addForm" id="addForm" method="post" action="" enctype="multipart/form-data">
<div class="inner_form">
<h2>Add Details</h2>
<div class="mfrminner">
<div style="color: #0000FF; text-align:center; font-weight:bold;"><?php echo $this->session->flashdata('msg');?><br /><?php echo $message; ?><br /><?php echo validation_errors(); ?></div>
<fieldset><legend>General Details</legend>

<div class="Txtblks">State</div>
<div class="fldblks">
	<select name="cmbState" id="cmbState" class="fild" tabindex="1" onchange="getDistrictByStateId()">
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
	<select name="cmbDistrict" id="cmbDistrict" class="fild" tabindex="2">
	<option value="">Select District</option>
	<select>
</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">City Name</div>
<div class="fldblks"><input type="text" name="txtCityName" id="txtCityName" class="fild" value="<?php echo set_value('txtCityName'); ?>" tabindex="3" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">PinCode</div>
<div class="fldblks"><input type="text" name="txtPinCode" id="txtPinCode" class="fild" value="<?php echo set_value('txtPinCode'); ?>" tabindex="4" /></div>
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

<div class="submit"><input type="button" name="btnSubmit" class="btn" value="Submit" onclick="FormValidate(this);" />&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/dashboard/listing_city_master"><input type="button" name="btnBack" id="btnBack" class="btn" value="Back" /></a></div>

<div class="clear"></div>
</div>
	<div class="clear"></div>
</div>
</form>

<script type="text/javascript" language="javascript">
function getDistrictByStateId()
{
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
function FormValidate(btn)
{
    if($("#cmbState").val()=='')
    {	
        alert("Please select State");
        $("#cmbState").focus();
        return false;
    }
	if($("#cmbDistrict").val()=='')
    {	
        alert("Please select District");
        $("#cmbDistrict").focus();
        return false;
    }
	else if($("#txtCityName").val()=='')
    {	
        alert("Please enter City Name");
        $("#txtCityName").focus();
        return false;
    }
    else
    {
		var data = $("#addForm").serialize();
		
		var url = "<?php echo base_url(); ?>index.php/dashboard/add_city_master";

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
					var redirecturl = "<?php echo base_url(); ?>index.php/dashboard/listing_city_master";
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