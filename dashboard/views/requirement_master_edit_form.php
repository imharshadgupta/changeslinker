<!--==============================Form=================================-->


<form name="editForm" id="editForm" method="post" action="<?php echo base_url(); ?>index.php/dashboard/edit_requirement_master" enctype="multipart/form-data" target="_blank">
<input type="hidden" name="hfRequirementId" id="hfRequirementId" value="<?php echo set_value('hfRequirementId',$RequirementId); ?>"/>
<input type="hidden" name="hfActive" id="hfActive" value="<?php echo set_value('hfActive',$Active); ?>" />
<input type="hidden" name="hfAcceptTermsAndConditions" id="hfAcceptTermsAndConditions" value="<?php echo set_value('hfAcceptTermsAndConditions',$AcceptTermsAndConditions); ?>" />
<div class="inner_form">
<h2>Edit Requisition Details</h2>
<div class="mfrminner">
<div style="color: #0000FF; text-align:center; font-weight:bold;"><?php echo $this->session->flashdata('msg');?><br /><?php echo $message; ?><br /><?php echo validation_errors(); ?></div>

<fieldset><legend>&nbsp;</legend>

<div class="Txtblks">Date</div>
    <div class="fldblks"><input type="text" name="txtDate" id="txtDate" class="fild" style="width:302px;" value="<?php echo set_value('txtDate',$Date); ?>" tabindex="1" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Title</div>
<div class="fldblks"><input type="text" name="txtRequirementTitle" id="txtRequirementTitle" class="fild" value="<?php echo set_value('txtRequirementTitle',$RequirementTitle); ?>" tabindex="2" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Client</div>
<div class="fldblks">
	<select name="cmbClient" id="cmbClient" class="fild" tabindex="3" onchange="ChangeClient()">
	<option value="">Select Client</option>
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
				
				$Client_Id = trim($row['iClientId']);
				$Client_Name = trim($row['cClientName']);
			?>
				<option value="<?php echo $Client_Id; ?>" <?php echo set_select("cmbClient","$Client_Id",($ClientId=="$Client_Id" ? TRUE:'')); ?>><?php echo $Client_Name; ?></option>
			<?php
				endforeach;	
			}
		}
	?>
	</select>
</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Contact Person</div>
<div class="fldblks">
<select name="cmbContactPerson" id="cmbContactPerson" class="fild" onchange="ChangeContactPerson()" tabindex="4">
<option value="">Select Contact Person</option>
</select>
</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Designation :-</div>
<div class="Txtblks" style="font-size:15px; font-weight:bold; text-align:left;" id="dvDesignation"></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Phone No. 1 :-</div>
<div class="Txtblks" style="font-size:15px; font-weight:bold; text-align:left;" id="dvPhoneNo1"></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Phone No. 2 :-</div>
<div class="Txtblks" style="font-size:15px; font-weight:bold; text-align:left;" id="dvPhoneNo2"></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Email :-</div>
<div class="Txtblks" style="font-size:15px; font-weight:bold; text-align:left;" id="dvEmail"></div>
<input type="hidden" id="dvEmaildata" name="dvEmaildata" >
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

</fieldset>

<fieldset><legend>General Details</legend>

<div class="Txtblks">Branch</div>
<div class="fldblks">
	<select name="cmbBranch" id="cmbBranch" class="fild" tabindex="10">
	<option value="">Select Branch</option>
	<?php 
		   $this->db->order_by('cBranchName', 'asc');
		   $this->db->where('bActive','1');
		   $this->db->where('bDelete','0');
    $sql = $this->db->get('branch_master');  
    if($sql)
    {
        if(($sql->num_rows) > 0)
        {
            $rows=$sql->result_array();
            
            foreach($rows as $row): 
            
                $Branch_Id = trim($row['iBranchId']);
                $Branch_Name = trim($row['cBranchName']);
            ?>
            <option value="<?php echo $Branch_Id; ?>" <?php echo set_select("cmbBranch","$Branch_Id",($BranchId=="$Branch_Id" ? TRUE:'')); ?>><?php echo $Branch_Name; ?></option>
        <?php
             endforeach;	
        }
    }
    ?>
	</select>
