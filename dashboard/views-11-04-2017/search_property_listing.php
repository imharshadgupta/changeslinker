<?php
	$State="";
	$District="";
	$City="";
	$Location="";
		
	if(isset($_GET['cmbState']) && ($_GET['cmbState']!=''))
	{
		$State = trim($_GET['cmbState']);
	}
	
	if(isset($_GET['cmbDistrict']) && ($_GET['cmbDistrict']!=''))
	{
		$District = trim($_GET['DistrictState']);
	}
	
	if(isset($_GET['cmbCity']) && ($_GET['cmbCity']!=''))
	{
		$City = trim($_GET['cmbCity']);
	}
	
	if(isset($_GET['cmbLocation']) && ($_GET['cmbLocation']!=''))
	{
		$Location = trim($_GET['cmbLocation']);
	}
		
	$sql1 = "SELECT iPropertyId,property_master.cPropertyName,state_master.cStateName,district_master.cDistrictName,city_master.cCityName,location_master.cLocationName FROM property_master LEFT JOIN state_master ON property_master.iStateId=state_master.iStateId LEFT JOIN district_master ON property_master.iDistrictId=district_master.iDistrictId LEFT JOIN city_master ON property_master.iCityId=city_master.iCityId LEFT JOIN location_master ON property_master.iLocationId=location_master.iLocationId";

	$sql2 ="";
	
	$orderby="";
		
	//WHERE cPropertyName LIKE "'. mysql_real_escape_string($propertyname) .'%";
	
	if($State!="")
	{
		if($sql2=='')
		{
			$sql2 =" WHERE property_master.iStateId='".$State."'";
		}
		else
		{
			$sql2.=" AND property_master.iStateId='".$State."'";
		}
	}
	
	if($District!="")
	{
		if($sql2=='')
		{
			$sql2 =" WHERE property_master.iDistrictId='".$District."'";
		}
		else
		{
			$sql2.=" AND property_master.iDistrictId='".$District."'";
		}
	}
		
	if($City!="")
	{
		if($sql2=='')
		{
			$sql2 =" WHERE property_master.iCityId='".$City."'";
		}
		else
		{
			$sql2.=" AND property_master.iCityId='".$City."'";
		}
	}
	
	if($Location!="")
	{
		if($sql2=='')
		{
			$sql2 =" WHERE property_master.iLocationId='".$Location."'";
		}
		else
		{
			$sql2.=" AND property_master.iLocationId='".$Location."'";
		}
	}
		
	if($sql2=='')
	{
		$orderby =" WHERE property_master.bActive=1 AND property_master.bDelete=1 ORDER BY cPropertyName ASC";
	}
	else
	{
		$orderby.=" AND WHERE property_master.bActive=1 AND property_master.bDelete=1 ORDER BY cPropertyName ASC";
	}
		
	$sql = $sql1.$sql2.$orderby; 
	
	$query = $this->db->query($sql);
	
	if($query->num_rows>0)
	{
		$SNo=1;
		foreach($query->result_array() as $row): 
		
			$PropertyId = trim($row['iPropertyId']);
			$PropertyName = trim($row['cPropertyName']);
			$Active = trim($row['bActive']);
		?>
		<tr class="gradeA">
			<td style="text-align:center;"><?php echo $SNo; ?>.</td>
			<td style="text-align:left;"><?php echo $PropertyName; ?></td>
		</tr>            
		<?php
				$SNo++;
			endforeach; 
		?>
	<?php	
	} 
	?>	