<style>
    iframe, .iframe{ min-width:800px; height: 500px; }
    table#example tr.odd,table#example tr.odd td.sorting_1 { background-color: #ccc;}
    table#example tr.even td.sorting_1 { background-color: #FFF;}
</style>

<div class="table_wrap">
    <h2 align="center">Deliveries Report</h2>
    <div class="tbls_wrp">
        <div class="tbls">        
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                <thead>
                    <tr>
                        <th>S.No.</th>
                        <th>Date</th>
                        <th>User</th>
                        <th>Client</th>
                        <th>Requirement</th>
                        <th>Property</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
					<?php $count = 1;foreach ($result_data as $value) { ?>
						<tr>
							<td><?php echo $count++ ?></td>
							<td><?php echo $value['dDCRDate'] ?></td>
							<td><?php echo $value['cName'] ?></td>
							<td><?php echo $value['clientsname'] ?></td>
							<td><?php echo $value['cRequirementTitle'] ?></td>
							<td><?php echo $value['cPropertyName'] ?></td>
							<td><?php echo $value['cDCRSummary'] ?></td>
						</tr>
					<?php }	?>                	
                </tbody>
            </table>   
        </div>        
        <div style="height:2px;"></div>
    </div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$('#example').dataTable();
	});
</script>