</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">State</div>
<div class="fldblks">
	<select name="cmbState" id="cmbState" class="fild" tabindex="11" onchange="getDistrictByStateId()">
	<option value="">Select State</option>
	<?php
		$this->db->order_by('cStateName', 'asc');
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
				<option value="<?php echo $State_Id; ?>" <?php echo set_select("cmbState","$State_Id",($StateId=="$State_Id" ? TRUE:'')); ?>><?php echo $State_Name; ?></option>
			<?php
				endforeach;	
			}
		}
	?>
	</select>
</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">District</div>
<div class="fldblks">
	<select name="cmbDistrict" id="cmbDistrict" class="fild" tabindex="12" onchange="getCityByDistrictIdAndStateId()">
	<option value="">Select District</option>
	</select>
</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">City</div>
<div class="fldblks">
	<select name="cmbCity" id="cmbCity" class="fild" tabindex="13" onchange="getLocationByCityIdAndDistrictIdAndStateId()">
	<option value="">Select City</option>
	</select>
</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Location</div>
<div class="fldblks">
	<select name="cmbLocation" id="cmbLocation" class="fild" tabindex="14">
	<option value="">Select Location</option>
	</select>
</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Area</div>
<div class="fldblks"><textarea name="txtArea" id="txtArea" class="fild" tabindex="15"><?php echo set_value('txtArea',$Area); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Height</div>
<div class="fldblks"><input type="text" name="txtHeight" id="txtHeight" class="fild" value="<?php echo set_value('txtHeight',$Height); ?>" tabindex="16" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Frontage</div>
<div class="fldblks"><input type="text" name="txtFrontage" id="txtFrontage" class="fild" value="<?php echo set_value('txtFrontage',$Frontage); ?>" tabindex="17" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Furnished Status</div>
<div class="fldblks">
<select name="cmbFurnishedStatus" id="cmbFurnishedStatus" class="fild" tabindex="18" >
  <option value="" <?php if (!(strcmp("", $cFurnishedStatus))) {echo "selected=\"selected\"";} ?>>Select Status</option>
  <option value="Furnished" <?php if (!(strcmp("Furnished", $cFurnishedStatus))) {echo "selected=\"selected\"";} ?>>Furnished</option>
  <option value="Unfurnished" <?php if (!(strcmp("Unfurnished", $cFurnishedStatus))) {echo "selected=\"selected\"";} ?>>Unfurnished</option>
  <option value="Semi-Furnished" <?php if (!(strcmp("Semi-Furnished", $cFurnishedStatus))) {echo "selected=\"selected\"";} ?>>Semi-Furnished</option>
  <option value="Any" <?php if (!(strcmp("Any", $cFurnishedStatus))) {echo "selected=\"selected\"";} ?>>Any</option>
</select>
	
</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>


<div class="Txtblks">Source</div>
<div class="fldblks">
	<select name="cmbSource" id="cmbSource" class="fild" tabindex="19">
	<option value="">Select Source</option>
	<?php 	
	    $this->db->order_by('cSourceName', 'asc');
		$this->db->where('bActive', 1);
		$this->db->where('bDelete', 0);
		$sql =  $this->db->get('source_master');  
		if($sql)
		{
			if(($sql->num_rows) > 0)
			{
				$rows = $sql->result_array();
				
				foreach($rows as $row): 
				
				$Source_Id = trim($row['iSourceId']);
				$Source_Name = trim($row['cSourceName']);
			?>
				<option value="<?php echo $Source_Id; ?>" <?php echo set_select("cmbSource","$Source_Id",($SourceId=="$Source_Id" ? TRUE:'')); ?>><?php echo $Source_Name; ?></option>
			<?php
				endforeach;	
			}
		}
	?>
	</select>
</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<!--
<div class="Txtblks">Property Purpose</div>
<div class="fldblks">
<select name="cmbPropertyPurpose" id="cmbPropertyPurpose" class="fild" tabindex="16">
<option value="">Select Property Purpose</option>
<option value="Sale"   <?php //echo set_select("cmbPropertyPurpose","Sale",($PropertyPurpose=="Sale" ? TRUE:'')); ?>>Sale</option>
<option value="Rental" <?php //echo set_select("cmbPropertyPurpose","Rental",($PropertyPurpose=="Rental" ? TRUE:'')); ?>>Rental</option>
<select></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>
-->

