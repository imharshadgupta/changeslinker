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
               "aoColumnDefs": [
                { 'bSortable': false, 'aTargets': [ 4,5,6 ] }
            ],
               "sAjaxSource": "<?php echo base_url();?>index.php/dashboard/listing_requirement_master_datatable/<?php echo $client_ids; ?>",
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
    <h2 align="center">Requisitions</h2>
        
    <div style="width:100%; height:25px; border:0px solid #FF0000;">
        <div align="right" style="float:left; width:97%; height:25px; border:0px solid #000000;">
            <a class="various" data-fancybox-type="iframe" href="<?php echo base_url(); ?>index.php/dashboard/add_form_requirement_master"><img src="<?php echo base_url(); ?>images/addnew.jpg" title="Add New" width="20" height="20" /></a>
        </div>
    </div> 
    
    <div class="tbls_wrp">
        <div class="tbls">        
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
            <thead>
            <tr>
				<th>SNo.</th>
				
				<th>Title</th>
				<!--<th>Client</th>-->
				<th>Status</th>
				<th>T&C</th>
				<th>Active</th>
                                <th>Staff<br>Name</th>
                                <th><img src="<?php echo base_url();?>images/View.png"></th>
				<th><img src="<?php echo base_url();?>images/edit.gif"></th>
            <!--<th>DELETE</th>-->
				<th><img widht="16" height="16" src="<?php echo base_url();?>images/print_med.gif"></th>
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