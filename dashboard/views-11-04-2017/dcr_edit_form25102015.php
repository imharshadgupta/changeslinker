
<!--==========================================================Form==========================================================================================-->

<div style="color: #0000FF; text-align:center; font-weight:bold;"><?php echo $this->session->flashdata('msg');?><br /><?php echo $message; ?><br /><?php echo validation_errors(); ?></div>
<form name="editForm" id="editForm" method="post" action="" enctype="multipart/form-data">
<input type="hidden" name="hfDCRId" id="hfDCRId" value="<?php echo set_value('hfDCRId',$DCRId); ?>" />
<div class="inner_form">

<h2>Edit DCR</h2>
<div class="mfrminner">

<fieldset><legend>DCR Summary</legend>

<div class="Txtblks">Date</div>
<div class="fldblks"><input type="text" name="txtDCRDate" id="txtDCRDate" class="fild" style="width:300px;" readonly="" value="<?php echo set_value('txtDCRDate',$DCRDate); ?>" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Remarks</div>
<div class="fldblks"><textarea name="txtDCRRemarks" id="txtDCRRemarks" class="fild"><?php echo set_value('txtDCRRemarks',$DCRRemarks); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

</fieldset>

<!------------------------------------------------------------------------------------------------------------------------------------------------------------>

<fieldset>
	<legend>DCR Details</legend>
   
	<div style="height:33px; border:0px solid green;">
		<div style="width:3%; height:5%; text-align:center; float:left; border:0px solid red; text-decoration:underline;"><label><strong>SNo.</strong></label></div>
		<div style="width:1%; height:5%; float:left; border:0px solid red;">&nbsp;</div>
		<div style="width:12%; height:5%; text-align:left; float:left; border:0px solid red; text-decoration:underline;"><label><strong>Task</strong></label></div>
		<div style="width:1%; height:5%; float:left; border:0px solid red;">&nbsp;</div>
		<div style="width:12%; height:5%; text-align:left; float:left; border:0px solid red; text-decoration:underline;"><label><strong>Client Req</strong></label></div>
		<div style="width:2%; height:5%; float:left; border:0px solid red;">&nbsp;</div>
		<div style="width:13%; height:5%; text-align:left; float:left; border:0px solid red; text-decoration:underline;" ><label><strong>Reqirement</strong></label></div>
		<div style="width:1%; height:5%; float:left; border:0px solid red;">&nbsp;</div>
		<div style="width:12%; height:5%; text-align:left; float:left; border:0px solid red; text-decoration:underline;"><label><strong>Client Prop</strong></label></div>
		<div style="width:2%; height:5%; float:left; border:0px solid red;">&nbsp;</div>
		<div style="width:13%; height:5%; text-align:left; float:left; border:0px solid red; text-decoration:underline;"><label><strong>Property</strong></label></div>
		<div style="width:1%; height:5%; float:left; border:0px solid red;">&nbsp;</div>
		<div style="width:13%; height:5%; text-align:left; float:left; border:0px solid red; text-decoration:underline;"><label><strong>Current Status</strong></label></div>
		<div style="width:1%; height:5%; float:left; border:0px solid red;">&nbsp;</div>
		<div style="width:12%; height:5%; text-align:left; float:left; border:0px solid red; text-decoration:underline;"><label><strong>Summary</strong></label></div>
		<div class="clear"></div>
	</div>
	
	<?php 
	$i=1;
	foreach($DCRDetailRows as $dcrdetrow)
	{
		$DCRDetailId = trim($dcrdetrow['iDCRDetailId']);
		$DCRId = trim($dcrdetrow['iDCRId']);
		$TaskId = trim($dcrdetrow['iTaskId']);
		$ClientReqId = trim($dcrdetrow['iClientReqId']);
		$RequirementId = trim($dcrdetrow['iRequirementId']);
		$ClientPropId = trim($dcrdetrow['iClientPropId']);
		$PropertyId = trim($dcrdetrow['iPropertyId']);
		$CurrentStatusId = trim($dcrdetrow['iCurrentStatusId']);
		$DCRSummary = trim($dcrdetrow['cDCRSummary']);
	?>		
		<div class='TBGroup'>
			<div class="row">
				<div style="width:3%; height:100%; text-align:center; float:left; border:0px solid red;"><?php echo $i; ?>.</div>
				<div style="width:1%; height:100%; float:left; border:0px solid red;">&nbsp;</div>
				<div style="width:12%; height:100%; float:left; border:0px solid blue;">
					<select name="cmbTask[]" id="cmbExistTask<?php echo $i; ?>" class="selected_task_existing chzn-select fild" tabindex="1">
					<option value="">Select Task</option>
					<?php 
					$this->db->where('bActive', 1);
					$this->db->where('bDelete', 0);
					$sql =  $this->db->get('task_master');  
					if($sql)
					{
						if(($sql->num_rows) > 0)
						{
							$rows = $sql->result_array();
							
							foreach($rows as $row): 
							
							$Task_Id = trim($row['iTaskId']);
							$Task_Name = trim($row['cTaskName']);
						?>
							<option value="<?php echo $Task_Id; ?>" <?php echo set_select("cmbTask","$Task_Id",($TaskId=="$Task_Id" ? TRUE:'')); ?>><?php echo $Task_Name; ?></option>
						<?php
							endforeach;	
						}
					}
					?>
					</select>
				</div>
				
				<div style="width:1%; height:100%; float:left; border:0px solid red;">&nbsp;</div>
				<div style="width:13%; height:100%; float:left; border:0px solid blue;">
					<select name="cmbClientReq[]" id="cmbExistClientReq<?php echo $i; ?>" class="selected_client_req_existing chzn-select fild" onchange="getReqByClientExist('<?php echo $i; ?>');" tabindex="2">
					<option value="">Select Client</option>
					<?php 
						$sql = $this->db->query("SELECT requirement_master.iClientId,client_master.cClientName FROM requirement_master LEFT JOIN client_master ON requirement_master.iClientId=client_master.iClientId WHERE requirement_master.iClientId<>0 AND requirement_master.bActive=1 AND requirement_master.bDelete=0 GROUP BY requirement_master.iClientId ORDER BY client_master.cClientName");
						
						if($sql)
						{
							if(($sql->num_rows) > 0)
							{
								$rows = $sql->result_array();
								
								foreach($rows as $row): 
								
								$Client_Id = trim($row['iClientId']);
								$Client_Name = trim($row['cClientName']);
							?>
								<option value="<?php echo $Client_Id; ?>" <?php echo set_select("cmbClient","$Client_Id",($ClientReqId=="$Client_Id" ? TRUE:'')); ?>><?php echo $Client_Name; ?></option>
							<?php
								endforeach;	
							}
						}
					?>
					</select>	
				</div>
				
				<div style="width:1%; height:100%; float:left; border:0px solid red;">&nbsp;</div>
				<div style="width:13%; height:100%; float:left; border:0px solid blue;">
					<select name="cmbRequirement[]" id="cmbExistRequirement<?php echo $i; ?>" class="selected_requirement_existing chzn-select fild" tabindex="3">
					<option value="">Select Requirement</option>
					</select>
				</div>

				<div style="width:1%; height:100%; float:left; border:0px solid red;">&nbsp;</div>
				<div style="width:13%; height:100%; float:left; border:0px solid blue;">
					<select name="cmbClientProp[]" id="cmbExistClientProp<?php echo $i; ?>" class="selected_client_prop_existing chzn-select fild" onchange="getPropByClientExist('<?php echo $i; ?>');" tabindex="4">
					<option value="">Select Client</option>
					<?php 
						$sql = $this->db->query("SELECT property_master.iClientId,client_master.cClientName FROM property_master LEFT JOIN client_master ON property_master.iClientId=client_master.iClientId WHERE property_master.iClientId<>0 AND property_master.bActive=1 AND property_master.bDelete=0 GROUP BY property_master.iClientId ORDER BY client_master.cClientName");  
						
						if($sql)
						{
							if(($sql->num_rows) > 0)
							{
								$rows = $sql->result_array();
								
								foreach($rows as $row): 
								
								$Client_Id = trim($row['iClientId']);
								$Client_Name = trim($row['cClientName']);
							?>
								<option value="<?php echo $Client_Id; ?>" <?php echo set_select("cmbClient","$Client_Id",($ClientPropId=="$Client_Id" ? TRUE:'')); ?>><?php echo $Client_Name; ?></option>
							<?php
								endforeach;	
							}
						}
					?>
					</select>	
				</div>
				
				<div style="width:1%; height:100%; float:left; border:0px solid red;">&nbsp;</div>
				<div style="width:13%; height:100%; float:left; border:0px solid blue;">
					<select name="cmbProperty[]" id="cmbExistProperty<?php echo $i; ?>" class="selected_property_existing chzn-select fild" tabindex="5">
					<option value="">Select Property</option>
					</select> 
				</div>
				
				<div style="width:1%; height:100%; float:left; border:0px solid red;">&nbsp;</div>
				<div style="width:13%; height:100%; float:left; border:0px solid blue;">
				<select name="cmbCurrentStatus[]" id="cmbExistCurrentStatus<?php echo $i; ?>" class="selected_current_status chzn-select fild" tabindex="6">
				<option value="">Select Status</option>
				<?php 
				$this->db->order_by("cCurrentStatusName", "asc");
				$this->db->where('bActive', 1);
				$this->db->where('bDelete', 0);
				$sql =  $this->db->get('current_status_master');  
				if($sql)
				{
					if(($sql->num_rows) > 0)
					{
						$rows = $sql->result_array();
						
						foreach($rows as $row): 
						
						$CurrentStatus_Id = trim($row['iCurrentStatusId']);
						$CurrentStatus_Name = trim($row['cCurrentStatusName']);
					?>
						<option value="<?php echo $CurrentStatus_Id; ?>" <?php echo set_select("cmbCurrentStatus","$CurrentStatus_Id",($CurrentStatusId=="$CurrentStatus_Id" ? TRUE:'')); ?>><?php echo $CurrentStatus_Name; ?></option>
					<?php
						endforeach;	
					}
				}
				?>
				</select>
				</div>
				
				<div style="width:1%; height:100%; float:left; border:0px solid red;">&nbsp;</div>
				<div style="width:13%; height:100%; float:left; border:0px solid blue;">
					<textarea name="txtDCRSummary[]" id="txtExistDCRSummary<?php echo $i; ?>" class="fild" col="5" rows="1" tabindex="7"><?php echo set_value('txtExistDCRSummary'.$i,$DCRSummary); ?></textarea>
				</div>
				<div class="clear"></div>
				
				<?php /* ?><div style="width:2%; height:100%; float:left; border:0px solid red;" align="center"><img src="<?php //echo base_url(); ?>images/remove.png" id='delButton' style="cursor:pointer" onclick="DeleteExistingDetail("<?php echo $CompanyId; ?>","<?php echo $BranchId; ?>","<?php echo $GoDownId; ?>","<?php echo $PurchaseDetailId; ?>")" /></div><?php */ ?>
		
				<div class="Txtblks"><hr /></div>
				<div class="fldblks"><hr /></div>
				<div class="Txtblks"><hr /></div>
				<div class="fldblks"><hr /></div>
				<div class="clear"></div>  
			</div>
		</div>
		
		<script type="text/javascript">
		$(document).ready(function(){
			getReqByClient("<?php echo $i; ?>");
			getPropByClient("<?php echo $i; ?>");
		});
		</script>
		
	<?php 
		$i++;
	} 
	?>	
	
	<div class="Txtblks">&nbsp;</div>
	<div class="fldblks">&nbsp;</div>
	<div class="Txtblks">&nbsp;</div>
	<div class="fldblks">&nbsp;</div>
	<div class="clear"></div>