<div class="Txtblks">Business Purpose</div>
<div class="fldblks">
	<select name="cmbBusinessPurpose" id="cmbBusinessPurpose" class="fild" tabindex="20">
	<option value="">Select Business Purpose</option>
	<?php 
		$this->db->order_by('cBusinessPurposeName', 'asc');
		$this->db->where('bActive', 1);
		$this->db->where('bDelete', 0);
		$sql =  $this->db->get('business_purpose_master');  
		if($sql)
		{
			if(($sql->num_rows) > 0)
			{
				$rows = $sql->result_array();
				
				foreach($rows as $row): 
				
				$BusinessPurpose_Id = trim($row['iBusinessPurposeId']);
				$BusinessPurpose_Name = trim($row['cBusinessPurposeName']);
			?>
				<option value="<?php echo $BusinessPurpose_Id; ?>" <?php echo set_select("cmbBusinessPurpose","$BusinessPurpose_Id",($BusinessPurposeId=="$BusinessPurpose_Id" ? TRUE:'')); ?>><?php echo $BusinessPurpose_Name; ?></option>
			<?php
				endforeach;	
			}
		}
	?>
	</select>
</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Property Category</div>
<div class="fldblks">
	<select name="cmbPropertyCategory" id="cmbPropertyCategory" class="fild" tabindex="21">
	<option value="">Select Property Category</option>
	<?php
		$this->db->order_by('cPropertyCategoryName', 'asc');
		$this->db->where('bActive', 1);
		$this->db->where('bDelete', 0);
		$sql =  $this->db->get('property_category_master');  
		if($sql)
		{
			if(($sql->num_rows) > 0)
			{
				$rows = $sql->result_array();
				
				foreach($rows as $row): 
				
				$PropertyCategory_Id = trim($row['iPropertyCategoryId']);
				$PropertyCategory_Name = trim($row['cPropertyCategoryName']);
			?>
				<option value="<?php echo $PropertyCategory_Id; ?>" <?php echo set_select("cmbPropertyCategory","$PropertyCategory_Id",($PropertyCategoryId=="$PropertyCategory_Id" ? TRUE:'')); ?>><?php echo $PropertyCategory_Name; ?></option>
			<?php
				endforeach;	
			}
		}
	?>
	</select>
</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Requirement Type</div>
<div class="fldblks">
<select name="cmbRequirementType" id="cmbRequirementType" class="fild" tabindex="22">
<option value="">Select Requirement Type</option>
<option value="Purchase" <?php echo set_select("cmbRequirementType","Purchase",($RequirementType=="Purchase" ? TRUE:'')); ?>>Purchase</option>
<option value="Lease"    <?php echo set_select("cmbRequirementType","Lease",($RequirementType=="Lease" ? TRUE:'')); ?>>Lease</option>
<option value="Any"    <?php echo set_select("cmbRequirementType","Any",($RequirementType=="Any" ? TRUE:'')); ?>>Any</option>
</select></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Budget</div>
<div class="fldblks"><input type="text" name="txtBudgetPerMonth" id="txtBudgetPerMonth" class="fild" value="<?php echo set_value('txtBudgetPerMonth',$BudgetPerMonth); ?>" tabindex="23" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Floor Level Preference</div>
<div class="fldblks"><input type="text" name="txtFloorLevelPreference" id="txtFloorLevelPreference" class="fild" value="<?php echo set_value('txtFloorLevelPreference',$FloorLevelPreference); ?>" tabindex="24" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Escalation</div>
<div class="fldblks">
	<select name="cmbEscalation" id="cmbEscalation" class="fild" tabindex="25">
	<option value="">Select Escalation</option>
	<?php 
		$this->db->order_by('cEscalationName', 'asc');
		$this->db->where('bActive', 1);
		$this->db->where('bDelete', 0);
		$sql =  $this->db->get('escalation_master');  
		if($sql)
		{
			if(($sql->num_rows) > 0)
			{
				$rows = $sql->result_array();
				
				foreach($rows as $row): 
				
				$Escalation_Id = trim($row['iEscalationId']);
				$Escalation_Name = trim($row['cEscalationName']);
			?>
				<option value="<?php echo $Escalation_Id; ?>" <?php echo set_select("cmbEscalation","$Escalation_Id",($EscalationId=="$Escalation_Id" ? TRUE:'')); ?>><?php echo $Escalation_Name; ?></option>
			<?php
				endforeach;	
			}
		}
	?>
	</select>
