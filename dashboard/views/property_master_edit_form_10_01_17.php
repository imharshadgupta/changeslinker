<!--==============================Form=================================-->

<form name="editForm" id="editForm" method="post" action="" enctype="multipart/form-data">
<input type="hidden" name="hfPropertyId" id="hfPropertyId" value="<?php echo set_value('hfPropertyId',$PropertyId); ?>"/>
<input type="hidden" name="hfActive" id="hfActive" value="<?php echo set_value('hfActive',$Active); ?>" />
<input type="hidden" name="hfAcceptTermsAndConditions" id="hfAcceptTermsAndConditions" value="<?php echo set_value('hfAcceptTermsAndConditions',$AcceptTermsAndConditions); ?>" />
<div class="inner_form">
<h2>Edit Property Details</h2>
<div class="mfrminner">
<div style="color: #0000FF; text-align:center; font-weight:bold;"><?php echo $this->session->flashdata('msg');?><br /><?php echo $message; ?><br /><?php echo validation_errors(); ?></div>
<fieldset><legend>General Details</legend>

<div class="Txtblks">Date</div>
<div class="fldblks"><input type="text" name="txtDate" id="txtDate" class="fild" style="width:302px;" value="<?php echo set_value('txtDate',$Date); ?>" tabindex="1" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Property Name</div>
<div class="fldblks"><input type="text" name="txtPropertyName" id="txtPropertyName" class="fild" value="<?php echo set_value('txtPropertyName',$PropertyName); ?>" tabindex="2" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Client</div>
<div class="fldblks">
	<select name="cmbClient" id="cmbClient" class="fild chzn-select" onchange="ChangeClient()" tabindex="3">
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

