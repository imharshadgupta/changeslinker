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
	<select name="cmbDistrict" id="cmbDistrict" class="fild" tabindex="2" onchange="getCityByDistrictIdAndStateId()">
	<option value="">Select District</option>
	<select>
</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">City</div>
<div class="fldblks">
	<select name="cmbCity" id="cmbCity" class="fild" tabindex="3">
	<option value="">Select City</option>
	<select>
</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Location</div>
<div class="fldblks"><textarea name="txtLocationName" id="txtLocationName" class="fild" tabindex="4"><?php echo set_value('txtLocationName'); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Landmark</div>
<div class="fldblks"><textarea name="txtLandmark" id="txtLandmark" class="fild" tabindex="5"><?php echo set_value('txtLandmark'); ?></textarea></div>
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

<div class="submit"><input type="button" name="btnSubmit" class="btn" value="Submit" onclick="FormValidate(this);" />&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/dashboard/listing_location_master"><input type="button" name="btnBack" id="btnBack" class="btn" value="Back" /></a></div>

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
	if($("#cmbCity").val()=='')
    {	
        alert("Please select City");
        $("#cmbDistrict").focus();
        return false;
    }
	else if($("#txtLocationName").val()=='')
    {	
        alert("Please enter Location Name");
        $("#txtLocationName").focus();
        return false;
    }
    else
    {
		var data = $("#addForm").serialize();
		
		var url = "<?php echo base_url(); ?>/index.php/dashboard/add_location_master";

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
					var redirecturl = "<?php echo base_url(); ?>/index.php/dashboard/listing_location_master";
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