</fieldset>

<!------------------------------------------------------------------------------------------------------------------------------------------------------------>

<fieldset>
	<legend>Add New</legend>
    
    <div class="Txtblks">&nbsp;</div>
    <div class="fldblks">&nbsp;</div>
    <div class="Txtblks">&nbsp;</div>
    <div class="fldblks"><input type='button' value='Add New' id='addButton'>&nbsp;<input type='button' value='Cancel' id='removeButton'></div>
    <div class="clear"></div>
	
	<div class="Txtblks">&nbsp;</div>
    <div class="fldblks">&nbsp;</div>
    <div class="Txtblks">&nbsp;</div>
    <div class="fldblks">&nbsp;</div>
    <div class="clear"></div>
    
	<div class="Txtblks">&nbsp;</div>
    <div class="fldblks">&nbsp;</div>
    <div class="Txtblks">&nbsp;</div>
    <div class="fldblks">&nbsp;</div>
    <div class="clear"></div>
    
	<div style="height:33px; border:0px solid green;">
		<div style="width:3%; height:5%; text-align:center; float:left; border:0px solid red; text-decoration:underline;"><label><strong>SNo.</strong></label></div>
		<div style="width:1%; height:5%; float:left; border:0px solid red;">&nbsp;</div>
		<div style="width:12%; height:5%; text-align:left; float:left; border:0px solid red; text-decoration:underline;"><label><strong>Task</strong></label></div>
		<div style="width:1%; height:5%; float:left; border:0px solid red;">&nbsp;</div>
		<div style="width:12%; height:5%; text-align:left; float:left; border:0px solid red; text-decoration:underline;"><label><strong>Client Req</strong></label></div>
		<div style="width:2%; height:5%; float:left; border:0px solid red;">&nbsp;</div>
		<div style="width:13%; height:5%; text-align:left; float:left; border:0px solid red; text-decoration:underline;" ><label><strong>Reqirement</strong></label></div>
		<div style="width:1%; height:5%; float:left; border:0px solid red;">&nbsp;</div>
		<div style="width:12%; height:5%; text-align:left; float:left; border:0px solid red; text-decoration:underline;"><label><strong>Client Prop</strong></label></div>
		<div style="width:2%; height:5%; float:left; border:0px solid red;">&nbsp;</div>
		<div style="width:13%; height:5%; text-align:left; float:left; border:0px solid red; text-decoration:underline;"><label><strong>Property</strong></label></div>
		<div style="width:1%; height:5%; float:left; border:0px solid red;">&nbsp;</div>
		<div style="width:13%; height:5%; text-align:left; float:left; border:0px solid red; text-decoration:underline;"><label><strong>Current Status</strong></label></div>
		<div style="width:1%; height:5%; float:left; border:0px solid red;">&nbsp;</div>
		<div style="width:12%; height:5%; text-align:left; float:left; border:0px solid red; text-decoration:underline;"><label><strong>Summary</strong></label></div>
		<div class="clear"></div>
	</div>

	<div id='TextBoxesGroup' class='TBGroup'>
		<div id="TextBoxDiv1" class="row" style="height:35px; border:0px solid green;">
			<div style="width:3%; height:100%; text-align:center; float:left; border:0px solid red;">1.</div>
			<div style="width:1%; height:100%; float:left; border:0px solid red;">&nbsp;</div>
			<div style="width:12%; height:100%; float:left; border:0px solid blue;">
				<select name="cmbTask[]" id="cmbTask1" class="selected_task chzn-select fild" tabindex="1">
				<option value="">Select Task</option>
				<?php 
				$this->db->where('bActive', 1);
				$this->db->where('bDelete', 0);
				$sql =  $this->db->get('task_master');  
				if($sql)
				{
					if(($sql->num_rows) > 0)
					{
						$rows = $sql->result_array();
						
						foreach($rows as $row): 
						
						$Task_Id = trim($row['iTaskId']);
						$Task_Name = trim($row['cTaskName']);
					?>
						<option value="<?php echo $Task_Id; ?>"><?php echo $Task_Name; ?></option>
					<?php
						endforeach;	
					}
				}
				?>
				</select>
			</div>
			
			<div style="width:1%; height:100%; float:left; border:0px solid red;">&nbsp;</div>
			<div style="width:13%; height:100%; float:left; border:0px solid blue;">
				<select name="cmbClientReq[]" id="cmbClientReq1" class="selected_client_req chzn-select fild" onchange="getRequirementByClient(this);" tabindex="2">
				<option value="">Select Client</option>
				<?php 
					$sql = $this->db->query("SELECT requirement_master.iClientId,client_master.cClientName FROM requirement_master LEFT JOIN client_master ON requirement_master.iClientId=client_master.iClientId WHERE requirement_master.iClientId<>0 AND requirement_master.bActive=1 AND requirement_master.bDelete=0 GROUP BY requirement_master.iClientId ORDER BY client_master.cClientName");
					
					if($sql)
					{
						if(($sql->num_rows) > 0)
						{
							$rows = $sql->result_array();
							
							foreach($rows as $row): 
							
							$Client_Id = trim($row['iClientId']);
							$Client_Name = trim($row['cClientName']);
						?>
							<option value="<?php echo $Client_Id; ?>"><?php echo $Client_Name; ?></option>
						<?php
							endforeach;	
						}
					}
				?>
				</select>	
			</div>
			
			<div style="width:1%; height:100%; float:left; border:0px solid red;">&nbsp;</div>
			<div style="width:13%; height:100%; float:left; border:0px solid blue;">
				<select name="cmbRequirement[]" id="cmbRequirement1" class="selected_requirement chzn-select fild" tabindex="3">
				<option value="">Select Requirement</option>
				</select>
			</div>
			
			<div style="width:1%; height:100%; float:left; border:0px solid red;">&nbsp;</div>
			<div style="width:13%; height:100%; float:left; border:0px solid blue;">
				<select name="cmbClientProp[]" id="cmbClientProp1" class="selected_client_prop chzn-select fild" onchange="getPropertyByClient(this);" tabindex="4">
				<option value="">Select Client</option>
				<?php 
					$sql = $this->db->query("SELECT property_master.iClientId,client_master.cClientName FROM property_master LEFT JOIN client_master ON property_master.iClientId=client_master.iClientId WHERE property_master.iClientId<>0 AND property_master.bActive=1 AND property_master.bDelete=0 GROUP BY property_master.iClientId ORDER BY client_master.cClientName");
					
					if($sql)
					{
						if(($sql->num_rows) > 0)
						{
							$rows = $sql->result_array();
							
							foreach($rows as $row): 
							
							$Client_Id = trim($row['iClientId']);
							$Client_Name = trim($row['cClientName']);
						?>
							<option value="<?php echo $Client_Id; ?>"><?php echo $Client_Name; ?></option>
						<?php
							endforeach;	
						}
					}
				?>
				</select>	
			</div>
			
			<div style="width:1%; height:100%; float:left; border:0px solid red;">&nbsp;</div>
			<div style="width:13%; height:100%; float:left; border:0px solid blue;">
				<select name="cmbProperty[]" id="cmbProperty1" class="selected_property chzn-select fild" tabindex="5">
				<option value="">Select Property</option>
				</select>
			</div>
			
			<div style="width:1%; height:100%; float:left; border:0px solid red;">&nbsp;</div>
			<div style="width:13%; height:100%; float:left; border:0px solid blue;">
			<select name="cmbCurrentStatus[]" id="cmbCurrentStatus1" class="selected_current_status chzn-select fild" tabindex="6">
			<option value="">Select Status</option>
			<?php 
				$this->db->order_by("cCurrentStatusName", "asc");
				$this->db->where('bActive', 1);
				$this->db->where('bDelete', 0);
				$sql =  $this->db->get('current_status_master');  
				if($sql)
				{
					if(($sql->num_rows) > 0)
					{
						$rows = $sql->result_array();
						
						foreach($rows as $row): 
						
						$CurrentStatus_Id = trim($row['iCurrentStatusId']);
						$CurrentStatus_Name = trim($row['cCurrentStatusName']);
					?>
						<option value="<?php echo $CurrentStatus_Id; ?>"><?php echo $CurrentStatus_Name; ?></option>
					<?php
						endforeach;	
					}
				}
			?>
			</select>
			</div>
			
			<div style="width:1%; height:100%; float:left; border:0px solid red;">&nbsp;</div>
			<div style="width:13%; height:100%; float:left; border:0px solid blue;"><textarea name="txtDCRSummary[]" id="txtDCRSummary1" class="fild" col="5" rows="1" tabindex="7" onblur="add_row();"><?php echo set_value('txtDCRSummary1'); ?></textarea></div>
			<div class="clear"></div>
			
			<div class="Txtblks"><hr /></div>
			<div class="fldblks"><hr /></div>
			<div class="Txtblks"><hr /></div>
			<div class="fldblks"><hr /></div>
			<div class="clear"></div>
		</div>
	</div>
	
	<div class="Txtblks">&nbsp;</div>
    <div class="fldblks">&nbsp;</div>
    <div class="Txtblks">&nbsp;</div>
    <div class="fldblks">&nbsp;</div>
    <div class="clear"></div>
	