<div class="Txtblks">Branch</div>
<div class="fldblks">
	<select name="cmbBranch" id="cmbBranch" class="fild" tabindex="4">
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
<div class="fldblks"><textarea name="txtPropertyAddress" id="txtPropertyAddress" class="fild" tabindex="9"><?php echo set_value('txtPropertyAddress',$PropertyAddress); ?></textarea></div>
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
				<option value="<?php echo $Property_Cat_Id; ?>" <?php echo set_select("cmbPropertyCategory","$Property_Cat_Id",($PropertyCatId=="$Property_Cat_Id" ? TRUE:'')); ?>><?php echo $Property_Cat_Name; ?></option>
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
				<option value="<?php echo $Property_Type_Id; ?>" <?php echo set_select("cmbPropertyType","$Property_Type_Id",($PropertyTypeId=="$Property_Type_Id" ? TRUE:'')); ?>><?php echo $Property_Type_Name; ?></option>
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
				<option value="<?php echo $Property_Status_Id; ?>" <?php echo set_select("cmbPropertyStatus","$Property_Status_Id",($PropertyStatusId=="$Property_Status_Id" ? TRUE:'')); ?>><?php echo $Property_Status_Name; ?></option>
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
<option value="Sale" <?php echo set_select("cmbPropertyPurpose","Sale",($PropertyPurpose=="Sale" ? TRUE:'')); ?>>Sale</option>
<option value="Rental" <?php echo set_select("cmbPropertyPurpose","Rental",($PropertyPurpose=="Rental" ? TRUE:'')); ?>>Rental</option>
</select></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Property Legal Status</div>
<div class="fldblks">
<select name="cmbPropertyLegalStatus" id="cmbPropertyLegalStatus" class="fild" tabindex="15">
<option value="">Select Property Legal Status</option>
<option value="Commercial" <?php echo set_select("cmbPropertyLegalStatus","Commercial",($PropertyLegalStatus=="Commercial" ? TRUE:'')); ?>>Commercial</option>
<option value="Residential" <?php echo set_select("cmbPropertyLegalStatus","Residential",($PropertyLegalStatus=="Residential" ? TRUE:'')); ?>>Residential</option>
<option value="Industrial" <?php echo set_select("cmbPropertyLegalStatus","Industrial",($PropertyLegalStatus=="Industrial" ? TRUE:'')); ?>>Industrial</option>
<option value="Agricultural" <?php echo set_select("cmbPropertyLegalStatus","Agricultural",($PropertyLegalStatus=="Agricultural" ? TRUE:'')); ?>>Agricultural</option>
</select>
</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Surrounding Brands</div>
<div class="fldblks"><textarea name="txtSurroundingBrands" id="txtSurroundingBrands" class="fild" tabindex="16"><?php echo set_value('txtSurroundingBrands',$SurroundingBrands); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Tagline for Website</div>
<div class="fldblks"><input type="text" name="cPropertyTaglineForWebsite" id="cPropertyTaglineForWebsite" class="fild" value="<?php echo set_value('cPropertyTaglineForWebsite',$PropertyTaglineForWebsite); ?>" tabindex="17" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Property Remarks</div>
<div class="fldblks"><textarea name="txtPropertyRemarks" id="txtPropertyRemarks" class="fild" tabindex="18"><?php echo set_value('txtPropertyRemarks',$PropertyRemarks); ?></textarea></div>
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
<div class="fldblks"><textarea name="txtTotalPlotArea" id="txtTotalPlotArea" class="fild" tabindex="19"><?php echo set_value('txtTotalPlotArea',$TotalPlotArea); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Building Area</div>
<div class="fldblks"><textarea name="txtBuildingArea" id="txtBuildingArea" class="fild" tabindex="20"><?php echo set_value('txtBuildingArea',$BuildingArea); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>
<?php 
if($NoOfFloorsInBuilding==0)
{
    $NoOfFloorsInBuilding = "";
}
?>
<div class="Txtblks">No. of floors in Building</div>
<div class="fldblks"><input type="text" name="txtNoOfFloorsInBuilding" id="txtNoOfFloorsInBuilding" class="fild" value="<?php echo set_value('txtNoOfFloorsInBuilding',$NoOfFloorsInBuilding); ?>" tabindex="21" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Ground Coverage</div>
<div class="fldblks"><textarea name="txtGroundCoverage" id="txtGroundCoverage" class="fild" tabindex="22"><?php echo set_value('txtGroundCoverage',$GroundCoverage); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Floor Offered</div>
<div class="fldblks"><input type="text" name="txtFloorOffered" id="txtFloorOffered" class="fild" value="<?php echo set_value('txtFloorOffered',$FloorOffered); ?>" tabindex="23" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Plate Area Of Floor Offered</div>
<div class="fldblks"><textarea name="txtPlateAreaOfFloorOffered" id="txtPlateAreaOfFloorOffered" class="fild" tabindex="24"><?php echo set_value('txtPlateAreaOfFloorOffered',$PlateAreaOfFloorOffered); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Toilet</div>
<div class="fldblks">
<select name="cmbToilet" id="cmbToilet" class="fild" tabindex="25">
<option value="">Select Toilet</option>
<option value="Public" <?php echo set_select("cmbToilet","Public",($Toilet=="Public" ? TRUE:'')); ?>>Public</option>
<option value="Dedicated" <?php echo set_select("cmbToilet","Dedicated",($Toilet=="Dedicated" ? TRUE:'')); ?>>Dedicated</option>
</select></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Parking</div>
<div class="fldblks">
<select name="cmbParking" id="cmbParking" class="fild" tabindex="26">
<option value="">Select Parking</option>
<option value="Two Wheelers Only" <?php echo set_select("cmbParking","Two Wheelers Only",($Parking=="Two Wheelers Only" ? TRUE:'')); ?>>Two Wheelers Only</option>
<option value="Four Wheelers Only" <?php echo set_select("cmbParking","Four Wheelers Only",($Parking=="Four Wheelers Only" ? TRUE:'')); ?>>Four Wheelers Only</option>
<option value="All Vehicles" <?php echo set_select("cmbParking","All Vehicles",($Parking=="All Vehicles" ? TRUE:'')); ?>>All Vehicles</option>
<option value="No Parking" <?php echo set_select("cmbParking","No Parking",($Parking=="No Parking" ? TRUE:'')); ?>>No Parking</option>
</select></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Carpet Area</div>
<div class="fldblks"><textarea name="txtCarpetArea" id="txtCarpetArea" class="fild" tabindex="27"><?php echo set_value('txtCarpetArea',$CarpetArea); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Built Up Area</div>
<div class="fldblks"><textarea name="txtBuiltUpArea" id="txtBuiltUpArea" class="fild" tabindex="28"><?php echo set_value('txtBuiltUpArea',$BuiltUpArea); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Super Built Up Area</div>
<div class="fldblks"><textarea name="txtSuperBuiltUpArea" id="txtSuperBuiltUpArea" class="fild" tabindex="29"><?php echo set_value('txtSuperBuiltUpArea',$SuperBuiltUpArea); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Frontage</div>
<div class="fldblks"><textarea name="txtFrontage" id="txtFrontage" class="fild" tabindex="30"><?php echo set_value('txtFrontage',$Frontage); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Depth</div>
<div class="fldblks"><input type="text" name="txtDepth" id="txtDepth" class="fild" value="<?php echo set_value('txtDepth',$Depth); ?>" tabindex="31" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Height</div>
<div class="fldblks"><input type="text" name="txtHeight" id="txtHeight" class="fild" value="<?php echo set_value('txtHeight',$Height); ?>" tabindex="32" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Property Furnished Status</div>
<div class="fldblks">
<select name="cmbPropertyFurnishedStatus" id="cmbPropertyFurnishedStatus" class="fild" tabindex="33">
<option value="">Select Furnished Status</option>
<option value="Furnished" <?php echo set_select("cmbPropertyFurnishedStatus","Furnished",($PropertyFurnishedStatus=="Furnished" ? TRUE:'')); ?>>Furnished</option>
<option value="Unfurnished" <?php echo set_select("cmbPropertyFurnishedStatus","Unfurnished",($PropertyFurnishedStatus=="Unfurnished" ? TRUE:'')); ?>>Unfurnished</option>
</select></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Power Load</div>
<div class="fldblks"><textarea name="txtPowerLoad" id="txtPowerLoad" class="fild" tabindex="34"><?php echo set_value('txtPowerLoad',$PowerLoad); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Power Backup</div>
<div class="fldblks"><textarea name="txtPowerBackup" id="txtPowerBackup" class="fild" tabindex="35"><?php echo set_value('txtPowerBackup',$PowerBackup); ?></textarea></div>
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
	<select name="cmbAgreementType" id="cmbAgreementType" class="fild" tabindex="36">
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
				<option value="<?php echo $Agreement_Type_Id; ?>" <?php echo set_select("cmbAgreementType","$Agreement_Type_Id",($AgreementTypeId=="$Agreement_Type_Id" ? TRUE:'')); ?>><?php echo $Agreement_Type_Name; ?></option>
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
<div class="fldblks"><textarea name="txtDemandPerSqFeet" id="txtDemandPerSqFeet" class="fild" tabindex="37"><?php echo set_value('txtDemandPerSqFeet',$DemandPerSqFeet); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Demand (Gross)(INR)</div>
<div class="fldblks"><textarea name="txtDemandGross" id="txtDemandGross" class="fild" tabindex="38"><?php echo set_value('txtDemandGross',$DemandGross); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Security Deposit</div>
<div class="fldblks"><textarea name="txtSecurityDeposit" id="txtSecurityDeposit" class="fild" tabindex="39"><?php echo set_value('txtSecurityDeposit',$SecurityDeposit); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Escalation</div>
<div class="fldblks">
	<select name="cmbEscalation" id="cmbEscalation" class="fild" tabindex="40">
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

