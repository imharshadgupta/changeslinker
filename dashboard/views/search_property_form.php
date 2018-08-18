<script type="text/javascript" language="javascript">
$(document).ready(function() {
	var oTable = $('#example').dataTable({
		"bJQueryUI": true,
		"aaSorting":[[2, "desc"]],
		"sPaginationType": "full_numbers"
	});
});
</script>

<?php
//$righttoadd = trim($this->session->userdata('RightToAdd_24'));
//$righttoedit = trim($this->session->userdata('RightToEdit_24'));
//$righttodelete = trim($this->session->userdata('RightToDelete_24'));


$righttoadd = $_SESSION['RightToAdd_24'];
$righttoedit = $_SESSION['RightToEdit_24'];
$righttodelete = $_SESSION['RightToDelete_24'];

?>

<form name="searchForm" id="searchForm" method="post" action="" enctype="multipart/form-data">
<div class="inner_form">
<h2>Search Properties</h2>
<div class="mfrminner">
<div style="color: #0000FF; text-align:center; font-weight:bold;"><?php echo $this->session->flashdata('msg');?><br /><?php echo $message; ?><br /><?php echo validation_errors(); ?></div>
<fieldset><legend>Parameters</legend>

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
	<select name="cmbCity" id="cmbCity" class="fild" tabindex="3" onchange="getLocationByCityIdAndDistrictIdAndStateId()">
	<option value="">Select City</option>
	<select>
</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">Location</div>
<div class="fldblks">
	<select name="cmbLocation" id="cmbLocation" class="fild" tabindex="4">
	<option value="">Select Location</option>
	<select>
</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="Txtblks">&nbsp;</div>
<div class="fldblks">&nbsp;</div>
<div class="clear"></div>

</fieldset>

<div class="submit"><input type="button" name="btnSubmit" class="btn" value="Submit" onclick="ValidateSearch();" /></div>

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
			url: "<?php echo base_url(); ?>index.php/dashboard/getdistrictbystate",
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
			url: "<?php echo base_url(); ?>index.php/dashboard/getcitybystateanddistrict",
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
			url: "<?php echo base_url(); ?>index.php/dashboard/getlocationbystateanddistrictandcity",
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
function ValidateSearch()
{
	var data = $("#searchForm").serialize();
		
	var url = "<?php echo base_url(); ?>index.php/dashboard/search_property_listing";

	btn.disabled = true;
	btn.value = 'Submitting...';

	$.get(url,data,function(data){	
		
	
	});
}
</script>

<div class="table_wrap">
    <h2 align="center">Property Listing</h2>
    <div class="tbls_wrp">
        <div class="tbls">        
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
            <thead>
            <tr>
				<th>SNo.</th>
				<th>Property Name</th>
            </tr>
            </thead>
            <tbody id="dvbody">
			
			 </tbody>
            </table> 
			
        <div style="height:2px;"></div>
    </div>
</div>   
     
<!-- ui-dialog -->
<div id="dialog"> </div>