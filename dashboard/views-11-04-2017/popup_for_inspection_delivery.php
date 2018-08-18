<script type="text/javascript" src="<?php echo base_url(); ?>js/script.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/jquery-ui-1.10.2.custom/js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/bpopup/jquery.bpopup.js"></script>


<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/datatable/css/demo_table_jui.css" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/datatable/themes/smoothness/jquery-ui-1.8.4.custom.css" />



<div style="color: #000; font-weight:bold;">
    <a href="javascript:void(0);" onclick="return bclose();" style="float:right; color: #000; text-decoration: none;" >X</a>

<!--    <div style="margin-top: 5px; margin-left: 20px;">
        <br> <br>-->
        <?php
      //  $i = 1;
        //foreach ($result as $res) {
            //foreach ($res as $reqresult) {
                //echo '<p style="padding-bottom:15px;">(' . $i . ') ' . $reqresult['cClientName'] . '</p>';
                //echo '<p style="padding-bottom:15px;">('.$i.') '.$reqresult['cRequirementTitle'].'</p>'; 
          //  }

          //  $i++;
        //}
        ?>
    <!--</div>-->


</div>

<?php 
        
      if($ins_del!='' && $ins_del==3)  
      {
        $msg = 'Inspection for '.$property_title[0]['cPropertyName'];  
      }else if($ins_del!='' && $ins_del==5)
      {
        $msg = 'Delivery for '.$property_title[0]['cPropertyName'];  
      }
      

      if($msg!="")
      {
          echo '<p style="text-align:center">'.$msg.'</p>';
      }
?>




<table cellpadding="2" cellspacing="2" border="1" class="display" id="example111">
    <thead>
        <tr>
            <th class="ui-state-default" rowspan="1" colspan="1">
                <div class="">SNo.<span class=" css_right  -triangle-1-s"></span></div>
            </th>
            <th class="ui-state-default" rowspan="1" colspan="1">
                <div class="DataTables_sort_wrapper">Date<span class=" css_right  -carat-2-n-s"></span>
                </div>
            </th>
            <th class="ui-state-default" rowspan="1" colspan="1">
                <div class="DataTables_sort_wrapper">RF<span class=" css_right  -carat-2-n-s">
                        
                    </span></div></th>
                    </tr>
</thead>
<tbody>


    
        
        <?php 
        
      
        
        $i = 1;
        
        
        echo '<pre>';
      //  print_r($result);
        echo '</pre>';
        
        $j=0;
        //foreach ($result as $res) {
        
        if(!empty($result))
        {
            foreach ($result as $reqresult) {
                //echo '<p style="padding-bottom:15px;">(' . $i . ') ' . $reqresult['cClientName'] . '</p>';
                
               //echo $this->dashboard_model->getDcrDate();
                
                ?>
    <tr class="gradeA">
                    <td style="text-align:center;"><?php echo $i;?></td>
                    <td style="text-align:center;"><?php echo $reqresult['dDCRDates'];;?></td>
                    <td style="text-align:left;"><?php echo $reqresult['cRequirementTitle'];?></td>
    </tr>
                <?php
                //echo '<p style="padding-bottom:15px;">('.$i.') '.$reqresult['cRequirementTitle'].'</p>'; 
        

            $i++;
            $j++;
        }
            
        }else{
            ?>
            <tr><td colspan="3" align="center">No Result Found.</tr>
            <?php
        }
        
            
        ?>
        
        



<!--<td align="center"><a href="index.php/dashboard/delete_property_master/" onclick="return confirmDelete()"><span class=" -trash"></span></a></td>-->     
</tbody>
</table>

<script>
    function fn_close_popup(){
        alert('aaa');
        //document.getElementById('dialog2').style.display='none';
        jQuery('#dialog3').bPopup().close();
    }

    function bclose() {
        parent.$("#dialog3").bPopup().close();
        return false;
    }


</script>