</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Lease Period Preference</div>
<div class="fldblks"><textarea name="txtLeasePeriodPreference" id="txtLeasePeriodPreference" class="fild" tabindex="26"><?php echo set_value('txtLeasePeriodPreference',$LeasePeriodPreference); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Rent Free Fit Out Period</div>
<div class="fldblks"><textarea name="txtRentFreeFitOutPeriod" id="txtRentFreeFitOutPeriod" class="fild" tabindex="28"><?php echo set_value('txtRentFreeFitOutPeriod',$RentFreeFitOutPeriod); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Power Load</div>
<div class="fldblks"><textarea name="txtPowerLoad" id="txtPowerLoad" class="fild" tabindex="29"><?php echo set_value('txtPowerLoad',$PowerLoad); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Power Backup</div>
<div class="fldblks">
<select name="cmbPowerBackup" id="cmbPowerBackup" class="fild" tabindex="30">
<option value="">Select Power Backup</option>
<option value="Required" <?php echo set_select("cmbPowerBackup","Required",($PowerBackup=="Required" ? TRUE:'')); ?>>Required</option>
<option value="Not Required" <?php echo set_select("cmbPowerBackup","Not Required",($PowerBackup=="Not Required" ? TRUE:'')); ?>>Not Required</option>
</select></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Expected Launch Date</div>
<div class="fldblks"><input type="text" name="txtExpectedLaunchDate" id="txtExpectedLaunchDate" class="fild" style="width:302px;" value="<?php echo set_value('txtExpectedLaunchDate',$ExpectedLaunchDate); ?>" readonly="readonly" tabindex="31" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Tagline for Website</div>
<div class="fldblks"><input type="text" name="txtRequirementTaglineForWebsite" id="txtRequirementTaglineForWebsite" class="fild" value="<?php echo set_value('txtRequirementTaglineForWebsite',$RequirementTaglineForWebsite); ?>" tabindex="32" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Remarks</div>
<div class="fldblks"><textarea name="txtRemarks" id="txtRemarks" class="fild"  tabindex="33"><?php echo set_value('txtRemarks',$Remarks); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

</fieldset>

<fieldset><legend>Landlord Scope of Work</legend>

<div class="Txtblks">Registration Expenses To Be Borne By</div>
<div class="fldblks">
<select name="cmbRegistrationExpensesToBeBorneBy" id="cmbRegistrationExpensesToBeBorneBy" class="fild" tabindex="34">
<option value="">Select Registration Expenses To Be Borne By</option>
<option value="50-50" <?php echo set_select("cmbRegistrationExpensesToBeBorneBy","50-50",($RegistrationExpensesToBeBorneBy=="50-50" ? TRUE:'')); ?>>50-50</option>
<option value="By Lessor" <?php echo set_select("cmbRegistrationExpensesToBeBorneBy","By Lessor",($RegistrationExpensesToBeBorneBy=="By Lessor" ? TRUE:'')); ?>>By Lessor</option>
<option value="By Lessee" <?php echo set_select("cmbRegistrationExpensesToBeBorneBy","By Lessee",($RegistrationExpensesToBeBorneBy=="By Lessee" ? TRUE:'')); ?>>By Lessee</option>
</select></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Taxation To Be Borne By</div>
<div class="fldblks">
<select name="cmbTaxationToBeBorneBy" id="cmbTaxationToBeBorneBy" class="fild" tabindex="35">
<option value="">Select Taxation To Be Borne By</option>
<option value="50-50" <?php echo set_select("cmbTaxationToBeBorneBy","50-50",($TaxationToBeBorneBy=="50-50" ? TRUE:'')); ?>>50-50</option>
<option value="By Lessor" <?php echo set_select("cmbTaxationToBeBorneBy","By Lessor",($TaxationToBeBorneBy=="By Lessor" ? TRUE:'')); ?>>By Lessor </option>
<option value="By Lessee" <?php echo set_select("cmbTaxationToBeBorneBy","By Lessee",($TaxationToBeBorneBy=="By Lessee" ? TRUE:'')); ?>>By Lessee </option>
</select></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Lock In Period</div>
<div class="fldblks"><input type="text" name="txtLockInPeriod" id="txtLockInPeriod" class="fild" value="<?php echo set_value('txtLockInPeriod',$LockInPeriod); ?>" tabindex="36" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Estimated Interior Budget</div>
<div class="fldblks"><input type="text" name="txtEstimatedInteriorBudget" id="txtEstimatedInteriorBudget" class="fild" value="<?php echo set_value('txtEstimatedInteriorBudget',$EstimatedInteriorBudget); ?>" tabindex="37" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Parking Preference</div>
<div class="fldblks">
<select name="cmbParkingPreference" id="cmbParkingPreference" class="fild" tabindex="38">
<option value="">Select Parking Preference</option>
<option value="Two Wheelers Only" <?php echo set_select("cmbParkingPreference","Two Wheelers Only",($ParkingPreference=="Two Wheelers Only" ? TRUE:'')); ?>>Two Wheelers Only</option>
<option value="Four Wheelers Only" <?php echo set_select("cmbParkingPreference","Four Wheelers Only",($ParkingPreference=="Four Wheelers Only" ? TRUE:'')); ?>>Four Wheelers Only</option>
<option value="All Vehicles" <?php echo set_select("cmbParkingPreference","All Vehicles",($ParkingPreference=="All Vehicles" ? TRUE:'')); ?>>All Vehicles</option>
<option value="No Parking" <?php echo set_select("cmbParkingPreference","No Parking",($ParkingPreference=="No Parking" ? TRUE:'')); ?>>No Parking</option>
</select></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