</fieldset>

<div class="submit"><input type="button" name="btnSubmit" class="btn" value="Submit" onclick="FormValidate(this);" />&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/dashboard/listing_dcr"><input type="button" name="btnBack" id="btnBack" class="btn" value="Back" /></a></div>

<div class="clear"></div>

</div>

<div class="clear"></div>

</div>

<script type="text/javascript">
$(".chzn-select").chosen(); 
$(".chzn-select-deselect").chosen({allow_single_deselect:true}); 
//$(".selected_product").trigger("liszt:updated");
</script>

</form>

<script type="text/javascript">
/*
function DeleteExistingDetail(CompanyId,BranchId,GoDownId,PurchaseDetailId)
{
	var confdel = confirm("Are you sure to delete this detail...?")
	
	if(confdel)
	{ 
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>index.php/dashboard/delete_existing_purchase_detail",
			data: "CompanyId="+CompanyId+"&BranchId="+BranchId+"&GoDownId="+GoDownId+"&PurchaseDetailId="+PurchaseDetailId,
			success: function(data){
				
				if(data=='TRUE')
				{
					alert("Detail deleted successfully.");
					var url = "<?php echo base_url(); ?>index.php/dashboard/edit_form_purchase/"+PurchaseDetailId;    
					$(location).attr('href',url);
				}
				else
				{
					alert("Error in deleting doc.");
					return false;
				}
			}
		});
	}
}*/
</script>

