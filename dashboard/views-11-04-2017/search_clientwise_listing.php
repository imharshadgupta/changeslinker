<script type="text/javascript" language="javascript">
$(document).ready(function() {
	var oTable = $('#example').dataTable({
		"bJQueryUI": true,
		"aaSorting":[[0, "asc"]],
		"sPaginationType": "full_numbers",
                "aLengthMenu": [[20, 50, 100], [20, 50, 100]],
                "iDisplayLength": 20
	});
});
</script>

<div class="inner_form">
<h2>Clientwise Search</h2>
<form name="searchForm" id="searchForm" method="post" action="<?php echo base_url(); ?>index.php/dashboard/searchclientwise">
<div class="mfrminner">
	
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
	<div class="fldblks">&nbsp;&nbsp;<input type='button' class="btn" value="Submit" onclick="ValidateSearch();" /></div>
	<div class="clear"></div>

	<div class="Txtblks">&nbsp;</div>
    <div class="fldblks">&nbsp;</div>
    <div class="Txtblks">&nbsp;</div>
    <div class="fldblks">&nbsp;</div>
    <div class="clear"></div>
	
	<div class="table_wrap">	
		
		<?php
		if(isset($query) && isset($ClientId))
		{ 
		?>
		<div class="tbls_wrp">		
		<div class="tbls">   
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
            <thead>
            <tr>
<!--				<th>SNo.</th>
				<th>Date</th>
				<th>Client</th>-->
				<th>Title</th>
				<th>Category</th>
				<th>City</th>
				<th>Type</th>
                                <th><img src="<?php echo base_url();?>images/View.png" ></th>
<!--				<th>EDIT</th>-->
            </tr>
            </thead>
            <tbody>
			<?php								
			$SNo=1;
			foreach($query->result_array() as $row)
			{ 
				$Id = trim($row['ID']);
				$dt = trim($row['DATE']);
				$splitdt = explode('-',$dt);
				$Date = $splitdt[2]."/".$splitdt[1]."/".$splitdt[0];
				$ClientName = trim($row['CLIENTNAME']);
				$Title = trim($row['TITLE']);
				$Type = trim($row['TYPE']);
				$CityName = trim($row['CITYNAME']);
				$PropertyCategoryName = trim($row['PROPERTYCATEGORYNAME']);
			?>
				<tr class="gradeA">
<!--					<td style="text-align:center;"><?php echo $SNo; ?>.</td>
					<td style="text-align:left;"><?php echo $Date; ?></td>
					<td style="text-align:left;"><?php echo $ClientName; ?></td>-->
					<td style="text-align:left;"><?php echo $Title; ?></td>
					<td style="text-align:left;"><?php echo $PropertyCategoryName; ?></td>
					<td style="text-align:left;"><?php echo $CityName; ?></td>
					<td style="text-align:left;"><?php echo $Type; ?></td>
					
					<?php 
					if($Type=='RF'){
					?>
						<td align="center"><a class="various" data-fancybox-type="iframe" href="<?php echo base_url(); ?>index.php/dashboard/viewrequisition/<?php echo $Id; ?>"><span class="ui-icon ui-icon-search"></span></a></td>
						
<!--						<td align="center"><a class="various" data-fancybox-type="iframe" href="<?php echo base_url(); ?>index.php/dashboard/edit_form_requirement_master/<?php echo $Id; ?>"><span class="ui-icon ui-icon-pencil"></span></a></td>-->
					<?php 
					}
					?>
					
					<?php 
					if($Type=='PSR'){
					?>
						<td align="center"><a class="various" data-fancybox-type="iframe" href="<?php echo base_url(); ?>index.php/dashboard/viewproperty/<?php echo $Id; ?>"><span class="ui-icon ui-icon-search"></span></a></td>
					
<!--						<td align="center"><a class="various" data-fancybox-type="iframe" href="<?php echo base_url(); ?>index.php/dashboard/edit_form_property_master/<?php echo $Id; ?>"><span class="ui-icon ui-icon-pencil"></span></a></td>-->
					<?php 
					}
					?>
				
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
<script type="text/javascript" language="javascript"> 
$(".chzn-select").chosen(); 
$(".chzn-select-deselect").chosen({allow_single_deselect:true}); 
</script>
</form>

<script type="text/javascript" language="javascript">
function ChangeSearchFor()
{
	if($("#cmbSearchFor").val()!='')
    {
		if($("#cmbSearchFor").val()=='RF')
		{
			$.ajax({
				type: "POST",
				dataType: 'json',
				url: "<?php echo base_url();?>index.php/dashboard/getclientfromrfmaster",
				data: "",
				success: function(details){
					
					$('#cmbClient').children('option:not(:first)').remove();
					
					$.each(details,function(sno,clientid_name) {	 
					
						var opt = $('<option />'); 									
						
						if(clientid_name[0] == "<?php echo $ClientId; ?>"){
							opt.val(clientid_name[0]);
							opt.text(clientid_name[1]);
							$(opt).attr('selected', 'selected');
						}		
						else
						{
							opt.val(clientid_name[0]);
							opt.text(clientid_name[1]);
						}
						
						$('#cmbClient').append(opt); 		    			
					});
					
					ChangeClient();
				}
			});
		}
		
		if($("#cmbSearchFor").val()=='PSR')
		{
			$.ajax({
				type: "POST",
				dataType: 'json',
				url: "<?php echo base_url();?>index.php/dashboard/getclientfrompsrmaster",
				data: "",
				success: function(details){
					
					$('#cmbClient').children('option:not(:first)').remove();
					
					$.each(details,function(sno,clientid_name) {	 
					
						var opt = $('<option />'); 									
						
						if(clientid_name[0]== "<?php echo $ClientId; ?>"){
							opt.val(clientid_name[0]);
							opt.text(clientid_name[1]);
							$(opt).attr('selected', 'selected');
						}		
						else
						{
							opt.val(clientid_name[0]);
							opt.text(clientid_name[1]);
						}
						
						$('#cmbClient').append(opt); 
					});
					
					ChangeClient();
				}
			});
		}	
	}
}
</script>

<script type="text/javascript" language="javascript">
function ChangeClient()
{
	$('#cmbRFPSR').children('option:not(:first)').remove();
		
	if($("#cmbClient").val()!='')
	{
		if($("#cmbSearchFor").val()=='RF')
		{
			$.ajax({
				type: "POST",
				dataType: 'json',
				url: "<?php echo base_url();?>index.php/dashboard/getrfbyclientid",
				data: "cmbClient="+$("#cmbClient").val(),
				success: function(details){
					
					$('#cmbRFPSR').children('option:not(:first)').remove();
					
					$.each(details,function(reqid,reqname) {	 
					
						var opt = $('<option />'); 									
						
						if(reqid == "<?php echo $RFPSRId; ?>"){
							opt.val(reqid);
							opt.text(reqname);
							$(opt).attr('selected', 'selected');
						}		
						else
						{
							opt.val(reqid);
							opt.text(reqname);
						}
						
						$('#cmbRFPSR').append(opt);
					});
				}
			});
		}
		
		if($("#cmbSearchFor").val()=='PSR')
		{
			$.ajax({
				type: "POST",
				dataType: 'json',
				url: "<?php echo base_url();?>index.php/dashboard/getpsrbyclientid",
				data: "cmbClient="+$("#cmbClient").val(),
				success: function(details){
					
					$('#cmbRFPSR').children('option:not(:first)').remove();
					
					$.each(details,function(propid,propname) {	 
					
						var opt = $('<option />'); 									
						
						if(propid == "<?php echo $RFPSRId; ?>"){
							opt.val(propid);
							opt.text(propname);
							$(opt).attr('selected', 'selected');
						}		
						else
						{
							opt.val(propid);
							opt.text(propname);
						}
						
						$('#cmbRFPSR').append(opt); 	
					});
				}
			});
		}
	}
}	
</script>

<script type="text/javascript" language="javascript">
$(document).ready(function(){
	ChangeSearchFor();
});
</script>

<script type="text/javascript" language="javascript">
function ValidateSearch()
{
	if($("#cmbSearchFor").val()=='')
    {	
        alert("Please select Search For");
        $("#cmbSearchFor").focus();
        return false;
	}	
	else if($("#cmbClient").val()=='')
    {	
        alert("Please select Client");
        $("#cmbClient").focus();
        return false;
    }
	else if($("#cmbRFPSR").val()=='')
    {	
        alert("Please select RF/PSR");
        $("#cmbRFPSR").focus();
        return false;
    }
	else
	{
		$("#searchForm").submit();
	}
}
</script>
<style type="text/css">
    tr.odd.gradeA td.sorting_1 { background-color: #CCC;}
     tr.even.gradeA td.sorting_1 { background-color: #FFF;}
</style>