</fieldset>

<fieldset><legend>Commercials / Terms & Conditions</legend>

<div class="Txtblks">Agreement Date</div>
<div class="fldblks"><input type="text" name="txtAgreementDate" id="txtAgreementDate" class="fild" style="width:302px;" value="<?php echo set_value('txtAgreementDate',$AgreementDate); ?>" readonly="readonly" tabindex="41" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Agreement Place</div>
<div class="fldblks"><input type="text" name="txtAgreementPlace" id="txtAgreementPlace" class="fild" value="<?php echo set_value('txtAgreementPlace',$AgreementPlace); ?>" tabindex="42" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Person 1 During Agreement</div>
<div class="fldblks"><input type="text" name="txtPerson1DuringAgreement" id="txtPerson1DuringAgreement" class="fild" value="<?php echo set_value('txtPerson1DuringAgreement',$Person1DuringAgreement); ?>" tabindex="43" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Person 2 During Agreement</div>
<div class="fldblks"><input type="text" name="txtPerson2DuringAgreement" id="txtPerson2DuringAgreement" class="fild" value="<?php echo set_value('txtPerson2DuringAgreement',$Person2DuringAgreement); ?>" tabindex="44" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<fieldset>
<legend>Existing Agreement</legend>
	<?php 
	if((isset($AgreementFileName)) && (!empty($AgreementFileName)))
	{
	?>
		<div align="left">
			<div class="Txtblks">&nbsp;</div>
			<div class="Txtblks" style="text-align:left;"><strong>SNo.</strong></div>
			<div class="fldblks" style="text-align:left;"><strong>Title</strong></div>
			<div class="clear"></div>
		</div>
		<div align="left">
			<div class="Txtblks">&nbsp;</div>
			<div class="Txtblks" style="text-align:left;">1.</div>
			<div class="fldblks" style="text-align:left;"><?php echo $AgreementFileName; ?></div>

			<div class="fldblks"><input type='button' value='Delete' id='delButton' onclick="DeleteExistingAgreement('<?php echo $PropertyId; ?>','<?php echo $AgreementFileName; ?>','<?php echo $AgreementFilePath; ?>')"></div>
			<div class="clear"></div>
		</div>
	<?php 
	}
	else
	{
	?>
		<div align="left">
			<div class="Txtblks">&nbsp;</div>
			<div class="Txtblks" style="text-align:left;"><strong>No Agreement file exists.</strong></div>
			<div class="fldblks">&nbsp;</div>
			<div class="clear"></div>
		</div>
    <?php 
	}
	?>
</fieldset>

<div class="Txtblks">Attach Agreement Copy</div>
					 <input type="hidden" name="hfAgreementFilePath" id="hfAgreementFilePath" value="" />
					 <input type="hidden" name="hfAgreementFileName" id="hfAgreementFileName" value="" />
<div class="fldblks"><input type="file" name="txtAgreement" id="txtAgreement" class="fild" tabindex="44" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks"><div id="uploadedAgreement"></div></div>
<div class="clear"></div>