<div class="Txtblks">CAM (INR)</div>
<div class="fldblks"><input type="text" name="txtCAM" id="txtCAM" class="fild" value="<?php echo set_value('txtCAM',$CAM); ?>" tabindex="41" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Service Tax on Lessor (INR)</div>
<div class="fldblks"><input type="text" name="txtServiceTaxOnLessor" id="txtServiceTaxOnLessor" class="fild" value="<?php echo set_value('txtServiceTaxOnLessor',$ServiceTaxOnLessor); ?>" tabindex="42" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Service Tax on Lessee (INR)</div>
<div class="fldblks"><input type="text" name="txtServiceTaxOnLessee" id="txtServiceTaxOnLessee" class="fild" value="<?php echo set_value('txtServiceTaxOnLessee',$ServiceTaxOnLessee); ?>" tabindex="43" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Property Tax on Lessor (INR)</div>
<div class="fldblks"><input type="text" name="txtPropertyTaxOnLessor" id="txtPropertyTaxOnLessor" class="fild" value="<?php echo set_value('txtPropertyTaxOnLessor',$PropertyTaxOnLessor); ?>" tabindex="44" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Property Tax on Lessee (INR)</div>
<div class="fldblks"><input type="text" name="txtPropertyTaxOnLessee" id="txtPropertyTaxOnLessee" class="fild" value="<?php echo set_value('txtPropertyTaxOnLessee',$PropertyTaxOnLessee); ?>" tabindex="45" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Stamp Duty & Registration</div>
<div class="fldblks">
<select name="cmbStampDutyAndRegistration" id="cmbStampDutyAndRegistration" class="fild" tabindex="46">
<option value="">Select Stamp Duty & Registration</option>
<option value="50-50" <?php echo set_select("cmbStampDutyAndRegistration","50-50",($StampDutyAndRegistration=="50-50" ? TRUE:'')); ?>>50-50</option>
<option value="On Lesser" <?php echo set_select("cmbStampDutyAndRegistration","On Lesser",($StampDutyAndRegistration=="On Lesser" ? TRUE:'')); ?>>On Lesser</option>
<option value="On Lessee" <?php echo set_select("cmbStampDutyAndRegistration","On Lessee",($StampDutyAndRegistration=="On Lessee" ? TRUE:'')); ?>>On Lessee</option>
</select>
</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Lock In</div>
<div class="fldblks">
<select name="cmbLockIn" id="cmbLockIn" class="fild" tabindex="47">
<option value="">Select Lock In</option>
<option value="Required" <?php echo set_select("cmbLockIn","Required",($LockIn=="Required" ? TRUE:'')); ?>>Required</option>
<option value="Not Required" <?php echo set_select("cmbLockIn","Not Required",($LockIn=="Not Required" ? TRUE:'')); ?>>Not Required</option>
</select>
</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Lock In Duration</div>
<div class="fldblks"><textarea name="txtLockInDuration" id="txtLockInDuration" class="fild" tabindex="48"><?php echo set_value('txtLockInDuration',$LockInDuration); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Rent Free Period(<?php echo $RentFreePeriod; ?>)</div>
<div class="fldblks">
<select name="cmbRentFreePeriod" id="cmbRentFreePeriod" class="fild" tabindex="49">
<option value="">Select Rent Free Period</option>
<option value="45 Days" <?php echo set_select("cmbRentFreePeriod","45 Days",($RentFreePeriod=="45 Days" ? TRUE:'')); ?>>45 Days</option>
<option value="60 Days" <?php echo set_select("cmbRentFreePeriod","60 Days",($RentFreePeriod=="60 Days" ? TRUE:'')); ?>>60 Days</option>
<option value="90 Days" <?php echo set_select("cmbRentFreePeriod","90 Days",($RentFreePeriod=="90 Days" ? TRUE:'')); ?>>90 Days</option>
<option value="120 Days" <?php echo set_select("cmbRentFreePeriod","120 Days",($RentFreePeriod=="120 Days" ? TRUE:'')); ?>>120 Days</option>
<option value="Above 6 Months" <?php echo set_select("cmbRentFreePeriod","Above 6 Months",($RentFreePeriod=="Above 6 Months" ? TRUE:'')); ?>>Above 6 Months</option>
</select>
</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Notice Period</div>
<div class="fldblks"><input type="text" name="txtNoticePeriod" id="txtNoticePeriod" class="fild" value="<?php echo set_value('txtNoticePeriod',$NoticePeriod); ?>" tabindex="50" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Possession Status</div>
<div class="fldblks"><input type="text" name="txtPossessionStatus" id="txtPossessionStatus" class="fild" value="<?php echo set_value('txtPossessionStatus',$PossessionStatus); ?>" tabindex="51" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>


