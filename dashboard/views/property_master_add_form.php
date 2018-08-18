<!--====================================================Form=====================================================================-->

<form name="addForm" id="addForm" method="post" action="" enctype="multipart/form-data">
<div class="inner_form">
<h2>Add Property Details</h2>
<div class="mfrminner">
<div style="color: #0000FF; text-align:center; font-weight:bold;"><?php echo $this->session->flashdata('msg');?><br /><?php echo $message; ?><br /><?php echo validation_errors(); ?></div>
<fieldset><legend>General Details</legend>

<div class="Txtblks">Date</div>
<div class="fldblks"><input type="text" name="txtDate" id="txtDate" class="fild" style="width:302px;" value="<?php echo set_value('txtDate'); ?>" tabindex="1" readonly="readonly" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<!--
<div class="Txtblks">Property</div>
<div class="fldblks">
	<select name="cmbProperty" id="cmbProperty" class="fild chzn-select" tabindex="2" onchange="getPropertyOwnerByPropertyId()">
	<option value="">Select Property</option>
	<?php 
	  /*$this->db->where('bActive', 1);
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
		}*/
	?>
	</select>
</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>
-->

<div class="Txtblks">Property Name</div>
<div class="fldblks"><input type="text" name="txtPropertyName" id="txtPropertyName" class="fild" value="<?php echo set_value('txtPropertyName'); ?>" tabindex="2" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Client</div>
<div class="fldblks">
	<select name="cmbClient" id="cmbClient" class="fild chzn-select" onchange="ChangeClient()" tabindex="3">
	<option value="">Select Client</option>
	<?php 
		$this->db->order_by("cClientName", "asc");
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
				<option value="<?php echo $Client_Id; ?>"><?php echo $Client_Name; ?></option>
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