<div class="Txtblks">&nbsp;</div>
<div class="fldblks"><input type="button" name="btnUploadAgreement" id="btnUploadAgreement" value="Upload Agreement" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="fldblks">&nbsp;</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Service Charges for Linkers</div>
<div class="fldblks"><textarea name="txtServiceChargesForLinkers" id="txtServiceChargesForLinkers" class="fild" tabindex="43"><?php echo set_value('txtServiceChargesForLinkers',$ServiceChargesForLinkers); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Paste Terms and Conditions here</div>
<div class="fldblks"><textarea name="txtTermsAndConditions" id="txtTermsAndConditions" class="fild" tabindex="45"><?php echo set_value('txtTermsAndConditions',$TermsAndConditions); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Accept T&C</div>
<div class="fldblks"><input type="checkbox" name="chkAcceptTermsAndConditions" id="chkAcceptTermsAndConditions" value="1" onclick="ChangeAcceptTermsAndCond()" <?php echo set_checkbox('chkAcceptTermsAndConditions', '1', ($AcceptTermsAndConditions=='1' ? TRUE:'')); ?>  /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

</fieldset>

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

<!------------------------------------------------------------------------------------------------------------------------------------------------------------>

<div class="submit"><input type="button" name="btnSubmit" class="btn" value="Submit" onclick="FormValidate(this);" />
&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/dashboard/dashboard"><input type="button" name="btnBack" id="btnBack" class="btn" value="Back" /></a></div>

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
function ChangeAcceptTermsAndCond()
{
	if(document.getElementById('chkAcceptTermsAndConditions').checked == true)
	{
		$("#hfAcceptTermsAndConditions").val(1);
	}
	else
	{
		$("#hfAcceptTermsAndConditions").val(0);
	}
}
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
$(document).ready(function(){
	$("#txtDate").datepicker({ 
		dateFormat: 'dd/mm/yy',
		showOn: "button",
		changeMonth: true,
		changeYear: true,
		yearRange:"-100:+10",
		maxDate: 0,
		buttonImage: "<?php echo base_url(); ?>images/calendar.gif",
		buttonImageOnly: true 
	});
	$("#txtExpectedLaunchDate").datepicker({ 
		dateFormat: 'dd/mm/yy',
		showOn: "button",
		changeMonth: true,
		changeYear: true,
		yearRange:"-100:+10",
		buttonImage: "<?php echo base_url(); ?>images/calendar.gif",
		buttonImageOnly: true 
	});
	$("#txtAgreementDate").datepicker({ 
		dateFormat: 'dd/mm/yy',
		showOn: "button",
		changeMonth: true,
		changeYear: true,
		yearRange:"-100:+10",
		buttonImage: "<?php echo base_url(); ?>images/calendar.gif",
		buttonImageOnly: true 
	});
	
	ChangeClient();
	ChangeActive();
	
	getDistrictByStateId();
	
	$('#btnUploadAgreement').click(function(e) {
		e.preventDefault();
		$.ajaxFileUpload({
			url 			: "<?php echo site_url(); ?>/dashboard/upload_requirement_agreement_file", 
			secureuri		:false,
			fileElementId	:'txtAgreement',
			dataType		: 'json',
			success	: function (data, status)
			{
				if(data.status != 'error')
				{
					$("#uploadedAgreement").html('( '+data.agreement_file_name+' )');
					$("#hfAgreementFilePath").val(data.agreement_file_path);
					$("#hfAgreementFileName").val(data.agreement_file_name);
					//$('#files').html('<p>Reloading files...</p>');
					//refresh_files();
				}
				alert(data.msg);
			}
		});
		return false;
	});
});	
</script>

<script type="text/javascript">
function DeleteExistingAgreement(RequirementId,AgreementName,AgreementPath)
{
	var confdel = confirm("Are you sure to delete this document...?")
	
	if(confdel)
	{ 
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>index.php/employee/delete_existing_requirement_agreement",
			data: "PropertyId="+PropertyId+"&AgreementName="+AgreementName+"&AgreementPath="+AgreementPath,
			success: function(data){
				
				if(data=='TRUE')
				{
					alert("Agreement deleted successfully.");
					var url = "<?php echo base_url(); ?>index.php/dashboard/edit_form_property_master/"+PropertyId;    
					$(location).attr('href',url);
				}
				else
				{
					alert("Error in deleting file.");
					return false;
				}
			}
		});
	}
}
</script>