<script type="text/javascript" language="javascript">
$(document).ready(function(){

	$("#addButton").click(function() {
	
       var  newTextBoxDiv = $(document.createElement('div')).attr({"id":"TextBoxDiv"+counter, "class":"row", "height":"100px", "border":"1px solid green"});
	   
	   var  maincontent1="<div style='width:3%; height:100%; text-align:center; float:left; border:0px solid red;'>"+counter+".</div>";
		    maincontent1+="<div style='width:1%; height:100%; float:left; border:0px solid red;'>&nbsp;</div>";
	        maincontent1+="<div style='width:12%; height:100%; float:left; border:0px solid blue;'>";
		    maincontent1+="<select name='cmbTask[]' id='cmbTask"+counter+"' data-placeholder='Select Task...' class='selected_task chzn-select fild'>";
			maincontent1+="<option value=''>Select Task</option>";	
			<?php 
			$this->db->where('bActive', 1);
			$this->db->where('bDelete', 0);
			$sql =  $this->db->get('task_master');  
			if($sql)
			{
				if(($sql->num_rows) > 0)
				{
					$rows = $sql->result_array();
					
					foreach($rows as $row): 
					
					$Task_Id = trim($row['iTaskId']);
					$Task_Name = trim($row['cTaskName']);
				?>
					maincontent1+="<option value='<?php echo $Task_Id; ?>'><?php echo $Task_Name; ?></option>";
				<?php
					endforeach;	
				}
			}
			?>
			maincontent1+="</select></div>";
		
			maincontent1+="<div style='width:1%; height:100%; float:left; border:0px solid red;'>&nbsp;</div>";
			maincontent1+="<div style='width:13%; height:100%; float:left; border:0px solid blue;'>";
			maincontent1+="<select name='cmbClientReq[]' id='cmbClientReq"+counter+"' data-placeholder='Select Client...' class='selected_client_req chzn-select fild' onchange='getRequirementByClient(this);'>";
			maincontent1+="<option value=''>Select Client</option>";	
			<?php 
			$sql = $this->db->query("SELECT requirement_master.iClientId,client_master.cClientName FROM requirement_master LEFT JOIN client_master ON requirement_master.iClientId=client_master.iClientId WHERE requirement_master.iClientId<>0 AND requirement_master.bActive=1 AND requirement_master.bDelete=0 GROUP BY requirement_master.iClientId ORDER BY client_master.cClientName"); 
			
			if($sql)
			{
				if(($sql->num_rows) > 0)
				{
					$rows = $sql->result_array();
					
					foreach($rows as $row): 
					
					$Client_Id = trim($row['iClientId']);
					$Client_Name = trim($row['cClientName']);
				?>
					maincontent1+="<option value='<?php echo $Client_Id; ?>'><?php echo $Client_Name; ?></option>";
				<?php
					endforeach;	
				}
			}
			?>
			maincontent1+="</select></div>";
			
			maincontent1+="<div style='width:1%; height:100%; float:left; border:0px solid red;'>&nbsp;</div>";
			maincontent1+="<div style='width:13%; height:100%; float:left; border:0px solid blue;'>";
			maincontent1+="<select name='cmbRequirement[]' id='cmbRequirement"+counter+"' data-placeholder='Select Requirement...' class='selected_requirement chzn-select fild'>";
			maincontent1+="<option value=''>Select Requirement</option>";	
			maincontent1+="</select></div>";
			
			maincontent1+="<div style='width:1%; height:100%; float:left; border:0px solid red;'>&nbsp;</div>";
			maincontent1+="<div style='width:13%; height:100%; float:left; border:0px solid blue;'>";
			maincontent1+="<select name='cmbClientProp[]' id='cmbClientProp"+counter+"' data-placeholder='Select Client...' class='selected_client_prop chzn-select fild' onchange='getPropertyByClient(this);'>";
			maincontent1+="<option value=''>Select Client</option>";	
			<?php 
			$sql = $this->db->query("SELECT property_master.iClientId,client_master.cClientName FROM property_master LEFT JOIN client_master ON property_master.iClientId=client_master.iClientId WHERE property_master.iClientId<>0 AND property_master.bActive=1 AND property_master.bDelete=0 GROUP BY property_master.iClientId ORDER BY client_master.cClientName"); 
			
			if($sql)
			{
				if(($sql->num_rows) > 0)
				{
					$rows = $sql->result_array();
					
					foreach($rows as $row): 
					
					$Client_Id = trim($row['iClientId']);
					$Client_Name = trim($row['cClientName']);
				?>
					maincontent1+="<option value='<?php echo $Client_Id; ?>'><?php echo $Client_Name; ?></option>";
				<?php
					endforeach;	
				}
			}
			?>
			maincontent1+="</select></div>";
			
			maincontent1+="<div style='width:1%; height:100%; float:left; border:0px solid red;'>&nbsp;</div>";
			maincontent1+="<div style='width:13%; height:100%; float:left; border:0px solid blue;'>";
			maincontent1+="<select name='cmbProperty[]' id='cmbProperty"+counter+"' data-placeholder='Select Property...' class='selected_property chzn-select fild'>";
			maincontent1+="<option value=''>Select Property</option>";	
			maincontent1+="</select></div>";
			
			maincontent1+="<div style='width:1%; height:100%; float:left; border:0px solid red;'>&nbsp;</div>";
			maincontent1+="<div style='width:13%; height:100%; float:left; border:0px solid blue;'>";
			maincontent1+="<select name='cmbCurrentStatus[]' id='cmbCurrentStatus"+counter+"' data-placeholder='Select Status...' class='selected_current_status chzn-select fild'>";
			maincontent1+="<option value=''>Select Status</option>";	
			<?php 
			$this->db->order_by("cCurrentStatusName", "asc");
			$this->db->where('bActive', 1);
			$this->db->where('bDelete', 0);
			$sql =  $this->db->get('current_status_master');  
			if($sql)
			{
				if(($sql->num_rows) > 0)
				{
					$rows = $sql->result_array();
					
					foreach($rows as $row): 
					
					$CurrentStatus_Id = trim($row['iCurrentStatusId']);
					$CurrentStatus_Name = trim($row['cCurrentStatusName']);
				?>
					maincontent1+="<option value='<?php echo $CurrentStatus_Id; ?>'><?php echo $CurrentStatus_Name; ?></option>";
				<?php
					endforeach;	
				}
			}
			?>
			maincontent1+="</select></div>";
			
			maincontent1+="<div style='width:1%; height:100%; float:left; border:0px solid red;'>&nbsp;</div>";
			maincontent1+="<div style='width:13%; height:100%; float:left; border:0px solid blue;'><textarea name='txtDCRSummary[]' id='txtDCRSummary"+counter+"' class='dcr_summary fild' col='6' rows='1' onblur='add_row();' tabindex='4'><?php echo set_value('txtDCRSummary[]'); ?></textarea></div>";

			maincontent1+="<div class='clear'></div>";
			
			maincontent1+="<div class='Txtblks'><hr /></div>";
			maincontent1+="<div class='fldblks'><hr /></div>";
			maincontent1+="<div class='Txtblks'><hr /></div>";
			maincontent1+="<div class='fldblks'><hr /></div>";
		 
			newTextBoxDiv.after().html(maincontent1);
		  
			newTextBoxDiv.appendTo("#TextBoxesGroup");
			
			$(".chzn-select").chosen(); 
			$(".chzn-select-deselect").chosen({allow_single_deselect:true});
			
			counter++;
     });
	 		
    $("#removeButton").click(function() {

		if(counter==2){
		  alert("No more fields to remove");
		  return false;
		}   
		
		counter--;
		
		$("#TextBoxDiv"+counter).remove();	
	});

/*-----------------------------------------------------------------------------------------------------------------------------------------------------------*/

	$("#txtDCRDate").datepicker({ 
		dateFormat: 'dd/mm/yy',
		showOn: "button",
		changeMonth: true,
		changeYear: true,
		yearRange:"-100:+10",
		maxDate: 0,
		buttonImage: "<?php echo base_url(); ?>images/calendar.gif",
		buttonImageOnly: true 
	});	
});
</script>

