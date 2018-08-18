<!--==============================Form=================================-->

<div class="inner_form">
<h2>Task Report</h2>
    <div class="mfrminner">

       <form name="frmDCRReport" id="frmDCRReport" method="post" action="<?php echo base_url();?>index.php/dashboard/dwdcrprintreport" target="_blank">
 
        <fieldset><legend>Datewise Task Report</legend>
	
        <div class="Txtblks">Date</div>
        <div class="fldblks"><input type="text" name="txtDate" id="txtDate" size="15" readonly="" value="<?php echo set_value('txtDate'); ?>" /></div>
        
        <div class="Txtblks">&nbsp;</div>
        <div class="fldblks">&nbsp;</div>
        
        <div class="clear"></div><br />
         
        </fieldset>
		
        <br />
         
        <div class="submit"><input type="button" name="btnSubmit" value="Print" class="btn" onclick="formvalidate()" /></div>
        
        <div class="clear"></div>
    
        <div style="color: #0000FF; text-align:center; font-weight:bold;"><?php echo $this->session->flashdata('msg');?><br /><?php echo $message; ?><br /><?php echo validation_errors(); ?></div>
        <div class="clear"></div>
        
		</form>
    </div>
</div>

<script type="text/javascript" language="javascript">
$(document).ready(function(){	
	$("#txtDate").datepicker({ 
		dateFormat: 'dd/mm/yy',
		showOn: "button",
		changeMonth: true,
		changeYear: true,
		yearRange:"-100:+10",
		buttonImage: "<?php echo base_url(); ?>images/calendar.gif",
		buttonImageOnly: true 
	});
});	
</script>

<script type="text/javascript" language="javascript">
function formvalidate()
{
	if($("#txtDate").val()=='')
	{	
		alert("Please Select Date");
		$("#txtDate").focus();
		return false;
	}
	else
	{
		$("#frmDCRReport").submit();
		//$("#txtFromDate").val('');
		//$("#txtToDate").val('');
	}
}	
</script>