<script type="text/javascript">
function DeleteAgreement()
{
	var confdel = confirm("Are you sure to delete this document...?")
	
	if(confdel)
	{ 	
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>index.php/dashboard/delete_uploaded_requirement_agreement",
			data: "AgreementName="+$("#hfAgreementName").val()+"&AgreementPath="+$("#hfAgreementPath").val(),
			success: function(data){
			
			    if(data=='TRUE')
				{
				 //alert("Agreement deleted successfully.");					 
				   $("#hfAgreementPath").val('');
				   $("#hfAgreementName").val('');
				   $("#dvAgreementName").html('');
				   $("#dvAgreementFile").css("display", "none");
				   $("#txtAgreement").disabled=false;
				   $("#txtAgreement").focus();
				}
				else
				{
					alert("Error in deleting doc.");
					return false;
				}
			}
		});
	}
}
</script>

<script type="text/javascript" language="javascript">
function ChangeClient()
{
	if($("#cmbClient").val()!='')
	{
		$.ajax({
			type: "POST",
			dataType: 'json',
			url: "<?php echo base_url();?>index.php/dashboard/getcontactpersonbyclient",
			data: "cmbClient="+$("#cmbClient").val(),
			success: function(details){
				
				$('#cmbContactPerson').children('option:not(:first)').remove();
				$("#dvDesignation").text('');
				$("#dvPhoneNo1").text('');
				$("#dvPhoneNo2").text('');
				$("#dvEmail").text('');
                                $("#dvEmaildata").val('');
			
				$.each(details,function(contactpersoncolumn,contactpersonname) {	 
				
					var opt = $('<option />'); 									
				
						opt.val(contactpersoncolumn);
						opt.text(contactpersonname);
						//BY Vinod Patidar
					 	//alert($("#cmbClient").val());
						if($("#cmbClient").val() == "<?php echo $ClientId; ?>" )
						{
						
							if(contactpersoncolumn == "<?php echo $ContactId; ?>")
							{
								opt.val(contactpersoncolumn);
								opt.text(contactpersonname);
								$(opt).attr('selected', 'selected');
								ChangeContactPerson(contactpersoncolumn);
							}	
					 
					 	}
					$('#cmbContactPerson').append(opt); 		
				});
			}
		});
	}
	else
	{
		$('#cmbContactPerson').children('option:not(:first)').remove();
		$("#dvDesignation").text('');
		$("#dvPhoneNo1").text('');
		$("#dvPhoneNo2").text('');
		$("#dvEmail").text('');
                $("#dvEmaildata").val('');
	}
}
</script>

<script type="text/javascript" language="javascript">
function ChangeContactPerson(ContactPersonId)
{
	
	var ContactPerson = $("#cmbContactPerson").val();
	if(ContactPersonId == 'undefined' || $("#cmbContactPerson").val() != '')
	{
		var ContactPerson = $("#cmbContactPerson").val();
	}else
	{
		var ContactPerson = ContactPersonId;
	}
	//alert(cp);
	if( typeof ContactPerson == 'undefined')
	{
		ContactPerson = '';
	}

	if(ContactPerson!='' )
	{
		var url = "<?php echo base_url(); ?>index.php/dashboard/getcontactdetailsbycontactperson";
		
		$.post(url,{cmbClient:$("#cmbClient").val(),cmbContactPerson:ContactPerson},function(responsedata,status){	
			
			if(responsedata!='noresultfound')
			{
				var resdata = responsedata.split('~');
				
				var ContactPersonName = resdata[0];
				var ContactPersonDesignation = resdata[1];
				var ContactPersonPhoneNo1 = resdata[2];
				var ContactPersonPhoneNo2 = resdata[3];
				var ContactPersonEmail = resdata[4];
				
				$("#dvDesignation").text(ContactPersonDesignation);
				$("#dvPhoneNo1").text(ContactPersonPhoneNo1);
				$("#dvPhoneNo2").text(ContactPersonPhoneNo2);
				$("#dvEmail").text(ContactPersonEmail);
                                $("#dvEmaildata").val(ContactPersonEmail);
			}
			else
			{
				$("#dvDesignation").text('');
				$("#dvPhoneNo1").text('');
				$("#dvPhoneNo2").text('');
				$("#dvEmail").text('');
                                $("#dvEmaildata").val('');
			}
		});
	}
	else
	{
		$("#dvDesignation").text('');
		$("#dvPhoneNo1").text('');
		$("#dvPhoneNo2").text('');
		$("#dvEmail").text('');
                $("#dvEmaildata").val('');
	}
}
</script>

