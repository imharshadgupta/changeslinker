<script type="text/javascript" language="javascript">
$(document).ready(function() {
	var oTable = $('#example').dataTable({
		"bJQueryUI": true,
		"aaSorting":[[0, "asc"]],
		"sPaginationType": "full_numbers"
	});
});
</script>

<div class="inner_form">
<h2>Search</h2>
<form name="searchForm" id="searchForm" method="post" target="_blank" action="<?php echo base_url(); ?>index.php/dashboard/propertysearchprintreport">
<div class="mfrminner">
	<div class="Txtblks">State</div>
	<div class="fldblks">
		<select name="cmbState" id="cmbState" class="fild chzn-select" tabindex="1" onchange="getCityByStateId()">
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
					<option value="<?php echo $State_Id; ?>" <?php if(isset($StateId)){ echo set_select("cmbState","$State_Id",($StateId=="$State_Id" ? TRUE:'')); } ?>><?php echo $State_Name; ?></option>
				<?php
					endforeach;	
				}
			}
		?>
		</select>
	</div>
	<div class="Txtblks">City</div>
	<div class="fldblks">
		<select name="cmbCity" id="cmbCity" class="fild chzn-select" tabindex="2">
		<option value="">Select City</option>
		</select>
	</div>
	<div class="clear"></div>
	
	<div class="Txtblks">Property Category</div>
	<div class="fldblks">
		<select name="cmbPropertyCategory" id="cmbPropertyCategory" class="fild chzn-select" tabindex="3">
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
		<select name="cmbPropertyType" id="cmbPropertyType" class="fild chzn-select" tabindex="4">
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
	<div class="fldblks"><input type='button' class="btn" value="Submit" onclick="ValidateSearch();" /></div>
	<div class="clear"></div>

	<div class="Txtblks">&nbsp;</div>
    <div class="fldblks">&nbsp;</div>
    <div class="Txtblks">&nbsp;</div>
    <div class="fldblks">&nbsp;</div>
    <div class="clear"></div>
	
	<div class="table_wrap">	
		
		<?php
		if(isset($query))
		{
		?>
		<div class="tbls_wrp">		
		<div class="tbls">   
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
            <thead>
            <tr>
				<th>SNo.</th>
				<th>Property Name</th>
				<th>Client</th>
				<th>State</th>
				<th>City</th>
				<th>Location</th>
				<th>Property Category</th>
				<th>Property Type</th>
				<th>Property Status</th>
				<th>View</th>
            </tr>
            </thead>
            <tbody>
			<?php								
			$SNo=1;
			foreach($query->result_array() as $row)
			{ 
				$PropertyId = trim($row['iPropertyId']);
				$PropertyName = trim($row['cPropertyName']);
				$ClientName = trim($row['cClientName']);
				$StateName = trim($row['cStateName']);
				$DistrictName = trim($row['cDistrictName']);
				$CityName = trim($row['cCityName']);
				$LocationName = trim($row['cLocationName']);
				$PropertyCategoryName = trim($row['cPropertyCategoryName']);
				$PropertyTypeName = trim($row['cPropertyTypeName']);
				$PropertyStatusName = trim($row['cPropertyStatusName']);
			?>
				<tr class="gradeA">
					<td style="text-align:center;"><?php echo $SNo; ?>.</td>
					<td style="text-align:left;"><?php echo $PropertyName; ?></td>
					<td style="text-align:left;"><?php echo $ClientName; ?></td>
					<td style="text-align:left;"><?php echo $StateName; ?></td>
					<td style="text-align:left;"><?php echo $CityName; ?></td>
					<td style="text-align:left;"><?php echo $LocationName; ?></td>
					<td style="text-align:left;"><?php echo $PropertyCategoryName; ?></td>
					<td style="text-align:left;"><?php echo $PropertyTypeName; ?></td>
					<td style="text-align:left;"><?php echo $PropertyStatusName; ?></td>
					<td align="center"><a class="various" data-fancybox-type="iframe" href="<?php echo base_url(); ?>index.php/dashboard/viewproperty/<?php echo $PropertyId; ?>"><span class="ui-icon ui-icon-pencil"></span></a></td>
				</tr>            
			<?php 
				$SNo++;
			} 				
			?>
            </tbody>
            </table>   
			</div>  
					
			<div style="height:2px;"></div>
			</div>
		<?php 
		} 
		?>	
		
		</div> 
	</div>
	<div class="clear"></div>
</div>

</form>

<script type="text/javascript" language="javascript">
function getCityByStateId()
{
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
			url: "<?php echo base_url();?>index.php/dashboard/getcitybystate",
			data: "cmbState="+$("#cmbState").val(),
			success: function(details){
				
				$('#cmbCity').children('option:not(:first)').remove();
				
				$.each(details,function(cityid,cityname) {	 
					var opt = $('<option />'); 									
					opt.val(cityid);
					opt.text(cityname);
					$('#cmbCity').append(opt); 		    			
				});
                                 //$('#cmbCity').val(cmbclient);
                                 $('.chzn-select').trigger('liszt:updated');
			}
		});
	}
}	
</script>

<script type="text/javascript" language="javascript">
function ValidateSearch()
{
	if(($("#cmbState").val()=='') && ($("#cmbCity").val()=='') && ($("#cmbPropertyCategory").val()=='') && ($("#cmbPropertyType").val()==''))
    {	
        alert("Please select Filter");
        $("#cmbState").focus();
        return false;
	}	
	else
	{
		$("#searchForm").submit();
	}
}
</script>

<script type="text/javascript" language="javascript"> 
$(".chzn-select").chosen(); 
$(".chzn-select-deselect").chosen({allow_single_deselect:true}); 
</script>