<div class="Txtblks">Current Tenant</div>
<div class="fldblks"><textarea name="txtCurrentTenant" id="txtCurrentTenant" class="fild" tabindex="52"><?php echo set_value('txtCurrentTenant',$CurrentTenant); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Lease up to</div>
<div class="fldblks"><input type="text" name="txtLeaseUpToDate" id="txtLeaseUpToDate" class="fild" style="width:302px;" value="<?php echo set_value('txtLeaseUpToDate',$LeaseUpToDate); ?>" tabindex="53" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Previous Tenant</div>
<div class="fldblks"><textarea name="txtPreviousTenant" id="txtPreviousTenant" class="fild" tabindex="54"><?php echo set_value('txtPreviousTenant',$PreviousTenant); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

</fieldset>


<fieldset><legend>Terms & Condition</legend>

<div class="Txtblks">Agreement Date</div>
<div class="fldblks"><input type="text" name="txtAgreementDate" id="txtAgreementDate" class="fild" style="width:302px;" value="<?php echo set_value('txtAgreementDate',$AgreementDate); ?>" readonly="readonly" tabindex="55" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Agreement Place</div>
<div class="fldblks"><input type="text" name="txtAgreementPlace" id="txtAgreementPlace" class="fild" value="<?php echo set_value('txtAgreementPlace',$AgreementPlace); ?>" tabindex="56" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Person 1 During Agreement</div>
<div class="fldblks"><input type="text" name="txtPerson1DuringAgreement" id="txtPerson1DuringAgreement" class="fild" value="<?php echo set_value('txtPerson1DuringAgreement',$Person1DuringAgreement); ?>" tabindex="57" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Person 2 During Agreement</div>
<div class="fldblks"><input type="text" name="txtPerson2DuringAgreement" id="txtPerson2DuringAgreement" class="fild" value="<?php echo set_value('txtPerson2DuringAgreement',$Person2DuringAgreement); ?>" tabindex="58" /></div>
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
<div class="fldblks"><input type="file" name="txtAgreement" id="txtAgreement" class="fild" tabindex="59" /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks"><div id="uploadedAgreement"></div></div>
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
<div class="fldblks"><textarea name="txtTermsAndConditions" id="txtTermsAndConditions" class="fild" tabindex="60"><?php echo set_value('txtTermsAndConditions',$TermsAndConditions); ?></textarea></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Accept T&C</div>
<div class="fldblks"><input type="checkbox" name="chkAcceptTermsAndConditions" id="chkAcceptTermsAndConditions" tabindex="61" value="1" onclick="ChangeAcceptTermsAndCond()" <?php echo set_checkbox('chkAcceptTermsAndConditions', '1', ($AcceptTermsAndConditions=='1' ? TRUE:'')); ?>  /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