<div class="Txtblks">Branch</div>
<div class="fldblks">
	<select name="cmbBranch" id="cmbBranch" class="fild" tabindex="4">
	<option value="">Select Branch</option>
	<?php 
		$this->db->order_by('cBranchName', 'asc');
		$this->db->where('bActive', 1);
		$this->db->where('bDelete', 0);
		$sql =  $this->db->get('branch_master');  
		if($sql)
		{
			if(($sql->num_rows) > 0)
			{
				$rows = $sql->result_array();
				
				foreach($rows as $row): 
				
				$Branch_Id = trim($row['iBranchId']);
				$Branch_Name = trim($row['cBranchName']);
			?>
				<option value="<?php echo $Branch_Id; ?>"><?php echo $Branch_Name; ?></option>
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
	<select name="cmbState" id="cmbState" class="fild" tabindex="5" onchange="getDistrictByStateId()">
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
				<option value="<?php echo $State_Id; ?>"><?php echo $State_Name; ?></option>
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
	<select name="cmbDistrict" id="cmbDistrict" class="fild" tabindex="6" onchange="getCityByDistrictIdAndStateId()">
	<option value="">Select District</option>
	</select>
</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">City</div>
<div class="fldblks">
	<select name="cmbCity" id="cmbCity" class="fild" tabindex="7" onchange="getLocationByCityIdAndDistrictIdAndStateId()">
	<option value="">Select City</option>
	</select>
</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Location</div>
<div class="fldblks">
	<select name="cmbLocation" id="cmbLocation" class="fild" tabindex="8">
	<option value="">Select Location</option>
	</select>
</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Property Address</div>
<div class="fldblks"><textarea name="txtPropertyAddress" id="txtPropertyAddress" class="fild" tabindex="9"><?php echo set_value('txtPropertyAddress'); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Source</div>
<div class="fldblks">
	<select name="cmbSource" id="cmbSource" class="fild" tabindex="10">
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
				<option value="<?php echo $Source_Id; ?>"><?php echo $Source_Name; ?></option>
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
	<select name="cmbPropertyCategory" id="cmbPropertyCategory" class="fild" tabindex="11">
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
				
				$Property_Cat_Id = trim($row['iPropertyCategoryId']);
				$Property_Cat_Name = trim($row['cPropertyCategoryName']);
			?>
				<option value="<?php echo $Property_Cat_Id; ?>"><?php echo $Property_Cat_Name; ?></option>
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

<div class="Txtblks">Property Type</div>
<div class="fldblks">
	<select name="cmbPropertyType" id="cmbPropertyType" class="fild" tabindex="12">
	<option value="">Select Property Type</option>
	<?php 
		$this->db->order_by('cPropertyTypeName', 'asc');
		$this->db->where('bActive', 1);
		$this->db->where('bDelete', 0);
		$sql =  $this->db->get('property_type_master');  
		if($sql)
		{
			if(($sql->num_rows) > 0)
			{
				$rows = $sql->result_array();
				
				foreach($rows as $row): 
				
				$Property_Type_Id = trim($row['iPropertyTypeId']);
				$Property_Type_Name = trim($row['cPropertyTypeName']);
			?>
				<option value="<?php echo $Property_Type_Id; ?>"><?php echo $Property_Type_Name; ?></option>
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

<div class="Txtblks">Property Status</div>
<div class="fldblks">
	<select name="cmbPropertyStatus" id="cmbPropertyStatus" class="fild" tabindex="13">
	<option value="">Select Property Status</option>
	<?php 
		$this->db->order_by('cPropertyStatusName', 'asc');
		$this->db->where('bActive', 1);
		$this->db->where('bDelete', 0);
		$sql =  $this->db->get('property_status_master');  
		if($sql)
		{
			if(($sql->num_rows) > 0)
			{
				$rows = $sql->result_array();
				
				foreach($rows as $row): 
				
				$Property_Status_Id = trim($row['iPropertyStatusId']);
				$Property_Status_Name = trim($row['cPropertyStatusName']);
			?>
				<option value="<?php echo $Property_Status_Id; ?>"><?php echo $Property_Status_Name; ?></option>
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

<div class="Txtblks">Property Purpose</div>
<div class="fldblks">
<select name="cmbPropertyPurpose" id="cmbPropertyPurpose" class="fild" tabindex="14">
<option value="">Select Property Purpose</option>
<option value="Sale">Sale</option>
<option value="Rental">Rental</option>
</select></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Property Legal Status</div>
<div class="fldblks">
<select name="cmbPropertyLegalStatus" id="cmbPropertyLegalStatus" class="fild" tabindex="15">
<option value="">Select Property Legal Status</option>
<option value="Commercial">Commercial</option>
<option value="Residential">Residential</option>
<option value="Industrial">Industrial</option>
<option value="Agricultural">Agricultural</option>
</select>
</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Availability Status</div>
<div class="fldblks">
<select name="cmbAvailabilityStatus" id="cmbAvailabilityStatus" class="fild" tabindex="16">
<option value="">Select Availability Status</option>
<option value="Available">Available</option>
<option value="Not Available">Not Available</option>
</select>
</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>


<div class="Txtblks">Surrounding Brands</div>
<div class="fldblks"><textarea name="txtSurroundingBrands" id="txtSurroundingBrands" class="fild" tabindex="17"><?php echo set_value('txtSurroundingBrands'); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Tagline for Website</div>
<div class="fldblks"><input type="text" name="txtPropertyTaglineForWebsite" id="txtPropertyTaglineForWebsite" class="fild" value="<?php echo set_value('txtPropertyTaglineForWebsite'); ?>" tabindex="18" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Property Remarks</div>
<div class="fldblks"><textarea name="txtPropertyRemarks" id="txtPropertyRemarks" class="fild" tabindex="19"><?php echo set_value('txtPropertyRemarks'); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

</fieldset>

<fieldset><legend>Specifications</legend>

<div class="Txtblks">Total Plot Area</div>
<div class="fldblks"><textarea name="txtTotalPlotArea" id="txtTotalPlotArea" class="fild" tabindex="20"><?php echo set_value('txtTotalPlotArea'); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Building Area</div>
<div class="fldblks"><textarea name="txtBuildingArea" id="txtBuildingArea" class="fild" tabindex="21"><?php echo set_value('txtBuildingArea'); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">No. of floors in Building</div>
<div class="fldblks"><input type="text" name="txtNoOfFloorsInBuilding" id="txtNoOfFloorsInBuilding" class="fild" value="<?php echo set_value('txtNoOfFloorsInBuilding'); ?>" tabindex="22" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Ground Coverage</div>
<div class="fldblks"><textarea name="txtGroundCoverage" id="txtGroundCoverage" class="fild" tabindex="23"><?php echo set_value('txtGroundCoverage'); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Floor Offered</div>
<div class="fldblks"><input type="text" name="txtFloorOffered" id="txtFloorOffered" class="fild" value="<?php echo set_value('txtFloorOffered'); ?>" tabindex="24" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Plate Area Of Floor Offered</div>
<div class="fldblks"><textarea name="txtPlateAreaOfFloorOffered" id="txtPlateAreaOfFloorOffered" class="fild" tabindex="25"><?php echo set_value('txtPlateAreaOfFloorOffered'); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Toilet</div>
<div class="fldblks">
<select name="cmbToilet" id="cmbToilet" class="fild" tabindex="26">
<option value="">Select Toilet</option>
<option value="Public">Public</option>
<option value="Dedicated">Dedicated</option>
</select></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Parking</div>
<div class="fldblks">
<select name="cmbParking" id="cmbParking" class="fild" tabindex="27">
<option value="">Select Parking</option>
<option value="Two Wheelers Only">Two Wheelers Only</option>
<option value="Four Wheelers Only">Four Wheelers Only</option>
<option value="All Vehicles">All Vehicles</option>
<option value="No Parking">No Parking</option>
</select></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Carpet Area</div>
<div class="fldblks"><textarea name="txtCarpetArea" id="txtCarpetArea" class="fild" tabindex="28"><?php echo set_value('txtCarpetArea'); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Built Up Area</div>
<div class="fldblks"><textarea name="txtBuiltUpArea" id="txtBuiltUpArea" class="fild" tabindex="29"><?php echo set_value('txtBuiltUpArea'); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Super Built Up Area</div>
<div class="fldblks"><textarea name="txtSuperBuiltUpArea" id="txtSuperBuiltUpArea" class="fild" tabindex="30"><?php echo set_value('txtSuperBuiltUpArea'); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Frontage</div>
<div class="fldblks"><textarea name="txtFrontage" id="txtFrontage" class="fild" tabindex="31"><?php echo set_value('txtFrontage'); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Depth</div>
<div class="fldblks"><textarea name="txtDepth" id="txtDepth" class="fild" tabindex="32"><?php echo set_value('txtDepth'); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Height</div>
<div class="fldblks"><input type="text" name="txtHeight" id="txtHeight" class="fild" tabindex="33" value="<?php echo set_value('txtHeight'); ?>" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Property Furnished Status</div>
<div class="fldblks">
<select name="cmbPropertyFurnishedStatus" id="cmbPropertyFurnishedStatus" class="fild" tabindex="34">
<option value="">Select Furnished Status</option>
<option value="Furnished">Furnished</option>
<option value="Unfurnished">Unfurnished</option>
</select>
</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Power Load</div>
<div class="fldblks"><textarea name="txtPowerLoad" id="txtPowerLoad" class="fild" tabindex="35"><?php echo set_value('txtPowerLoad'); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Power Backup</div>
<div class="fldblks"><textarea name="txtPowerBackup" id="txtPowerBackup" class="fild" tabindex="36"><?php echo set_value('txtPowerBackup'); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>


<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

</fieldset>

<fieldset><legend>Commercials</legend>

<div class="Txtblks">Agreement Type</div>
<div class="fldblks">
	<select name="cmbAgreementType" id="cmbAgreementType" class="fild" tabindex="37">
	<option value="">Select Agreement Type</option>
	<?php 
		$this->db->order_by('cAgreementTypeName', 'asc');
		$this->db->where('bActive', 1);
		$this->db->where('bDelete', 0);
		$sql =  $this->db->get('agreement_type_master');  
		if($sql)
		{
			if(($sql->num_rows) > 0)
			{
				$rows = $sql->result_array();
				
				foreach($rows as $row): 
				
				$Agreement_Type_Id = trim($row['iAgreementTypeId']);
				$Agreement_Type_Name = trim($row['cAgreementTypeName']);
			?>
				<option value="<?php echo $Agreement_Type_Id; ?>"><?php echo $Agreement_Type_Name; ?></option>
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

<div class="Txtblks">Demand (Per Sq.Feet)(INR)</div>
<div class="fldblks"><textarea name="txtDemandPerSqFeet" id="txtDemandPerSqFeet" class="fild" tabindex="38"><?php echo set_value('txtDemandPerSqFeet'); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Demand (Gross)(INR)</div>
<div class="fldblks"><textarea name="txtDemandGross" id="txtDemandGross" class="fild" tabindex="39"><?php echo set_value('txtDemandGross'); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Security Deposit</div>
<div class="fldblks"><textarea name="txtSecurityDeposit" id="txtSecurityDeposit" class="fild" tabindex="40"><?php echo set_value('txtSecurityDeposit'); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Escalation</div>
<div class="fldblks">
	<select name="cmbEscalation" id="cmbEscalation" class="fild" tabindex="41">
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
				<option value="<?php echo $Escalation_Id; ?>"><?php echo $Escalation_Name; ?></option>
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

<div class="Txtblks">CAM (INR)</div>
<div class="fldblks"><input type="text" name="txtCAM" id="txtCAM" class="fild" value="<?php echo set_value('txtCAM'); ?>" tabindex="42" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Service Tax on Lessor (INR)</div>
<div class="fldblks"><input type="text" name="txtServiceTaxOnLessor" id="txtServiceTaxOnLessor" class="fild" value="<?php echo set_value('txtServiceTaxOnLessor'); ?>" tabindex="43" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Service Tax on Lessee (INR)</div>
<div class="fldblks"><input type="text" name="txtServiceTaxOnLessee" id="txtServiceTaxOnLessee" class="fild" value="<?php echo set_value('txtServiceTaxOnLessee'); ?>" tabindex="44" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Property Tax on Lessor (INR)</div>
<div class="fldblks"><input type="text" name="txtPropertyTaxOnLessor" id="txtPropertyTaxOnLessor" class="fild" value="<?php echo set_value('txtPropertyTaxOnLessor'); ?>" tabindex="45" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Property Tax on Lessee (INR)</div>
<div class="fldblks"><input type="text" name="txtPropertyTaxOnLessee" id="txtPropertyTaxOnLessee" class="fild" value="<?php echo set_value('txtPropertyTaxOnLessee'); ?>" tabindex="46" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Stamp Duty & Registration</div>
<div class="fldblks">
<select name="cmbStampDutyAndRegistration" id="cmbStampDutyAndRegistration" class="fild" tabindex="47">
<option value="">Select Stamp Duty & Registration</option>
<option value="50-50">50-50</option>
<option value="On Lesser">On Lesser</option>
<option value="On Lessee">On Lessee</option>
</select>
</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Lock In</div>
<div class="fldblks">
<select name="cmbLockIn" id="cmbLockIn" class="fild" tabindex="48">
<option value="">Select Lock In</option>
<option value="Required">Required</option>
<option value="Not Required">Not Required</option>
</select>
</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Lock In Duration</div>
<div class="fldblks"><textarea name="txtLockInDuration" id="txtLockInDuration" class="fild" tabindex="49"><?php echo set_value('txtLockInDuration'); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Rent Free Period</div>
<div class="fldblks">
<select name="cmbRentFreePeriod" id="cmbRentFreePeriod" class="fild" tabindex="50">
<option value="">Select Rent Free Period</option>
<option value="45 Days">45 Days</option>
<option value="60 Days">60 Days</option>
<option value="90 Days">90 Days</option>
<option value="120 Days">120 Days</option>
<option value="Above 6 Months">Above 6 Months</option>
</select>
</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Notice Period</div>
<div class="fldblks"><input type="text" name="txtNoticePeriod" id="txtNoticePeriod" class="fild" value="<?php echo set_value('txtNoticePeriod'); ?>" tabindex="51" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Possession Status</div>
<div class="fldblks"><input type="text" name="txtPossessionStatus" id="txtPossessionStatus" class="fild" value="<?php echo set_value('txtPossessionStatus'); ?>" tabindex="52" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>



<div class="Txtblks">Current Tenant</div>
<div class="fldblks"><textarea name="txtCurrentTenant" id="txtCurrentTenant" class="fild" tabindex="53"><?php echo set_value('txtCurrentTenant'); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Lease up to</div>
<div class="fldblks"><input type="text" name="txtLeaseUpToDate" id="txtLeaseUpToDate" class="fild" style="width:302px;" value="<?php echo set_value('txtLeaseUpToDate'); ?>" tabindex="54" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Previous Tenant</div>
<div class="fldblks"><textarea name="txtPreviousTenant" id="txtPreviousTenant" class="fild" tabindex="55"><?php echo set_value('txtPreviousTenant'); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

</fieldset>

<fieldset><legend>Terms & Condition</legend>

<div class="Txtblks">Agreement Date</div>
<div class="fldblks"><input type="text" name="txtAgreementDate" id="txtAgreementDate" class="fild" style="width:302px;" value="<?php echo set_value('txtAgreementDate'); ?>" readonly="readonly" tabindex="56" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Agreement Place</div>
<div class="fldblks"><input type="text" name="txtAgreementPlace" id="txtAgreementPlace" class="fild" value="<?php echo set_value('txtAgreementPlace'); ?>" tabindex="57" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Person 1 During Agreement</div>
<div class="fldblks"><input type="text" name="txtPerson1DuringAgreement" id="txtPerson1DuringAgreement" class="fild" value="<?php echo set_value('txtPerson1DuringAgreement'); ?>" tabindex="58" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Person 2 During Agreement</div>
<div class="fldblks"><input type="text" name="txtPerson2DuringAgreement" id="txtPerson2DuringAgreement" class="fild" value="<?php echo set_value('txtPerson2DuringAgreement'); ?>" tabindex="59" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Attach Agreement Copy</div>
					 <input type="hidden" name="hfAgreementFilePath" id="hfAgreementFilePath" value="" />
					 <input type="hidden" name="hfAgreementFileName" id="hfAgreementFileName" value="" />
<div class="fldblks"><input type="file" name="txtAgreement" id="txtAgreement" class="fild" tabindex="60" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks" id="dvAgreementFile" style="display:none; font-size:10px; text-align:left; border:0px solid blue;">
	<div style="font-size:12px; font-weight:bold; float:left; width:25%; border:0px solid red;">Uploaded :</div>
	<div id="dvAgreementName" style="font-size:12px; float:left; width:60%; border:0px solid red;"> </div>
	<div style="float:left; width:15%; border:0px solid red;"><a href="#" onclick="DeleteAgreement();"><img src="<?php echo base_url(); ?>images/remove.png" align="center" height="18" width="18" /></a></div>
</div>
<div class="clear"></div>

<div class="Txtblks">&nbsp;</div>
<div class="fldblks"><input type="button" name="btnUploadAgreement" id="btnUploadAgreement" value="Upload Agreement" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Paste Terms and Conditions here</div>
<div class="fldblks"><textarea name="txtTermsAndConditions" id="txtTermsAndConditions" class="fild" tabindex="61"><?php echo set_value('txtTermsAndConditions'); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Accept T&C</div>
<div class="fldblks"><input type="checkbox" name="chkAcceptTermsAndConditions" id="chkAcceptTermsAndConditions" tabindex="62" value="1" <?php echo set_checkbox('chkAcceptTermsAndConditions', '1'); ?> /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

</fieldset>

<fieldset>
	<legend>Upload Attachments</legend>
    
    <div class="Txtblks">&nbsp;</div>
    <div class="fldblks">&nbsp;</div>
    <div class="Txtblks">&nbsp;</div>
    <div class="fldblks"><input type='button' value='Add New' id='addButton'>&nbsp;<input type='button' value='Cancel' id='removeButton'></div>
    <div class="clear"></div>
	
	<div class="Txtblks">&nbsp;</div>
    <div class="fldblks"><strong>(Permitted Max. File Size 500 KB)</strong></div>
    <div class="Txtblks">&nbsp;</div>
    <div class="fldblks">&nbsp;</div>
    <div class="clear"></div>
    
    <div id='TextBoxesGroup'>
        <div id="TextBoxDiv1">
        	<div class="Txtblks">
	        	<label>Attach 1 : </label>
            </div>
            <div class="fldblks">
				<input type="hidden" name="hfAttachmentFilePath[]" id="hfAttachment1Path" value="" />
				<input type="hidden" name="hfAttachmentFileName[]" id="hfAttachment1Name"  value="" />
            	<input type="file" name="txtAttachment1" id="txtAttachment1" class="fild" tabindex="63" />
            </div>
            <div class="Txtblks">
	        	<label>Title 1 :  </label>
            </div>
            <div class="fldblks">
            	<input type="textbox" name="txtAttachmentTitle[]" id="txtAttachmentTitle1" class="fild" style="width:200px;" tabindex="64" />&nbsp;<input type="button" name="btnUploadAttachment1" id="btnUploadAttachment1" value="Upload 1" onclick="UploadAttachment('1');" />
            </div>
            <div class="clear"></div>
			
			<div class="Txtblks">&nbsp;</div>
			<div class="fldblks">&nbsp;</div>
			<div class="Txtblks">&nbsp;</div>
			<div class="fldblks" id="dvAttachment1File" style="display:none; font-size:10px; text-align:left; border:0px solid blue;">
				<div style="font-size:12px; font-weight:bold; float:left; width:25%; border:0px solid red; ">Uploaded 1 :</div>
				<div id="dvAttachment1Name" style="font-size:12px; float:left; width:60%; border:0px solid red;"> </div>
				<div style="float:left; width:15%; border:0px solid red;"><a href="#" onclick="DeleteAttachment('1');"><img src="<?php echo base_url(); ?>images/remove.png" align="center" height="18" width="18" /></a></div>
			</div>
			<div class="clear"></div>

        </div>
    </div>
	
	<div class="Txtblks">&nbsp;</div>
	<div class="fldblks"><!--<input type="button" name="btnUploadAttachment" id="btnUploadAttachment" value="Upload" onclick="UploadAttach();" />--></div>
	<div class="Txtblks">&nbsp;</div>
	<div class="fldblks">&nbsp;</div>
	<div class="clear"></div>

</fieldset>

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

<div class="submit"><input type="button" name="btnSubmit" class="btn" value="Submit" onclick="FormValidate(this);" />&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/dashboard/dashboard"><input type="button" name="btnBack" id="btnBack" class="btn" value="Back" /></a></div>

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
	
	var Mydate = new Date();  
	
	var day = Mydate.getDate();
	var dayval =  day < 10 ? '0' + day : '' + day;
	
	var month = Mydate.getMonth() + 1;
	var monval =  month < 10 ? '0' + month : '' + month;

	var newdat = (monval +"/"+ dayval+"/"+Mydate.getFullYear());
	var splitdt = newdat.split("/");
	
	var defaultcurrdt = splitdt[1]+"/"+splitdt[0]+"/"+splitdt[2];
	$("#txtDate").val(defaultcurrdt);
	
	$("#txtLeaseUpToDate").datepicker({ 
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

	$('#btnUploadAgreement').click(function(e) {
		e.preventDefault();
		
		$("#btnUploadAgreement").val("uploading...");
		
		$.ajaxFileUpload({
			url 			: "<?php echo site_url(); ?>/dashboard/upload_property_agreement_file", 
			secureuri		:false,
			fileElementId	:'txtAgreement',
			dataType		: 'json',
			success	: function (data, status)
			{
				if(data.status != 'error')
				{
					$("#hfAgreementFilePath").val(data.agreement_file_path);
				    $("#hfAgreementFileName").val(data.agreement_file_name);
				    $("#dvAgreementName").html('('+data.agreement_file_name+')');
				    $("#dvAgreementFile").css("display", "block");
				    $("#txtAgreement").disabled = true;
				    $("#btnUploadAgreement").val("Upload Agreement");
				    alert(data.msg);	
				}
				else
				{
					alert(data.msg);
					return false;
				}
			}
		});
		return false;
	});
	
  //------------------------------------------------------------------------------------------------------------------------------------------

	var counter = 2;
  
	$("#addButton").click(function () {
  
	  /*if(counter>10){
			alert("Only 10 doc fields are allowed");
			return false;
		}*/   
	  		
        var newTextBoxDiv = $(document.createElement('div')).attr("id", 'TextBoxDiv'+counter); 
	   
	    newTextBoxDiv.after().html('<div class="Txtblks"><label>Attach '+counter+' : </label></div>'+ '<div class="fldblks"><input type="hidden" name="hfAttachmentFilePath[]" id="hfAttachment'+counter+'Path" /><input type="hidden" name="hfAttachmentFileName[]" id="hfAttachment'+counter+'Name" /><input type="file" name="txtAttachment'+counter+'" id="txtAttachment'+counter+'" class="fild" value="" /></div><div class="Txtblks"><label>Title '+counter+ ' : </label></div><div class="fldblks"><input type="text" name="txtAttachmentTitle[]" id="txtAttachmentTitle'+counter+'" class="fild" style="width:200px;" value="" />&nbsp;<input type="button" name="btnUploadAttachment'+counter+'" id="btnUploadAttachment'+counter+'" value="Upload '+counter+'" onclick="UploadAttachment('+counter+')" /></div><div class="clear"></div><div class="Txtblks">&nbsp;</div><div class="fldblks">&nbsp;</div><div class="Txtblks">&nbsp;</div><div class="fldblks" id="dvAttachment'+counter+'File" style="display:none; font-size:10px; text-align:left; border:0px solid blue;"><div style="font-size:12px; font-weight:bold; float:left; width:25%; border:0px solid red; ">Uploaded '+counter+' :</div><div id="dvAttachment'+counter+'Name" style="font-size:12px; float:left; width:60%; border:0px solid red;"> </div><div style="float:left; width:15%; border:0px solid red;"><a href="#" onclick="DeleteAttachment('+counter+');"><img src="<?php echo base_url(); ?>images/remove.png" align="center" height="18" width="18" /></a></div></div><div class="clear"></div>');
	  
	    newTextBoxDiv.appendTo("#TextBoxesGroup");
    	
		counter++;
     });
  
	$("#removeButton").click(function () {

		if(counter==2){
		  alert("No more attachment fields to remove");
		  return false;
		}   
	
		counter--;
		
		$("#TextBoxDiv"+counter).remove();
	});
});	
</script>

<script type="text/javascript" language="javascript">
function UploadAttachment(attachno) 
{
    $.ajaxFileUpload({
		url 			: "<?php echo site_url(); ?>/dashboard/upload_property_attachment/"+attachno, 
		secureuri		: false,
		fileElementId	: 'txtAttachment'+attachno,
		dataType		: 'json',
		success	: function (data, status)
		{
			if(data.status != 'error')
			{
			   $("#btnUploadAttachment"+attachno).val("uploading...");
			   $("#hfAttachment"+attachno+"Path").val(data.attachment_file_path);
			   $("#hfAttachment"+attachno+"Name").val(data.attachment_file_name);
			   $("#dvAttachment"+attachno+"Name").html('('+data.attachment_file_name+')');
			   $("#dvAttachment"+attachno+"File").css("display", "block");
			   $("#txtAttachment"+attachno).disabled = true;
			   $("#btnUploadAttachment"+attachno).val("Upload"+attachno);
			   alert(data.msg);
			}
			else
			{
				alert(data.msg);
				return false;
			}	
		}
	});
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
			url: "<?php echo base_url();?>index.php/dashboard/delete_uploaded_property_agreement",
			data: "AgreementName="+$("#hfAgreementFileName").val()+"&AgreementPath="+$("#hfAgreementFilePath").val(),
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

<script type="text/javascript">
function DeleteAttachment(attachno)
{
	var confdel = confirm("Are you sure to delete this document...?")
	
	if(confdel)
	{ 	
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>index.php/dashboard/delete_uploaded_property_attachment",
			data: "AttachmentName="+$("#hfAttachment"+attachno+"Name").val()+"&AttachmentPath="+$("#hfAttachment"+attachno+"Path").val(),
			success: function(data){
			
			    if(data=='TRUE')
				{
				 //alert("Attachment deleted successfully.");
				   $("#hfAttachment"+attachno+"Path").val('');
				   $("#hfAttachment"+attachno+"Name").val('');
				   $("#dvAttachment"+attachno+"Name").html('');
				   $("#dvAttachment"+attachno+"File").css("display", "none");
				   $("#txtAttachment"+attachno).disabled=false;
				   $("#txtAttachment"+attachno).val('');
				   $("#txtAttachment"+attachno).focus();
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
function ChangeContactPerson()
{
	if($("#cmbContactPerson").val()!='')
	{
		var url = "<?php echo base_url(); ?>index.php/dashboard/getcontactdetailsbycontactperson";
		
		$.post(url,{cmbClient:$("#cmbClient").val(),cmbContactPerson:$("#cmbContactPerson").val()},function(responsedata,status){	
			
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
function getLocationByCityIdAndDistrictIdAndStateId()
{
	$('#cmbLocation').children('option:not(:first)').remove();
	
	if($("#cmbCity").val()=='')
	{	
		alert("Please Select City");
		$("#cmbCity").focus();
		return false;
	}
	else
	{
		$.ajax({
			type: "POST",
			dataType: 'json',
			url: "<?php echo base_url();?>index.php/dashboard/getlocationbystateanddistrictandcity",
			data: "cmbState="+$("#cmbState").val()+"&cmbDistrict="+$("#cmbDistrict").val()+"&cmbCity="+$("#cmbCity").val(),
			success: function(details){
				
				$('#cmbLocation').children('option:not(:first)').remove();
				
				$.each(details,function(locationid,locationname) {	 
				
					var opt = $('<option />'); 									
					opt.val(locationid);
					opt.text(locationname);
					$('#cmbLocation').append(opt); 		    			
				});
			}
		});
	}
}	
</script>

<script type="text/javascript" language="javascript">
function FormValidate(btn)
{
    var clientid = $("#cmbClient").val();
    
    if($("#txtDate").val()=='')
    {	
        alert("Please select Date");
        $("#txtDate").focus();
        return false;
    }
	else if($("#txtPropertyName").val()=='')
    {	
        alert("Please enter Property Name");
        $("#txtPropertyName").focus();
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
        btn.disabled = true;
		btn.value = 'Submitting...';
        
		var data = $("#addForm").serialize();
		
		var url = "<?php echo base_url(); ?>index.php/dashboard/add_property_master";
		
		$.post(url,data,function(responsedata,status){
			
			btn.disabled = true;
			btn.value = 'Submitting...';
		  
		   //alert(responsedata.msg);
		  
		    if(responsedata)
			{
				if(responsedata.status == 1)
				{					
					btn.disabled = false;
					btn.value = 'Submit';
					alert(responsedata.msg);
					var redirecturl = "<?php echo base_url(); ?>index.php/dashboard/listing_property_master/"+clientid;
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
 
// $( "#txtPropertyTaglineForWebsite" ).blur(function() {  
//    $("html, body").animate({ scrollTop: 1100 }, 600);
//    
//    return false;
//});
// 
//    $( "#cmbContactPerson" ).blur(function() {  
//    $("html, body").animate({ scrollTop: 400 }, 600);
//    
//    return false;
//});
//
//$( "#cmbPropertyStatus" ).blur(function() { 
//$("html, body").animate({ scrollTop: 900 }, 600);
//
//return false;
//});
//
//$( "#cmbPropertyStatus" ).blur(function() { 
//$("html, body").animate({ scrollTop: 900 }, 600);
//
//return false;
//});
//
//
//
//
//$( "#txtPreviousTenant" ).blur(function() { 
//$("html, body").animate({ scrollTop: 3500 }, 600);
//
//return false;
//});
//
//
//$( "#txtPropertyTaxOnLessee" ).blur(function() { 
//$("html, body").animate({ scrollTop: 3000 }, 600);
//
//return false;
//});
//
//$( "#txtFloorOffered" ).blur(function() { 
//$("html, body").animate({ scrollTop: 1900 }, 600);
//
//return false;
//});
//
//
//
//$( "#txtCAM" ).blur(function() { 
//$("html, body").animate({ scrollTop: 2500 }, 600);
//
//return false;
//});

$( "#txtDate" ).blur(function() {  
       $("#ui-datepicker-div").hide();
    return false;
});

</script>