<script type="text/javascript" language="javascript">
    $(document).ready(function() {
        var oTable = $('#example').dataTable({
            "bJQueryUI": true,
            "aaSorting":[[1, "desc"]],
            "sPaginationType": "full_numbers"
        });
    });
</script>

<script type="text/javascript" language="javascript">
    function confirmDelete()
    {
        var del = confirm('Are you sure want to delete this detail?');
  
        if(del)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
</script>

<div class="table_wrap">
    <h2 align="center">Deals  Lost</h2>

    <div style="width:100%; height:25px; border:0px solid #FF0000;">
        <div align="right" style="float:left; width:97%; height:25px; border:0px solid #000000;">
            <a class="various" data-fancybox-type="iframe" href="<?php echo base_url(); ?>index.php/dashboard/add_form_deal_lost"><img src="<?php echo base_url(); ?>images/addnew.jpg" title="Add New" width="20" height="20" /></a>
        </div>
    </div> 

    <div class="tbls_wrp">
        <div class="tbls">        
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Client</th>
                        <th>Requirement</th>

                        <th>Property</th>
                        <th>Deal Lost Reason</th>
                        <th>Follow Up Date</th>
                        <th>Active</th>

                        <th>EDIT</th>
                    <!--<th>DELETE</th>-->
                    </tr>
                </thead>
                <tbody>

                    <?php
                    foreach ($query->result_array() as $row):
                        $DealLostId = trim($row['iDealLostId']);
                        ?>

                        <tr class="gradeA">



                            <td style="text-align:left;"><?php echo trim($row['dDate']); ?></td>
                            <td style="text-align:left;"><?php echo trim($row['ClientNameReq']); ?></td>
                            <td style="text-align:left;"><?php echo trim($row['cRequirementTitle']); ?></td>

                            <td style="text-align:left;"><?php echo trim($row['cPropertyName']); ?></td>
                            <td style="text-align:left;"><?php echo trim($row['cSummaryOfDealLostReason']); ?></td>
                            <td style="text-align:left;"><?php echo trim($row['dFollowUpDate']); ?></td>
                            <td style="text-align:left;"><?php echo trim($row['bActive']); ?></td>

                            <td align="center"><a class="various" data-fancybox-type="iframe" href="<?php echo base_url(); ?>index.php/dashboard/edit_form_deal_lost/<?php echo $DealLostId; ?>"><span class="ui-icon ui-icon-pencil"></span></a></td>

    <!--<td align="center"><a href="<?php //echo base_url();  ?>index.php/dashboard/delete_deal_lost/<?php //echo $DealLostId;  ?>" onclick="return confirmDelete()"><span class="ui-icon ui-icon-trash"></span></a></td>-->
                        </tr>            

                    <?php endforeach; ?>

                </tbody>
            </table>   
        </div>        
        <div style="height:2px;"></div>
    </div>
</div>        

<!-- ui-dialog -->
<div id="dialog"> </div>