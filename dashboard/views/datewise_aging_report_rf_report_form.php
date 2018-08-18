<!--==============================Form=================================-->

<div class="inner_form">
<h2>REQUIREMENT AGING REPORT</h2>
    <div class="mfrminner">

       <form name="frmWeeklyReport" id="frmWeeklyReport" method="post" action="<?php echo base_url();?>index.php/dashboard/requirement_aging_report" target="_blank">
 
        <fieldset><legend>Monthly Report</legend>
	
        <div class="Txtblks">From Date</div>
        <div class="fldblks"><input type="text" name="txtFromDate" id="txtFromDate" size="15" readonly="" value="<?php echo set_value('txtFromDate'); ?>" /></div>
        
        <div class="Txtblks">To Date</div>
        <div class="fldblks"><input type="text" name="txtToDate" id="txtToDate" size="15" readonly="" value="<?php echo set_value('txtToDate'); ?>" /></div>
        
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
	$("#txtFromDate").datepicker({ 
		dateFormat: 'dd/mm/yy',
		showOn: "button",
		changeMonth: true,
		changeYear: true,
		yearRange:"-100:+10",
		buttonImage: "<?php echo base_url(); ?>images/calendar.gif",
		buttonImageOnly: true 
	});
	
	$("#txtToDate").datepicker({ 
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
	if($("#txtFromDate").val()=='')
	{	
		alert("Please Select From Date");
		$("#txtFromDate").focus();
		return false;
	}
	else if($("#txtToDate").val()=='')
	{	
		alert("Please Select To Date");
		$("#txtToDate").focus();
		return false;
	}
	else
	{
		$("#frmWeeklyReport").submit();
		//$("#txtFromDate").val('');
		//$("#txtToDate").val('');
	}
}	
</script>