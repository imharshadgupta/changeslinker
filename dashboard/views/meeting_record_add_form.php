<!--====================================================Form===================================================================-->

<form name="addForm" id="addForm" method="post" action="" enctype="multipart/form-data">
<div class="inner_form">
<h2>Add Details</h2>
<div class="mfrminner">
<div style="color: #0000FF; text-align:center; font-weight:bold;"><?php echo $this->session->flashdata('msg');?><br /><?php echo $message; ?><br /><?php echo validation_errors(); ?></div>
<fieldset><legend>General Details</legend>

<div class="Txtblks">Party</div>
<div class="fldblks">
	<select name="cmbParty" id="cmbParty" class="fild" tabindex="1">
	<option value="">Select Party</option>
	<?php 
		$this->db->where('bActive', 1);
		$this->db->where('bDelete', 0);
		$sql =  $this->db->get('party_master');  
		if($sql)
		{
			if(($sql->num_rows) > 0)
			{
				$rows = $sql->result_array();
				
				foreach($rows as $row): 
				
				$Party_Id = trim($row['iPartyId']);
				$Party_Name = trim($row['cPartyName']);
			?>
				<option value="<?php echo $Party_Id; ?>"><?php echo $Party_Name; ?></option>
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

<div class="Txtblks">Property</div>
<div class="fldblks">
	<select name="cmbProperty" id="cmbProperty" class="fild" tabindex="2">
	<option value="">Select Property</option>
	<?php 
		$this->db->where('bActive', 1);
		$this->db->where('bDelete', 0);
		$sql =  $this->db->get('property_master');  
		if($sql)
		{
			if(($sql->num_rows) > 0)
			{
				$rows = $sql->result_array();
				
				foreach($rows as $row): 
				
				$Property_Id = trim($row['iPropertyId']);
				$Property_Name = trim($row['cPropertyName']);
			?>
				<option value="<?php echo $Property_Id; ?>"><?php echo $Property_Name; ?></option>
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

<div class="Txtblks">Meeting Date Time</div>
<div class="fldblks"><input type="text" name="txtMeetingDateTime" id="txtMeetingDateTime" class="fild" style="width:302px;" value="<?php echo set_value('txtMeetingDateTime'); ?>" readonly="readonly" tabindex="3" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Meeting Duration</div>
<div class="fldblks"><input type="text" name="txtMeetingDuration" id="txtMeetingDuration" class="fild" value="<?php echo set_value('txtMeetingDuration'); ?>" tabindex="4" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Meeting Summary</div>
<div class="fldblks"><textarea name="txtMeetingSummary" id="txtMeetingSummary" class="fild" tabindex="7"><?php echo set_value('txtMeetingSummary'); ?></textarea></div>
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

<div class="submit"><input type="button" name="btnSubmit" class="btn" value="Submit" onclick="FormValidate(this);" />&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/dashboard/listing_meeting_record"><input type="button" name="btnBack" id="btnBack" class="btn" value="Back" /></a></div>

<div class="clear"></div>
</div>
	<div class="clear"></div>
</div>
</form>

<script type="text/javascript" language="javascript">
$(document).ready(function(){
	$('#txtMeetingDateTime').datetimepicker({
		dateFormat: 'dd/mm/yy',
		controlType: 'select',
		oneLine: true,
		timeFormat: 'hh:mm tt',
		showOn: 'button',
		buttonImage: "<?php echo base_url(); ?>images/calendar.gif",
        buttonImageOnly: true
	});
});	
</script>	

<script type="text/javascript" language="javascript">
function FormValidate(btn)
{
    if($("#cmbParty").val()=='')
    {	
        alert("Please select Party");
        $("#cmbParty").focus();
        return false;
    }
    else
    {
		var data = $("#addForm").serialize();
		
		var url = "<?php echo base_url(); ?>index.php/dashboard/add_meeting_record";

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
					var redirecturl = "<?php echo base_url(); ?>index.php/dashboard/listing_meeting_record";
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