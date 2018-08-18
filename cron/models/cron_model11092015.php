<?php

class Cron_model extends CI_Model {
		
	function __construct(){
		parent::__construct();
	}
	
	function daily_tracker_report_mailer($CurrentLocalDate)
	{
		$splitdt=explode('-',$CurrentLocalDate);
		$CurrDate=$splitdt[2]."/".$splitdt[1]."/".$splitdt[0];
	
		$tbl="";
		$tbl.="<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">";
		$tbl.="<tr>
				  <td align=\"center\" style=\"text-align:center; font-size:18px;text-decoration:underline;\"><strong>DAILY STATUS REPORT</strong></td>
			  </tr>
			  <tr>
				  <td>&nbsp;</td>
			  </tr>
			  <tr>
				  <td align=\"center\" style=\"text-align:center; font-size:18px;text-decoration:underline;\"><strong>Date : $CurrDate</strong></td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
			  </tr>";
			
		
		///////////////////////////////////////////////// 1.Clients Added /////////////////////////////////////////////////////////////////
		
		$sql1 = "SELECT client_master.cClientName,branch_master.cBranchName FROM client_master LEFT JOIN branch_master ON client_master.iBranchId=branch_master.iBranchId
				 WHERE client_master.dCreateDate='".$CurrentLocalDate."' AND client_master.bActive=1 AND client_master.bDelete=0 ORDER BY client_master.cClientName";
	
		$tbl.="<tr>";
		$tbl.="<td>";
		$tbl.="<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">";
		$tbl.="<tr>";
		$tbl.="<td align=\"center\" style=\"font-size:15px;text-decoration:underline;\"><b>1. Clients Added</b></td>";
		$tbl.="</tr>";
		$tbl.="<tr>";
		$tbl.="<td>&nbsp;</td>";
		$tbl.="</tr>";
		
		$query1 = $this->db->query($sql1);
		
		if($query1)
		{
			if($query1->num_rows() > 0)
			{	
				$tbl.="<tr>";
				$tbl.="<td align=\"center\">";
				$tbl.="<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">
						<tr style=\"background-color:#CCCCCC;\">
						 <td width=\"5%\" align=\"center\"><b>SNo.</b></td>
						 <td width=\"60%\" align=\"left\"><b>Client Name</b></td>
						 <td width=\"35%\" align=\"left\"><b>Branch</b></td>
					   </tr>";
					   
				$S1No=1;
				foreach($query1->result_array() as $row1)
				{
					if($row1['cClientName']!='')
					{
						$ClientName = trim($row1['cClientName']);
					}
					else
					{
						$ClientName="";
					}
								
					if($row1['cBranchName']!='')
					{
						$ClientBranchName = trim($row1['cBranchName']);
					}
					else
					{
						$ClientBranchName="";
					}

					$tbl.="<tr>";
					$tbl.="<td align=\"center\">".$S1No.".</td>";
					$tbl.="<td align=\"left\">".$ClientName."</td>";
					$tbl.="<td align=\"left\">".$ClientBranchName."</td>";
					$tbl.="</tr>";
							
					$S1No++;
				}
				
					$tbl.="<tr>
							   <td colspan=\"3\">&nbsp;</td>
						   </tr>
						   </table>";
					$tbl.="</td>";
					$tbl.="</tr>";
			}
			else
			{
				$tbl.="<tr>";
				$tbl.="<td align=\"center\">No result found</td>";
				$tbl.="</tr>";
			}
		}
		
		$tbl.="<tr>";
		$tbl.="<td>&nbsp;</td>";
		$tbl.="</tr>";
		$tbl.="</table>";
		$tbl.="</td>";
		$tbl.="</tr>";
		
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			
			
		////////////////////////////////////////////////////// 2. RF Added /////////////////////////////////////////////////////////////////////////////////
		
		$sql2 = "SELECT requirement_master.cRequirementTitle,client_master.cClientName,user_master.cName FROM requirement_master LEFT JOIN client_master ON requirement_master.iClientId=client_master.iClientId LEFT JOIN user_master ON requirement_master.iAddedByUserId=user_master.iUserId WHERE requirement_master.dDate='".$CurrentLocalDate."' AND requirement_master.bActive=1 AND requirement_master.bDelete=0";
		
		$tbl.="<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">";
		$tbl.="<tr>";
		$tbl.="<td align=\"center\" style=\"font-size:15px;text-decoration:underline;\"><b>2. RF Added</b></td>";
		$tbl.="</tr>"; 
		$tbl.="<tr>";
		$tbl.="<td>&nbsp;</td>";
		$tbl.="</tr>";
			
		$query2 = $this->db->query($sql2);	  
		 
		if($query2)
		{
			if($query2->num_rows() > 0)
			{	
				$tbl.="<tr>";
				$tbl.="<td align=\"center\">";
				$tbl.="<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">
						<tr>
						 <td colspan=\"4\">&nbsp;</td>
						</tr>
						<tr style=\"background-color:#CCCCCC;\">
						 <td width=\"5%\" align=\"center\"><b>SNo.</b></td>
						 <td width=\"45%\" align=\"left\"><b>RF Title</b></td>
						 <td width=\"25%\" align=\"left\"><b>Client</b></td>
						 <td width=\"25%\" align=\"left\"><b>Added By</b></td>
					   </tr>";

				$S2No=1;
				foreach($query2->result_array() as $row2)
				{
					if($row2['cRequirementTitle']!='')
					{
						$RequirementTitle = trim($row2['cRequirementTitle']);
					}
					else
					{
						$RequirementTitle="";
					}
					
					if($row2['cClientName']!='')
					{
						$ClientName = trim($row2['cClientName']);
					}
					else
					{
						$ClientName="";
					}
					
					if($row2['cName']!='')
					{
						$AddedByUserName = trim($row2['cName']);
					}
					else
					{
						$AddedByUserName="";
					}

					$tbl.="<tr>";
					$tbl.="<td align=\"center\">".$S2No.".</td>";
					$tbl.="<td align=\"left\">".$RequirementTitle."</td>";
					$tbl.="<td align=\"left\">".$ClientName."</td>";
					$tbl.="<td align=\"left\">".$AddedByUserName."</td>";
					$tbl.="</tr>";
							
					$S2No++;
				}
				
				$tbl.="<tr>
						   <td colspan=\"4\">&nbsp;</td>
					   </tr>
					   </table>";
				$tbl.="</td>";
				$tbl.="</tr>";
			}
			else
			{
				$tbl.="<tr>";
				$tbl.="<td align=\"center\">No result found</td>";
				$tbl.="</tr>";
			}
		}
		
		$tbl.="<tr>";
		$tbl.="<td>&nbsp;</td>";
		$tbl.="</tr>";
		$tbl.="</table>";	
		$tbl.="</td>";
		$tbl.="</tr>";

		///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		
		////////////////////////////////////////////// 3. PSR Added //////////////////////////////////////////////////////////////////////////////////////////
		
		$sql3 = "SELECT property_master.cPropertyName,client_master.cClientName,user_master.cName FROM property_master LEFT JOIN client_master ON property_master.iClientId=client_master.iClientId LEFT JOIN user_master ON property_master.iAddedByUserId=user_master.iUserId WHERE property_master.dDate='".$CurrentLocalDate."' AND property_master.bActive=1 AND property_master.bDelete=0";
		
		$query3 = $this->db->query($sql3);
		
		$tbl.="<tr>";
		$tbl.="<td>";
		$tbl.="<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">";
		$tbl.="<tr>";
		$tbl.="<td align=\"center\" style=\"font-size:15px;text-decoration:underline;\"><b>3. PSR Added</b></td>";
		$tbl.="</tr>";
		$tbl.="<tr>";
		$tbl.="<td>&nbsp;</td>";
		$tbl.="</tr>";
		
		if($query3)
		{
			if($query3->num_rows() > 0)
			{	   
				$tbl.="<tr>";
				$tbl.="<td align=\"center\">";
				$tbl.="<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">
						<tr style=\"background-color:#CCCCCC;\">
						 <td width=\"5%\" align=\"center\"><b>SNo.</b></td>
						 <td width=\"45%\" align=\"left\"><b>PSR Title</b></td>
						 <td width=\"25%\" align=\"left\"><b>Client</b></td>
						 <td width=\"25%\" align=\"left\"><b>Added By</b></td>
					   </tr>";	   

				$S3No=1;
				foreach($query3->result_array() as $row3)
				{
					if($row3['cPropertyName']!='')
					{
						$PropertyName = trim($row3['cPropertyName']);
					}
					else
					{
						$PropertyName="";
					}
					
					if($row3['cClientName']!='')
					{
						$ClientName = trim($row3['cClientName']);
					}
					else
					{
						$ClientName="";
					}
					
					if($row3['cName']!='')
					{
						$AddedByUserName = trim($row3['cName']);
					}
					else
					{
						$AddedByUserName="";
					}
					
					$tbl.="<tr>";
					$tbl.="<td align=\"center\">".$S3No.".</td>";
					$tbl.="<td align=\"left\">".$PropertyName."</td>";
					$tbl.="<td align=\"left\">".$ClientName."</td>";
					$tbl.="<td align=\"left\">".$AddedByUserName."</td>";
					$tbl.="</tr>";
							
					$S3No++;
				}
				
				$tbl.="<tr>
						   <td colspan=\"4\">&nbsp;</td>
					   </tr>
					   </table>";
				$tbl.="</td>";
				$tbl.="</tr>";
			}
			else
			{
				$tbl.="<tr>";
				$tbl.="<td align=\"center\">No result found</td>";
				$tbl.="</tr>";
			}
		}
		
		$tbl.="<tr>";
		$tbl.="<td>&nbsp;</td>";
		$tbl.="</tr>";
		$tbl.="</table>";
		$tbl.="</td>";
		$tbl.="</tr>";
		
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////	
		
		/////////////////////////////////////////////// 4. Deals Done  //////////////////////////////////////////////////////////////////////////////////////
		
		$sql4 = "SELECT CMREQ.cClientName as cReqClientName,requirement_master.cRequirementTitle,CMPROP.cClientName as cPropClientName,property_master.cPropertyName FROM deal_initiate LEFT JOIN property_master ON deal_initiate.iPropertyId=property_master.iPropertyId LEFT JOIN requirement_master ON deal_initiate.iRequirementId=requirement_master.iRequirementId 
				 LEFT JOIN client_master as CMREQ ON deal_initiate.iClientReqId=CMREQ.iClientId LEFT JOIN client_master as CMPROP ON deal_initiate.iClientPropId=CMPROP.iClientId WHERE deal_initiate.dDealDoneDate='".$CurrentLocalDate."' AND deal_initiate.bActive=1 AND deal_initiate.bDelete=0";		
		
		$query4 = $this->db->query($sql4);
		
		$tbl.="<tr>";
		$tbl.="<td>";
		$tbl.="<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">";
		$tbl.="<tr>";
		$tbl.="<td align=\"center\" style=\"font-size:15px;text-decoration:underline;\"><b>4. Deals Done</b></td>";
		$tbl.="</tr>";
		$tbl.="<tr>";
		$tbl.="<td>&nbsp;</td>";
		$tbl.="</tr>";
		
		if($query4)
		{
			if($query4->num_rows() > 0)
			{
			    $tbl.="<tr>";
				$tbl.="<td align=\"center\">";
				$tbl.="<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">
						<tr style=\"background-color:#CCCCCC;\">
						 <td width=\"5%\" align=\"center\"><b>SNo.</b></td>
						 <td width=\"20%\" align=\"left\"><b>Client Req</b></td>
						 <td width=\"25%\" align=\"left\"><b>RF Title</b></td>
						 <td width=\"20%\" align=\"left\"><b>Client Prop</b></td>
						 <td width=\"30%\" align=\"left\"><b>PSR Title</b></td>
					   </tr>";	   

				$S4No=1;
				foreach($query4->result_array() as $row4)
				{
					if($row4['cReqClientName']!='')
					{
						$ReqClientName = trim($row4['cReqClientName']);
					}
					else
					{
						$ReqClientName="";
					}
					
					if($row4['cRequirementTitle']!='')
					{
						$RequirementTitle = trim($row4['cRequirementTitle']);
					}
					else
					{
						$RequirementTitle="";
					}
								
					if($row4['cPropClientName']!='')
					{
						$PropClientName = trim($row4['cPropClientName']);
					}
					else
					{
						$PropClientName="";
					}
					
					if($row4['cPropertyName']!='')
					{
						$PropertyName = trim($row4['cPropertyName']);
					}
					else
					{
						$PropertyName="";
					}
					
					$tbl.="<tr>";
					$tbl.="<td align=\"center\">".$S4No.".</td>";
					$tbl.="<td align=\"left\">".$ReqClientName."</td>";
					$tbl.="<td align=\"left\">".$RequirementTitle."</td>";
					$tbl.="<td align=\"left\">".$PropClientName."</td>";
					$tbl.="<td align=\"left\">".$PropertyName."</td>";
					$tbl.="</tr>";
							
					$S4No++;
	
				}				
					$tbl.="<tr>
							   <td colspan=\"5\">&nbsp;</td>
						   </tr>
						   </table>";
					$tbl.="</td>";
					$tbl.="</tr>";
			}
			else
			{
			    $tbl.="<tr>";
				$tbl.="<td align=\"center\">No result found</td>";
				$tbl.="</tr>";
			}
		}
		
	    $tbl.="<tr>";
		$tbl.="<td>&nbsp;</td>";
		$tbl.="</tr>";
		$tbl.="</table>";
		$tbl.="</td>";
		$tbl.="</tr>";
		
		///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		////////////////////////////////////////////////// 5. Deals Lost  ////////////////////////////////////////////////////////////////////////////////////
		
		$sql5 = "SELECT CMREQ.cClientName as cReqClientName,requirement_master.cRequirementTitle,CMPROP.cClientName as cPropClientName,property_master.cPropertyName,deal_lost.cSummaryOfDealLostReason FROM deal_lost LEFT JOIN property_master ON deal_lost.iPropertyId=property_master.iPropertyId LEFT JOIN requirement_master ON deal_lost.iRequirementId=requirement_master.iRequirementId 
				 LEFT JOIN client_master as CMREQ ON deal_lost.iClientReqId=CMREQ.iClientId LEFT JOIN client_master as CMPROP ON deal_lost.iClientPropId=CMPROP.iClientId WHERE deal_lost.dDate='".$CurrentLocalDate."' AND deal_lost.bDelete=0";		
				 
		$query5 = $this->db->query($sql5);
		
		$tbl.="<tr>";
		$tbl.="<td>";
		$tbl.="<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">";
		$tbl.="<tr>";
		$tbl.="<td align=\"center\" style=\"font-size:15px;text-decoration:underline;\"><b>5. Deals Lost</b></td>";
		$tbl.="</tr>";
		$tbl.="<tr>";
		$tbl.="<td>&nbsp;</td>";
		$tbl.="</tr>";
		
		if($query5)
		{
			if($query5->num_rows() > 0)
			{
				$tbl.="<tr>";
				$tbl.="<td align=\"center\">";
				$tbl.="<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">
						<tr style=\"background-color:#CCCCCC;\">
						 <td width=\"5%\" align=\"center\"><b>SNo.</b></td>
						 <td width=\"15%\" align=\"left\"><b>Client Req</b></td>
						 <td width=\"15%\" align=\"left\"><b>RF Title</b></td>
						 <td width=\"15%\" align=\"left\"><b>Client Prop</b></td>
						 <td width=\"15%\" align=\"left\"><b>PSR Title</b></td>
						 <td width=\"35%\" align=\"left\"><b>Reason</b></td>
					   </tr>";
			
				$S5No=1;
				foreach($query5->result_array() as $row5)
				{
					if($row5['cReqClientName']!='')
					{
						$ReqClientName = trim($row5['cReqClientName']);
					}
					else
					{
						$ReqClientName="";
					}
					
					if($row5['cRequirementTitle']!='')
					{
						$RequirementTitle = trim($row5['cRequirementTitle']);
					}
					else
					{
						$RequirementTitle="";
					}
								
					if($row5['cPropClientName']!='')
					{
						$PropClientName = trim($row5['cPropClientName']);
					}
					else
					{
						$PropClientName="";
					}
					
					if($row5['cPropertyName']!='')
					{
						$PropertyName = trim($row5['cPropertyName']);
					}
					else
					{
						$PropertyName="";
					}
					
					if($row5['cSummaryOfDealLostReason']!='')
					{
						$DealLostReason = trim($row5['cSummaryOfDealLostReason']);
					}
					else
					{
						$DealLostReason="";
					}

					$tbl.="<tr>";
					$tbl.="<td align=\"center\">".$S5No.".</td>";
					$tbl.="<td align=\"left\">".$ReqClientName."</td>";
					$tbl.="<td align=\"left\">".$RequirementTitle."</td>";
					$tbl.="<td align=\"left\">".$PropClientName."</td>";
					$tbl.="<td align=\"left\">".$PropertyName."</td>";
					$tbl.="<td align=\"left\">".$DealLostReason."</td>";
					$tbl.="</tr>";
							
					$S5No++;
				}
				
					$tbl.="<tr>
							   <td colspan=\"6\">&nbsp;</td>
						   </tr>
						   </table>";
					$tbl.="</td>";
					$tbl.="</tr>";
			}
			else
			{
				$tbl.="<tr>";
				$tbl.="<td align=\"center\">No result found</td>";
				$tbl.="</tr>";
			}
		}
			
		$tbl.="<tr>";
		$tbl.="<td>&nbsp;</td>";
		$tbl.="</tr>";
		$tbl.="</table>";
		$tbl.="</td>";
		$tbl.="</tr>";
		
		///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		/////////////////////////////////////////////////////// 6. Tasks  ////////////////////////////////////////////////////////////////////////////////////
		
		$sql6 = "SELECT user_master.cName,task_master.cTaskName,COUNT(*) as TASKCOUNT FROM task_assign LEFT JOIN task_master ON task_assign.iTaskId=task_master.iTaskId LEFT JOIN user_master ON task_assign.iTaskDoneByUserId=user_master.iUserId WHERE task_assign.dTaskDoneDate='".$CurrentLocalDate."' AND task_assign.bTaskDone=1 AND task_assign.bDelete=0 GROUP BY user_master.cName,task_master.cTaskName";
	
		$query6 = $this->db->query($sql6);
		
		$tbl.="<tr>";
		$tbl.="<td>";
		$tbl.="<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">";
		$tbl.="<tr>";
		$tbl.="<td align=\"center\" style=\"font-size:15px;text-decoration:underline;\"><b>6. Tasks</b></td>";
		$tbl.="</tr>";
		$tbl.="<tr>";
		$tbl.="<td>&nbsp;</td>";
		$tbl.="</tr>";
		
		if($query6)
		{
			if($query6->num_rows() > 0)
			{
				$tbl.="<tr>";
				$tbl.="<td align=\"center\">";
				$tbl.="<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">
						<tr style=\"background-color:#CCCCCC;\">
						 <td width=\"5%\" align=\"center\"><b>SNo.</b></td>
						 <td width=\"40%\" align=\"left\"><b>Task Name</b></td>
						 <td width=\"35%\" align=\"left\"><b>Staff Name</b></td>
						 <td width=\"20%\" align=\"left\"><b>Count</b></td>
					   </tr>";
			
				$S6No=1;
				foreach($query6->result_array() as $row6)
				{
					if($row6['cTaskName']!='')
					{
						$TaskName = trim($row6['cTaskName']);
					}
					else
					{
						$TaskName="";
					}
					
					if($row6['cName']!='')
					{
						$StaffName = trim($row6['cName']);
					}
					else
					{
						$StaffName="";
					}
								
					if($row6['TASKCOUNT']!='')
					{
						$TASKCOUNT = trim($row6['TASKCOUNT']);
					}
					else
					{
						$TASKCOUNT="";
					}
					
					$tbl.="<tr>";
					$tbl.="<td align=\"center\">".$S6No.".</td>";
					$tbl.="<td align=\"left\">".$TaskName."</td>";
					$tbl.="<td align=\"left\">".$StaffName."</td>";
					$tbl.="<td align=\"left\">".$TASKCOUNT."</td>";
					$tbl.="</tr>";
							
					$S6No++;
				}
				
					$tbl.="<tr>
							   <td colspan=\"4\">&nbsp;</td>
						   </tr>
						   </table>";
					$tbl.="</td>";
					$tbl.="</tr>";
			}
			else
			{
				$tbl.="<tr>";
				$tbl.="<td align=\"center\">No result found</td>";
				$tbl.="</tr>";
			}
		}
			
		$tbl.="<tr>";
		$tbl.="<td>&nbsp;</td>";
		$tbl.="</tr>";
		$tbl.="</table>";
		$tbl.="</td>";
		$tbl.="</tr>";
		
		///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		//////////////////////////////////////////////// 7. DCR Summary  /////////////////////////////////////////////////////////////////////////////////////
	
		$sql77 = "SELECT dcr_summary.iDCRId,user_master.cName FROM dcr_summary LEFT JOIN user_master ON dcr_summary.iUserId=user_master.iUserId WHERE dcr_summary.dDCRDate='".$CurrentLocalDate."' AND dcr_summary.bDelete=0";

		$query77 = $this->db->query($sql77);
	
		$tbl.="<tr>";
		$tbl.="<td>";
		$tbl.="<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">";
		$tbl.="<tr>";
		$tbl.="<td align=\"center\" style=\"font-size:15px;text-decoration:underline;\"><b>7. DCR Summary</b></td>";
		$tbl.="</tr>";
		$tbl.="<tr>";
		$tbl.="<td>&nbsp;</td>";
		$tbl.="</tr>";
		
		if($query77)
		{
			if($query77->num_rows() > 0)
			{
				foreach($query77->result_array() as $row77)
				{
					if($row77['iDCRId']!='')
					{
						$DCRId = trim($row7['iDCRId']);
					}
					else
					{
						$DCRId="";
					}
					
					if($row77['cName']!='')
					{
						$StaffName = trim($row7['cName']);
					}
					else
					{
						$StaffName="";
					}
				
					$tbl.="<tr>";
					$tbl.="<td align=\"left\">".$StaffName."</td>";	
					$tbl.="</tr>";
					$tbl.="<tr>";
					$tbl.="<td align=\"center\">";
					$tbl.="<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">
							<tr style=\"background-color:#CCCCCC;\">
							 <td width=\"5%\" align=\"center\"><b>SNo.</b></td>
							 <td width=\"30%\" align=\"left\"><b>Task</b></td>
							 <td width=\"30%\" align=\"left\"><b>Client Req</b></td>
							 <td width=\"15%\" align=\"left\"><b>RF</b></td>
							 <td width=\"20%\" align=\"left\"><b>Client PSR</b></td>
							 <td width=\"15%\" align=\"left\"><b>PSR</b></td>
							 <td width=\"15%\" align=\"left\"><b>Summary</b></td>
						   </tr>";

						   
					$sql7 = "SELECT task_master.cTaskName,CMREQ.cClientName as cReqClientName,requirement_master.cRequirementTitle,CMPROP.cClientName as cPropClientName,property_master.cPropertyName,dcr_detail.cDCRSummary
							 FROM dcr_detail LEFT JOIN task_master ON dcr_detail.iTaskId=task_master.iTaskId LEFT JOIN client_master as CMREQ ON dcr_detail.iClientReqId=CMREQ.iClientId LEFT JOIN client_master as CMPROP ON dcr_detail.iClientPropId=CMPROP.iClientId WHERE dcr_detail.iDCRId='".$DCRId."'";
		
					$query7 = $this->db->query($sql7);
					
					if($query7)
					{
						if($query7->num_rows() > 0)
						{
							$S7No=1;
							foreach($query7->result_array() as $row7)
							{
								if($row7['cTaskName']!='')
								{
									$TaskName = trim($row7['cTaskName']);
								}
								else
								{
									$TaskName="";
								}
								
								if($row7['cReqClientName']!='')
								{
									$ReqClientName = trim($row7['cReqClientName']);
								}
								else
								{
									$ReqClientName="";
								}
								
								if($row7['cRequirementTitle']!='')
								{
									$RequirementTitle = trim($row7['cRequirementTitle']);
								}
								else
								{
									$RequirementTitle="";
								}
											
								if($row7['cPropClientName']!='')
								{
									$PropClientName = trim($row7['cPropClientName']);
								}
								else
								{
									$PropClientName="";
								}
								
								if($row7['cPropertyName']!='')
								{
									$PropertyName = trim($row7['cPropertyName']);
								}
								else
								{
									$PropertyName="";
								}
								
								if($row7['cDCRSummary']!='')
								{
									$DCRSummary = trim($row7['cDCRSummary']);
								}
								else
								{
									$DCRSummary="";
								}

								$tbl.="<tr>";
								$tbl.="<td align=\"center\">".$S7No.".</td>";
								$tbl.="<td align=\"left\">".$TaskName."</td>";
								$tbl.="<td align=\"left\">".$ReqClientName."</td>";
								$tbl.="<td align=\"left\">".$RequirementTitle."</td>";
								$tbl.="<td align=\"left\">".$PropClientName."</td>";
								$tbl.="<td align=\"left\">".$PropertyName."</td>";
								$tbl.="<td align=\"left\">".$DCRSummary."</td>";
								$tbl.="</tr>";
										
								$S7No++;
							}
							
								$tbl.="<tr>
										   <td colspan=\"7\">&nbsp;</td>
									   </tr>
									   </table>";
								$tbl.="</td>";
								$tbl.="</tr>";
						}
					}
				}
			}
			else
			{
				$tbl.="<tr>";
				$tbl.="<td align=\"center\">No result found</td>";
				$tbl.="</tr>";
			}
		}
			
		$tbl.="<tr>";
		$tbl.="<td>&nbsp;</td>";
		$tbl.="</tr>";
		$tbl.="<tr>";
		$tbl.="<td>&nbsp;</td>";
		$tbl.="</tr>";
		$tbl.="<tr>";
		$tbl.="<td>&nbsp;</td>";
		$tbl.="</tr>";
		$tbl.="</table>";
		$tbl.="</td>";
		$tbl.="</tr>";
		
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		$tbl.="</table>";
		
		//echo $tbl;
		return $tbl;
	}
	
	
	function staff_task_reminder_detail($CurrentLocalDate)
	{
		$sql="SELECT task_assign.iTaskAssignId,UMTAB.cName as cTaskAssignedByName,UMTDB.cName as cTaskDoneByName,task_assign.iDepartmentId,department_master.cDepartmentName,CMREQ.cClientName as cReqClientName,requirement_master.cRequirementTitle,CMPROP.cClientName as cPropClientName,property_master.cPropertyName,
		      task_assign.dTaskAssignDateTime,task_assign.cTaskSummary,task_assign.dTaskTargetDateTime,task_assign.dReminderDateTime,CASE task_assign.bTaskDone WHEN 1 THEN 'Yes' ELSE 'No' END AS 'bTaskDone' 
			  FROM task_assign LEFT JOIN user_master as UMTAB ON task_assign.iTaskAssignedByUserId=UMTAB.iUserId LEFT JOIN user_master as UMTDB ON task_assign.iTaskDoneByUserId=UMTDB.iUserId LEFT JOIN department_master ON task_assign.iDepartmentId=department_master.iDepartmentId 
			  LEFT JOIN client_master as CMREQ ON task_assign.iClientReqId=CMREQ.iClientId LEFT JOIN client_master as CMPROP ON task_assign.iClientPropId=CMPROP.iClientId 
			  LEFT JOIN requirement_master ON task_assign.iRequirementId=requirement_master.iRequirementId LEFT JOIN property_master ON task_assign.iPropertyId=property_master.iPropertyId WHERE date(task_assign.dReminderDateTime)='".$CurrentLocalDate."' AND task_assign.bTaskDone=0 AND task_assign.bDelete=0 ORDER BY iTaskAssignId DESC";
		
		$query = $this->db->query($sql);
		
		if($query)
		{
			$result = $query->result_array();
			
			return $result;
		}
	}
	
	
}	