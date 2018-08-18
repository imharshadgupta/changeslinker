<!--==============================Form=================================-->

<form name="editForm" id="editForm" method="post" action="" enctype="multipart/form-data">
<input type="hidden" name="hfSuccessStoryId" id="hfSuccessStoryId" value="<?php echo set_value('hfSuccessStoryId',$SuccessStoryId); ?>"/>
<input type="hidden" name="hfActive" id="hfActive" value="<?php echo set_value('hfActive',$Active); ?>" />
<div class="inner_form">
<h2>Edit Details</h2>
<div class="mfrminner">
<div style="color: #0000FF; text-align:center; font-weight:bold;"><?php echo $this->session->flashdata('msg');?><br /><?php echo $message; ?><br /><?php echo validation_errors(); ?></div>
<fieldset><legend>General Details</legend>

<div class="Txtblks">Property</div>
<div class="fldblks">
	<select name="cmbProperty" id="cmbProperty" class="fild chzn-select" tabindex="1" onchange="getPropertyOwnerByPropertyId()">
	<option value="">Select Property</option>
	<?php
		$this->db->order_by('cPropertyName', 'asc');
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
				<option value="<?php echo $Property_Id; ?>" <?php echo set_select("cmbProperty","$Property_Id",($PropertyId=="$Property_Id" ? TRUE:'')); ?>><?php echo $Property_Name; ?></option>
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

<div class="Txtblks">Lessor (Party Owner)</div>
<div class="fldblks">
	<select name="cmbLessor" id="cmbLessor" class="fild" tabindex="3">
	<option value="">Select Lessor</option>
	</select>
</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Lessee</div>
<div class="fldblks">
	<select name="cmbLessee" id="cmbLessee" class="fild chzn-select" tabindex="3">
	<option value="">Select Lessee</option>
	<?php 
		$this->db->order_by('cClientName', 'asc');
		$this->db->where('bActive', 1);
		$this->db->where('bDelete', 0);
		$sql =  $this->db->get('client_master');  
		if($sql)
		{
			if(($sql->num_rows) > 0)
			{
				$rows = $sql->result_array();
				
				foreach($rows as $row): 
				
				$Lessee_Id = trim($row['iClientId']);
				$Lessee_Name = trim($row['cClientName']);
			?>
				<option value="<?php echo $Lessee_Id; ?>" <?php echo set_select("cmbLessee","$Lessee_Id",($LesseeId=="$Lessee_Id" ? TRUE:'')); ?>><?php echo $Lessee_Name; ?></option>
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

<div class="Txtblks">Content</div>
<div class="fldblks"><textarea name="txtContent" id="txtContent" class="fild"  tabindex="3"><?php echo set_value('txtContent',$Content); ?></textarea></div>
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

<!------------------------------------------------------------------------------------------------------------------------------------------------------------>

<div class="submit"><input type="button" name="btnSubmit" class="btn" value="Submit" onclick="FormValidate(this)" />&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/dashboard/listing_success_story"><input type="button" name="btnBack" id="btnBack" class="btn" value="Back" /></a></div>

<div class="clear"></div>

</div>
	<div class="clear"></div>
</div>
<script type="text/javascript" language="javascript"> 
$(".chzn-select").chosen(); 
$(".chzn-select-deselect").chosen({allow_single_deselect:true}); 
</script>
</form>

<script type="text/javascript" language="javascript">
$(document).ready(function(){
	if($("#cmbProperty").val()!='')
	{
		getPropertyOwnerByPropertyId();
	}
});
</script>

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
function getPropertyOwnerByPropertyId()
{
	$('#cmbLessor').children('option:not(:first)').remove();
		
	if($("#cmbProperty").val()=='')
	{	
		alert("Please Select PSR");
		$("#cmbProperty").focus();
		return false;
	}
	else
	{
		$.ajax({
			type: "POST",
			dataType: 'json',
			url: "<?php echo base_url();?>index.php/dashboard/getpropertyownerbyproperty",
			data: "cmbProperty="+$("#cmbProperty").val(),
			success: function(details){
				
				$('#cmbLessor').children('option:not(:first)').remove();
				
				$.each(details,function(lesserid,lessername) {	 
					//alert(lesserid+"=>"+lessername);
					var opt = $('<option />'); 									
					
					if(lesserid == "<?php echo $LessorId; ?>"){
						opt.val(lesserid);
						opt.text(lessername);
						$(opt).attr('selected', 'selected');
					}		
					else
					{
						opt.val(lesserid);
						opt.text(lessername);
					}
						
					$('#cmbLessor').append(opt);	
				});
			}
		});
	}
}	
</script>

<script type="text/javascript" language="javascript">
function FormValidate(btn)
{
    if($("#cmbProperty").val()=='')
    {	
        alert("Please select Property");
        $("#cmbProperty").focus();
        return false;
    }
    else
    {
		var data = $("#editForm").serialize();
		
		var url = "<?php echo base_url(); ?>index.php/dashboard/edit_success_story";
		
		$.post(url,data,function(responsedata,status){	
		
			btn.disabled = true;
			btn.value = 'Submitting...';
		
		    if(responsedata)
			{
				if(responsedata.status==1)
				{					
					btn.disabled = false;
					btn.value = 'Submit';
					alert(responsedata.msg);
					var redirecturl = "<?php echo base_url(); ?>index.php/dashboard/listing_success_story";
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