</fieldset>

<!------------------------------------------------------------------------------------------------------------------------------------------------------------->

<fieldset>
<legend>Existing Uploaded Docs</legend>
	<?php 
	if(count($AttachmentRows)>0)
	{
	?>
    <div align="left">
    	<div class="Txtblks">&nbsp;</div>
        <div class="Txtblks" style="text-align:left;"><strong>Title</strong></div>
        <div class="fldblks" style="text-align:left;"><strong>Image</strong></div>
		<div class="fldblks">&nbsp;</div>
        <div class="clear"></div>
    </div>
	<?php 
	}
	else
	{
	?>
    <div align="left">
    	<div class="Txtblks">&nbsp;</div>
        <div class="Txtblks" style="text-align:left;"><strong>No doc exists.</strong></div>
        <div class="fldblks">&nbsp;</div>
        <div class="clear"></div>
    </div>
    <?php 
	}
	?>
	
	<?php 
	$i=1;
	foreach($AttachmentRows as $docrow)
	{
		$PropertyAttachmentId = trim($docrow['iPropertyAttachmentId']);
		$PropertyId = trim($docrow['iPropertyId']);
		$AttachmentTitle = trim($docrow['cAttachmentTitle']);
		$AttachmentFilePath = trim($docrow['cAttachmentFilePath']);
		$AttachmentFileName = trim($docrow['cAttachmentFileName']);
		
		$ImgUrl =  base_url($AttachmentFilePath);
	?>
    
    	<div align="left">
        	<div class="Txtblks">&nbsp;</div>
            <div class="Txtblks" style="text-align:left;"><?php //echo $i; ?><?php echo $AttachmentTitle; ?></div>
            <div class="fldblks" style="text-align:left;"><img src="<?php echo $ImgUrl; ?>" title="<?php echo $AttachmentTitle; ?>" height="50" width="100" /></div>
            <div class="fldblks"><input type='button' value='Delete' id='delButton' onclick="DeleteExistingAttachment('<?php echo $PropertyAttachmentId; ?>','<?php echo $PropertyId; ?>','<?php echo $AttachmentFileName; ?>','<?php echo $AttachmentFilePath; ?>')"></div>
            <div class="clear"></div>
		</div>
	
	<?php
    	$i++;
	}
	?>

