<!--==============================Form=================================-->

<div class="inner_form">
    <h2>Source Wise Reports</h2>
    <div class="mfrminner">

        <form name="frmDCRReport" id="frmDCRReport" method="post" action="<?php echo base_url(); ?>index.php/dashboard/need_sourcewise_reports" target="_blank">

            <fieldset><legend>Source Wise Reports</legend>



                <div class="Txtblks">Source</div>
                <div class="fldblks">
                    <select name="cmbSource" id="cmbSource" class="fild" tabindex="8">
                        <option value="">Select Source</option>
                        <?php
                        $this->db->where('bActive', 1);
                        $this->db->where('bDelete', 0);
                        $sql = $this->db->get('source_master');
                        if ($sql) {
                            if (($sql->num_rows) > 0) {
                                $rows = $sql->result_array();

                                foreach ($rows as $row):

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

                <div class="Txtblks">Filter</div>
                <div class="fldblks">
                    <select name="cmbFilter" id="cmbFilter" class="fild" style="width:200px;">
                        <option value="">Select Filter</option>
                        <option value="3">PSR</option>
                        <option value="2">Client</option>
                        <option value="1">RF</option>
                    </select>
                </div>



                <div class="Txtblks">&nbsp;</div>
                <div class="fldblks">&nbsp;</div>

                <div class="clear"></div>   


                <div class="Txtblks">Date</div>
                <div class="fldblks1">
                    <input type="text" name="txtDate" id="txtDate" size="15" readonly="" value="<?php echo set_value('txtDate'); ?>" />

                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="text" name="txtToDate" id="txtToDate" size="15" readonly="" value="<?php echo set_value('txtToDate'); ?>" />
                </div>



            </fieldset>

            <br />

            <div class="submit"><input type="button" name="btnSubmit" value="Print" class="btn" onclick="formvalidate()" /></div>

            <div class="clear"></div>

            <div style="color: #0000FF; text-align:center; font-weight:bold;"><?php echo $this->session->flashdata('msg'); ?><br /><?php echo $message; ?><br /><?php echo validation_errors(); ?></div>
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
        if($("#cmbFilter").val()==''){
            alert("Please Select Filter");
            $("#cmbFilter").focus();
            return false;
        } else if($("#txtDate").val()=='')
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