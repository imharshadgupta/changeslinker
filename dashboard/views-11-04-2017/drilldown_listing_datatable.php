<?php
if($client_id!="")
{
    $client_ids = $client_id;
}else{
     $client_ids = '';
}

?>

<script type="text/javascript" language="javascript">
$(document).ready(function() {
	var oTable = $('#example').dataTable({
		"bJQueryUI": true,
		"aaSorting":[[0, "desc"]],
		"sPaginationType": "full_numbers",
                "bPaginate": true,
              "bLengthChange": true,
               "aLengthMenu": [[20, 50, 100], [20, 50, 100]],
                "iDisplayLength": 20,
              "bFilter": true,
              "bSort": true,
              "bInfo": true,
              "bAutoWidth": false,
              "bProcessing": true,
              "bServerSide": true,
//               "aoColumnDefs": [
//                { 'bSortable': false, 'aTargets': [ 4,5,6 ] }
//            ],
               "sAjaxSource": "<?php echo base_url();?>index.php/dashboard/drilldown_report_datatable/<?php echo '/'.$taskid.'/'.$userid.'/'.$formdate.'/'.$todate; ?>",
              // "aoColumns": [ {"bSearchable": false},{"bSearchable": false},{"bSearchable": false}, {"bSearchable": false}, {"bSearchable": true},{"bSearchable": true}]
               
               
               
               
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
    
     <?php 
   
    $this->db->select('cName');		
    $this->db->where('iUserId', $userid);		
    $sql1 =  $this->db->get('user_master'); 
    $rows1 = $sql1->row_array();
    
    
    $this->db->select('cTaskName');		
    $this->db->where('iTaskId', $taskid);		
    $sql3 =  $this->db->get('task_master'); 
    $rows3 = $sql3->row_array();
    
    
    
    ?>
<!--    
    <table style="border: 0px solid;
    align-items: center;
    text-align: center;
    width: 33%;
    margin: auto; font-size: 16px; color: #333; padding-bottom: 20px; padding-top: 10px;">
        <tr style="height:30px;">
            <td> <span>Staff Name :</span>
        
</td>
            <td><span><?php echo $rows1['cName'] ? $rows1['cName'] : ''; ?></span></td>
        </tr>
        <tr style="height:30px;">
            <td><span>Date :</span>
        </td>
            <td><span><?php echo $formdate.' to '.$todate;?></span></td>
        </tr>
        <tr style="height:30px;">
            <td><span>Task Type :</span>
        </td>
            <td><span><?php echo $rows3['cTaskName'] ? $rows3['cTaskName'] : '' ;?></span></td>
        </tr>
    </table>-->
    
    <h2 align="center" style="font-size: 17px;"><?php echo $rows1['cName'] ? $rows1['cName'] : ''; ?> &nbsp; |&nbsp;   <?php echo $rows3['cTaskName'] ? $rows3['cTaskName'] : '' ;?>  &nbsp;|&nbsp; <?php echo $formdate.' to '.$todate;?> </h2>
        
   
   
    <div class="tbls_wrp">
        <div class="tbls">        
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
            <thead>
            <tr>
                                <th>SNo.</th>	
				<th>Date</th>
                                <th>Client</th>
				<th>RF</th>
				<th>PSR</th>
				
            </tr>
            </thead>
            <tbody></tbody>
            </table>   
		</div>        
        <div style="height:2px;"></div>
    </div>
</div>        

<!-- ui-dialog -->
<div id="dialog"> </div>





<style>
    
    iframe{min-width:800px; height: 500px;}
    
   .iframe{min-width:800px;height: 500px;}
   
   table#example tr.odd,table#example tr.odd td.sorting_1 { background-color: #ccc;}
   table#example tr.even td.sorting_1 { background-color: #FFF;}
    
</style>


<script>
    
    function bclose() {
        parent.$("#dialog3").bPopup().close();
        return false;
    }
    
function fn_close_popup(){
	//document.getElementById('dialog2').style.display='none';
	jQuery('#dialog3').bPopup().close();
}
</script>
<script>
//
//    $(function(){
//                $('.iframe111').bind('click', function(e){
//
//                    alert('aaaaaaaaaaa'); return false;
//
//                e.preventDefault();
//    //		alert(1);
//                t = this;
//                $('#dialog3').bPopup({content:'iframe'
//                , loadUrl: t.href
//                ,follow: [false, false] 
//                ,onOpen(){
//    //			alert('Press ESC Key to Close Window')
//                }
//                } );
//                });
//        });
        
        
        $('.iframe').bind('click', function(e){
                  
                    
                    
                e.preventDefault();
//		alert(1);
		t = this;
		$('#dialog3').bPopup({content:'iframe'
		, loadUrl: t.href
		,follow: [false, false] 
		,onOpen(){
//			alert('Press ESC Key to Close Window')
		}
		} );
		});

//
//$(".iframesss").click(function(){
//    
//    
//    
//              alert('aaaa')      ;return false
//                    
//                //e.preventDefault();
////		alert(1);
//		t = this;
//		$('#dialog3').bPopup({content:'iframe'
//		, loadUrl: t.href
//		,follow: [false, false] 
//		,onOpen(){
////			alert('Press ESC Key to Close Window')
//		}
//		} );
//})

//
//$(function(){
//    $('.iframesss').on('click', function(e){
//       alert('aaaa');
//        return false;
//    });
//});
//
//$(document).ready(function() {
//    $('#example').dataTable();
//} );






$('#example tbody').on( 'click', '.iframesss', function () {
    
                    
                //e.preventDefault();
//		alert(1);
		t = this;
		$('#dialog3').bPopup({content:'iframe'
		, loadUrl: t.href
		,follow: [false, false] 
		,onOpen(){
//			alert('Press ESC Key to Close Window')
		}
		});
                return false;

})

</script>