<script type="text/javascript" language="javascript">
function getDistrictByStateId()
{	
	if($("#cmbState").val()=='')
	{	
		alert("Please Select State");
		$("#cmbState").focus();
		$('#cmbDistrict').children('option:not(:first)').remove();
		$('#cmbCity').children('option:not(:first)').remove();
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
					
					if(districtid == "<?php echo $DistrictId; ?>"){
						opt.val(districtid);
						opt.text(districtname);
						$(opt).attr('selected', 'selected');
					}		
					else
					{
						opt.val(districtid);
						opt.text(districtname);
					}
					
					$('#cmbDistrict').append(opt); 		
				});
				
				getCityByDistrictIdAndStateId();
			}
		});
	}
}	
</script>

<script type="text/javascript" language="javascript">
function getCityByDistrictIdAndStateId()
{
	$('#cmbCity').children('option:not(:first)').remove();	

	$.ajax({
		type: "POST",
		dataType: 'json',
		url: "<?php echo base_url();?>index.php/dashboard/getcitybystateanddistrict",
		data: "cmbState="+$("#cmbState").val()+"&cmbDistrict="+$("#cmbDistrict").val(),
		success: function(details){
			
			$('#cmbCity').children('option:not(:first)').remove();
			
			$.each(details,function(cityid,cityname) {	 
			
				var opt = $('<option />'); 									
				
				if(cityid == "<?php echo $CityId; ?>"){
					opt.val(cityid);
					opt.text(cityname);
					$(opt).attr('selected', 'selected');
				}		
				else
				{
					opt.val(cityid);
					opt.text(cityname);
				}
				
				$('#cmbCity').append(opt); 		    			
			});
			
			getLocationByCityIdAndDistrictIdAndStateId();
		}
	});
}	
</script>

<script type="text/javascript" language="javascript">
function getLocationByCityIdAndDistrictIdAndStateId()
{
	$('#cmbLocation').children('option:not(:first)').remove();	

	$.ajax({
		type: "POST",
		dataType: 'json',
		url: "<?php echo base_url();?>index.php/dashboard/getlocationbystateanddistrictandcity",
		data: "cmbState="+$("#cmbState").val()+"&cmbDistrict="+$("#cmbDistrict").val()+"&cmbCity="+$("#cmbCity").val(),
		success: function(details){
			
			$('#cmbLocation').children('option:not(:first)').remove();
			
			$.each(details,function(locationid,locationname) {	 
			
				var opt = $('<option />'); 									
				
				if(locationid == "<?php echo $LocationId; ?>"){
					opt.val(locationid);
					opt.text(locationname);
					$(opt).attr('selected', 'selected');
				}		
				else
				{
					opt.val(locationid);
					opt.text(locationname);
				}
				
				$('#cmbLocation').append(opt); 		    			
			});
		}
	});
}	
</script>

<script type="text/javascript" language="javascript">
function FormValidate(btn)
{
    if($("#txtDate").val()=='')
    {	
        alert("Please select Date");
        $("#txtDate").focus();
        return false;
    }
	else if($("#txtRequirementTitle").val()=='')
    {	
        alert("Please enter Requirement Title");
        $("#txtRequirementTitle").focus();
        return false;
    }
	else if($("#cmbClient").val()=='')
    {	
        alert("Please select Client");
        $("#cmbClient").focus();
        return false;
    }
    else
    {
		var data = $("#editForm").serialize();
		
		var url = "<?php echo base_url(); ?>index.php/dashboard/edit_requirement_master";
                
                 var clientids = '<?php echo $ClientId; ?>';
                 

		$.post(url,data,function(responsedata,status){
		  
		  //alert(responsedata);
		  
		    if(responsedata)
			{
				if(responsedata.status == 1)
				{					
					btn.disabled = false;
					btn.value = 'Submit';
					alert(responsedata.msg);
					var redirecturl = "<?php echo base_url(); ?>index.php/dashboard/listing_requirement_master/"+clientids;
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

<script>
    
//$( "#cmbFurnishedStatus" ).blur(function() {  
//    $("html, body").animate({ scrollTop: 800 }, 600);
//    
//    return false;
//});

 
$( "#txtDate" ).blur(function() {  
       $("#ui-datepicker-div").hide();
    return false;
});


</script>