</fieldset>

<fieldset>
	<legend>Upload Attachments</legend>
    
    <div class="Txtblks">&nbsp;</div>
    <div class="fldblks">&nbsp;</div>
    <div class="Txtblks">&nbsp;</div>
    <div class="fldblks"><input type='button' value='Add New' id='addButton'>&nbsp;<input type='button' value='Cancel' id='removeButton'></div>
    <div class="clear"></div>
    
    <div id='TextBoxesGroup'>
        <div id="TextBoxDiv1">
        	<div class="Txtblks">
	        	<label>Attach 1 : </label>
            </div>
            <div class="fldblks">
				<input type="hidden" name="hfAttachmentFilePath[]" id="hfAttachment1Path" value="" />
				<input type="hidden" name="hfAttachmentFileName[]" id="hfAttachment1Name"  value="" />
            	<input type="file" name="txtAttachment1" id="txtAttachment1" class="fild" tabindex="61" />
            </div>
            <div class="Txtblks">
	        	<label>Title 1 :  </label>
            </div>
            <div class="fldblks">
            	<input type="textbox" name="txtAttachmentTitle[]" id="txtAttachmentTitle1" class="fild" style="width:200px;" tabindex="61" />&nbsp;<input type="button" name="btnUploadAttachment1" id="btnUploadAttachment1" value="Upload 1" onclick="UploadAttachment('1');" />
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
<div class="fldblks"><input type="checkbox" name="chkActive" id="chkActive" onclick="ChangeActive();" value="1" <?php echo set_checkbox('chkActive', '1', ($Active=='1' ? TRUE:'')); ?> /></div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<!------------------------------------------------------------------------------------------------------------------------------------------------------------->

<div class="submit"><input type="button" name="btnSubmit" class="btn" value="Submit" onclick="FormValidate(this)" />&nbsp;&nbsp;<a href="<?php echo base_url(); ?>index.php/dashboard/dashboard"><input type="button" name="btnBack" id="btnBack" class="btn" value="Back" /></a></div>

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
	
	ChangeClient();
	ChangeActive();
	
	getDistrictByStateId();
	
	$('#btnUploadAgreement').click(function(e) {
		e.preventDefault();
		$.ajaxFileUpload({
			url 			: "<?php echo site_url(); ?>/dashboard/upload_property_agreement_file", 
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
	
	//---------------------------------------------------------------------------------------------------------------------------------------------------------

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
		  alert("No more doc fields to remove");
		  return false;
		}   
	
		counter--;
		
		$("#TextBoxDiv"+counter).remove();
	});	
});	