<script type="text/javascript" language="javascript">
var counter = 2;

function add_row() 
{	
   var newTextBoxDiv = $(document.createElement('div')).attr({"id":"TextBoxDiv"+counter, "class":"row", "height":"100px", "border":"1px solid green"});
	   
   var  maincontent1="<div style='width:3%; height:100%; text-align:center; float:left; border:0px solid red;'>"+counter+".</div>";
		maincontent1+="<div style='width:1%; height:100%; float:left; border:0px solid red;'>&nbsp;</div>";
		maincontent1+="<div style='width:12%; height:100%; float:left; border:0px solid blue;'>";
		maincontent1+="<select name='cmbTask[]' id='cmbTask"+counter+"' data-placeholder='Select Task...' class='selected_task chzn-select fild'>";
		maincontent1+="<option value=''>Select Task</option>";	
		<?php 
		$this->db->where('bActive', 1);
		$this->db->where('bDelete', 0);
		$sql =  $this->db->get('task_master');  
		if($sql)
		{
			if(($sql->num_rows) > 0)
			{
				$rows = $sql->result_array();
				
				foreach($rows as $row): 
				
				$Task_Id = trim($row['iTaskId']);
				$Task_Name = trim($row['cTaskName']);
			?>
				maincontent1+="<option value='<?php echo $Task_Id; ?>'><?php echo $Task_Name; ?></option>";
			<?php
				endforeach;	
			}
		}
		?>
		maincontent1+="</select></div>";
	
		maincontent1+="<div style='width:1%; height:100%; float:left; border:0px solid red;'>&nbsp;</div>";
		maincontent1+="<div style='width:13%; height:100%; float:left; border:0px solid blue;'>";
		maincontent1+="<select name='cmbClientReq[]' id='cmbClientReq"+counter+"' data-placeholder='Select Client...' class='selected_client_req chzn-select fild' onchange='getRequirementByClient(this);'>";
		maincontent1+="<option value=''>Select Client</option>";	
		<?php 
		$sql = $this->db->query("SELECT requirement_master.iClientId,client_master.cClientName FROM requirement_master LEFT JOIN client_master ON requirement_master.iClientId=client_master.iClientId WHERE requirement_master.iClientId<>0 AND requirement_master.bActive=1 AND requirement_master.bDelete=0 GROUP BY requirement_master.iClientId ORDER BY client_master.cClientName");		
		
		if($sql)
		{
			if(($sql->num_rows) > 0)
			{
				$rows = $sql->result_array();
				
				foreach($rows as $row): 
				
				$Client_Id = trim($row['iClientId']);
				$Client_Name = trim($row['cClientName']);
			?>
				maincontent1+="<option value='<?php echo $Client_Id; ?>'><?php echo $Client_Name; ?></option>";
			<?php
				endforeach;	
			}
		}
		?>
		maincontent1+="</select></div>";
		
		maincontent1+="<div style='width:1%; height:100%; float:left; border:0px solid red;'>&nbsp;</div>";
		maincontent1+="<div style='width:13%; height:100%; float:left; border:0px solid blue;'>";
		maincontent1+="<select name='cmbRequirement[]' id='cmbRequirement"+counter+"' data-placeholder='Select Requirement...' class='selected_requirement chzn-select fild'>";
		maincontent1+="<option value=''>Select Requirement</option>";	
		maincontent1+="</select></div>";
		
		maincontent1+="<div style='width:1%; height:100%; float:left; border:0px solid red;'>&nbsp;</div>";
		maincontent1+="<div style='width:13%; height:100%; float:left; border:0px solid blue;'>";
		maincontent1+="<select name='cmbClientProp[]' id='cmbClientProp"+counter+"' data-placeholder='Select Client...' class='selected_client_prop chzn-select fild' onchange='getPropertyByClient(this);'>";
		maincontent1+="<option value=''>Select Client</option>";	
		<?php 
		$sql = $this->db->query("SELECT property_master.iClientId,client_master.cClientName FROM property_master LEFT JOIN client_master ON property_master.iClientId=client_master.iClientId WHERE property_master.iClientId<>0 AND property_master.bActive=1 AND property_master.bDelete=0 GROUP BY property_master.iClientId ORDER BY client_master.cClientName"); 
		
		if($sql)
		{
			if(($sql->num_rows) > 0)
			{
				$rows = $sql->result_array();
				
				foreach($rows as $row): 
				
				$Client_Id = trim($row['iClientId']);
				$Client_Name = trim($row['cClientName']);
			?>
				maincontent1+="<option value='<?php echo $Client_Id; ?>'><?php echo $Client_Name; ?></option>";
			<?php
				endforeach;	
			}
		}
		?>
		maincontent1+="</select></div>";
		
		maincontent1+="<div style='width:1%; height:100%; float:left; border:0px solid red;'>&nbsp;</div>";
		maincontent1+="<div style='width:13%; height:100%; float:left; border:0px solid blue;'>";
		maincontent1+="<select name='cmbProperty[]' id='cmbProperty"+counter+"' data-placeholder='Select Property...' class='selected_property chzn-select fild'>";
		maincontent1+="<option value=''>Select Property</option>";	
		maincontent1+="</select></div>";
		
		maincontent1+="<div style='width:1%; height:100%; float:left; border:0px solid red;'>&nbsp;</div>";
		maincontent1+="<div style='width:13%; height:100%; float:left; border:0px solid blue;'>";
		maincontent1+="<select name='cmbCurrentStatus[]' id='cmbCurrentStatus"+counter+"' data-placeholder='Select Status...' class='selected_current_status chzn-select fild'>";
		maincontent1+="<option value=''>Select Status</option>";	
		<?php 
		$this->db->order_by("cCurrentStatusName", "asc");
		$this->db->where('bActive', 1);
		$this->db->where('bDelete', 0);
		$sql =  $this->db->get('current_status_master');  
		if($sql)
		{
			if(($sql->num_rows) > 0)
			{
				$rows = $sql->result_array();
				
				foreach($rows as $row): 
				
				$CurrentStatus_Id = trim($row['iCurrentStatusId']);
				$CurrentStatus_Name = trim($row['cCurrentStatusName']);
			?>
				maincontent1+="<option value='<?php echo $CurrentStatus_Id; ?>'><?php echo $CurrentStatus_Name; ?></option>";
			<?php
				endforeach;	
			}
		}
		?>
		maincontent1+="</select></div>";
			
		maincontent1+="<div style='width:1%; height:100%; float:left; border:0px solid red;'>&nbsp;</div>";
		maincontent1+="<div style='width:13%; height:100%; float:left; border:0px solid blue;'><textarea name='txtDCRSummary[]' id='txtDCRSummary"+counter+"' class='dcr_summary fild' col='6' rows='1' onblur='add_row();' tabindex='4'><?php echo set_value('txtDCRSummary[]'); ?></textarea></div>";

		maincontent1+="<div class='clear'></div>";
		
		maincontent1+="<div class='Txtblks'><hr /></div>";
		maincontent1+="<div class='fldblks'><hr /></div>";
		maincontent1+="<div class='Txtblks'><hr /></div>";
		maincontent1+="<div class='fldblks'><hr /></div>";
	 
		newTextBoxDiv.after().html(maincontent1);
	  
		newTextBoxDiv.appendTo("#TextBoxesGroup");
		
		$(".chzn-select").chosen(); 
		$(".chzn-select-deselect").chosen({allow_single_deselect:true});
		
		counter++;
}
</script>

