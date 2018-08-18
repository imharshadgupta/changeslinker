<!--==============================Form=================================-->

<form name="addForm" id="addForm" method="post" action="" enctype="multipart/form-data">
<div class="inner_form">
<h2>Add Details</h2>
<div class="mfrminner">
<div style="color: #0000FF; text-align:center; font-weight:bold;"><?php echo $this->session->flashdata('msg');?><br /><?php echo $message; ?><br /><?php echo validation_errors(); ?></div>
<fieldset><legend>General Details</legend>

<div class="Txtblks">Inspection Date</div>
<div class="fldblks"><input type="text" name="txtInspectionDate" id="txtInspectionDate" class="fild" style="width:302px;" value="<?php echo set_value('txtInspectionDate'); ?>" tabindex="1" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Party</div>
<div class="fldblks">
	<select name="cmbParty" id="cmbParty" class="fild" tabindex="2">
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
	<select name="cmbProperty" id="cmbProperty" class="fild" tabindex="3">
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

<div class="Txtblks">People at the time of Inspection</div>
<div class="fldblks"><textarea name="txtPeopleAtTheTimeOfInspection" id="txtPeopleAtTheTimeOfInspection" class="fild" tabindex="4"><?php echo set_value('txtPeopleAtTheTimeOfInspection'); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Inspection Summary</div>
<div class="fldblks"><textarea name="txtInspectionSummary" id="txtInspectionSummary" class="fild" tabindex="5"><?php echo set_value('txtInspectionSummary'); ?></textarea></div>
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

<div class="submit"><input type="button" name="btnSubmit" class="btn" value="Submit" onclick="FormValidate(this);" />&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/dashboard/listing_inspection_record"><input type="button" name="btnBack" id="btnBack" class="btn" value="Back" /></a></div>

<div class="clear"></div>
</div>
	<div class="clear"></div>
</div>
</form>

<script type="text/javascript">  
$(document).ready(function(){ 
	$("#txtInspectionDate").datepicker({ 
		dateFormat: 'dd/mm/yy',
		showOn: "button",
		changeMonth: true,
		changeYear: true,
		yearRange:"-100:+10",
		buttonImage: "<?php echo base_url(); ?>images/calendar.gif",
		buttonImageOnly: true 
	});	
	
	$('#txtParty').autocomplete({
		source:"<?php echo base_url();?>index.php/dashboard/suggestparties", 
		minLength:1,
	  /*select: function(event, ui) {
			var party_id = ui.item.value;
			getPropertyByPropertyOwnerId(party_id);
        }*/
	});
		
	$('#txtProperty').autocomplete({
		source:"<?php echo base_url();?>index.php/dashboard/suggestproperties", 
		minLength:1,
	  /*select: function(event, ui) {
			var party_id = ui.item.value;
			getPropertyByPropertyOwnerId(party_id);
        }*/
	});	
});
</script>

<script type="text/javascript" language="javascript">
function FormValidate(btn)
{
    if($("#txtInspectionDate").val()=='')
    {	
        alert("Please select Inspection Date");
        $("#txtInspectionDate").focus();
        return false;
    }
    else
    {
		var data = $("#addForm").serialize();
		
		var url = "<?php echo base_url(); ?>/index.php/dashboard/add_inspection_record";

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
					var redirecturl = "<?php echo base_url(); ?>/index.php/dashboard/listing_inspection_record";
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