function UploadAttachment(attachno) 
{
   $("#btnUploadAttachment"+attachno).val("uploading...");
	
    $.ajaxFileUpload({
		url 			: "<?php echo site_url(); ?>/dashboard/upload_property_attachment/"+attachno, 
		secureuri		: false,
		fileElementId	: 'txtAttachment'+attachno,
		dataType		: 'json',
		success	: function (data, status)
		{
			if(data.status != 'error')
			{
			   $("#hfAttachment"+attachno+"Path").val(data.attachment_file_path);
			   $("#hfAttachment"+attachno+"Name").val(data.attachment_file_name);
			   $("#dvAttachment"+attachno+"Name").html('('+data.attachment_file_name+')');
			   $("#dvAttachment"+attachno+"File").css("display", "block");
			   $("#txtAttachment"+attachno).disabled = true;
			   $("#btnUploadAttachment"+attachno).val("Upload"+attachno);
			   alert(data.msg);
			}
		}
	});
}
</script>

<script type="text/javascript">
function DeleteExistingAgreement(PropertyId,AgreementName,AgreementPath)
{
	var confdel = confirm("Are you sure to delete this document...?")
	
	if(confdel)
	{ 
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>index.php/employee/delete_existing_property_agreement",
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
			url: "<?php echo base_url();?>index.php/dashboard/delete_uploaded_property_agreement",
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

<script type="text/javascript">
function DeleteExistingAttachment(AttachmentId,PropertyId,AttachmentName,AttachmentPath)
{
	var confdel = confirm("Are you sure to delete this document...?")
	
	if(confdel)
	{ 
		$.ajax({
			type: "POST",
			url: "<?php echo base_url();?>index.php/dashboard/delete_existing_property_attachment",
			data: "AttachmentId="+AttachmentId+"&PropertyId="+PropertyId+"&AttachmentName="+AttachmentName+"&AttachmentPath="+AttachmentPath,
			success: function(datas){
                            
                            var data = $.trim(datas);
                            
                          
				
				if(data=='1')
				{
					alert("Attachment deleted successfully.");
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
	//alert($("#cmbClient").val());
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
	
	if($("#cmbCity").val()=='')
	{	
		alert("Please Select City");
		$("#cmbCity").focus();
		return false;
	}
	else
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
					
					if(locationid == "<?php echo $LocationId; ?>")
					{
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
		var data = $("#editForm").serialize();
                
                var clientids = '<?php echo $ClientId; ?>';
                
		btn.disabled = true;
		btn.value = 'Submitting...';
		
		var url = "<?php echo base_url(); ?>index.php/dashboard/edit_property_master";
		
		$.post(url,data,function(responsedata,status){
		  
			if(responsedata)
			{
				if(responsedata.status == 1)
				{					
					btn.disabled = false;
					btn.value = 'Submit';
					alert(responsedata.msg);
					var redirecturl = "<?php echo base_url(); ?>index.php/dashboard/listing_property_master/"+clientids;
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
    
   
 
//    $( "#cmbContactPerson" ).blur(function() {  
//    $("html, body").animate({ scrollTop: 400 }, 600);
//    
//    return false;
//});
//
//$( "#cmbPropertyStatus" ).blur(function() { 
//$("html, body").animate({ scrollTop: 700 }, 600);
//
//return false;
//});
//
//$( "#txtFloorOffered" ).blur(function() { 
//$("html, body").animate({ scrollTop: 1300 }, 600);
//
//return false;
//});
    
    
 
 
// 
//$( "#txtDate" ).blur(function() {  
//       $("#ui-datepicker-div").hide();
//    return false;
//});



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
//$("html, body").animate({ scrollTop: 4100 }, 600);
//
//return false;
//});
//
//
//
//$( "#txtAgreementPlace" ).blur(function() { 
//$("html, body").animate({ scrollTop: 3100 }, 600);
//
//return false;
//});
//
//
//
//$( "#txtDepth" ).blur(function() { 
//$("html, body").animate({ scrollTop: 2500 }, 600);
//
//return false;
//});
//
//
//$( "#txtFrontage" ).blur(function() { 
//$("html, body").animate({ scrollTop: 2500 }, 600);
//
//return false;
//});





    
 
$( "#txtDate" ).blur(function() {  
       $("#ui-datepicker-div").hide();
    return false;
});





</script>