<script type="text/javascript" language="javascript">
function getRequirementByClient(e)
{	
	var cmbClientReq = $(e).closest(".row").find(".selected_client_req").val();
	
	if(cmbClientReq!='')
	{	
		$.ajax({
			type: "POST",
			dataType: 'json',
			url: "<?php echo base_url(); ?>index.php/dashboard/getrequirementbyclient",
			data: "cmbClient="+cmbClientReq,
			success: function(details){
				
				$(e).closest(".row").find(".selected_requirement").children('option:not(:first)').remove();
				
				$.each(details,function(reqid,reqname) {
				    var opt = $('<option />'); 									
					opt.val(reqid);
					opt.text(reqname);
					$(e).closest(".row").find(".selected_requirement").append(opt);				  
				});
				
				$(e).closest(".row").find(".selected_requirement").trigger("liszt:updated");	
			}
		});
	}
	else
	{
		$(e).closest(".row").find(".selected_requirement").val('');
	}
}
</script>

<script type="text/javascript" language="javascript">
function getPropertyByClient(e)
{	
	var cmbClientProp = $(e).closest(".row").find(".selected_client_prop").val();
	
	if(cmbClientProp!='')
	{
		$.ajax({
			type: "POST",
			dataType: 'json',
			url: "<?php echo base_url(); ?>index.php/dashboard/getpropertybyclient",
			data: "cmbClient="+cmbClientProp,
			success: function(details){
				//alert(details);
			    $(e).closest(".row").find(".selected_property").children('option:not(:first)').remove();
				
				$.each(details,function(propid,propname) {
				    var opt = $('<option />'); 									
					opt.val(propid);
					opt.text(propname);
					$(e).closest(".row").find(".selected_property").append(opt);				  
				});
				
				$(e).closest(".row").find(".selected_property").trigger("liszt:updated");
			}
		});
	}
	else
	{
		$(e).closest(".row").find(".selected_property").val('');
	}
}
</script>

<script type="text/javascript" language="javascript">
function getReqByClient(rowno)
{
    if($("#cmbExistClientReq"+rowno).val()!='')
	{
		$.ajax({
			type: "POST",
			dataType: 'json',
			url: "<?php echo base_url(); ?>index.php/dashboard/getrequirementbyclient",
			data: "cmbClient="+$("#cmbExistClientReq"+rowno).val(),
			success: function(details){
			/*$.each(details,function(reqid,reqname) {
					alert(reqid+"=>"+reqname);
			  });*/
				<?php
				foreach($DCRDetailRows as $dcrdetrow)
				{
					$RequirementId = trim($dcrdetrow['iRequirementId']);
				?>
					if($("#cmbExistRequirement"+rowno).val()=='')
					{		
						$("#cmbExistRequirement"+rowno).children('option:not(:first)').remove();
						//alert("#cmbExistRequirement"+i);
						$.each(details,function(reqid,reqname) {	 
								
							//alert(reqid+"=>"+reqname+"(<?php echo $RequirementId; ?>)");
							
							var opt = $('<option />');
							
							if(reqid == "<?php echo $RequirementId; ?>")
							{	
								opt.val(reqid);
								opt.text(reqname);
								$(opt).attr('selected', 'selected');
							}		
							else
							{
								opt.val(reqid);
								opt.text(reqname);
							}
							
							$("#cmbExistRequirement"+rowno).append(opt);
						});
						
						$("#cmbExistRequirement"+rowno).trigger("liszt:updated");
					}
					
				<?php
				}
				?>																
			}
		});
	}
	else
	{
		$(e).closest(".row").find(".selected_requirement_existing").val('');
	}
}
</script>

<script type="text/javascript" language="javascript">
function getReqByClientExist(rowno)
{
    if($("#cmbExistClientReq"+rowno).val()!='')
	{
	    $.ajax({
			type: "POST",
			dataType: 'json',
			url: "<?php echo base_url(); ?>index.php/dashboard/getrequirementbyclient",
			data: "cmbClient="+$("#cmbExistClientReq"+rowno).val(),
			success: function(details){
				//alert(details);
				$("#cmbExistRequirement"+rowno).children('option:not(:first)').remove();
				
			    $.each(details,function(reqid,reqname) {
					var opt = $('<option />'); 									
					opt.val(reqid);
					opt.text(reqname);
					$("#cmbExistRequirement"+rowno).append(opt);				  
				});
				
				$("#cmbExistRequirement"+rowno).trigger("liszt:updated");	
			}
		});
	}
	else
	{
		$("#cmbExistRequirement"+rowno).val('');
	}
}
</script>

<script type="text/javascript" language="javascript">
function getPropByClient(rowno)
{
    if($("#cmbExistClientProp"+rowno).val()!='')
	{
		//alert($("#cmbExistClientProp"+rowno).val());
		
		$.ajax({
			type: "POST",
			dataType: 'json',
			url: "<?php echo base_url(); ?>index.php/dashboard/getpropertybyclient",
			data: "cmbClient="+$("#cmbExistClientProp"+rowno).val(),
			success: function(details){
				//alert(details);
			  /*$.each(details,function(propid,propname) {
					alert(propid+"=>"+propname);
				});*/
				
			    <?php
				foreach($DCRDetailRows as $dcrdetrow)
				{
					$PropertyId = trim($dcrdetrow['iPropertyId']);
				?>
					if($("#cmbExistProperty"+rowno).val()=='')
					{		
						$("#cmbExistProperty"+rowno).children('option:not(:first)').remove();
						//alert("#cmbExistRequirement"+i);
						$.each(details,function(propid,propname) {	 
								
							//alert(propid+"=>"+propname+"(<?php echo $RequirementId; ?>)");
							
							var opt = $('<option />');
							
							if(propid == "<?php echo $PropertyId; ?>")
							{	
								opt.val(propid);
								opt.text(propname);
								$(opt).attr('selected', 'selected');
							}		
							else
							{
								opt.val(propid);
								opt.text(propname);
							}
							
							$("#cmbExistProperty"+rowno).append(opt);
						});
						
						$("#cmbExistProperty"+rowno).trigger("liszt:updated");
					}
				<?php
				}
				?>																
			}
		}); 
	}
	else
	{
		$(e).closest(".row").find(".selected_property_existing").val('');
	}
}
</script>

<script type="text/javascript" language="javascript">
function getPropByClientExist(rowno)
{
	if($("#cmbExistClientProp"+rowno).val()!='')
	{
		$.ajax({
			type: "POST",
			dataType: 'json',
			url: "<?php echo base_url(); ?>index.php/dashboard/getpropertybyclient",
			data: "cmbClient="+$("#cmbExistClientProp"+rowno).val(),
			success: function(details){
				//alert(details);
				$("#cmbExistProperty"+rowno).children('option:not(:first)').remove();
				
				$.each(details,function(propid,propname) {
				    var opt = $('<option />'); 									
					opt.val(propid);
					opt.text(propname);
					$("#cmbExistProperty"+rowno).append(opt);				  
				});
				
				$("#cmbExistProperty"+rowno).trigger("liszt:updated");
			}
		});
	}
	else
	{
		$("#cmbExistProperty"+rowno).val('');
	}
}
</script>

<script type="text/javascript" language="javascript">
function FormValidate(btn)
{
    if($("#txtDCRDate").val()=='')
    {	
        alert("Please select Date");
        $("#txtDCRDate").focus();
        return false;
    }
    else
    {
		var data = $("#editForm").serialize();
		
		var url = "<?php echo base_url(); ?>index.php/dashboard/edit_dcr";

		btn.disabled = true;
		btn.value = 'Submitting...';
		
		$.post(url,data,function(responsedata,status){	
	       //alert(responsedata);	
		    if(responsedata)
			{
				if(responsedata.status == 1)
				{					
					btn.disabled = false;
					btn.value = 'Submit';
					alert(responsedata.msg);
					var redirecturl = "<?php echo base_url(); ?>index.php/dashboard/listing_dcr";
					$(location).attr('href',redirecturl);	
				}	
				else
				{
					btn.disabled = false;
					btn.value = 'Submit';
					alert(responsedata.msg);
				} 
			}
			
		},'json');//,'json'
    }
}
</script>