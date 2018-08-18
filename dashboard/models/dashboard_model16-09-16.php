<?php

class Dashboard_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function save_activity_details($new_activity_data) {
        $insert = $this->db->insert('activity_log_master', $new_activity_data);

        if ($insert) {
            $insert_id = $this->db->insert_id();
            return $insert_id;
        } else {
            return FALSE;
        }
    }

    function get_client_ip() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if (getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if (getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if (getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if (getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if (getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';

        return $ipaddress;
    }

    /* function user_pending_task_list_all($UserId)
      {
      $sql="SELECT task_assign.iTaskAssignId,task_assign.dTaskAssignDateTime,user_master.cUserName,task_assign.dTaskTargetDateTime,client_master.cClientName,property_master.cPropertyName,task_assign.cTaskSummary,task_assign.dTaskTargetDateTime,CASE task_assign.bTaskDone WHEN 1 THEN 'Yes' ELSE 'No' END AS 'bTaskDone'
      FROM task_assign LEFT JOIN user_master ON task_assign.iUserId=user_master.iUserId LEFT JOIN client_master ON task_assign.iClientId=client_master.iClientId LEFT JOIN property_master ON task_assign.iPropertyId=property_master.iPropertyId
      LEFT JOIN requirement_master ON task_assign.iRequirementId=requirement_master.iRequirementId WHERE task_assign.iUserId='".$UserId."' AND task_assign.bTaskDone=0 AND task_assign.bDelete=0 ORDER BY iTaskAssignId DESC";

      $query = $this->db->query($sql);

      return $query;
      } */

    function sendEmail($RecipientEmailAddress, $EmailSubject, $EmailMessage) {
        $mail = new PHPMailer();
        $mail->IsSMTP();                                     // We are going to use SMTP
        $mail->SMTPAuth = true;                                 // Enabled SMTP authentication
        $mail->SMTPSecure = "ssl";                                // Prefix for secure protocol to connect to the server
        $mail->Host = "smtp.gmail.com";                 // Setting GMail as our SMTP server
        $mail->Port = 465;     //25;            // SMTP port to connect to GMail
        $mail->Username = "support@linkersindia.com";           // User email address
        $mail->Password = "manashids";
        $mail->IsHTML(true); // Password in GMail

        $mail->SetFrom('support@linkersindia.com', 'Linkers India');     //Who is sending the email
        $mail->AddReplyTo("support@linkersindia.com', 'Linkers India");  //Email address that receives the response
        $mail->Subject = "$EmailSubject";
        $mail->Body = "$EmailMessage";

        $mail->AltBody = "To view the message, please use an HTML compatible email viewer!";

        $mail->AddAddress("$RecipientEmailAddress");            // Who is addressed the email to
        //$mail->AddAttachment("images/phpmailer.gif");             // some attached files
        //$mail->AddAttachment("images/phpmailer_mini.gif");        // as many as you want

        if (!$mail->Send()) {
            //  echo "Error: " . $mail->ErrorInfo;
            return false;
        } else {
            //  echo "Message sent correctly!";
            return true;
        }
    }

    function sendEmaildata($RecipientEmailAddress, $EmailSubject, $EmailMessage) {


        $mail = new PHPMailer();
        $mail->IsSMTP();                                     // We are going to use SMTP
        $mail->SMTPAuth = true;                                 // Enabled SMTP authentication
        $mail->SMTPSecure = "ssl";                                // Prefix for secure protocol to connect to the server
        $mail->Host = "smtp.gmail.com";                 // Setting GMail as our SMTP server
        $mail->Port = 465;                                 // SMTP port to connect to GMail
        $mail->Username = "support@linkersindia.com";           // User email address
        $mail->Password = "manashids";                          // Password in GMail
        $mail->IsHTML(true);
        $mail->SetFrom('support@linkersindia.com', 'Linkers India');     //Who is sending the email
        $mail->AddReplyTo($RecipientEmailAddress, 'Linkers India');  //Email address that receives the response
        $mail->AddAddress($RecipientEmailAddress, 'Subject');

        $mail->Subject = "$EmailSubject";
        $mail->Body = "$EmailMessage";

        if (!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
            exit;
        }

        echo 'Message has been sent';
    }

    function check_send_email() {
        $UserRecipientEmailAddress = "mohatshim.rachitsoftsol@gmail.com";
        $UserEmailSubject = "Test Mail - Linkers";
        $UserEmailMessage = "This is a test mail from linkers.";

        if (filter_var($UserRecipientEmailAddress, FILTER_VALIDATE_EMAIL) !== false) {
            $SendEmail = $this->SendEmail($UserRecipientEmailAddress, $UserEmailSubject, $UserEmailMessage);

            return $SendEmail;
        }
    }

    function user_pending_task_list_all() {
        $sql = "SELECT task_assign.iTaskAssignId,task_assign.dTaskAssignDateTime,user_master.cName as cTaskAssignedByName,department_master.cDepartmentName,task_assign.dTaskTargetDateTime,CMREQ.cClientName as cReqClientName,requirement_master.cRequirementTitle,CMPROP.cClientName as cPropClientName,property_master.cPropertyName,task_assign.cTaskSummary,task_assign.dTaskTargetDateTime,task_assign.dReminderDateTime,CASE task_assign.bTaskDone WHEN 1 THEN 'Yes' ELSE 'No' END AS 'bTaskDone' 
			  FROM task_assign LEFT JOIN user_master ON task_assign.iTaskAssignedByUserId=user_master.iUserId LEFT JOIN department_master ON task_assign.iDepartmentId=department_master.iDepartmentId 
			  LEFT JOIN client_master as CMREQ ON task_assign.iClientReqId=CMREQ.iClientId LEFT JOIN client_master as CMPROP ON task_assign.iClientPropId=CMPROP.iClientId  
			  LEFT JOIN requirement_master ON task_assign.iRequirementId=requirement_master.iRequirementId LEFT JOIN property_master ON task_assign.iPropertyId=property_master.iPropertyId WHERE task_assign.bTaskDone=0 AND task_assign.bDelete=0 ORDER BY iTaskAssignId DESC";

        $query = $this->db->query($sql);

        return $query;
    }

    function user_pending_task_by_dept($UserDeptId) {
        $sql = "SELECT task_assign.iTaskAssignId,task_assign.dTaskAssignDateTime,user_master.cName as cTaskAssignedByName,department_master.cDepartmentName,task_assign.dTaskTargetDateTime,CMREQ.cClientName as cReqClientName,requirement_master.cRequirementTitle,CMPROP.cClientName as cPropClientName,property_master.cPropertyName,task_assign.cTaskSummary,task_assign.dTaskTargetDateTime,task_assign.dReminderDateTime,CASE task_assign.bTaskDone WHEN 1 THEN 'Yes' ELSE 'No' END AS 'bTaskDone' 
			  FROM task_assign LEFT JOIN user_master ON task_assign.iTaskAssignedByUserId=user_master.iUserId LEFT JOIN department_master ON task_assign.iDepartmentId=department_master.iDepartmentId LEFT JOIN client_master as CMREQ ON task_assign.iClientReqId=CMREQ.iClientId LEFT JOIN client_master as CMPROP ON task_assign.iClientPropId=CMPROP.iClientId LEFT JOIN requirement_master ON task_assign.iRequirementId=requirement_master.iRequirementId LEFT JOIN property_master ON task_assign.iPropertyId=property_master.iPropertyId WHERE task_assign.iDepartmentId='" . $UserDeptId . "' AND task_assign.bTaskDone=0 AND task_assign.bDelete=0 ORDER BY iTaskAssignId DESC";

        $query = $this->db->query($sql);

        return $query;
    }

    //-----------------------------------------------------------Get District----------------------------------------------------------------------------------

    function get_district_by_state($StateId) {
        $this->db->where('iStateId', $StateId);
        $this->db->where('bActive', 1);
        $this->db->where('bDelete', 0);
        $query = $this->db->get('district_master');

        $districts = array();

        if ($query->result()) {
            foreach ($query->result() as $dist) {
                $districts[$dist->iDistrictId] = $dist->cDistrictName;
            }
            return $districts;
        } else {
            return FALSE;
        }
    }

    //----------------------------------------------------- Get City ------------------------------------------------------------------------------------------

    function get_district_by_id($DistrictId) {
        $query4 = $this->db->query("SELECT cDistrictName FROM district_master WHERE district_master.iDistrictId='" . $DistrictId . "'");
        $row4 = $query4->row_array();
        return $DistrictName = trim($row4['cDistrictName']);
    }

    function get_location_by_id($LocationId) {
        $query6 = $this->db->query("SELECT cLocationName FROM location_master WHERE location_master.iLocationId='" . $LocationId . "'");
        $row6 = $query6->row_array();
        return $LocationName = trim($row6['cLocationName']);
    }

    function get_city_by_id($id) {
        $sql = "SELECT cCityName FROM city_master WHERE iCityId='" . $id . "'";

        $query = $this->db->query($sql);

        if ($query) {
            $result = $query->row_array();

            return $result['cCityName'];
        }
    }

    function get_city_by_state_and_district($StateId, $DistrictId) {
        $this->db->where('iStateId', $StateId);
        $this->db->where('iDistrictId', $DistrictId);
        $this->db->where('bActive', 1);
        $this->db->where('bDelete', 0);
        $query = $this->db->get('city_master');

        $cities = array();

        if ($query->result()) {
            foreach ($query->result() as $cit) {
                $cities[$cit->iCityId] = $cit->cCityName;
            }
            return $cities;
        } else {
            return FALSE;
        }
    }

    //---------------------------------------------------------------------------------------------------------------------------------------------------------

    function get_city_by_state($StateId) {
        $this->db->where('iStateId', $StateId);
        $this->db->where('bActive', 1);
        $this->db->where('bDelete', 0);
        $query = $this->db->get('city_master');

        $cities = array();

        if ($query->result()) {
            foreach ($query->result() as $cit) {
                $cities[$cit->iCityId] = $cit->cCityName;
            }
            return $cities;
        } else {
            return FALSE;
        }
    }

    //----------------------------------------------------Get Locations----------------------------------------------------------------------------------------

    function get_location_by_state_and_district_and_city($StateId, $DistrictId, $CityId) {
        $this->db->where('iStateId', $StateId);
        $this->db->where('iDistrictId', $DistrictId);
        $this->db->where('iCityId', $CityId);
        $this->db->where('bActive', 1);
        $this->db->where('bDelete', 0);
        $query = $this->db->get('location_master');

        $locations = array();

        if ($query->result()) {
            foreach ($query->result() as $loc) {
                $locations[$loc->iLocationId] = $loc->cLocationName;
            }

            return $locations;
        } else {
            return FALSE;
        }
    }

    //----------------------------------------------------Get Property Owner-----------------------------------------------------------------------------------

    function get_property_owner_by_property($PropertyId) {
        $sql = "SELECT property_master.iClientId,client_master.cClientName FROM property_master LEFT JOIN client_master ON property_master.iClientId=client_master.iClientId WHERE property_master.iPropertyId='" . $PropertyId . "'";

        $query = $this->db->query($sql);

        if ($query) {
            $propertyowners = array();

            if ($query->num_rows > 0) {
                foreach ($query->result() as $propown) {
                    $propertyowners[$propown->iClientId] = $propown->cClientName;
                }
                return $propertyowners;
            }
        } else {
            return FALSE;
        }
    }

    //-----------------------------------------------------------Get District----------------------------------------------------------------------------------

    function get_contact_person_by_client($ClientId) {
        $sql = "SELECT client_master.cContactPerson1Name,client_master.cContactPerson2Name,client_master.cContactPerson3Name,client_master.cContactPerson4Name,client_master.cContactPerson5Name,
			  client_master.cContactPerson6Name,client_master.cContactPerson7Name,client_master.cContactPerson8Name,client_master.cContactPerson9Name,client_master.cContactPerson10Name FROM client_master WHERE client_master.iClientId='" . $ClientId . "'";

        $query = $this->db->query($sql);

        $CPArray = array();

        if ($query->result()) {
            $row = $query->row_array();

            // key already known
            // $array[$key] = $value;

            if (!empty($row['cContactPerson1Name']) && ($row['cContactPerson1Name'] != '')) {
                $CPArray[1] = $row['cContactPerson1Name'];
            }
            if (!empty($row['cContactPerson2Name']) && ($row['cContactPerson2Name'] != '')) {
                $CPArray[2] = $row['cContactPerson2Name'];
            }
            if (!empty($row['cContactPerson3Name']) && ($row['cContactPerson3Name'] != '')) {
                $CPArray[3] = $row['cContactPerson3Name'];
            }
            if (!empty($row['cContactPerson4Name']) && ($row['cContactPerson4Name'] != '')) {
                $CPArray[4] = $row['cContactPerson4Name'];
            }
            if (!empty($row['cContactPerson5Name']) && ($row['cContactPerson5Name'] != '')) {
                $CPArray[5] = $row['cContactPerson5Name'];
            }
            if (!empty($row['cContactPerson6Name']) && ($row['cContactPerson6Name'] != '')) {
                $CPArray[6] = $row['cContactPerson6Name'];
            }
            if (!empty($row['cContactPerson7Name']) && ($row['cContactPerson7Name'] != '')) {
                $CPArray[7] = $row['cContactPerson7Name'];
            }
            if (!empty($row['cContactPerson8Name']) && ($row['cContactPerson8Name'] != '')) {
                $CPArray[8] = $row['cContactPerson8Name'];
            }
            if (!empty($row['cContactPerson9Name']) && ($row['cContactPerson9Name'] != '')) {
                $CPArray[9] = $row['cContactPerson9Name'];
            }
            if (!empty($row['cContactPerson10Name']) && ($row['cContactPerson10Name'] != '')) {
                $CPArray[10] = $row['cContactPerson10Name'];
            }

            return $CPArray;
        } else {
            return FALSE;
        }
    }

    function get_contact_details_by_contact_person($ClientId, $ColumnNo) {
        if (!empty($ClientId) && !empty($ColumnNo)) {
            $sql = "SELECT client_master.cContactPerson" . $ColumnNo . "Name,client_master.cContactPerson" . $ColumnNo . "Designation,client_master.cContactPerson" . $ColumnNo . "PhoneNo1,client_master.cContactPerson" . $ColumnNo . "PhoneNo2,client_master.cContactPerson" . $ColumnNo . "Email FROM client_master WHERE client_master.iClientId='" . $ClientId . "'";

            $query = $this->db->query($sql);

            if ($query) {
                if ($query->num_rows > 0) {
                    $row = $query->row_array();

                    $ContactPersonName = trim($row["cContactPerson" . $ColumnNo . "Name"]);
                    $ContactPersonDesignation = trim($row["cContactPerson" . $ColumnNo . "Designation"]);
                    $ContactPersonPhoneNo1 = trim($row["cContactPerson" . $ColumnNo . "PhoneNo1"]);
                    $ContactPersonPhoneNo2 = trim($row["cContactPerson" . $ColumnNo . "PhoneNo2"]);
                    $ContactPersonEmail = trim($row["cContactPerson" . $ColumnNo . "Email"]);

                    return $ContactPersonName . "~" . $ContactPersonDesignation . "~" . $ContactPersonPhoneNo1 . "~" . $ContactPersonPhoneNo2 . "~" . $ContactPersonEmail;
                } else {
                    return 'noresultfound';
                }
            }
        }
    }

    //------------------------------------------------------ Suggest Parties -------------------------------------------------------------------------------

    function suggest_party_names($partyname) {
        $sql = 'SELECT iClientId,cClientName FROM client_master WHERE cClientName LIKE "' . mysql_real_escape_string($partyname) . '%" ORDER BY cClientName ASC';
        $query = $this->db->query($sql);
        if ($query) {
            $data = array();
            foreach ($query->result() as $objnm) {
                $ClientId = $objnm->iClientId;
                $ClientName = $objnm->cClientName;

                $data[] = array(
                    'label' => $ClientName,
                    'value' => $ClientId
                );
            }

            return $data;
        } else {
            return FALSE;
        }
    }

    //----------------------------------------------------- Suggest Properties -------------------------------------------------------------------------------

    function suggest_property_names($propertyname) {
        $sql = 'SELECT iPropertyId,cPropertyName FROM property_master WHERE cPropertyName LIKE "' . mysql_real_escape_string($propertyname) . '%" ORDER BY cPropertyName ASC';
        $query = $this->db->query($sql);
        if ($query) {
            $data = array();
            foreach ($query->result() as $objnm) {
                $PropertyId = $objnm->iPropertyId;
                $PropertyName = $objnm->cPropertyName;

                $data[] = array(
                    'label' => $PropertyName,
                    'value' => $PropertyId
                );
            }

            return $data;
        } else {
            return FALSE;
        }
    }

    //----------------------------------------------------- Search --------------------------------------------------------------------------------------------

    function search_by_text_in_property($txtSearch) {
        $sql = "SELECT property_master.iPropertyId,property_master.cPropertyName,client_master.cClientName,state_master.cStateName,district_master.cDistrictName,city_master.cCityName,location_master.cLocationName,property_master.cPropertyAddress,source_master.cSourceName,property_category_master.cPropertyCategoryName,property_type_master.cPropertyTypeName,property_status_master.cPropertyStatusName,property_master.cPropertyPurpose,property_master.cPropertyLegalStatus,property_master.cPropertyRemarks,property_master.cTotalPlotArea,property_master.cBuildingArea,property_master.iNoOfFloorsInBuilding,property_master.cGroundCoverage,property_master.cFloorOffered,property_master.cPlateAreaOfFloorOffered,property_master.cToilet,property_master.cParking,property_master.cCarpetArea,property_master.cBuiltUpArea,property_master.cSuperBuiltUpArea,property_master.cFrontage,property_master.cDepth,property_master.cHeight,agreement_type_master.cAgreementTypeName,property_master.cDemandPerSqFeet,property_master.cDemandGross,property_master.cSecurityDeposit,escalation_master.cEscalationName,property_master.cCAM,property_master.cServiceTaxOnLessor,property_master.cServiceTaxOnLessee,property_master.cPropertyTaxOnLessor,property_master.cPropertyTaxOnLessee,property_master.cStampDutyAndRegistration,property_master.cLockIn,property_master.cLockInDuration,property_master.cRentFreePeriod,property_master.cNoticePeriod,property_master.cPossessionStatus,property_master.cPowerLoad,property_master.cPowerBackup,property_master.cCurrentTenant,property_master.dLeaseUpToDate,property_master.cPreviousTenant,property_master.dAgreementDate,property_master.cAgreementPlace,property_master.cPerson1DuringAgreement,property_master.cPerson2DuringAgreement            
				FROM property_master LEFT JOIN client_master ON property_master.iClientId=client_master.iClientId LEFT JOIN state_master ON property_master.iStateId=state_master.iStateId LEFT JOIN district_master ON property_master.iDistrictId=district_master.iDistrictId LEFT JOIN city_master ON property_master.iCityId=city_master.iCityId LEFT JOIN location_master ON property_master.iLocationId=location_master.iLocationId LEFT JOIN source_master ON property_master.iSourceId=source_master.iSourceId LEFT JOIN property_category_master ON property_master.iPropertyCategoryId=property_category_master.iPropertyCategoryId	LEFT JOIN property_type_master ON property_master.iPropertyTypeId=property_type_master.iPropertyTypeId LEFT JOIN property_status_master ON property_master.iPropertyStatusId=property_status_master.iPropertyStatusId LEFT JOIN agreement_type_master ON property_master.iAgreementTypeId=agreement_type_master.iAgreementTypeId LEFT JOIN escalation_master ON property_master.iEscalationId=escalation_master.iEscalationId
				WHERE (property_master.cPropertyName LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (client_master.cClientName LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (state_master.cStateName LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (district_master.cDistrictName LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (city_master.cCityName LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (location_master.cLocationName LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (property_master.cPropertyAddress LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (source_master.cSourceName LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (property_category_master.cPropertyCategoryName LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (property_type_master.cPropertyTypeName LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (property_status_master.cPropertyStatusName LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (property_master.cPropertyPurpose LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (property_master.cPropertyLegalStatus LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (property_master.cPropertyRemarks LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (property_master.cTotalPlotArea LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (property_master.cBuildingArea LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (property_master.iNoOfFloorsInBuilding LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (property_master.cGroundCoverage LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (property_master.cFloorOffered LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (property_master.cPlateAreaOfFloorOffered LIKE '%" . mysql_real_escape_string($txtSearch) . "%') 
				OR (property_master.cToilet LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (property_master.cParking LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (property_master.cCarpetArea LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (property_master.cBuiltUpArea LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (property_master.cSuperBuiltUpArea LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (property_master.cFrontage LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (property_master.cDepth LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (property_master.cHeight LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (agreement_type_master.cAgreementTypeName LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (property_master.cHeight LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (property_master.cDemandPerSqFeet LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (property_master.cDemandGross LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (property_master.cSecurityDeposit LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (escalation_master.cEscalationName LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (property_master.cCAM LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (property_master.cServiceTaxOnLessor LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (property_master.cServiceTaxOnLessee LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (property_master.cPropertyTaxOnLessee LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (property_master.cStampDutyAndRegistration LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (property_master.cLockIn LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (property_master.cLockInDuration LIKE '%" . mysql_real_escape_string($txtSearch) . "%')
				OR (property_master.cRentFreePeriod LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (property_master.cNoticePeriod LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (property_master.cPossessionStatus LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (property_master.cPowerLoad LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (property_master.cPowerBackup LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (property_master.cCurrentTenant LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (property_master.dLeaseUpToDate LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (property_master.cPreviousTenant LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (property_master.dAgreementDate LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (property_master.cAgreementPlace LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (property_master.cPerson1DuringAgreement LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (property_master.cPerson2DuringAgreement LIKE '%" . mysql_real_escape_string($txtSearch) . "%')
				AND property_master.bDelete=0 ORDER BY cPropertyName ASC";

        $query = $this->db->query($sql);

        return $query;
    }

    function search_by_text_in_client($txtSearch) {
        $sql = "SELECT client_master.iClientId,client_master.cClientName,client_master.cAddress,state_master.cStateName,district_master.cDistrictName,city_master.cCityName,location_master.cLocationName,client_master.cLandmark,client_master.cContactPerson1Name,client_master.cContactPerson1Designation,client_master.cContactPerson1PhoneNo1,client_master.cContactPerson1PhoneNo2,client_master.cContactPerson1Email,client_master.cContactPerson2Name,client_master.cContactPerson2Designation,client_master.cContactPerson2PhoneNo1,client_master.cContactPerson2PhoneNo2,client_master.cContactPerson2Email,client_master.cContactPerson3Name,client_master.cContactPerson3Designation,client_master.cContactPerson3PhoneNo1,client_master.cContactPerson3PhoneNo2,client_master.cContactPerson3Email,client_master.cRemarks
				FROM client_master LEFT JOIN state_master ON client_master.iStateId=state_master.iStateId LEFT JOIN district_master ON client_master.iDistrictId=district_master.iDistrictId LEFT JOIN city_master ON client_master.iCityId=city_master.iCityId LEFT JOIN location_master ON client_master.iLocationId=location_master.iLocationId
				WHERE (client_master.cClientName LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (client_master.cAddress LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (state_master.cStateName LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (district_master.cDistrictName LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (city_master.cCityName LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (location_master.cLocationName LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (client_master.cLandmark LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (client_master.cContactPerson1Name LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (client_master.cContactPerson1Designation LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (client_master.cContactPerson1PhoneNo1 LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (client_master.cContactPerson1PhoneNo2 LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (client_master.cContactPerson1Email LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (client_master.cContactPerson2Name LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (client_master.cContactPerson2Designation LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (client_master.cContactPerson2PhoneNo1 LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (client_master.cContactPerson2PhoneNo2 LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (client_master.cContactPerson2Email LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (client_master.cContactPerson3Name LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (client_master.cContactPerson3Designation LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (client_master.cContactPerson3PhoneNo1 LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (client_master.cContactPerson3PhoneNo2 LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (client_master.cContactPerson3Email LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (client_master.cRemarks LIKE '%" . mysql_real_escape_string($txtSearch) . "%') AND client_master.bDelete=0 ORDER BY client_master.cClientName";

        $query = $this->db->query($sql);

        return $query;
    }

    function search_by_text_in_requirement($txtSearch) {
        $sql = "SELECT requirement_master.iRequirementId,requirement_master.dDate,client_master.cClientName,requirement_master.cContactPerson1,requirement_master.cContactPerson2,requirement_master.cContactPerson3,state_master.cStateName,district_master.cDistrictName,city_master.cCityName,location_master.cLocationName,requirement_master.cArea,requirement_master.cHeight,requirement_master.cFrontage,source_master.cSourceName,requirement_master.cPropertyPurpose,business_purpose_master.cBusinessPurposeName,property_category_master.cPropertyCategoryName,requirement_master.cRequirementType,requirement_master.cBudgetPerMonth,requirement_master.cFloorLevelPreference,escalation_master.cEscalationName,requirement_master.cLeasePeriodPreference,requirement_master.cRentFreeFitOutPeriod,requirement_master.cPowerLoad,requirement_master.cPowerBackup,requirement_master.dExpectedLaunchDate,requirement_master.cRemarks,requirement_master.cRegistrationExpensesToBeBorneBy,requirement_master.cTaxationToBeBorneBy,requirement_master.cLockInPeriod,requirement_master.cEstimatedInteriorBudget,requirement_master.cParkingPreference,requirement_master.dAgreementDate,requirement_master.cAgreementPlace,requirement_master.cPerson1DuringAgreement,requirement_master.cPerson2DuringAgreement,requirement_master.cTermsAndConditions,requirement_master.cServiceChargesForLinkers
				FROM requirement_master LEFT JOIN client_master ON requirement_master.iClientId=client_master.iClientId LEFT JOIN state_master ON client_master.iStateId=state_master.iStateId LEFT JOIN district_master ON client_master.iDistrictId=district_master.iDistrictId LEFT JOIN city_master ON client_master.iCityId=city_master.iCityId LEFT JOIN location_master ON client_master.iLocationId=location_master.iLocationId LEFT JOIN source_master ON requirement_master.iSourceId=source_master.iSourceId LEFT JOIN business_purpose_master ON requirement_master.iBusinessPurposeId=business_purpose_master.iBusinessPurposeId LEFT JOIN property_category_master ON requirement_master.iPropertyCategoryId=property_category_master.iPropertyCategoryId LEFT JOIN escalation_master ON requirement_master.iEscalationId=escalation_master.iEscalationId
				WHERE (requirement_master.dDate LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (client_master.cClientName LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (requirement_master.cContactPerson1 LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (requirement_master.cContactPerson2 LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (requirement_master.cContactPerson3 LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (state_master.cStateName LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (district_master.cDistrictName LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (city_master.cCityName LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (location_master.cLocationName LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (requirement_master.cArea LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (requirement_master.cHeight LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (requirement_master.cFrontage LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (source_master.cSourceName LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (requirement_master.cPropertyPurpose LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (business_purpose_master.cBusinessPurposeName LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (property_category_master.cPropertyCategoryName LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (requirement_master.cRequirementType LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (requirement_master.cBudgetPerMonth LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (requirement_master.cFloorLevelPreference LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (escalation_master.cEscalationName LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (requirement_master.cLeasePeriodPreference LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (requirement_master.cRentFreeFitOutPeriod LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (requirement_master.cPowerLoad LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (requirement_master.cPowerBackup LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (requirement_master.dExpectedLaunchDate LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (requirement_master.cRemarks LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (requirement_master.cRegistrationExpensesToBeBorneBy LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (requirement_master.cTaxationToBeBorneBy LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (requirement_master.cLockInPeriod LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (requirement_master.cEstimatedInteriorBudget LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (requirement_master.cParkingPreference LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (requirement_master.dAgreementDate LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (requirement_master.cAgreementPlace LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (requirement_master.cPerson1DuringAgreement LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (requirement_master.cPerson2DuringAgreement LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (requirement_master.cTermsAndConditions LIKE '%" . mysql_real_escape_string($txtSearch) . "%') OR (requirement_master.cServiceChargesForLinkers LIKE '%" . mysql_real_escape_string($txtSearch) . "%') AND requirement_master.bDelete=0";

        $query = $this->db->query($sql);

        return $query;
    }

    //---------------------------------------------------------------------------------------------------------------------------------------------------------
    function get_clients_from_requirement_master() {
        $sql = "SELECT requirement_master.iClientId, ltrim(client_master.cClientName)cClientName
		 FROM requirement_master 
		 LEFT JOIN client_master ON requirement_master.iClientId=client_master.iClientId 
		 WHERE requirement_master.iClientId<>0 
		 AND requirement_master.bActive=1 
		 AND requirement_master.bDelete=0 
		 GROUP BY requirement_master.iClientId 
		 ORDER BY ltrim(client_master.cClientName) ASC";

        $query = $this->db->query($sql);

        $clients = array();

        if ($query->result()) {
            foreach ($query->result() as $clt) {

                $clients[] = array($clt->iClientId, $clt->cClientName);
            }
            return $clients;
        } else {
            return FALSE;
        }
    }

    function get_requirement_by_client_id($ClientId) {
        $this->db->where('iClientId', $ClientId);
        $this->db->where('bActive', 1);
        $this->db->where('bDelete', 0);
        $query = $this->db->get('requirement_master');

        $requirements = array();

        if ($query->result()) {
            foreach ($query->result() as $req) {
                $requirements[$req->iRequirementId] = $req->cRequirementTitle;
                //$requirements[$req->iRequirementId][] = $req->cRequirementTitle;  
                //$requirements['ReqId'] = $req->iRequirementId; 
                //$requirements['ReqTitle'] = $req->cRequirementTitle;  	
            }
            return $requirements;
        } else {
            return FALSE;
        }
    }

    function search_by_location_propertytype_in_requirement($CityId, $LocationId, $PropertyCategoryId) {
        $sql = "SELECT requirement_master.iRequirementId,requirement_master.cRequirementTitle,requirement_master.dDate,client_master.cClientName,requirement_master.cContactPerson1,requirement_master.cContactPerson2,requirement_master.cContactPerson3,state_master.cStateName,district_master.cDistrictName,city_master.cCityName,location_master.cLocationName,requirement_master.cArea,requirement_master.cHeight,requirement_master.cFrontage,source_master.cSourceName,requirement_master.cPropertyPurpose,business_purpose_master.cBusinessPurposeName,property_category_master.cPropertyCategoryName,requirement_master.cRequirementType,requirement_master.cBudgetPerMonth,requirement_master.cFloorLevelPreference,escalation_master.cEscalationName,requirement_master.cLeasePeriodPreference,requirement_master.cRentFreeFitOutPeriod,requirement_master.cPowerLoad,requirement_master.cPowerBackup,requirement_master.dExpectedLaunchDate,requirement_master.cRemarks,requirement_master.cRegistrationExpensesToBeBorneBy,requirement_master.cTaxationToBeBorneBy,requirement_master.cLockInPeriod,requirement_master.cEstimatedInteriorBudget,requirement_master.cParkingPreference,requirement_master.dAgreementDate,requirement_master.cAgreementPlace,requirement_master.cPerson1DuringAgreement,requirement_master.cPerson2DuringAgreement,requirement_master.cTermsAndConditions,requirement_master.cServiceChargesForLinkers
				FROM requirement_master LEFT JOIN client_master ON requirement_master.iClientId=client_master.iClientId LEFT JOIN state_master ON client_master.iStateId=state_master.iStateId LEFT JOIN district_master ON client_master.iDistrictId=district_master.iDistrictId LEFT JOIN city_master ON client_master.iCityId=city_master.iCityId LEFT JOIN location_master ON client_master.iLocationId=location_master.iLocationId LEFT JOIN source_master ON requirement_master.iSourceId=source_master.iSourceId LEFT JOIN business_purpose_master ON requirement_master.iBusinessPurposeId=business_purpose_master.iBusinessPurposeId LEFT JOIN property_category_master ON requirement_master.iPropertyCategoryId=property_category_master.iPropertyCategoryId LEFT JOIN escalation_master ON requirement_master.iEscalationId=escalation_master.iEscalationId
				WHERE (requirement_master.iCityId = '" . mysql_real_escape_string($CityId) . "') 
				AND (requirement_master.iLocationId = '" . mysql_real_escape_string($LocationId) . "') 
				AND (requirement_master.iPropertyCategoryId = '" . mysql_real_escape_string($PropertyCategoryId) . "') 
				AND requirement_master.bDelete=0";

        $query = $this->db->query($sql);

        return $query;
    }

    function get_clients_from_property_master() {
        $sql = "SELECT property_master.iClientId,client_master.cClientName FROM property_master LEFT JOIN client_master ON property_master.iClientId=client_master.iClientId WHERE property_master.iClientId<>0 AND property_master.bActive=1 AND property_master.bDelete=0 GROUP BY property_master.iClientId ORDER BY client_master.cClientName ASC";

        $query = $this->db->query($sql);

        $clients = array();

        if ($query->result()) {
            foreach ($query->result() as $clt) {
                $clients[] = array($clt->iClientId, $clt->cClientName);
            }
            return $clients;
        } else {
            return FALSE;
        }
    }

    function get_property_by_client_id($ClientId) {
        $this->db->where('iClientId', $ClientId);
        $this->db->where('bActive', 1);
        $this->db->where('bDelete', 0);
        $query = $this->db->get('property_master');

        $properties = array();

        if ($query->result()) {
            foreach ($query->result() as $prop) {
                $properties[$prop->iPropertyId] = $prop->cPropertyName;
            }
            return $properties;
        } else {
            return FALSE;
        }
    }

    function search_by_location_propertytype_in_property($CityId, $LocationId, $PropertyCategoryId) {
        $sql = "SELECT property_master.iPropertyId,property_master.cPropertyName,client_master.cClientName,state_master.cStateName,district_master.cDistrictName,city_master.cCityName,location_master.cLocationName,property_master.cPropertyAddress,source_master.cSourceName,property_category_master.cPropertyCategoryName,property_type_master.cPropertyTypeName,property_status_master.cPropertyStatusName,property_master.cPropertyPurpose,property_master.cPropertyLegalStatus,property_master.cPropertyRemarks,property_master.cTotalPlotArea,property_master.cBuildingArea,property_master.iNoOfFloorsInBuilding,property_master.cGroundCoverage,property_master.cFloorOffered,property_master.cPlateAreaOfFloorOffered,property_master.cToilet,property_master.cParking,property_master.cCarpetArea,property_master.cBuiltUpArea,property_master.cSuperBuiltUpArea,property_master.cFrontage,property_master.cDepth,property_master.cHeight,agreement_type_master.cAgreementTypeName,property_master.cDemandPerSqFeet,property_master.cDemandGross,property_master.cSecurityDeposit,escalation_master.cEscalationName,property_master.cCAM,property_master.cServiceTaxOnLessor,property_master.cServiceTaxOnLessee,property_master.cPropertyTaxOnLessor,property_master.cPropertyTaxOnLessee,property_master.cStampDutyAndRegistration,property_master.cLockIn,property_master.cLockInDuration,property_master.cRentFreePeriod,property_master.cNoticePeriod,property_master.cPossessionStatus,property_master.cPowerLoad,property_master.cPowerBackup,property_master.cCurrentTenant,property_master.dLeaseUpToDate,property_master.cPreviousTenant,property_master.dAgreementDate,property_master.cAgreementPlace,property_master.cPerson1DuringAgreement,property_master.cPerson2DuringAgreement            
				FROM property_master LEFT JOIN client_master ON property_master.iClientId=client_master.iClientId LEFT JOIN state_master ON property_master.iStateId=state_master.iStateId LEFT JOIN district_master ON property_master.iDistrictId=district_master.iDistrictId LEFT JOIN city_master ON property_master.iCityId=city_master.iCityId LEFT JOIN location_master ON property_master.iLocationId=location_master.iLocationId LEFT JOIN source_master ON property_master.iSourceId=source_master.iSourceId LEFT JOIN property_category_master ON property_master.iPropertyCategoryId=property_category_master.iPropertyCategoryId LEFT JOIN property_type_master ON property_master.iPropertyTypeId=property_type_master.iPropertyTypeId LEFT JOIN property_status_master ON property_master.iPropertyStatusId=property_status_master.iPropertyStatusId LEFT JOIN agreement_type_master ON property_master.iAgreementTypeId=agreement_type_master.iAgreementTypeId LEFT JOIN escalation_master ON property_master.iEscalationId=escalation_master.iEscalationId
				WHERE (property_master.iCityId  = '" . mysql_real_escape_string($CityId) . "') 
				AND (property_master.iLocationId = '" . mysql_real_escape_string($LocationId) . "') 
				AND property_master.bDelete=0 ORDER BY cPropertyName ASC";
//				AND (property_master.iPropertyCategoryId = '".mysql_real_escape_string($PropertyCategoryId)."') 

        $query = $this->db->query($sql);

        return $query;
    }

    //---------------------------------------------------------------------------------------------------------------------------------------------------------

    function search_client_wise($ClientId) {
        $sql = "SELECT requirement_master.iRequirementId as ID,requirement_master.dDate as DATE,requirement_master.cRequirementTitle as TITLE,client_master.cClientName as CLIENTNAME, 'RF' as TYPE, state_master.cStateName as STATENAME,district_master.cDistrictName as DISTRICTNAME,city_master.cCityName as CITYNAME,location_master.cLocationName as LOCATIONNAME,property_category_master.cPropertyCategoryName as PROPERTYCATEGORYNAME FROM requirement_master LEFT JOIN client_master ON requirement_master.iClientId=client_master.iClientId LEFT JOIN state_master ON client_master.iStateId=state_master.iStateId LEFT JOIN district_master ON client_master.iDistrictId=district_master.iDistrictId LEFT JOIN city_master ON client_master.iCityId=city_master.iCityId LEFT JOIN location_master ON client_master.iLocationId=location_master.iLocationId LEFT JOIN property_category_master ON requirement_master.iPropertyCategoryId=property_category_master.iPropertyCategoryId WHERE requirement_master.iClientId='" . $ClientId . "' AND requirement_master.bActive=1 AND requirement_master.bDelete=0
				UNION ALL
				SELECT property_master.iPropertyId as ID,property_master.dDate as DATE,property_master.cPropertyName as TITLE,client_master.cClientName as CLIENTNAME,'PSR' as TYPE, state_master.cStateName as STATENAME,district_master.cDistrictName as DISTRICTNAME,city_master.cCityName as CITYNAME,location_master.cLocationName as LOCATIONNAME,property_category_master.cPropertyCategoryName as PROPERTYCATEGORYNAME FROM property_master LEFT JOIN client_master ON property_master.iClientId=client_master.iClientId LEFT JOIN state_master ON client_master.iStateId=state_master.iStateId LEFT JOIN district_master ON client_master.iDistrictId=district_master.iDistrictId LEFT JOIN city_master ON client_master.iCityId=city_master.iCityId LEFT JOIN location_master ON client_master.iLocationId=location_master.iLocationId LEFT JOIN property_category_master ON property_master.iPropertyCategoryId=property_category_master.iPropertyCategoryId WHERE property_master.iClientId='" . $ClientId . "' AND property_master.bActive=1 AND property_master.bDelete=0";

        $query = $this->db->query($sql);

        return $query;
    }

    //-----------------------------------------------------Agreement Type---------------------------------------------------------------------------------------

    function get_all_agreement_type_master() {
        $sql = "SELECT agreement_type_master.iAgreementTypeId,agreement_type_master.cAgreementTypeName,CASE agreement_type_master.bActive WHEN 1 THEN 'Yes' ELSE 'No' END AS 'bActive' FROM agreement_type_master WHERE agreement_type_master.bDelete=0";

        $query = $this->db->query($sql);

        return $query;
    }

    function agreement_type_master_get_by_id($id) {
        $sql = "SELECT * FROM agreement_type_master WHERE agreement_type_master.iAgreementTypeId='" . $id . "'";

        $query = $this->db->query($sql);

        if ($query) {
            $result = $query->row_array();

            return $result;
        }
    }

    function add_agreement_type_master($data) {
        $AgreementTypeName = trim($data['txtAgreementTypeName']);
        $Active = (int) trim($data['chkActive']);

        $sql = "SELECT * FROM agreement_type_master WHERE agreement_type_master.cAgreementTypeName='" . $AgreementTypeName . "' AND agreement_type_master.bDelete=0";

        $query = $this->db->query($sql);

        if ($query) {
            if ($query->num_rows > 0) {
                return json_encode(Array("status" => "0", "msg" => EXIST_MSG));
            } else {
                $addData = array(
                    'cAgreementTypeName' => $AgreementTypeName,
                    'bActive' => $Active,
                );

                $insert = $this->db->insert('agreement_type_master', $addData);

                if ($insert) {
                    return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
                } else {
                    return json_encode(Array("status" => "0", "msg" => ERROR_INSERT_MSG));
                }
            }
        }
    }

    function edit_agreement_type_master($data) {
        $hfAgreementTypeId = trim($data['hfAgreementTypeId']);
        $AgreementTypeName = trim($data['txtAgreementTypeName']);
        $Active = trim($data['hfActive']);

        $sql = "SELECT * FROM agreement_type_master WHERE agreement_type_master.cAgreementTypeName='" . $AgreementTypeName . "' AND agreement_type_master.bDelete=0 AND agreement_type_master.iAgreementTypeId!='" . $hfAgreementTypeId . "'";

        $query = $this->db->query($sql);

        if ($query) {
            if ($query->num_rows > 0) {
                return json_encode(Array("status" => "0", "msg" => EXIST_MSG));
            } else {
                $editData = array(
                    'cAgreementTypeName' => $AgreementTypeName,
                    'bActive' => $Active,
                );

                $this->db->where('iAgreementTypeId', $hfAgreementTypeId);
                $update = $this->db->update('agreement_type_master', $editData);

                if ($update) {
                    return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
                } else {
                    return json_encode(Array("status" => "0", "msg" => ERROR_UPDATE_MSG));
                }
            }
        }
    }

    function delete_agreement_type_master($id) {
        $sql = "UPDATE agreement_type_master SET agreement_type_master.bDelete=1 WHERE agreement_type_master.iAgreementTypeId='" . $id . "'";

        $query = $this->db->query($sql);

        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    //-----------------------------------------------------Call Type-------------------------------------------------------------------------------------------

    function get_all_call_type_master() {
        $sql = "SELECT call_type_master.iCallTypeId,call_type_master.cCallTypeName,CASE call_type_master.bActive WHEN 1 THEN 'Yes' ELSE 'No' END AS 'bActive' FROM call_type_master WHERE call_type_master.bDelete=0";

        $query = $this->db->query($sql);

        return $query;
    }

    function call_type_master_get_by_id($id) {
        $sql = "SELECT * FROM call_type_master WHERE call_type_master.iCallTypeId='" . $id . "'";

        $query = $this->db->query($sql);

        if ($query) {
            $result = $query->row_array();

            return $result;
        }
    }

    function add_call_type_master($data) {
        $CallTypeName = trim($data['txtCallTypeName']);
        $Active = (int) trim($data['chkActive']);

        $sql = "SELECT * FROM call_type_master WHERE call_type_master.cCallTypeName='" . $CallTypeName . "' AND call_type_master.bDelete=0";

        $query = $this->db->query($sql);

        if ($query) {
            if ($query->num_rows > 0) {
                return json_encode(Array("status" => "0", "msg" => EXIST_MSG));
            } else {
                $addData = array(
                    'cCallTypeName' => $CallTypeName,
                    'bActive' => $Active,
                );

                $insert = $this->db->insert('call_type_master', $addData);

                if ($insert) {
                    return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
                } else {
                    return json_encode(Array("status" => "0", "msg" => ERROR_INSERT_MSG));
                }
            }
        }
    }

    function edit_call_type_master($data) {
        $hfCallTypeId = trim($data['hfCallTypeId']);
        $CallTypeName = trim($data['txtCallTypeName']);
        $Active = trim($data['hfActive']);

        $sql = "SELECT * FROM call_type_master WHERE call_type_master.cCallTypeName='" . $CallTypeName . "' AND call_type_master.bDelete=0 AND call_type_master.iCallTypeId!='" . $hfCallTypeId . "'";

        $query = $this->db->query($sql);

        if ($query) {
            if ($query->num_rows > 0) {
                return json_encode(Array("status" => "0", "msg" => EXIST_MSG));
            } else {
                $editData = array(
                    'cCallTypeName' => $CallTypeName,
                    'bActive' => $Active,
                );

                $this->db->where('iCallTypeId', $hfCallTypeId);
                $update = $this->db->update('call_type_master', $editData);

                if ($update) {
                    return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
                } else {
                    return json_encode(Array("status" => "0", "msg" => ERROR_UPDATE_MSG));
                }
            }
        }
    }

    function delete_call_type_master($id) {
        $sql = "UPDATE call_type_master SET call_type_master.bDelete=1 WHERE call_type_master.iCallTypeId='" . $id . "'";

        $query = $this->db->query($sql);

        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    //-----------------------------------------------------City------------------------------------------------------------------------------------------------

    function get_all_city_master() {
        $sql = "SELECT city_master.iCityId,city_master.cCityName,city_master.cPinCode,state_master.cStateName,district_master.cDistrictName,CASE city_master.bActive WHEN 1 THEN 'Yes' ELSE 'No' END AS 'bActive'
			  FROM city_master LEFT JOIN state_master ON city_master.iStateId=state_master.iStateId LEFT JOIN district_master ON city_master.iDistrictId=district_master.iDistrictId WHERE city_master.bDelete=0";

        $query = $this->db->query($sql);

        return $query;
    }

    function city_master_get_by_id($id) {
        $sql = "SELECT * FROM city_master WHERE iCityId='" . $id . "'";

        $query = $this->db->query($sql);

        if ($query) {
            $result = $query->row_array();

            return $result;
        }
    }

    function add_city_master($data) {
        $StateId = trim($data['cmbState']);
        $DistrictId = trim($data['cmbDistrict']);
        $CityName = trim($data['txtCityName']);
        $PinCode = trim($data['txtPinCode']);
        $Active = (int) trim($data['chkActive']);

        $sql = "SELECT * FROM city_master WHERE iStateId='" . $StateId . "' AND iDistrictId='" . $DistrictId . "' AND city_master.cCityName='" . $CityName . "' AND city_master.bDelete=0";

        $query = $this->db->query($sql);

        if ($query) {
            if ($query->num_rows > 0) {
                return json_encode(Array("status" => "0", "msg" => EXIST_MSG));
            } else {
                $addData = array(
                    'cCityName' => $CityName,
                    'iDistrictId' => $DistrictId,
                    'iStateId' => $StateId,
                    'cPinCode' => $PinCode,
                    'bActive' => $Active,
                );

                $insert = $this->db->insert('city_master', $addData);

                if ($insert) {
                    return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
                } else {
                    return json_encode(Array("status" => "0", "msg" => ERROR_INSERT_MSG));
                }
            }
        }
    }

    function edit_city_master($data) {
        $hfCityId = trim($data['hfCityId']);

        $StateId = trim($data['cmbState']);
        $DistrictId = trim($data['cmbDistrict']);
        $CityName = trim($data['txtCityName']);
        $PinCode = trim($data['txtPinCode']);
        $Active = (int) trim($data['chkActive']);

        $sql = "SELECT * FROM city_master WHERE iStateId='" . $StateId . "' AND iDistrictId='" . $DistrictId . "' AND city_master.cCityName='" . $CityName . "' AND city_master.bDelete=0 AND city_master.iCityId!='" . $hfCityId . "'";

        $query = $this->db->query($sql);

        if ($query) {
            if ($query->num_rows > 0) {
                return json_encode(Array("status" => "0", "msg" => EXIST_MSG));
            } else {
                $editData = array(
                    'cCityName' => $CityName,
                    'iDistrictId' => $DistrictId,
                    'iStateId' => $StateId,
                    'cPinCode' => $PinCode,
                    'bActive' => $Active,
                );

                $this->db->where('iCityId', $hfCityId);
                $update = $this->db->update('city_master', $editData);

                if ($update) {
                    return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
                } else {
                    return json_encode(Array("status" => "0", "msg" => ERROR_UPDATE_MSG));
                }
            }
        }
    }

    function delete_city_master($id) {
        $sql = "UPDATE city_master SET city_master.bDelete=1 WHERE city_master.iCityId='" . $id . "'";

        $query = $this->db->query($sql);

        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    //---------------------------------------------------------District----------------------------------------------------------------------------------------

    function get_all_district_master() {
        $sql = "SELECT district_master.iDistrictId,state_master.cStateName,district_master.cDistrictName,CASE district_master.bActive WHEN 1 THEN 'Yes' ELSE 'No' END AS 'bActive' 
			  FROM district_master LEFT JOIN state_master ON district_master.iStateId=state_master.iStateId WHERE district_master.bDelete=0";

        $query = $this->db->query($sql);

        return $query;
    }

    function district_master_get_by_id($id) {
        $sql = "SELECT * FROM district_master WHERE district_master.iDistrictId='" . $id . "'";

        $query = $this->db->query($sql);

        if ($query) {
            $result = $query->row_array();

            return $result;
        }
    }

    function add_district_master($data) {
        $StateId = trim($data['cmbState']);
        $DistrictName = trim($data['txtDistrictName']);
        $Active = (int) trim($data['chkActive']);

        $sql = "SELECT * FROM district_master WHERE district_master.iStateId='" . $StateId . "' AND district_master.cDistrictName='" . $DistrictName . "' AND district_master.bDelete=0";

        $query = $this->db->query($sql);

        if ($query) {
            if ($query->num_rows > 0) {
                return json_encode(Array("status" => "0", "msg" => EXIST_MSG));
            } else {
                $addData = array(
                    'iStateId' => $StateId,
                    'cDistrictName' => $DistrictName,
                    'bActive' => $Active,
                );

                $insert = $this->db->insert('district_master', $addData);

                if ($insert) {
                    return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
                } else {
                    return json_encode(Array("status" => "0", "msg" => ERROR_INSERT_MSG));
                }
            }
        }
    }

    function edit_district_master($data) {
        $hfDistrictId = trim($data['hfDistrictId']);
        $StateId = trim($data['cmbState']);
        $DistrictName = trim($data['txtDistrictName']);
        $Active = (int) trim($data['chkActive']);

        $sql = "SELECT * FROM district_master WHERE district_master.iStateId='" . $StateId . "' AND district_master.cDistrictName='" . $DistrictName . "' AND district_master.bDelete=0 AND district_master.iDistrictId!='" . $hfDistrictId . "'";

        $query = $this->db->query($sql);

        if ($query) {
            if ($query->num_rows > 0) {
                return json_encode(Array("status" => "0", "msg" => EXIST_MSG));
            } else {
                $editData = array(
                    'iStateId' => $StateId,
                    'cDistrictName' => $DistrictName,
                    'bActive' => $Active,
                );

                $this->db->where('iDistrictId', $hfDistrictId);
                $update = $this->db->update('district_master', $editData);

                if ($update) {
                    return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
                } else {
                    return json_encode(Array("status" => "0", "msg" => ERROR_UPDATE_MSG));
                }
            }
        }
    }

    function delete_district_master($id) {
        $sql = "UPDATE district_master SET district_master.bDelete=1 WHERE district_master.iDistrictId='" . $id . "'";

        $query = $this->db->query($sql);

        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    //-----------------------------------------------------Escalation------------------------------------------------------------------------------------------

    function get_all_escalation_master() {
        $sql = "SELECT escalation_master.iEscalationId,escalation_master.cEscalationName,CASE escalation_master.bActive WHEN 1 THEN 'Yes' ELSE 'No' END AS 'bActive' FROM escalation_master WHERE escalation_master.bDelete=0";

        $query = $this->db->query($sql);

        return $query;
    }

    function escalation_master_get_by_id($id) {
        $sql = "SELECT * FROM escalation_master WHERE escalation_master.iEscalationId='" . $id . "'";

        $query = $this->db->query($sql);

        if ($query) {
            $result = $query->row_array();

            return $result;
        }
    }

    function add_escalation_master($data) {
        $EscalationName = trim($data['txtEscalationName']);
        $Active = (int) trim($data['chkActive']);

        $sql = "SELECT * FROM escalation_master WHERE escalation_master.cEscalationName='" . $EscalationName . "' AND escalation_master.bDelete=0";

        $query = $this->db->query($sql);

        if ($query) {
            if ($query->num_rows > 0) {
                return json_encode(Array("status" => "0", "msg" => EXIST_MSG));
            } else {
                $addData = array(
                    'cEscalationName' => $EscalationName,
                    'bActive' => $Active,
                );

                $insert = $this->db->insert('escalation_master', $addData);

                if ($insert) {
                    return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
                } else {
                    return json_encode(Array("status" => "0", "msg" => ERROR_INSERT_MSG));
                }
            }
        }
    }

    function edit_escalation_master($data) {
        $hfEscalationId = trim($data['hfEscalationId']);
        $EscalationName = trim($data['txtEscalationName']);
        $Active = trim($data['hfActive']);

        $sql = "SELECT * FROM escalation_master WHERE escalation_master.cEscalationName='" . $EscalationName . "' AND escalation_master.bDelete=0 AND escalation_master.iEscalationId!='" . $hfEscalationId . "'";

        $query = $this->db->query($sql);

        if ($query) {
            if ($query->num_rows > 0) {
                return json_encode(Array("status" => "0", "msg" => EXIST_MSG));
            } else {
                $editData = array(
                    'cEscalationName' => $EscalationName,
                    'bActive' => $Active,
                );

                $this->db->where('iEscalationId', $hfEscalationId);
                $update = $this->db->update('escalation_master', $editData);

                if ($update) {
                    return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
                } else {
                    return json_encode(Array("status" => "0", "msg" => ERROR_UPDATE_MSG));
                }
            }
        }
    }

    function delete_escalation_master($id) {
        $sql = "UPDATE escalation_master SET escalation_master.bDelete=1 WHERE escalation_master.iEscalationId='" . $id . "'";

        $query = $this->db->query($sql);

        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    //-----------------------------------------------------Location------------------------------------------------------------------------------------------------

    function get_all_location_master() {
        $sql = "SELECT location_master.iLocationId,location_master.cLocationName,location_master.cLandmark,state_master.cStateName,state_master.cStateAbbreviation,district_master.cDistrictName,city_master.cCityName,CASE location_master.bActive WHEN 1 THEN 'Yes' ELSE 'No' END AS 'bActive'
			  FROM location_master LEFT JOIN state_master ON location_master.iStateId=state_master.iStateId LEFT JOIN district_master ON location_master.iDistrictId=district_master.iDistrictId LEFT JOIN city_master ON location_master.iCityId=city_master.iCityId WHERE location_master.bDelete=0";

        $query = $this->db->query($sql);

        return $query;
    }

    function location_master_get_by_id($id) {
        $sql = "SELECT * FROM location_master WHERE location_master.iLocationId='" . $id . "'";

        $query = $this->db->query($sql);

        if ($query) {
            $result = $query->row_array();

            return $result;
        }
    }

    function add_location_master($data) {
        $StateId = trim($data['cmbState']);
        $DistrictId = trim($data['cmbDistrict']);
        $CityId = trim($data['cmbCity']);
        $LocationName = trim($data['txtLocationName']);
        $Landmark = trim($data['txtLandmark']);
        $Active = (int) trim($data['chkActive']);

        $sql = "SELECT * FROM location_master WHERE location_master.iStateId='" . $StateId . "' AND location_master.iDistrictId='" . $DistrictId . "' AND location_master.iCityId='" . $CityId . "' AND location_master.cLocationName='" . $LocationName . "' AND location_master.bDelete=0";

        $query = $this->db->query($sql);

        if ($query) {
            if ($query->num_rows > 0) {
                return json_encode(Array("status" => "0", "msg" => EXIST_MSG));
            } else {
                $addData = array(
                    'iStateId' => $StateId,
                    'iDistrictId' => $DistrictId,
                    'iCityId' => $CityId,
                    'cLocationName' => $LocationName,
                    'cLandmark' => $Landmark,
                    'bActive' => $Active,
                );

                $insert = $this->db->insert('location_master', $addData);

                if ($insert) {
                    return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
                } else {
                    return json_encode(Array("status" => "0", "msg" => ERROR_INSERT_MSG));
                }
            }
        }
    }

    function edit_location_master($data) {
        $hfLocationId = trim($data['hfLocationId']);
        $StateId = trim($data['cmbState']);
        $DistrictId = trim($data['cmbDistrict']);
        $CityId = trim($data['cmbCity']);
        $LocationName = trim($data['txtLocationName']);
        $Landmark = trim($data['txtLandmark']);
        $Active = (int) trim($data['chkActive']);

        $sql = "SELECT * FROM location_master WHERE location_master.iStateId='" . $StateId . "' AND location_master.iDistrictId='" . $DistrictId . "' AND location_master.iCityId='" . $CityId . "' AND location_master.cLocationName='" . $LocationName . "' AND location_master.bDelete=0 AND location_master.iLocationId!='" . $hfLocationId . "'";

        $query = $this->db->query($sql);

        if ($query) {
            if ($query->num_rows > 0) {
                return json_encode(Array("status" => "0", "msg" => EXIST_MSG));
            } else {
                $editData = array(
                    'cLocationName' => $LocationName,
                    'iCityId' => $CityId,
                    'iDistrictId' => $DistrictId,
                    'iStateId' => $StateId,
                    'cLandmark' => $Landmark,
                    'bActive' => $Active,
                );

                $this->db->where('iLocationId', $hfLocationId);
                $update = $this->db->update('location_master', $editData);

                if ($update) {
                    return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
                } else {
                    return json_encode(Array("status" => "0", "msg" => ERROR_UPDATE_MSG));
                }
            }
        }
    }

    function delete_location_master($id) {
        $sql = "UPDATE location_master SET location_master.bDelete=1 WHERE location_master.iLocationId='" . $id . "'";

        $query = $this->db->query($sql);

        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    //--------------------------------------------------------Party--------------------------------------------------------------------------------------------

    /* function get_all_party_master()
      {
      $sql="SELECT party_master.iPartyId,party_master.cPartyName,party_type_master.cPartyTypeName,CASE party_master.bActive WHEN 1 THEN 'Yes' ELSE 'No' END AS 'bActive'
      FROM party_master LEFT JOIN party_type_master ON party_master.iPartyTypeId=party_type_master.iPartyTypeId WHERE party_master.bDelete=0";

      $query = $this->db->query($sql);

      return $query;
      }

      function party_master_get_by_id($id)
      {
      $sql="SELECT * FROM party_master WHERE party_master.iPartyId='".$id."'";

      $query = $this->db->query($sql);

      if($query)
      {
      $result = $query->row_array();

      return $result;
      }
      }

      function add_party_master($data)
      {
      $PartyTypeId = trim($data['cmbPartyType']);
      $PartyName = trim($data['txtPartyName']);
      $Address = trim($data['txtAddress']);
      $StateId = trim($data['cmbState']);
      $DistrictId = trim($data['cmbDistrict']);
      $CityId = trim($data['cmbCity']);
      $Location = trim($data['txtLocation']);
      $Landmark = trim($data['txtLandmark']);

      $ContactPerson1Name = trim($data['txtContactPerson1Name']);
      $ContactPerson1Designation = trim($data['txtContactPerson1Designation']);
      $ContactPerson1PhoneNo1 = trim($data['txtContactPerson1PhoneNo1']);
      $ContactPerson1PhoneNo2 = trim($data['txtContactPerson1PhoneNo2']);
      $ContactPerson1Email = trim($data['txtContactPerson1Email']);

      $ContactPerson2Name = trim($data['txtContactPerson2Name']);
      $ContactPerson2Designation = trim($data['txtContactPerson2Designation']);
      $ContactPerson2PhoneNo1 = trim($data['txtContactPerson2PhoneNo1']);
      $ContactPerson2PhoneNo2 = trim($data['txtContactPerson2PhoneNo2']);
      $ContactPerson2Email = trim($data['txtContactPerson2Email']);

      $ContactPerson3Name = trim($data['txtContactPerson3Name']);
      $ContactPerson3Designation = trim($data['txtContactPerson3Designation']);
      $ContactPerson3PhoneNo1 = trim($data['txtContactPerson3PhoneNo1']);
      $ContactPerson3PhoneNo2 = trim($data['txtContactPerson3PhoneNo2']);
      $ContactPerson3Email = trim($data['txtContactPerson3Email']);

      $Active = (int)trim($data['chkActive']);



      $sql="SELECT * FROM party_master WHERE party_master.iPartyTypeId='".$PartyTypeId."' AND party_master.cPartyName='".$PartyName."' AND party_master.bDelete=0";

      $query = $this->db->query($sql);

      if($query)
      {
      if($query->num_rows > 0)
      {
      return json_encode(Array("status"=>"0","msg"=>EXIST_MSG));
      }
      else
      {
      $addData = array(
      'iPartyTypeId' => $PartyTypeId,
      'cPartyName' => $PartyName,
      'cAddress' => $Address,
      'iStateId' => $StateId,
      'iDistrictId' => $DistrictId,
      'iCityId' => $CityId,
      'cLocation' => $Location,
      'cLandmark' => $Landmark,
      'cContactPerson1Name' => $ContactPerson1Name,
      'cContactPerson1Designation' => $ContactPerson1Designation,
      'cContactPerson1PhoneNo1' => $ContactPerson1PhoneNo1,
      'cContactPerson1PhoneNo2' => $ContactPerson1PhoneNo2,
      'cContactPerson1Email' => $ContactPerson1Email,
      'cContactPerson2Name' => $ContactPerson2Name,
      'cContactPerson2Designation' => $ContactPerson2Designation,
      'cContactPerson2PhoneNo1' => $ContactPerson2PhoneNo1,
      'cContactPerson2PhoneNo2' => $ContactPerson2PhoneNo2,
      'cContactPerson2Email' => $ContactPerson2Email,
      'cContactPerson3Name' => $ContactPerson3Name,
      'cContactPerson3Designation' => $ContactPerson3Designation,
      'cContactPerson3PhoneNo1' => $ContactPerson3PhoneNo1,
      'cContactPerson3PhoneNo2' => $ContactPerson3PhoneNo2,
      'cContactPerson3Email' => $ContactPerson3Email,
      'bActive' => $Active,
      );

      $insert = $this->db->insert('party_master', $addData);

      if($insert)
      {
      return json_encode(Array("status"=>"1","msg"=>SUCCESS_INSERT_MSG));
      }
      else
      {
      return json_encode(Array("status"=>"0","msg"=>ERROR_INSERT_MSG));
      }
      }
      }
      }

      function edit_party_master($data)
      {
      $hfPartyId = trim($data['hfPartyId']);

      $PartyTypeId = trim($data['cmbPartyType']);
      $PartyName = trim($data['txtPartyName']);
      $Address = trim($data['txtAddress']);
      $StateId = trim($data['cmbState']);
      $DistrictId = trim($data['cmbDistrict']);
      $CityId = trim($data['cmbCity']);
      $Location = trim($data['txtLocation']);
      $Landmark = trim($data['txtLandmark']);

      $ContactPerson1Name = trim($data['txtContactPerson1Name']);
      $ContactPerson1Designation = trim($data['txtContactPerson1Designation']);
      $ContactPerson1PhoneNo1 = trim($data['txtContactPerson1PhoneNo1']);
      $ContactPerson1PhoneNo2 = trim($data['txtContactPerson1PhoneNo2']);
      $ContactPerson1Email = trim($data['txtContactPerson1Email']);

      $ContactPerson2Name = trim($data['txtContactPerson2Name']);
      $ContactPerson2Designation = trim($data['txtContactPerson2Designation']);
      $ContactPerson2PhoneNo1 = trim($data['txtContactPerson2PhoneNo1']);
      $ContactPerson2PhoneNo2 = trim($data['txtContactPerson2PhoneNo2']);
      $ContactPerson2Email = trim($data['txtContactPerson2Email']);

      $ContactPerson3Name = trim($data['txtContactPerson3Name']);
      $ContactPerson3Designation = trim($data['txtContactPerson3Designation']);
      $ContactPerson3PhoneNo1 = trim($data['txtContactPerson3PhoneNo1']);
      $ContactPerson3PhoneNo2 = trim($data['txtContactPerson3PhoneNo2']);
      $ContactPerson3Email = trim($data['txtContactPerson3Email']);

      $sql="SELECT * FROM party_master WHERE party_master.iPartyTypeId='".$PartyTypeId."' AND party_master.cPartyName='".$PartyName."' AND party_master.bDelete=0 AND party_master.iPartyId!='".$hfPartyId."'";

      $query = $this->db->query($sql);

      if($query)
      {
      if($query->num_rows > 0)
      {
      return json_encode(Array("status"=>"0","msg"=>EXIST_MSG));
      }
      else
      {
      $editData = array(
      'iPartyTypeId' => $PartyTypeId,
      'cPartyName' => $PartyName,
      'cAddress' => $Address,
      'iStateId' => $StateId,
      'iDistrictId' => $DistrictId,
      'iCityId' => $CityId,
      'cLocation' => $Location,
      'cLandmark' => $Landmark,
      'cContactPerson1Name' => $ContactPerson1Name,
      'cContactPerson1Designation' => $ContactPerson1Designation,
      'cContactPerson1PhoneNo1' => $ContactPerson1PhoneNo1,
      'cContactPerson1PhoneNo2' => $ContactPerson1PhoneNo2,
      'cContactPerson1Email' => $ContactPerson1Email,
      'cContactPerson2Name' => $ContactPerson2Name,
      'cContactPerson2Designation' => $ContactPerson2Designation,
      'cContactPerson2PhoneNo1' => $ContactPerson2PhoneNo1,
      'cContactPerson2PhoneNo2' => $ContactPerson2PhoneNo2,
      'cContactPerson2Email' => $ContactPerson2Email,
      'cContactPerson3Name' => $ContactPerson3Name,
      'cContactPerson3Designation' => $ContactPerson3Designation,
      'cContactPerson3PhoneNo1' => $ContactPerson3PhoneNo1,
      'cContactPerson3PhoneNo2' => $ContactPerson3PhoneNo2,
      'cContactPerson3Email' => $ContactPerson3Email,
      'bActive' => $Active,
      );

      $this->db->where('iPartyId', $hfPartyId);
      $update = $this->db->update('party_master', $editData);

      if($update)
      {
      return json_encode(Array("status"=>"1","msg"=>SUCCESS_INSERT_MSG));
      }
      else
      {
      return json_encode(Array("status"=>"0","msg"=>ERROR_UPDATE_MSG));
      }
      }
      }
      }

      function delete_party_master($id)
      {
      $sql="UPDATE party_master SET party_master.bDelete=1 WHERE party_master.iPartyId='".$id."'";

      $query = $this->db->query($sql);

      if($query)
      {
      return TRUE;
      }
      else
      {
      return FALSE;
      }
      } */

    //--------------------------------------------------------Party Type---------------------------------------------------------------------------------------

    /* function get_all_party_type_master()
      {
      $sql="SELECT party_type_master.iPartyTypeId,party_type_master.cPartyTypeName,CASE party_type_master.bActive WHEN 1 THEN 'Yes' ELSE 'No' END AS 'bActive' FROM party_type_master WHERE party_type_master.bDelete=0";

      $query = $this->db->query($sql);

      return $query;
      }

      function party_type_master_get_by_id($id)
      {
      $sql="SELECT * FROM party_type_master WHERE party_type_master.iPartyTypeId='".$id."'";

      $query = $this->db->query($sql);

      if($query)
      {
      $result = $query->row_array();

      return $result;
      }
      }

      function add_party_type_master($data)
      {
      $PartyTypeName = trim($data['txtPartyTypeName']);
      $Active = (int)trim($data['chkActive']);

      $sql="SELECT * FROM party_type_master WHERE party_type_master.cPartyTypeName='".$PartyTypeName."' AND party_type_master.bDelete=0";

      $query = $this->db->query($sql);

      if($query)
      {
      if($query->num_rows > 0)
      {
      return json_encode(Array("status"=>"0","msg"=>EXIST_MSG));
      }
      else
      {
      $addData = array(
      'cPartyTypeName' => $PartyTypeName,
      'bActive' => $Active,
      );

      $insert = $this->db->insert('party_type_master', $addData);

      if($insert)
      {
      return json_encode(Array("status"=>"1","msg"=>SUCCESS_INSERT_MSG));
      }
      else
      {
      return json_encode(Array("status"=>"0","msg"=>ERROR_INSERT_MSG));
      }
      }
      }
      }

      function edit_party_type_master($data)
      {
      $hfPartyTypeId = trim($data['hfPartyTypeId']);
      $PartyTypeName = trim($data['txtPartyTypeName']);
      $Active = trim($data['hfActive']);

      $sql="SELECT * FROM party_type_master WHERE party_type_master.cPartyTypeName='".$PartyTypeName."' AND party_type_master.bDelete=0 AND party_type_master.iPartyTypeId!='".$hfPartyTypeId."'";

      $query = $this->db->query($sql);

      if($query)
      {
      if($query->num_rows > 0)
      {
      return json_encode(Array("status"=>"0","msg"=>EXIST_MSG));
      }
      else
      {
      $editData = array(
      'cPartyTypeName' => $PartyTypeName,
      'bActive' => $Active,
      );

      $this->db->where('iPartyTypeId', $hfPartyTypeId);
      $update = $this->db->update('party_type_master', $editData);

      if($update)
      {
      return json_encode(Array("status"=>"1","msg"=>SUCCESS_INSERT_MSG));
      }
      else
      {
      return json_encode(Array("status"=>"0","msg"=>ERROR_UPDATE_MSG));
      }
      }
      }
      }

      function delete_party_type_master($id)
      {
      $sql="UPDATE party_type_master SET party_type_master.bDelete=1 WHERE party_type_master.iPartyTypeId='".$id."'";

      $query = $this->db->query($sql);

      if($query)
      {
      return TRUE;
      }
      else
      {
      return FALSE;
      }
      } */

    //--------------------------------------------------------Client--------------------------------------------------------------------------------------------

    function get_all_client_master() {




        $sql = "SELECT client_master.iClientId,client_master.cClientName,
					CASE client_master.bActive WHEN 1 THEN 'Yes' ELSE 'No' END AS 'bActive',
					cContactPerson1PhoneNo1 AS ph1,cContactPerson1PhoneNo2 AS ph12,
					cContactPerson2PhoneNo1 AS ph2,cContactPerson2PhoneNo2 AS ph22,
					cContactPerson3PhoneNo1 AS ph3,cContactPerson3PhoneNo2 AS ph32,
					cContactPerson4PhoneNo1 AS ph4,cContactPerson4PhoneNo2 AS ph42,
					cContactPerson5PhoneNo1 AS ph5,cContactPerson5PhoneNo2 AS ph52,
					cContactPerson6PhoneNo1 AS ph6,cContactPerson6PhoneNo2 AS ph62,
					cContactPerson7PhoneNo1 AS ph7,cContactPerson7PhoneNo2 AS ph72,
					cContactPerson8PhoneNo1 AS ph8,cContactPerson8PhoneNo2 AS ph82,
					cContactPerson9PhoneNo1 AS ph9,cContactPerson9PhoneNo2 AS ph92,
					cContactPerson10PhoneNo1 AS ph10,cContactPerson10PhoneNo2 AS ph102 ";

        $sql = $sql . "			
					,( SELECT csm.cCurrentStatusName FROM dcr_summary ds  join dcr_detail dd on dd.iDCRId = ds.iDCRId
left outer join current_status_master csm on csm.iCurrentStatusId = dd.iCurrentStatusId
 where iClientReqId = client_master.iClientId
					and ds.bDelete=0 and dd.bDelete=0  
					and dd.iCurrentStatusId !=0
					order by dDCRDate desc limit 0,1 ) as totdcrrf ";

        $sql = $sql . "			
					,( SELECT count(*) FROM dcr_summary ds  join dcr_detail dd on dd.iDCRId = ds.iDCRId
left outer join current_status_master csm on csm.iCurrentStatusId = dd.iCurrentStatusId
 where iClientReqId = client_master.iClientId
					and ds.bDelete=0 and dd.bDelete=0  
					and dd.iCurrentStatusId !=0
					and dd.iTaskId  = 3
					) as tot_inspections ";

        $sql = $sql . "			
					,( SELECT count(*) FROM dcr_summary ds  join dcr_detail dd on dd.iDCRId = ds.iDCRId
left outer join current_status_master csm on csm.iCurrentStatusId = dd.iCurrentStatusId
 where iClientReqId = client_master.iClientId
					and ds.bDelete=0 and dd.bDelete=0  
					and dd.iCurrentStatusId !=0
					and dd.iTaskId  = 5
					 ) as tot_dealdone ";


        $sql = $sql . "			
					,(SELECT count(*) FROM requirement_master r where r.iClientId = client_master.iClientId) as totrf
					
					,(SELECT count(*) FROM property_master p where p.iClientId = client_master.iClientId) as totprc

			  FROM client_master 
			  WHERE client_master.bDelete=0
			  and  client_master.bActive=1
			  order by client_master.dCreateDate desc, iClientId desc";
        //	  
//order by client_master.cClientName

        $query = $this->db->query($sql);

        return $query;
    }

    function get_all_client_master_datatable() {

        $iDisplayStart = $this->input->get_post('iDisplayStart', true);
        $iDisplayLength = $this->input->get_post('iDisplayLength', true);
        $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
        $iSortingCols = $this->input->get_post('iSortingCols', true);
        $sSearch = $this->input->get_post('sSearch', true);
        $sEcho = $this->input->get_post('sEcho', true);



        $aColumns = array("client_master.iClientId,client_master.cClientName,
					CASE client_master.bActive WHEN 1 THEN 'Yes' ELSE 'No' END AS 'bActive',
					cContactPerson1PhoneNo1 AS ph1,cContactPerson1PhoneNo2 AS ph12,
					cContactPerson2PhoneNo1 AS ph2,cContactPerson2PhoneNo2 AS ph22,
					cContactPerson3PhoneNo1 AS ph3,cContactPerson3PhoneNo2 AS ph32,
					cContactPerson4PhoneNo1 AS ph4,cContactPerson4PhoneNo2 AS ph42,
					cContactPerson5PhoneNo1 AS ph5,cContactPerson5PhoneNo2 AS ph52,
					cContactPerson6PhoneNo1 AS ph6,cContactPerson6PhoneNo2 AS ph62,
					cContactPerson7PhoneNo1 AS ph7,cContactPerson7PhoneNo2 AS ph72,
					cContactPerson8PhoneNo1 AS ph8,cContactPerson8PhoneNo2 AS ph82,
					cContactPerson9PhoneNo1 AS ph9,cContactPerson9PhoneNo2 AS ph92,
					cContactPerson10PhoneNo1 AS ph10,cContactPerson10PhoneNo2 AS ph102,( SELECT csm.cCurrentStatusName FROM dcr_summary ds  join dcr_detail dd on dd.iDCRId = ds.iDCRId
left outer join current_status_master csm on csm.iCurrentStatusId = dd.iCurrentStatusId
 where iClientReqId = client_master.iClientId
					and ds.bDelete=0 and dd.bDelete=0  
					and dd.iCurrentStatusId !=0
					order by dDCRDate desc limit 0,1 ) as totdcrrf,( SELECT count(*) FROM dcr_summary ds  join dcr_detail dd on dd.iDCRId = ds.iDCRId
left outer join current_status_master csm on csm.iCurrentStatusId = dd.iCurrentStatusId
 where iClientReqId = client_master.iClientId
					and ds.bDelete=0 and dd.bDelete=0  
					and dd.iCurrentStatusId !=0
					and dd.iTaskId  = 3
					) as tot_inspections,( SELECT count(*) FROM dcr_summary ds  join dcr_detail dd on dd.iDCRId = ds.iDCRId
left outer join current_status_master csm on csm.iCurrentStatusId = dd.iCurrentStatusId
 where iClientReqId = client_master.iClientId
					and ds.bDelete=0 and dd.bDelete=0  
					and dd.iCurrentStatusId !=0
					and dd.iTaskId  = 5
					 ) as tot_dealdone,(SELECT count(*) FROM requirement_master r where r.iClientId = client_master.iClientId) as totrf,(SELECT count(*) FROM property_master p where p.iClientId = client_master.iClientId) as totprc");




        // DB table to use
        $sIndexColumn = 'client_master.iClientId';
        $sTable = 'client_master';
        $where = "  client_master.bDelete=0 ";



        // Paging
        if (isset($iDisplayStart) && $iDisplayLength != '-1') {
            $this->db->limit($this->db->escape_str($iDisplayLength), $this->db->escape_str($iDisplayStart));
        }

        if (isset($iSortCol_0)) {
            for ($i = 0; $i < intval($iSortingCols); $i++) {
                $iSortCol = $this->input->get_post('iSortCol_' . $i, true);
                $bSortable = $this->input->get_post('bSortable_' . intval($iSortCol), true);
                $sSortDir = $this->input->get_post('sSortDir_' . $i, true);

                if ($bSortable == 'true') {
                    $col = intval($this->db->escape_str($iSortCol));
                    $this->db->order_by('iClientId', $this->db->escape_str($sSortDir));
                }
            }
        }

        // Ordering


        /*
         * Ordering
         */

        /*
         * Filtering
         * NOTE this does not match the built-in DataTables filtering which does it
         * word by word on any field. It's possible to do here, but concerned about efficiency
         * on very large tables, and MySQL's regex functionality is very limited
         */


        $sWhere = $where;
        if (isset($_GET['sSearch']) && $_GET['sSearch'] != "") {
            $where = $where . " and (";
            $sWhere = " (" . $where;
            $sWhere .= " cClientName LIKE '%" . $this->db->escape_like_str($sSearch) . "%' ";
//            for ( $i=0 ; $i<count($aColumns) ; $i++ )
//            {
//
//                if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $i!=0 && $i!=1)
//                {
//                    
//                    //$this->db->or_like($aColumns[$i], $this->db->escape_like_str($sSearch));
//                    $sWhere .= ' '.$aColumns[$i]." LIKE '%".$this->db->escape_like_str($sSearch)."%' OR ";
//                }
//            }
//            $sWhere = substr_replace( $sWhere, "", -3 );
            $sWhere .= '))';
        }
        /* Individual column filtering */
        for ($i = 0; $i < count($aColumns); $i++) {

            if (isset($_GET['bSearchable_' . $i]) && $_GET['bSearchable_' . $i] == "true" && $_GET['sSearch_' . $i] != '' && $i != 0 && $i != 1) {
                if ($sWhere == "") {
                    $sWhere = $where;
                } else {
                    $sWhere .= " AND ";
                }


                $sWhere .= $aColumns[$i] . " LIKE '%" . mysql_real_escape_string($_GET['sSearch_' . $i]) . "%' ";
            }
        }

        $this->db->select('SQL_CALC_FOUND_ROWS ' . str_replace(' , ', ' ', implode(', ', $aColumns)), false);
        $this->db->from($sTable);
        //$this->db->join("current_status_master", "property_master.iCurrentStatusId=current_status_master.iCurrentStatusId", "LEFT");
        $this->db->where($sWhere, null, false);
        $rResult = $this->db->get();


        //echo $this->db->last_query();die;


        $this->db->select('FOUND_ROWS() AS found_rows');
        $iFilteredTotal = $this->db->get()->row()->found_rows;

        // Total data set length

        $iTotal = $iFilteredTotal;

        // Output
        $output = array(
            'sEcho' => intval($sEcho),
            'iTotalRecords' => $iTotal,
            'iTotalDisplayRecords' => $iFilteredTotal,
            'aaData' => array()
        );


        $sno = 1;
        foreach ($rResult->result_array() as $aRow) {
            $row = array();
            foreach ($aRow as $col) {
                $row[] = $col;
            }

            $ClientId = trim($aRow['iClientId']);
            $ClientName = html_entity_decode($aRow['cClientName']);
            $Active = trim($aRow['bActive']);
            $phone = trim($aRow['ph1']);
            if (trim($aRow['ph12'])) {
                $phone = $phone . "<br />," . trim($aRow['ph12']);
            }
            if (trim($aRow['ph2'])) {
                $phone = $phone . "<br />," . trim($aRow['ph2']);
            }
            if (trim($aRow['ph22'])) {
                $phone = $phone . "<br />," . trim($aRow['ph22']);
            }
            if (trim($aRow['ph3'])) {
                $phone = $phone . "<br>," . trim($aRow['ph3']);
            }
            if (trim($aRow['ph32'])) {
                $phone = $phone . "<br />," . trim($aRow['ph32']);
            }
            if (trim($aRow['ph4'])) {
                $phone = $phone . "<br />," . trim($aRow['ph4']);
            }
            if (trim($aRow['ph42'])) {
                $phone = $phone . "<br>," . trim($aRow['ph42']);
            }
            if (trim($aRow['ph5'])) {
                $phone = $phone . "<br />," . trim($aRow['ph5']);
            }
            if (trim($aRow['ph52'])) {
                $phone = $phone . "<br />," . trim($aRow['ph52']);
            }
            if (trim($aRow['ph6'])) {
                $phone = $phone . "<br>," . trim($aRow['ph6']);
            }
            if (trim($aRow['ph62'])) {
                $phone = $phone . "<br />," . trim($aRow['ph62']);
            }
            if (trim($aRow['ph7'])) {
                $phone = $phone . "<br />," . trim($aRow['ph7']);
            }
            if (trim($aRow['ph72'])) {
                $phone = $phone . "<br>," . trim($aRow['ph72']);
            }
            if (trim($aRow['ph8'])) {
                $phone = $phone . "<br />," . trim($aRow['ph8']);
            }
            if (trim($aRow['ph82'])) {
                $phone = $phone . "<br />," . trim($aRow['ph82']);
            }
            if (trim($aRow['ph9'])) {
                $phone = $phone . "<br>," . trim($aRow['ph9']);
            }
            if (trim($aRow['ph92'])) {
                $phone = $phone . "<br />," . trim($aRow['ph92']);
            }if (trim($aRow['ph10'])) {
                $phone = $phone . "<br />," . trim($aRow['ph10']);
            }
            if (trim($aRow['ph102'])) {
                $phone = $phone . "<br />," . trim($aRow['ph102']);
            }



            $righttoadd = trim($this->session->userdata('RightToAdd_11'));
            $righttoedit = trim($this->session->userdata('RightToEdit_11'));
            $righttodelete = trim($this->session->userdata('RightToDelete_11'));


            $taskurl = base_url() . 'index.php/dashboard/add_form_dcr_single/0/popup';

            $taskurls = '<a  class="iframe" style="text-decoration:none;" href="' . $taskurl . '"  >+</a>';



            $deliverys = base_url() . 'index.php/dashboard/listing_requirement_master/' . $ClientId;

            $deliveryurl = '<a  class="iframesss" href="' . $deliverys . '"  >' . $aRow['totrf'] . '</a>';


            $totrf = base_url() . 'index.php/dashboard/listing_property_master/' . $ClientId;

            $totrfurl = '<a  class="iframesss" href="' . $totrf . '"  >' . $aRow['totprc'] . '</a>';


            $viewporturlhtml = base_url() . 'index.php/dashboard/viewclient/' . $ClientId;

            $viewporturlsht = '<a class="various" data-fancybox-type="iframe" href="' . $viewporturlhtml . '" target="_blank"><span class="ui-icon ui-icon-search"></span></a>';


            $editurl = base_url() . 'index.php/dashboard/edit_form_client_master/' . $ClientId;

            $editurls = '<a class="various" data-fancybox-type="iframe" href="' . $editurl . '"><span class="ui-icon ui-icon-pencil"></span></a>';


            $propertydel = base_url() . 'index.php/dashboard/clienthistory/' . $ClientId;

            $propertydels = '<a class="various" data-fancybox-type="iframe" href="' . $propertydel . '" title="Print History" target="_blank"><span class="ui-icon ui-icon-print"></span></a>';


            //$row[0] = $ClientId;
            $row[0] = $ClientName;
            $row[1] = $phone;
            $row[2] = $Active;
            $row[3] = $aRow['totdcrrf'];
            $row[4] = $deliveryurl;
            $row[5] = $totrfurl;
            $row[6] = $taskurls;//$totrfurl;
            $row[7] = $viewporturlsht;
            
            $righttoedit =1;
            if ($righttoedit == '1') {
                $row[8] = $editurls;
                $row[9] = $propertydels;
            } else {
              $row[8] = $propertydels;  
            }

            $sno++;
            $output['aaData'][] = $row;
        }

        echo json_encode($output);
    }

    function client_master_get_by_id($id) {
        $sql = "SELECT * FROM client_master WHERE client_master.iClientId='" . $id . "'";

        $query = $this->db->query($sql);

        if ($query) {
            $result = $query->row_array();

            return $result;
        }
    }

    function add_client_master($data) {
        $ClientName = trim($data['txtClientName']);
        $Address = trim($data['txtAddress']);
        $BranchId = trim($data['cmbBranch']);

        $StateId = trim($data['cmbState']);
        $DistrictId = trim($data['cmbDistrict']);
        $CityId = trim($data['cmbCity']);
        $LocationId = trim($data['cmbLocation']);
        $Landmark = trim($data['txtLandmark']);
        $SourceId = trim($data['cmbSource']);

        $ContactPerson1Name = trim($data['txtContactPerson1Name']);
        $ContactPerson1Designation = trim($data['txtContactPerson1Designation']);
        $ContactPerson1PhoneNo1 = trim($data['txtContactPerson1PhoneNo1']);
        $ContactPerson1PhoneNo2 = trim($data['txtContactPerson1PhoneNo2']);
        $ContactPerson1Email = trim($data['txtContactPerson1Email']);

        $ContactPerson2Name = trim($data['txtContactPerson2Name']);
        $ContactPerson2Designation = trim($data['txtContactPerson2Designation']);
        $ContactPerson2PhoneNo1 = trim($data['txtContactPerson2PhoneNo1']);
        $ContactPerson2PhoneNo2 = trim($data['txtContactPerson2PhoneNo2']);
        $ContactPerson2Email = trim($data['txtContactPerson2Email']);

        $ContactPerson3Name = trim($data['txtContactPerson3Name']);
        $ContactPerson3Designation = trim($data['txtContactPerson3Designation']);
        $ContactPerson3PhoneNo1 = trim($data['txtContactPerson3PhoneNo1']);
        $ContactPerson3PhoneNo2 = trim($data['txtContactPerson3PhoneNo2']);
        $ContactPerson3Email = trim($data['txtContactPerson3Email']);

        $ContactPerson4Name = trim($data['txtContactPerson4Name']);
        $ContactPerson4Designation = trim($data['txtContactPerson4Designation']);
        $ContactPerson4PhoneNo1 = trim($data['txtContactPerson4PhoneNo1']);
        $ContactPerson4PhoneNo2 = trim($data['txtContactPerson4PhoneNo2']);
        $ContactPerson4Email = trim($data['txtContactPerson4Email']);

        $ContactPerson5Name = trim($data['txtContactPerson5Name']);
        $ContactPerson5Designation = trim($data['txtContactPerson5Designation']);
        $ContactPerson5PhoneNo1 = trim($data['txtContactPerson5PhoneNo1']);
        $ContactPerson5PhoneNo2 = trim($data['txtContactPerson5PhoneNo2']);
        $ContactPerson5Email = trim($data['txtContactPerson5Email']);

        $ContactPerson6Name = trim($data['txtContactPerson6Name']);
        $ContactPerson6Designation = trim($data['txtContactPerson6Designation']);
        $ContactPerson6PhoneNo1 = trim($data['txtContactPerson6PhoneNo1']);
        $ContactPerson6PhoneNo2 = trim($data['txtContactPerson6PhoneNo2']);
        $ContactPerson6Email = trim($data['txtContactPerson6Email']);

        $ContactPerson7Name = trim($data['txtContactPerson7Name']);
        $ContactPerson7Designation = trim($data['txtContactPerson7Designation']);
        $ContactPerson7PhoneNo1 = trim($data['txtContactPerson7PhoneNo1']);
        $ContactPerson7PhoneNo2 = trim($data['txtContactPerson7PhoneNo2']);
        $ContactPerson7Email = trim($data['txtContactPerson7Email']);

        $ContactPerson8Name = trim($data['txtContactPerson8Name']);
        $ContactPerson8Designation = trim($data['txtContactPerson8Designation']);
        $ContactPerson8PhoneNo1 = trim($data['txtContactPerson8PhoneNo1']);
        $ContactPerson8PhoneNo2 = trim($data['txtContactPerson8PhoneNo2']);
        $ContactPerson8Email = trim($data['txtContactPerson8Email']);

        $ContactPerson9Name = trim($data['txtContactPerson9Name']);
        $ContactPerson9Designation = trim($data['txtContactPerson9Designation']);
        $ContactPerson9PhoneNo1 = trim($data['txtContactPerson9PhoneNo1']);
        $ContactPerson9PhoneNo2 = trim($data['txtContactPerson9PhoneNo2']);
        $ContactPerson9Email = trim($data['txtContactPerson9Email']);

        $ContactPerson10Name = trim($data['txtContactPerson10Name']);
        $ContactPerson10Designation = trim($data['txtContactPerson10Designation']);
        $ContactPerson10PhoneNo1 = trim($data['txtContactPerson10PhoneNo1']);
        $ContactPerson10PhoneNo2 = trim($data['txtContactPerson10PhoneNo2']);
        $ContactPerson10Email = trim($data['txtContactPerson10Email']);

        $Remarks = trim($data['txtRemarks']);

        $Active = (int) trim($data['chkActive']);

        $CurrentDate = date('Y-m-d');


        $sql = "SELECT * FROM client_master WHERE client_master.cClientName='" . $ClientName . "' AND client_master.bDelete=0";

        $query = $this->db->query($sql);

        if ($query) {
            if ($query->num_rows > 0) {
                return json_encode(Array("status" => "0", "msg" => EXIST_MSG));
            } else {
                $addData = array(
                    'dCreateDate' => $CurrentDate,
                    'cClientName' => htmlentities($ClientName, ENT_QUOTES),
                    'cAddress' => $Address,
                    'iBranchId' => $BranchId,
                    'iStateId' => $StateId,
                    'iDistrictId' => $DistrictId,
                    'iCityId' => $CityId,
                    'iLocationId' => $LocationId,
                    'cLandmark' => $Landmark,
                    'iSourceId' => $SourceId,
                    'cContactPerson1Name' => $ContactPerson1Name,
                    'cContactPerson1Designation' => $ContactPerson1Designation,
                    'cContactPerson1PhoneNo1' => $ContactPerson1PhoneNo1,
                    'cContactPerson1PhoneNo2' => $ContactPerson1PhoneNo2,
                    'cContactPerson1Email' => $ContactPerson1Email,
                    'cContactPerson2Name' => $ContactPerson2Name,
                    'cContactPerson2Designation' => $ContactPerson2Designation,
                    'cContactPerson2PhoneNo1' => $ContactPerson2PhoneNo1,
                    'cContactPerson2PhoneNo2' => $ContactPerson2PhoneNo2,
                    'cContactPerson2Email' => $ContactPerson2Email,
                    'cContactPerson3Name' => $ContactPerson3Name,
                    'cContactPerson3Designation' => $ContactPerson3Designation,
                    'cContactPerson3PhoneNo1' => $ContactPerson3PhoneNo1,
                    'cContactPerson3PhoneNo2' => $ContactPerson3PhoneNo2,
                    'cContactPerson3Email' => $ContactPerson3Email,
                    'cContactPerson4Name' => $ContactPerson4Name,
                    'cContactPerson4Designation' => $ContactPerson4Designation,
                    'cContactPerson4PhoneNo1' => $ContactPerson4PhoneNo1,
                    'cContactPerson4PhoneNo2' => $ContactPerson4PhoneNo2,
                    'cContactPerson4Email' => $ContactPerson4Email,
                    'cContactPerson5Name' => $ContactPerson5Name,
                    'cContactPerson5Designation' => $ContactPerson5Designation,
                    'cContactPerson5PhoneNo1' => $ContactPerson5PhoneNo1,
                    'cContactPerson5PhoneNo2' => $ContactPerson5PhoneNo2,
                    'cContactPerson5Email' => $ContactPerson5Email,
                    'cContactPerson6Name' => $ContactPerson6Name,
                    'cContactPerson6Designation' => $ContactPerson6Designation,
                    'cContactPerson6PhoneNo1' => $ContactPerson6PhoneNo1,
                    'cContactPerson6PhoneNo2' => $ContactPerson6PhoneNo2,
                    'cContactPerson6Email' => $ContactPerson6Email,
                    'cContactPerson7Name' => $ContactPerson7Name,
                    'cContactPerson7Designation' => $ContactPerson7Designation,
                    'cContactPerson7PhoneNo1' => $ContactPerson7PhoneNo1,
                    'cContactPerson7PhoneNo2' => $ContactPerson7PhoneNo2,
                    'cContactPerson7Email' => $ContactPerson7Email,
                    'cContactPerson8Name' => $ContactPerson8Name,
                    'cContactPerson8Designation' => $ContactPerson8Designation,
                    'cContactPerson8PhoneNo1' => $ContactPerson8PhoneNo1,
                    'cContactPerson8PhoneNo2' => $ContactPerson8PhoneNo2,
                    'cContactPerson8Email' => $ContactPerson8Email,
                    'cContactPerson9Name' => $ContactPerson9Name,
                    'cContactPerson9Designation' => $ContactPerson9Designation,
                    'cContactPerson9PhoneNo1' => $ContactPerson9PhoneNo1,
                    'cContactPerson9PhoneNo2' => $ContactPerson9PhoneNo2,
                    'cContactPerson9Email' => $ContactPerson9Email,
                    'cContactPerson10Name' => $ContactPerson10Name,
                    'cContactPerson10Designation' => $ContactPerson10Designation,
                    'cContactPerson10PhoneNo1' => $ContactPerson10PhoneNo1,
                    'cContactPerson10PhoneNo2' => $ContactPerson10PhoneNo2,
                    'cContactPerson10Email' => $ContactPerson10Email,
                    'cRemarks' => htmlentities($Remarks, ENT_QUOTES),
                    'bActive' => $Active,
                );

                $insert = $this->db->insert('client_master', $addData);

                $client_Id = $this->db->insert_id();



                /* Data insert in task tables */


                $UserId = trim($this->session->userdata('UserId'));

                $DCRDate = date('Y-m-d H:i:s');

                $DCRRemarks = "";

                $new_activity_data = array(
                    'dActivityDateTime' => date('Y-m-d H:i:s'),
                    'cUserName' => trim($this->session->userdata('UserName')),
                    'cIPAddress' => $this->get_client_ip(),
                    'cActivityDesc' => 'Add New Task'
                );

                $newactivitylogid = $this->save_activity_details($new_activity_data);

                $addData = array(
                    'dDCRDate' => $DCRDate,
                    'iUserId' => $UserId,
                    'cDCRRemarks' => $DCRRemarks,
                    'iActivityLogId' => trim($newactivitylogid),
                );

                $SaveData = $this->db->insert('dcr_summary', $addData);
                $DCRId = $this->db->insert_id();

                $addDCRDetail = array(
                    'iDCRId' => $DCRId,
                    'iClientReqId' => $client_Id,
                    'iTaskId' => '15',
                    'cDCRSummary' => 'New Client Added'
                );

                $insertDCRDetail = $this->db->insert('dcr_detail', $addDCRDetail);


                /* Mail send after add client */

                $mailhtml = "";
                $mailhtml .= '<div>';
                $mailhtml .= '<p>Dear ' . ucfirst($ClientName) . ',</p>';
                $mailhtml .= '<p>Greetings from Linkers India!</p>
                                <p>We are pleased to share that we have added you in our CRM as our prestigious Client.<br>We strive to deliver quality Corporate Leasing Services and assure that our association shall be successful.</p>
                                <p>Thanks!</p>
                                <p>Best Regards,<br>Team Linkers India<br>Bakhatgarh Towers, 34/2, Race Course Rd, New Palasia, Old Palasia, Indore, Madhya Pradesh, 452001.<br>+91 731 4044406, +91 9993999996<br><a href="mailto:support@linkersindia.com" target="_blank">support@linkersindia.com</a></p>
                                </div>';


                $this->sendEmail($ContactPerson1Email, 'Welcome', $mailhtml);

                /* Email send to the internal staff */

                $this->db->where('bActive', 1);
                $this->db->where('bDelete', 0);
                $query = $this->db->get('user_master');

                $innerstaff = "";

                $cityname = $this->get_city_by_id($CityId);
                $statename = $this->state_master_get_by_id($StateId);
                $district = $this->get_district_by_id($DistrictId);
                $locations = $this->get_location_by_id($LocationId);

                $statenames = $statename['cStateName'];

                $innerstaff .='<div>
                                <p>Hello,</p>';
                $innerstaff .='<p>A new Client ' . ucfirst($ClientName) . ' is added by ' . $this->session->userdata('UserName') . ' on ' . date('d-m-Y H:i:s') . '<br>Please find following details:<br>';
                $innerstaff .= $ClientName . '<br>' . $Address . ' ' . $locations . ' ' . $cityname . ' ' . $district . ' ' . $statenames . '<br>';
                $innerstaff.=$ContactPerson1Email . '<br>';
                $innerstaff.=$ContactPerson1PhoneNo1 . '</p>';
                $innerstaff.= '<p>Best Regards,<br>Team Linkers India<br>Bakhatgarh Towers, 34/2, Race Course Rd, New Palasia, Old Palasia, Indore, Madhya Pradesh, 452001.<br>+91 731 4044406, +91 9993999996<br><a href="mailto:support@linkersindia.com" target="_blank">support@linkersindia.com</a></p>
                                </div>';



                if ($query->result()) {
                    foreach ($query->result() as $req) {

                        $this->sendEmail($req->cEmailAddress, 'New Client Added', $innerstaff);
                    }
                }







                if ($insert) {
                    return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
                } else {
                    return json_encode(Array("status" => "0", "msg" => ERROR_INSERT_MSG));
                }
            }
        }
    }

    function edit_client_master($data) {
        $hfClientId = trim($data['hfClientId']);

        $ClientName = trim($data['txtClientName']);
        $Address = trim($data['txtAddress']);
        $BranchId = trim($data['cmbBranch']);

        $StateId = trim($data['cmbState']);
        $DistrictId = trim($data['cmbDistrict']);
        $CityId = trim($data['cmbCity']);
        $LocationId = trim($data['cmbLocation']);
        $Landmark = trim($data['txtLandmark']);
        $SourceId = trim($data['cmbSource']);

        $ContactPerson1Name = trim($data['txtContactPerson1Name']);
        $ContactPerson1Designation = trim($data['txtContactPerson1Designation']);
        $ContactPerson1PhoneNo1 = trim($data['txtContactPerson1PhoneNo1']);
        $ContactPerson1PhoneNo2 = trim($data['txtContactPerson1PhoneNo2']);
        $ContactPerson1Email = trim($data['txtContactPerson1Email']);

        $ContactPerson2Name = trim($data['txtContactPerson2Name']);
        $ContactPerson2Designation = trim($data['txtContactPerson2Designation']);
        $ContactPerson2PhoneNo1 = trim($data['txtContactPerson2PhoneNo1']);
        $ContactPerson2PhoneNo2 = trim($data['txtContactPerson2PhoneNo2']);
        $ContactPerson2Email = trim($data['txtContactPerson2Email']);

        $ContactPerson3Name = trim($data['txtContactPerson3Name']);
        $ContactPerson3Designation = trim($data['txtContactPerson3Designation']);
        $ContactPerson3PhoneNo1 = trim($data['txtContactPerson3PhoneNo1']);
        $ContactPerson3PhoneNo2 = trim($data['txtContactPerson3PhoneNo2']);
        $ContactPerson3Email = trim($data['txtContactPerson3Email']);

        $ContactPerson4Name = trim($data['txtContactPerson4Name']);
        $ContactPerson4Designation = trim($data['txtContactPerson4Designation']);
        $ContactPerson4PhoneNo1 = trim($data['txtContactPerson4PhoneNo1']);
        $ContactPerson4PhoneNo2 = trim($data['txtContactPerson4PhoneNo2']);
        $ContactPerson4Email = trim($data['txtContactPerson4Email']);

        $ContactPerson5Name = trim($data['txtContactPerson5Name']);
        $ContactPerson5Designation = trim($data['txtContactPerson5Designation']);
        $ContactPerson5PhoneNo1 = trim($data['txtContactPerson5PhoneNo1']);
        $ContactPerson5PhoneNo2 = trim($data['txtContactPerson5PhoneNo2']);
        $ContactPerson5Email = trim($data['txtContactPerson5Email']);

        $ContactPerson6Name = trim($data['txtContactPerson6Name']);
        $ContactPerson6Designation = trim($data['txtContactPerson6Designation']);
        $ContactPerson6PhoneNo1 = trim($data['txtContactPerson6PhoneNo1']);
        $ContactPerson6PhoneNo2 = trim($data['txtContactPerson6PhoneNo2']);
        $ContactPerson6Email = trim($data['txtContactPerson6Email']);

        $ContactPerson7Name = trim($data['txtContactPerson7Name']);
        $ContactPerson7Designation = trim($data['txtContactPerson7Designation']);
        $ContactPerson7PhoneNo1 = trim($data['txtContactPerson7PhoneNo1']);
        $ContactPerson7PhoneNo2 = trim($data['txtContactPerson7PhoneNo2']);
        $ContactPerson7Email = trim($data['txtContactPerson7Email']);

        $ContactPerson8Name = trim($data['txtContactPerson8Name']);
        $ContactPerson8Designation = trim($data['txtContactPerson8Designation']);
        $ContactPerson8PhoneNo1 = trim($data['txtContactPerson8PhoneNo1']);
        $ContactPerson8PhoneNo2 = trim($data['txtContactPerson8PhoneNo2']);
        $ContactPerson8Email = trim($data['txtContactPerson8Email']);

        $ContactPerson9Name = trim($data['txtContactPerson9Name']);
        $ContactPerson9Designation = trim($data['txtContactPerson9Designation']);
        $ContactPerson9PhoneNo1 = trim($data['txtContactPerson9PhoneNo1']);
        $ContactPerson9PhoneNo2 = trim($data['txtContactPerson9PhoneNo2']);
        $ContactPerson9Email = trim($data['txtContactPerson9Email']);

        $ContactPerson10Name = trim($data['txtContactPerson10Name']);
        $ContactPerson10Designation = trim($data['txtContactPerson10Designation']);
        $ContactPerson10PhoneNo1 = trim($data['txtContactPerson10PhoneNo1']);
        $ContactPerson10PhoneNo2 = trim($data['txtContactPerson10PhoneNo2']);
        $ContactPerson10Email = trim($data['txtContactPerson10Email']);

        $Remarks = trim($data['txtRemarks']);

        $Active = trim($data['hfActive']);


        $sql = "SELECT * FROM client_master WHERE client_master.cClientName='" . $ClientName . "' AND client_master.bDelete=0 AND client_master.iClientId!='" . $hfClientId . "'";

        $query = $this->db->query($sql);

        if ($query) {
            if ($query->num_rows > 0) {
                return json_encode(Array("status" => "0", "msg" => EXIST_MSG));
            } else {
                $editData = array(
                    'cClientName' => htmlentities($ClientName, ENT_QUOTES),
                    'cAddress' => $Address,
                    'iBranchId' => $BranchId,
                    'iStateId' => $StateId,
                    'iDistrictId' => $DistrictId,
                    'iCityId' => $CityId,
                    'iLocationId' => $LocationId,
                    'cLandmark' => $Landmark,
                    'iSourceId' => $SourceId,
                    'cContactPerson1Name' => $ContactPerson1Name,
                    'cContactPerson1Designation' => $ContactPerson1Designation,
                    'cContactPerson1PhoneNo1' => $ContactPerson1PhoneNo1,
                    'cContactPerson1PhoneNo2' => $ContactPerson1PhoneNo2,
                    'cContactPerson1Email' => $ContactPerson1Email,
                    'cContactPerson2Name' => $ContactPerson2Name,
                    'cContactPerson2Designation' => $ContactPerson2Designation,
                    'cContactPerson2PhoneNo1' => $ContactPerson2PhoneNo1,
                    'cContactPerson2PhoneNo2' => $ContactPerson2PhoneNo2,
                    'cContactPerson2Email' => $ContactPerson2Email,
                    'cContactPerson3Name' => $ContactPerson3Name,
                    'cContactPerson3Designation' => $ContactPerson3Designation,
                    'cContactPerson3PhoneNo1' => $ContactPerson3PhoneNo1,
                    'cContactPerson3PhoneNo2' => $ContactPerson3PhoneNo2,
                    'cContactPerson3Email' => $ContactPerson3Email,
                    'cContactPerson4Name' => $ContactPerson4Name,
                    'cContactPerson4Designation' => $ContactPerson4Designation,
                    'cContactPerson4PhoneNo1' => $ContactPerson4PhoneNo1,
                    'cContactPerson4PhoneNo2' => $ContactPerson4PhoneNo2,
                    'cContactPerson4Email' => $ContactPerson4Email,
                    'cContactPerson5Name' => $ContactPerson5Name,
                    'cContactPerson5Designation' => $ContactPerson5Designation,
                    'cContactPerson5PhoneNo1' => $ContactPerson5PhoneNo1,
                    'cContactPerson5PhoneNo2' => $ContactPerson5PhoneNo2,
                    'cContactPerson5Email' => $ContactPerson5Email,
                    'cContactPerson6Name' => $ContactPerson6Name,
                    'cContactPerson6Designation' => $ContactPerson6Designation,
                    'cContactPerson6PhoneNo1' => $ContactPerson6PhoneNo1,
                    'cContactPerson6PhoneNo2' => $ContactPerson6PhoneNo2,
                    'cContactPerson6Email' => $ContactPerson6Email,
                    'cContactPerson7Name' => $ContactPerson7Name,
                    'cContactPerson7Designation' => $ContactPerson7Designation,
                    'cContactPerson7PhoneNo1' => $ContactPerson7PhoneNo1,
                    'cContactPerson7PhoneNo2' => $ContactPerson7PhoneNo2,
                    'cContactPerson7Email' => $ContactPerson7Email,
                    'cContactPerson8Name' => $ContactPerson8Name,
                    'cContactPerson8Designation' => $ContactPerson8Designation,
                    'cContactPerson8PhoneNo1' => $ContactPerson8PhoneNo1,
                    'cContactPerson8PhoneNo2' => $ContactPerson8PhoneNo2,
                    'cContactPerson8Email' => $ContactPerson8Email,
                    'cContactPerson9Name' => $ContactPerson9Name,
                    'cContactPerson9Designation' => $ContactPerson9Designation,
                    'cContactPerson9PhoneNo1' => $ContactPerson9PhoneNo1,
                    'cContactPerson9PhoneNo2' => $ContactPerson9PhoneNo2,
                    'cContactPerson9Email' => $ContactPerson9Email,
                    'cContactPerson10Name' => $ContactPerson10Name,
                    'cContactPerson10Designation' => $ContactPerson10Designation,
                    'cContactPerson10PhoneNo1' => $ContactPerson10PhoneNo1,
                    'cContactPerson10PhoneNo2' => $ContactPerson10PhoneNo2,
                    'cContactPerson10Email' => $ContactPerson10Email,
                    'cRemarks' => htmlentities($Remarks, ENT_QUOTES),
                    'bActive' => $Active,
                );

                $this->db->where('iClientId', $hfClientId);
                $update = $this->db->update('client_master', $editData);

                if ($update) {
                    return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
                } else {
                    return json_encode(Array("status" => "0", "msg" => ERROR_UPDATE_MSG));
                }
            }
        }
    }

    function delete_client_master($id) {
        $sql = "UPDATE client_master SET client_master.bDelete=1 WHERE client_master.iClientId='" . $id . "'";

        $query = $this->db->query($sql);

        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    //-----------------------------------------------------Task----------------------------------------------------------------------------------------------

    function get_all_task_master() {
        $sql = "SELECT task_master.iTaskId,task_master.cTaskName,CASE task_master.bActive WHEN 1 THEN 'Yes' ELSE 'No' END AS 'bActive' FROM task_master WHERE task_master.bDelete=0";

        $query = $this->db->query($sql);

        return $query;
    }

    function task_master_get_by_id($id) {
        $sql = "SELECT * FROM task_master WHERE task_master.iTaskId='" . $id . "'";

        $query = $this->db->query($sql);

        if ($query) {
            $result = $query->row_array();

            return $result;
        }
    }

    function add_task_master($data) {
        $TaskName = trim($data['txtTaskName']);
        $Active = (int) trim($data['chkActive']);

        $sql = "SELECT * FROM task_master WHERE task_master.cTaskName='" . $TaskName . "' AND task_master.bDelete=0";

        $query = $this->db->query($sql);

        if ($query) {
            if ($query->num_rows > 0) {
                return json_encode(Array("status" => "0", "msg" => EXIST_MSG));
            } else {
                $addData = array(
                    'cTaskName' => $TaskName,
                    'bActive' => $Active,
                );

                $insert = $this->db->insert('task_master', $addData);

                if ($insert) {
                    return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
                } else {
                    return json_encode(Array("status" => "0", "msg" => ERROR_INSERT_MSG));
                }
            }
        }
    }

    function edit_task_master($data) {
        $hfTaskId = trim($data['hfTaskId']);
        $TaskName = trim($data['txtTaskName']);
        $Active = trim($data['hfActive']);

        $sql = "SELECT * FROM task_master WHERE task_master.cTaskName='" . $TaskName . "' AND task_master.bDelete=0 AND task_master.iTaskId!='" . $hfTaskId . "'";

        $query = $this->db->query($sql);

        if ($query) {
            if ($query->num_rows > 0) {
                return json_encode(Array("status" => "0", "msg" => EXIST_MSG));
            } else {
                $editData = array(
                    'cTaskName' => $TaskName,
                    'bActive' => $Active,
                );

                $this->db->where('iTaskId', $hfTaskId);
                $update = $this->db->update('task_master', $editData);

                if ($update) {
                    return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
                } else {
                    return json_encode(Array("status" => "0", "msg" => ERROR_UPDATE_MSG));
                }
            }
        }
    }

    function delete_task_master($id) {
        $sql = "UPDATE task_master SET task_master.bDelete=1 WHERE task_master.iTaskId='" . $id . "'";

        $query = $this->db->query($sql);

        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    //-----------------------------------------------------Property Category------------------------------------------------------------------------------------------

    function get_all_property_category_master() {
        $sql = "SELECT property_category_master.iPropertyCategoryId,property_category_master.cPropertyCategoryName,CASE property_category_master.bActive WHEN 1 THEN 'Yes' ELSE 'No' END AS 'bActive' FROM property_category_master WHERE property_category_master.bDelete=0";

        $query = $this->db->query($sql);

        return $query;
    }

    function property_category_master_get_by_id($id) {
        $sql = "SELECT * FROM property_category_master WHERE property_category_master.iPropertyCategoryId='" . $id . "'";

        $query = $this->db->query($sql);

        if ($query) {
            $result = $query->row_array();

            return $result;
        }
    }

    function add_property_category_master($data) {
        $PropertyCategoryName = trim($data['txtPropertyCategoryName']);
        $Active = (int) trim($data['chkActive']);

        $sql = "SELECT * FROM property_category_master WHERE property_category_master.cPropertyCategoryName='" . $PropertyCategoryName . "' AND property_category_master.bDelete=0";

        $query = $this->db->query($sql);

        if ($query) {
            if ($query->num_rows > 0) {
                return json_encode(Array("status" => "0", "msg" => EXIST_MSG));
            } else {
                $addData = array(
                    'cPropertyCategoryName' => $PropertyCategoryName,
                    'bActive' => $Active,
                );

                $insert = $this->db->insert('property_category_master', $addData);

                if ($insert) {
                    return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
                } else {
                    return json_encode(Array("status" => "0", "msg" => ERROR_INSERT_MSG));
                }
            }
        }
    }

    function edit_property_category_master($data) {
        $hfPropertyCategoryId = trim($data['hfPropertyCategoryId']);
        $PropertyCategoryName = trim($data['txtPropertyCategoryName']);
        $Active = trim($data['hfActive']);

        $sql = "SELECT * FROM property_category_master WHERE property_category_master.cPropertyCategoryName='" . $PropertyCategoryName . "' AND property_category_master.bDelete=0 AND property_category_master.iPropertyCategoryId!='" . $hfPropertyCategoryId . "'";

        $query = $this->db->query($sql);

        if ($query) {
            if ($query->num_rows > 0) {
                return json_encode(Array("status" => "0", "msg" => EXIST_MSG));
            } else {
                $editData = array(
                    'cPropertyCategoryName' => $PropertyCategoryName,
                    'bActive' => $Active,
                );

                $this->db->where('iPropertyCategoryId', $hfPropertyCategoryId);
                $update = $this->db->update('property_category_master', $editData);

                if ($update) {
                    return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
                } else {
                    return json_encode(Array("status" => "0", "msg" => ERROR_UPDATE_MSG));
                }
            }
        }
    }

    function delete_property_category_master($id) {
        $sql = "UPDATE property_category_master SET property_category_master.bDelete=1 WHERE property_category_master.iPropertyCategoryId='" . $id . "'";

        $query = $this->db->query($sql);

        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    //-----------------------------------------------------Property Status-------------------------------------------------------------------------------------------

    function get_all_property_status_master() {
        $sql = "SELECT property_status_master.iPropertyStatusId,property_status_master.cPropertyStatusName,CASE property_status_master.bActive WHEN 1 THEN 'Yes' ELSE 'No' END AS 'bActive' FROM property_status_master WHERE property_status_master.bDelete=0";

        $query = $this->db->query($sql);

        return $query;
    }

    function property_status_master_get_by_id($id) {
        $sql = "SELECT * FROM property_status_master WHERE iPropertyStatusId='" . $id . "'";

        $query = $this->db->query($sql);

        if ($query) {
            $result = $query->row_array();

            return $result;
        }
    }

    function add_property_status_master($data) {
        $PropertyStatusName = trim($data['txtPropertyStatusName']);
        $Active = (int) trim($data['chkActive']);

        $sql = "SELECT * FROM property_status_master WHERE property_status_master.cPropertyStatusName='" . $PropertyStatusName . "' AND property_status_master.bDelete=0";

        $query = $this->db->query($sql);

        if ($query) {
            if ($query->num_rows > 0) {
                return json_encode(Array("status" => "0", "msg" => EXIST_MSG));
            } else {
                $addData = array(
                    'cPropertyStatusName' => $PropertyStatusName,
                    'bActive' => $Active,
                );

                $insert = $this->db->insert('property_status_master', $addData);

                if ($insert) {
                    return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
                } else {
                    return json_encode(Array("status" => "0", "msg" => ERROR_INSERT_MSG));
                }
            }
        }
    }

    function edit_property_status_master($data) {
        $hfPropertyStatusId = trim($data['hfPropertyStatusId']);
        $PropertyStatusName = trim($data['txtPropertyStatusName']);
        $Active = trim($data['hfActive']);

        $sql = "SELECT * FROM property_status_master WHERE property_status_master.cPropertyStatusName='" . $PropertyStatusName . "' AND property_status_master.bDelete=0 AND iPropertyStatusId!='" . $hfPropertyStatusId . "'";

        $query = $this->db->query($sql);

        if ($query) {
            if ($query->num_rows > 0) {
                return json_encode(Array("status" => "0", "msg" => EXIST_MSG));
            } else {
                $editData = array(
                    'cPropertyStatusName' => $PropertyStatusName,
                    'bActive' => $Active,
                );

                $this->db->where('iPropertyStatusId', $hfPropertyStatusId);
                $update = $this->db->update('property_status_master', $editData);

                if ($update) {
                    return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
                } else {
                    return json_encode(Array("status" => "0", "msg" => ERROR_UPDATE_MSG));
                }
            }
        }
    }

    function delete_property_status_master($id) {
        $sql = "UPDATE property_status_master SET property_status_master.bDelete=1 WHERE property_status_master.iPropertyStatusId='" . $id . "'";

        $query = $this->db->query($sql);

        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    //-----------------------------------------------------Property Type-------------------------------------------------------------------------------------------

    function get_all_property_type_master() {
        $sql = "SELECT property_type_master.iPropertyTypeId,property_type_master.cPropertyTypeName,CASE property_type_master.bActive WHEN 1 THEN 'Yes' ELSE 'No' END AS 'bActive' FROM property_type_master WHERE property_type_master.bDelete=0";

        $query = $this->db->query($sql);

        return $query;
    }

    function property_type_master_get_by_id($id) {
        $sql = "SELECT * FROM property_type_master WHERE iPropertyTypeId='" . $id . "'";

        $query = $this->db->query($sql);

        if ($query) {
            $result = $query->row_array();

            return $result;
        }
    }

    function add_property_type_master($data) {
        $PropertyTypeName = trim($data['txtPropertyTypeName']);
        $Active = (int) trim($data['chkActive']);

        $sql = "SELECT * FROM property_type_master WHERE property_type_master.cPropertyTypeName='" . $PropertyTypeName . "' AND property_type_master.bDelete=0";

        $query = $this->db->query($sql);

        if ($query) {
            if ($query->num_rows > 0) {
                return json_encode(Array("status" => "0", "msg" => EXIST_MSG));
            } else {
                $addData = array(
                    'cPropertyTypeName' => $PropertyTypeName,
                    'bActive' => $Active,
                );

                $insert = $this->db->insert('property_type_master', $addData);

                if ($insert) {
                    return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
                } else {
                    return json_encode(Array("status" => "0", "msg" => ERROR_INSERT_MSG));
                }
            }
        }
    }

    function edit_property_type_master($data) {
        $hfPropertyTypeId = trim($data['hfPropertyTypeId']);
        $PropertyTypeName = trim($data['txtPropertyTypeName']);
        $Active = trim($data['hfActive']);

        $sql = "SELECT * FROM property_type_master WHERE property_type_master.cPropertyTypeName='" . $PropertyTypeName . "' AND property_type_master.bDelete=0 AND iPropertyTypeId!='" . $hfPropertyTypeId . "'";

        $query = $this->db->query($sql);

        if ($query) {
            if ($query->num_rows > 0) {
                return json_encode(Array("status" => "0", "msg" => EXIST_MSG));
            } else {
                $editData = array(
                    'cPropertyTypeName' => $PropertyTypeName,
                    'bActive' => $Active,
                );

                $this->db->where('iPropertyTypeId', $hfPropertyTypeId);
                $update = $this->db->update('property_type_master', $editData);

                if ($update) {
                    return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
                } else {
                    return json_encode(Array("status" => "0", "msg" => ERROR_UPDATE_MSG));
                }
            }
        }
    }

    function delete_property_type_master($id) {
        $sql = "UPDATE property_type_master SET property_type_master.bDelete=1 WHERE property_type_master.iPropertyTypeId='" . $id . "'";

        $query = $this->db->query($sql);

        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    //-----------------------------------------------------State------------------------------------------------------------------------------------------

    function get_all_state_master() {
        $sql = "SELECT state_master.iStateId,state_master.cStateName,state_master.cStateAbbreviation,CASE state_master.bActive WHEN 1 THEN 'Yes' ELSE 'No' END AS 'bActive' FROM state_master WHERE state_master.bDelete=0";

        $query = $this->db->query($sql);

        return $query;
    }

    function state_master_get_by_id($id) {
        $sql = "SELECT * FROM state_master WHERE iStateId='" . $id . "'";

        $query = $this->db->query($sql);

        if ($query) {
            $result = $query->row_array();

            return $result;
        }
    }

    function add_state_master($data) {
        $StateName = trim($data['txtStateName']);
        $StateAbbreviation = trim($data['txtStateAbbreviation']);
        $Active = (int) trim($data['chkActive']);

        $sql = "SELECT * FROM state_master WHERE state_master.cStateName='" . $StateName . "' AND state_master.bDelete=0";

        $query = $this->db->query($sql);

        if ($query) {
            if ($query->num_rows > 0) {
                return json_encode(Array("status" => "0", "msg" => EXIST_MSG));
            } else {
                $addData = array(
                    'cStateName' => $StateName,
                    'cStateAbbreviation' => $StateAbbreviation,
                    'bActive' => $Active,
                );

                $insert = $this->db->insert('state_master', $addData);

                if ($insert) {
                    return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
                } else {
                    return json_encode(Array("status" => "0", "msg" => ERROR_INSERT_MSG));
                }
            }
        }
    }

    function edit_state_master($data) {
        $hfStateId = trim($data['hfStateId']);
        $StateName = trim($data['txtStateName']);
        $StateAbbreviation = trim($data['txtStateAbbreviation']);
        $Active = trim($data['hfActive']);

        $sql = "SELECT * FROM state_master WHERE state_master.cStateName='" . $StateName . "' AND state_master.bDelete=0 AND iStateId!='" . $hfStateId . "'";

        $query = $this->db->query($sql);

        if ($query) {
            if ($query->num_rows > 0) {
                return json_encode(Array("status" => "0", "msg" => EXIST_MSG));
            } else {
                $editData = array(
                    'cStateName' => $StateName,
                    'cStateAbbreviation' => $StateAbbreviation,
                    'bActive' => $Active,
                );

                $this->db->where('iStateId', $hfStateId);
                $update = $this->db->update('state_master', $editData);

                if ($update) {
                    return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
                } else {
                    return json_encode(Array("status" => "0", "msg" => ERROR_UPDATE_MSG));
                }
            }
        }
    }

    function delete_state_master($id) {
        $sql = "UPDATE state_master SET state_master.bDelete=1 WHERE state_master.iStateId='" . $id . "'";

        $query = $this->db->query($sql);

        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    //-----------------------------------------------------User------------------------------------------------------------------------------------------

    function get_all_user_master() {
        $sql = "SELECT user_master.iUserId,user_master.cName,user_master.cDesignation,user_master.cAddress,user_master.iMobileNo,user_master.cEmailAddress,
		user_master.cEmergencyContactName,user_master.cEmergencyContactPhoneNo,user_master.cEmergencyContactEmailAddress,user_master.cUserProfilePicPath,
		user_master.cUserProfilePicName,user_master.cUserName,user_master.cPassword,user_master.cUserType,CASE user_master.bActive WHEN 1 THEN 'Yes' ELSE 'No' END AS 'bActive' FROM user_master WHERE user_master.bDelete=0";

        $query = $this->db->query($sql);

        return $query;
    }

    function user_master_get_by_id($id) {
        $sql = "SELECT * FROM user_master WHERE user_master.iUserId='" . $id . "'";

        $query = $this->db->query($sql);

        if ($query) {
            $result = $query->row_array();

            return $result;
        }
    }

    function add_user_master($data) {
        $Name = trim($data['txtName']);
        $Designation = trim($data['txtDesignation']);
        $Department = trim($data['cmbDepartment']);
        $Address = trim($data['txtAddress']);
        $MobileNo = trim($data['txtMobileNo']);
        $EmailAddress = trim($data['txtEmailAddress']);
        $EmergencyContactName = trim($data['txtEmergencyContactName']);
        $EmergencyContactPhoneNo = trim($data['txtEmergencyContactPhoneNo']);
        $EmergencyContactEmailAddress = trim($data['txtEmergencyContactEmailAddress']);

        //$UserProfilePicPath = trim($data['txtUserProfilePicPath']);
        //$UserProfilePicName = trim($data['txtUserProfilePicName']);

        $UserProfilePicPath = "";
        $UserProfilePicName = "";

        $UserName = trim($data['txtUserName']);
        $Password = trim($data['txtPassword']);

        //$UserType = trim($data['txtUserType']);

        $UserType = 'Employee';
        $Active = (int) trim($data['chkActive']);

        $sql = "SELECT * FROM user_master WHERE user_master.cName='" . $Name . "' AND user_master.cUserName='" . $UserName . "' AND user_master.cPassword='" . $Password . "' AND user_master.bDelete=0";

        $query = $this->db->query($sql);

        if ($query) {
            if ($query->num_rows > 0) {
                return json_encode(Array("status" => "0", "msg" => EXIST_MSG));
            } else {
                $addData = array(
                    'cName' => $Name,
                    'cDesignation' => $Designation,
                    'iDepartmentId' => $Department,
                    'cAddress' => $Address,
                    'iMobileNo' => $MobileNo,
                    'cEmailAddress' => $EmailAddress,
                    'cEmergencyContactName' => $EmergencyContactName,
                    'cEmergencyContactPhoneNo' => $EmergencyContactPhoneNo,
                    'cEmergencyContactEmailAddress' => $EmergencyContactEmailAddress,
                    'cUserProfilePicPath' => $UserProfilePicPath,
                    'cUserProfilePicName' => $UserProfilePicName,
                    'cUserName' => $UserName,
                    'cPassword' => $Password,
                    'cUserType' => $UserType,
                    'bActive' => $Active,
                );

                $insert = $this->db->insert('user_master', $addData);

                if ($insert) {
                    return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
                } else {
                    return json_encode(Array("status" => "0", "msg" => ERROR_INSERT_MSG));
                }
            }
        }
    }

    function edit_user_master($data) {
        $hfUserId = trim($data['hfUserId']);
        $Name = trim($data['txtName']);
        $Designation = trim($data['txtDesignation']);
        $Department = trim($data['cmbDepartment']);
        $Address = trim($data['txtAddress']);
        $MobileNo = trim($data['txtMobileNo']);
        $EmailAddress = trim($data['txtEmailAddress']);
        $EmergencyContactName = trim($data['txtEmergencyContactName']);
        $EmergencyContactPhoneNo = trim($data['txtEmergencyContactPhoneNo']);
        $EmergencyContactEmailAddress = trim($data['txtEmergencyContactEmailAddress']);
        //$UserProfilePicPath = trim($data['txtUserProfilePicPath']);
        //$UserProfilePicName = trim($data['txtUserProfilePicName']);
        $UserProfilePicPath = "";
        $UserProfilePicName = "";
        $UserName = trim($data['txtUserName']);
        $Password = trim($data['txtPassword']);
        //$UserType = trim($data['txtUserType']);
        $UserType = 'Employee';
        $Active = trim($data['hfActive']);

        $sql = "SELECT * FROM user_master WHERE user_master.cName='" . $Name . "' AND user_master.cUserName='" . $UserName . "' AND user_master.cPassword='" . $Password . "' AND user_master.bDelete=0 AND user_master.iUserId!='" . $hfUserId . "'";

        $query = $this->db->query($sql);

        if ($query) {
            if ($query->num_rows > 0) {
                return json_encode(Array("status" => "0", "msg" => EXIST_MSG));
            } else {
                $editData = array(
                    'cName' => $Name,
                    'cDesignation' => $Designation,
                    'iDepartmentId' => $Department,
                    'cAddress' => $Address,
                    'iMobileNo' => $MobileNo,
                    'cEmailAddress' => $EmailAddress,
                    'cEmergencyContactName' => $EmergencyContactName,
                    'cEmergencyContactPhoneNo' => $EmergencyContactPhoneNo,
                    'cEmergencyContactEmailAddress' => $EmergencyContactEmailAddress,
                    'cUserProfilePicPath' => $UserProfilePicPath,
                    'cUserProfilePicName' => $UserProfilePicName,
                    'cUserName' => $UserName,
                    'cPassword' => $Password,
                    'cUserType' => $UserType,
                    'bActive' => $Active,
                );

                $this->db->where('iUserId', $hfUserId);
                $update = $this->db->update('user_master', $editData);

                if ($update) {
                    return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
                } else {
                    return json_encode(Array("status" => "0", "msg" => ERROR_UPDATE_MSG));
                }
            }
        }
    }

    function delete_user_master($id) {
        $sql = "UPDATE user_master SET user_master.bDelete=1 WHERE user_master.iUserId='" . $id . "'";

        $query = $this->db->query($sql);

        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /*
      //-----------------------------------------------------Calls Record-------------------------------------------------------------------------------------------

      function get_all_call_record()
      {
      $sql="SELECT call_record.iCallRecordId,call_record.iCallRecordId,user_master.cName,user_master.cName,user_master.cDesignation,call_record.dCallDateTime,call_record.dCallDateTime,call_type_master.cCallTypeName,call_record.cContactNo,call_record.cPersonName,property_master.cPropertyName,call_record.cCallSummary,call_record.dNextCallDateTime
      FROM call_record LEFT JOIN user_master ON call_record.iUserId=user_master.iUserId LEFT JOIN call_type_master ON call_record.iCallTypeId=call_type_master.iCallTypeId LEFT JOIN property_master ON call_record.iPropertyId=property_master.iPropertyId WHERE call_record.bDelete=0";

      $query = $this->db->query($sql);

      return $query;
      }

      function call_record_get_by_id($id)
      {
      $sql="SELECT * FROM call_record WHERE call_record.iCallRecordId='".$id."'";

      $query = $this->db->query($sql);

      if($query)
      {
      $result = $query->row_array();

      return $result;
      }
      }

      function add_call_record($data)
      {
      $UserId = trim($this->session->userdata('UserId'));

      $txtCallDateTime = trim($data['txtCallDateTime']);
      if(!empty($txtCallDateTime))
      {
      $txtCallDtTm = str_replace('/', '-', $txtCallDateTime);
      $CallDateTime=date('Y-m-d H:i:s', strtotime($txtCallDtTm));
      }
      else
      {
      $CallDateTime="";
      }

      $CallTypeId = trim($data['cmbCallType']);
      $ContactNo = trim($data['txtContactNo']);
      $PersonName = trim($data['txtPersonName']);
      $PropertyId = trim($data['cmbProperty']);
      $CallSummary = trim($data['txtCallSummary']);

      $txtNextCallDateTime = trim($data['txtNextCallDateTime']);
      if(!empty($txtNextCallDateTime))
      {
      $txtNextDtTm = str_replace('/', '-', $txtNextCallDateTime);
      $NextCallDateTime=date('Y-m-d H:i:s', strtotime($txtNextDtTm));
      }
      else
      {
      $NextCallDateTime="";
      }

      $addData = array(
      'iUserId' => $UserId,
      'dCallDateTime' => $CallDateTime,
      'iCallTypeId' => $CallTypeId,
      'cContactNo' => $ContactNo,
      'cPersonName' => $PersonName,
      'iPropertyId' => $PropertyId,
      'cCallSummary' => $CallSummary,
      'dNextCallDateTime' => $NextCallDateTime,
      );

      $insert = $this->db->insert('call_record', $addData);

      if($insert)
      {
      return json_encode(Array("status"=>"1","msg"=>SUCCESS_INSERT_MSG));
      }
      else
      {
      return json_encode(Array("status"=>"0","msg"=>ERROR_INSERT_MSG));
      }
      }

      function edit_call_record($data)
      {
      $hfCallRecordId = trim($data['hfCallRecordId']);

      $UserId = trim($this->session->userdata('UserId'));

      $txtCallDateTime = trim($data['txtCallDateTime']);
      if(!empty($txtNextCallDateTime))
      {
      $txtCallDtTm = str_replace('/', '-', $txtCallDateTime);
      $CallDateTime=date('Y-m-d H:i:s', strtotime($txtCallDtTm));
      }
      else
      {
      $CallDateTime="";
      }

      $CallTypeId = trim($data['cmbCallType']);
      $ContactNo = trim($data['txtContactNo']);
      $PersonName = trim($data['txtPersonName']);
      $PropertyId = trim($data['cmbProperty']);
      $CallSummary = trim($data['txtCallSummary']);

      $txtNextCallDateTime = trim($data['txtNextCallDateTime']);
      if(!empty($txtNextCallDateTime))
      {
      $txtNextDtTm = str_replace('/', '-', $txtNextCallDateTime);
      $NextCallDateTime=date('Y-m-d H:i:s', strtotime($txtNextDtTm));
      }
      else
      {
      $NextCallDateTime="";
      }

      $editData = array(
      'iUserId' => $UserId,
      'dCallDateTime' => $CallDateTime,
      'iCallTypeId' => $CallTypeId,
      'cContactNo' => $ContactNo,
      'cPersonName' => $PersonName,
      'iPropertyId' => $PropertyId,
      'cCallSummary' => $CallSummary,
      'dNextCallDateTime' => $NextCallDateTime,
      );

      $this->db->where('iCallRecordId', $hfCallRecordId);
      $update = $this->db->update('call_record', $editData);

      if($update)
      {
      return json_encode(Array("status"=>"1","msg"=>SUCCESS_INSERT_MSG));
      }
      else
      {
      return json_encode(Array("status"=>"0","msg"=>ERROR_UPDATE_MSG));
      }
      }

      function delete_call_record($id)
      {
      $sql="UPDATE call_record SET call_record.bDelete=1 WHERE call_record.iCallRecordId='".$id."'";

      $query = $this->db->query($sql);

      if($query)
      {
      return TRUE;
      }
      else
      {
      return FALSE;
      }
      }


      //-----------------------------------------------------Visits Record-------------------------------------------------------------------------------------------

      function get_all_visit_record()
      {
      $sql="SELECT visit_record.iVisitRecordId,user_master.cName,user_master.cName,user_master.cDesignation,visit_record.dVisitDateTime,visit_record.cPersonName,property_master.cPropertyName,visit_record.cVisitSummary,visit_record.dNextVisitDateTime
      FROM visit_record LEFT JOIN user_master ON visit_record.iUserId=user_master.iUserId LEFT JOIN property_master ON visit_record.iPropertyId=property_master.iPropertyId WHERE visit_record.bDelete=0";

      $query = $this->db->query($sql);

      return $query;
      }

      function visit_record_get_by_id($id)
      {
      $sql="SELECT * FROM visit_record WHERE visit_record.iVisitRecordId='".$id."'";

      $query = $this->db->query($sql);

      if($query)
      {
      $result = $query->row_array();

      return $result;
      }
      }

      function add_visit_record($data)
      {
      $UserId = trim($this->session->userdata('UserId'));

      $txtVisitDateTime = trim($data['txtVisitDateTime']);
      if(!empty($txtVisitDateTime))
      {
      $txtVisitDtTm = str_replace('/', '-', $txtVisitDateTime);
      $VisitDateTime=date('Y-m-d H:i:s', strtotime($txtVisitDtTm));
      }
      else
      {
      $VisitDateTime="";
      }

      $PersonName = trim($data['txtPersonName']);
      $PropertyId = trim($data['cmbProperty']);
      $VisitSummary = trim($data['txtVisitSummary']);

      $txtNextVisitDateTime = trim($data['txtNextVisitDateTime']);
      if(!empty($txtNextVisitDateTime))
      {
      $txtNextVisitDtTm = str_replace('/', '-', $txtNextVisitDateTime);
      $NextVisitDateTime=date('Y-m-d H:i:s', strtotime($txtNextVisitDtTm));
      }
      else
      {
      $NextVisitDateTime="";
      }

      $addData = array(
      'iUserId' => $UserId,
      'dVisitDateTime' => $VisitDateTime,
      'cPersonName' => $PersonName,
      'iPropertyId' => $PropertyId,
      'cVisitSummary' => $VisitSummary,
      'dNextVisitDateTime' => $NextVisitDateTime,
      );

      $insert = $this->db->insert('visit_record', $addData);

      if($insert)
      {
      return json_encode(Array("status"=>"1","msg"=>SUCCESS_INSERT_MSG));
      }
      else
      {
      return json_encode(Array("status"=>"0","msg"=>ERROR_INSERT_MSG));
      }
      }

      function edit_visit_record($data)
      {
      $hfVisitRecordId = trim($data['hfVisitRecordId']);

      $UserId = trim($this->session->userdata('UserId'));

      $txtVisitDateTime = trim($data['txtVisitDateTime']);
      if(!empty($txtVisitDateTime))
      {
      $txtVisitDtTm = str_replace('/', '-', $txtVisitDateTime);
      $VisitDateTime=date('Y-m-d H:i:s', strtotime($txtVisitDtTm));
      }
      else
      {
      $VisitDateTime="";
      }

      $PersonName = trim($data['txtPersonName']);
      $PropertyId = trim($data['cmbProperty']);
      $VisitSummary = trim($data['txtVisitSummary']);

      $txtNextVisitDateTime = trim($data['txtNextVisitDateTime']);
      if(!empty($txtNextVisitDateTime))
      {
      $txtNextVisitDtTm = str_replace('/', '-', $txtNextVisitDateTime);
      $NextVisitDateTime=date('Y-m-d H:i:s', strtotime($txtNextVisitDtTm));
      }
      else
      {
      $NextVisitDateTime="";
      }

      $editData = array(
      'iUserId' => $UserId,
      'dVisitDateTime' => $VisitDateTime,
      'cPersonName' => $PersonName,
      'iPropertyId' => $PropertyId,
      'cVisitSummary' => $VisitSummary,
      'dNextVisitDateTime' => $NextVisitDateTime,
      );

      $this->db->where('iVisitRecordId', $hfVisitRecordId);
      $update = $this->db->update('visit_record', $editData);

      if($update)
      {
      return json_encode(Array("status"=>"1","msg"=>SUCCESS_INSERT_MSG));
      }
      else
      {
      return json_encode(Array("status"=>"0","msg"=>ERROR_UPDATE_MSG));
      }
      }

      function delete_visit_record($id)
      {
      $sql="UPDATE visit_record SET visit_record.bDelete=1 WHERE visit_record.iVisitRecordId='".$id."'";

      $query = $this->db->query($sql);

      if($query)
      {
      return TRUE;
      }
      else
      {
      return FALSE;
      }
      }

      //-----------------------------------------------------Meetings Record------------------------------------------------------------------------------------

      function get_all_meeting_record()
      {
      $sql="SELECT meeting_record.iMeetingRecordId,user_master.cName,user_master.cName,user_master.cDesignation,meeting_record.dMeetingDateTime,meeting_record.cMeetingDuration,party_master.cPartyName,property_master.cPropertyName,meeting_record.cMeetingSummary
      FROM meeting_record LEFT JOIN user_master ON meeting_record.iUserId=user_master.iUserId LEFT JOIN party_master ON meeting_record.iPartyId=party_master.iPartyId LEFT JOIN property_master ON meeting_record.iPropertyId=property_master.iPropertyId WHERE meeting_record.bDelete=0";

      $query = $this->db->query($sql);

      return $query;
      }

      function meeting_record_get_by_id($id)
      {
      $sql="SELECT * FROM meeting_record WHERE meeting_record.iMeetingRecordId='".$id."'";

      $query = $this->db->query($sql);

      if($query)
      {
      $result = $query->row_array();

      return $result;
      }
      }

      function add_meeting_record($data)
      {
      $UserId = trim($this->session->userdata('UserId'));

      $txtMeetingDateTime = trim($data['txtMeetingDateTime']);
      if(!empty($txtMeetingDateTime))
      {
      $txtMeetingDtTm = str_replace('/', '-', $txtMeetingDateTime);
      $MeetingDateTime=date('Y-m-d H:i:s', strtotime($txtMeetingDtTm));
      }
      else
      {
      $MeetingDateTime="";
      }

      $MeetingDuration = trim($data['txtMeetingDuration']);
      $PartyId = trim($data['cmbParty']);
      $PropertyId = trim($data['cmbProperty']);
      $MeetingSummary = trim($data['txtMeetingSummary']);

      $addData = array(
      'iUserId' => $UserId,
      'dMeetingDateTime' => $MeetingDateTime,
      'cMeetingDuration' => $MeetingDuration,
      'iPartyId' => $PartyId,
      'iPropertyId' => $PropertyId,
      'cMeetingSummary' => $MeetingSummary,
      );

      $insert = $this->db->insert('meeting_record', $addData);

      if($insert)
      {
      return json_encode(Array("status"=>"1","msg"=>SUCCESS_INSERT_MSG));
      }
      else
      {
      return json_encode(Array("status"=>"0","msg"=>ERROR_INSERT_MSG));
      }
      }

      function edit_meeting_record($data)
      {
      $hfMeetingRecordId = trim($data['hfMeetingRecordId']);

      $UserId = trim($this->session->userdata('UserId'));

      $txtMeetingDateTime = trim($data['txtMeetingDateTime']);
      if(!empty($txtMeetingDateTime))
      {
      $txtMeetingDtTm = str_replace('/', '-', $txtMeetingDateTime);
      $MeetingDateTime=date('Y-m-d H:i:s', strtotime($txtMeetingDtTm));
      }
      else
      {
      $MeetingDateTime="";
      }

      $MeetingDuration = trim($data['txtMeetingDuration']);
      $PartyId = trim($data['cmbParty']);
      $PropertyId = trim($data['cmbProperty']);
      $MeetingSummary = trim($data['txtMeetingSummary']);

      $editData = array(
      'iUserId' => $UserId,
      'dMeetingDateTime' => $MeetingDateTime,
      'cMeetingDuration' => $MeetingDuration,
      'iPartyId' => $PartyId,
      'iPropertyId' => $PropertyId,
      'cMeetingSummary' => $MeetingSummary,
      );

      $this->db->where('iMeetingRecordId', $hfMeetingRecordId);
      $update = $this->db->update('meeting_record', $editData);

      if($update)
      {
      return json_encode(Array("status"=>"1","msg"=>SUCCESS_INSERT_MSG));
      }
      else
      {
      return json_encode(Array("status"=>"0","msg"=>ERROR_UPDATE_MSG));
      }
      }

      function delete_meeting_record($id)
      {
      $sql="UPDATE meeting_record SET meeting_record.bDelete=1 WHERE meeting_record.iMeetingRecordId='".$id."'";

      $query = $this->db->query($sql);

      if($query)
      {
      return TRUE;
      }
      else
      {
      return FALSE;
      }
      }

      //----------------------------------------------------- Inspection Record -----------------------------------------------------------------------------

      function get_all_inspection_record()
      {
      $sql="SELECT inspection_record.iInspectionRecordId,user_master.cName,user_master.cName,user_master.cDesignation,inspection_record.dInspectionDate,party_master.cPartyName,property_master.cPropertyName,inspection_record.cPeopleAtTheTimeOfInspection,inspection_record.cInspectionSummary
      FROM inspection_record LEFT JOIN user_master ON inspection_record.iUserId=user_master.iUserId LEFT JOIN party_master ON inspection_record.iPartyId=party_master.iPartyId LEFT JOIN property_master ON inspection_record.iPropertyId=property_master.iPropertyId WHERE inspection_record.bDelete=0";

      $query = $this->db->query($sql);

      return $query;
      }

      function inspection_record_get_by_id($id)
      {
      $sql="SELECT * FROM inspection_record WHERE inspection_record.iInspectionRecordId='".$id."'";

      $query = $this->db->query($sql);

      if($query)
      {
      $result = $query->row_array();

      return $result;
      }
      }

      function add_inspection_record($data)
      {
      $UserId = trim($this->session->userdata('UserId'));

      $txtInspectionDate = trim($data['txtInspectionDate']);
      if(!empty($txtInspectionDate))
      {
      $splitinspdt = explode('/',$txtInspectionDate);
      $InspectionDate = $splitinspdt[2]."-".$splitinspdt[1]."-".$splitinspdt[0];
      }
      else
      {
      $InspectionDate="";
      }

      $PartyId = trim($data['cmbParty']);
      $PropertyId = trim($data['cmbProperty']);
      $PeopleAtTheTimeOfInspection = trim($data['txtPeopleAtTheTimeOfInspection']);
      $InspectionSummary = trim($data['txtInspectionSummary']);

      $addData = array(
      'iUserId' => $UserId,
      'dInspectionDate' => $InspectionDate,
      'iPartyId' => $PartyId,
      'iPropertyId' => $PropertyId,
      'cPeopleAtTheTimeOfInspection'=> $PeopleAtTheTimeOfInspection,
      'cInspectionSummary' => $InspectionSummary,
      );

      $insert = $this->db->insert('inspection_record', $addData);

      if($insert)
      {
      return json_encode(Array("status"=>"1","msg"=>SUCCESS_INSERT_MSG));
      }
      else
      {
      return json_encode(Array("status"=>"0","msg"=>ERROR_INSERT_MSG));
      }
      }

      function edit_inspection_record($data)
      {
      $hfInspectionRecordId = trim($data['hfInspectionRecordId']);

      $UserId = trim($this->session->userdata('UserId'));

      $txtInspectionDate = trim($data['txtInspectionDate']);
      if(!empty($txtInspectionDate))
      {
      $splitinspdt = explode('/',$txtInspectionDate);
      $InspectionDate = $splitinspdt[2]."-".$splitinspdt[1]."-".$splitinspdt[0];
      }
      else
      {
      $InspectionDate="";
      }

      $PartyId = trim($data['cmbParty']);
      $PropertyId = trim($data['cmbProperty']);
      $PeopleAtTheTimeOfInspection = trim($data['txtPeopleAtTheTimeOfInspection']);
      $InspectionSummary = trim($data['txtInspectionSummary']);

      $editData = array(
      'iUserId' => $UserId,
      'dInspectionDate' => $InspectionDate,
      'iPartyId' => $PartyId,
      'iPropertyId' => $PropertyId,
      'cPeopleAtTheTimeOfInspection'=> $PeopleAtTheTimeOfInspection,
      'cInspectionSummary' => $InspectionSummary,
      );

      $this->db->where('iInspectionRecordId', $hfInspectionRecordId);
      $update = $this->db->update('inspection_record', $editData);

      if($update)
      {
      return json_encode(Array("status"=>"1","msg"=>SUCCESS_INSERT_MSG));
      }
      else
      {
      return json_encode(Array("status"=>"0","msg"=>ERROR_UPDATE_MSG));
      }
      }

      function delete_inspection_record($id)
      {
      $sql="UPDATE inspection_record SET inspection_record.bDelete=1 WHERE inspection_record.iInspectionRecordId='".$id."'";

      $query = $this->db->query($sql);

      if($query)
      {
      return TRUE;
      }
      else
      {
      return FALSE;
      }
      }
     */

    //-----------------------------------------------------DCR------------------------------------------------------------------------------------------------

    function get_all_dcr($client_id) {
        $sql = "SELECT dcr_summary.iDCRId,dcr_summary.dDCRDate,dcr_summary.iUserId,user_master.cName,dcr_summary.cDCRRemarks FROM dcr_summary LEFT JOIN user_master ON dcr_summary.iUserId=user_master.iUserId 
		WHERE dcr_summary.bDelete=0 ";

        $sql = $sql . " and exists( select * from dcr_detail where dcr_detail.iDCRId = dcr_summary.iDCRId and  iClientReqId = $client_id and dcr_detail.bDelete=0 ) ";

        $sql = $sql . "	ORDER BY dcr_summary.iDCRId DESC";

        $query = $this->db->query($sql);

        return $query;
    }

    function get_dcr_by_user_id($UserId, $client_id) {
        $sql = "SELECT dcr_summary.iDCRId,dcr_summary.dDCRDate,dcr_summary.iUserId,user_master.cName,dcr_summary.cDCRRemarks FROM dcr_summary LEFT JOIN user_master ON dcr_summary.iUserId=user_master.iUserId WHERE dcr_summary.iUserId='" . $UserId . "' AND dcr_summary.bDelete=0 
		";

        $sql = $sql . " and exists( select * from dcr_detail where dcr_detail.iDCRId = dcr_summary.iDCRId and  iClientReqId = $client_id  and dcr_detail.bDelete=0 ) ";

        $sql = $sql . "	ORDER BY dcr_summary.iDCRId DESC";

        $query = $this->db->query($sql);

        return $query;
    }

    function get_requirement_by_client($ClientId) {
        //$this->db->where('iClientId', $ClientId);
        $this->db->where('bActive', 1);
        $this->db->where('bDelete', 0);
        $query = $this->db->get('requirement_master');

        $requirements = array();

        if ($query->result()) {
            foreach ($query->result() as $req) {
                $requirements[$req->iRequirementId] = $req->cRequirementTitle;
            }
            return $requirements;
        } else {
            return FALSE;
        }
    }

    function get_property_by_client($ClientId) {
        //$this->db->where('iClientId', $ClientId);
        $this->db->where('bActive', 1);
        $this->db->where('bDelete', 0);
        $query = $this->db->get('property_master');

        $properties = array();

        if ($query->result()) {
            foreach ($query->result() as $prop) {
                $properties[$prop->iPropertyId] = $prop->cPropertyName;
            }
            return $properties;
        } else {
            return FALSE;
        }
    }

    function dcr_get_by_id($id) {
        $sql = "SELECT * FROM dcr_summary WHERE dcr_summary.iDCRId='" . $id . "'";

        $query = $this->db->query($sql);

        if ($query) {
            $result = $query->row_array();

            return $result;
        }
    }

    function dcr_details_get_by_id($id) {
        $sql = "SELECT * FROM dcr_detail WHERE dcr_detail.iDCRId='" . $id . "' AND dcr_detail.bDelete=0";

        $query = $this->db->query($sql);

        if ($query) {
            $result = $query->result_array();

            return $result;
        }
    }

    function dcr_date_user_exists($UserId, $DCRDate) {
        $sql = "SELECT * FROM dcr_summary WHERE dcr_summary.iUserId='" . $UserId . "' AND dcr_summary.dDCRDate='" . $DCRDate . "' AND dcr_summary.bDelete=0";

        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function dcr_date_user_exists_single($UserId, $DCRDate, $cleint_id) {
        $sql = "SELECT * 
		FROM dcr_summary 
		inner join dcr_detail
		on dcr_detail.iDCRId = dcr_summary.iDCRId
		WHERE dcr_summary.iUserId='" . $UserId . "' 
		AND dcr_summary.dDCRDate='" . $DCRDate . "' 
		AND dcr_summary.bDelete=0
		and dcr_detail.bDelete=0
		and dcr_detail.iClientReqId = " . $cleint_id . "
		";

        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /* function add_dcr($data)
      {
      $DCRMode = trim($data['txtDCRMode']);

      $UserId = trim($this->session->userdata('UserId'));

      $DCRDt = trim($data['txtDCRDate']);
      $splitdcrdt = explode('/',$DCRDt);
      $DCRDate = $splitdcrdt[2]."-".$splitdcrdt[1]."-".$splitdcrdt[0];

      $DCRRemarks = trim($data['txtDCRRemarks']);

      $Saveflag=false;

      if($DCRMode=='New')
      {
      $new_activity_data = array(
      'dActivityDateTime' => date('Y-m-d H:i:s'),
      'cUserName' => trim($this->session->userdata('UserName')),
      'cIPAddress' => $this->get_client_ip(),
      'cActivityDesc' => 'Add New DCR'
      );

      $newactivitylogid = $this->save_activity_details($new_activity_data);

      if($newactivitylogid)
      {
      $addData = array(
      'dDCRDate' => $DCRDate,
      'iUserId' => $UserId,
      'cDCRRemarks' => $DCRRemarks,
      'iActivityLogId' => trim($newactivitylogid),
      );

      $SaveData = $this->db->insert('dcr_summary', $addData);

      $DCRId = $this->db->insert_id();

      if($SaveData)
      {
      foreach($data['cmbTask'] as $key => $val)
      {
      if(!empty($data['cmbTask'][$key]) && ($data['cmbTask'][$key]!=''))
      {
      $addDetail = array(
      'iDCRId' => $DCRId,
      'iTaskId' => $data['cmbTask'][$key],
      'iClientReqId' => $data['cmbClientReq'][$key],
      'iRequirementId' => $data['cmbRequirement'][$key],
      'iClientPropId' => $data['cmbClientProp'][$key],
      'iPropertyId' => $data['cmbProperty'][$key],
      'cDCRSummary' => $data['txtDCRSummary'][$key],
      );

      $insertDetail = $this->db->insert('dcr_detail', $addDetail);

      if($insertDetail)
      {
      $Saveflag=true;
      }
      }
      }
      }
      }
      }

      if($DCRMode=='Replace')
      {
      $prevdeleteflag=false;

      $sql="SELECT * FROM dcr_summary WHERE dcr_summary.iUserId='".$UserId."' AND dcr_summary.dDCRDate='".$DCRDate."' AND dcr_summary.bDelete=0";

      $query = $this->db->query($sql);

      if($query->num_rows() > 0)
      {
      $row = $query->row_array();

      $DCRId = trim($row['iDCRId']);

      $this->db->where('iDCRId',$DCRId);
      $sql2 = $this->db->get('dcr_detail');

      if($sql2->num_rows() > 0)
      {
      $delarray = array('bDelete' => 1);

      $this->db->where('iDCRId',$DCRId);
      $delete_dcr_detail = $this->db->update('dcr_detail',$delarray);

      if($delete_dcr_detail)
      {
      $delarray = array('bDelete' => 1);

      $this->db->where('iDCRId',$DCRId);
      $delete_dcr_summary = $this->db->update('dcr_summary',$delarray);

      if($delete_dcr_summary)
      {
      $prevdeleteflag=true;
      }
      }
      }
      }

      if($prevdeleteflag==true)
      {
      $UserId = trim($this->session->userdata('UserId'));

      $DCRDt = trim($data['txtDCRDate']);
      $splitdcrdt = explode('/',$DCRDt);
      $DCRDate = $splitdcrdt[2]."-".$splitdcrdt[1]."-".$splitdcrdt[0];

      $DCRRemarks = trim($data['txtDCRRemarks']);

      $new_activity_data = array(
      'dActivityDateTime' => date('Y-m-d H:i:s'),
      'cUserName' => trim($this->session->userdata('UserName')),
      'cIPAddress' => $this->get_client_ip(),
      'cActivityDesc' => 'Edit & Add new DCR'
      );

      $newactivitylogid = $this->save_activity_details($new_activity_data);

      if($newactivitylogid)
      {
      $addData = array(
      'dDCRDate' => $DCRDate,
      'iUserId' => $UserId,
      'cDCRRemarks' => $DCRRemarks,
      'iActivityLogId' => trim($newactivitylogid),
      );

      $SaveData = $this->db->insert('dcr_summary', $addData);

      $DCRId = $this->db->insert_id();

      if($SaveData)
      {
      foreach($data['cmbTask'] as $key => $val)
      {
      if(!empty($data['cmbTask'][$key]) && ($data['cmbTask'][$key]!=''))
      {
      $addDetail = array(
      'iDCRId' => $DCRId,
      'iTaskId' => $data['cmbTask'][$key],
      'iClientReqId' => $data['cmbClientReq'][$key],
      'iRequirementId' => $data['cmbRequirement'][$key],
      'iClientPropId' => $data['cmbClientProp'][$key],
      'iPropertyId' => $data['cmbProperty'][$key],
      'cDCRSummary' => $data['txtDCRSummary'][$key],
      );

      $insertDetail = $this->db->insert('dcr_detail', $addDetail);

      if($insertDetail)
      {
      $Saveflag=true;
      }
      }
      }
      }
      }
      }
      }

      if($Saveflag=='true')
      {
      return json_encode(Array("status"=>"1","msg"=>SUCCESS_INSERT_MSG));
      }
      else
      {
      return json_encode(Array("status"=>"0","msg"=>ERROR_UPDATE_MSG));
      }
      }

      function edit_dcr($data)
      {
      //$this->db->trans_start();

      $hfDCRId = trim($data['hfDCRId']);

      $DCRDt = trim($data['txtDCRDate']);
      $splitdcrdt = explode('/',$DCRDt);
      $DCRDate = $splitdcrdt[2]."-".$splitdcrdt[1]."-".$splitdcrdt[0];

      $UserId = trim($this->session->userdata('UserId'));

      $DCRRemarks = trim($data['txtDCRRemarks']);


      $Deleteflag=false;
      $Saveflag=false;

      $new_activity_data = array(
      'dActivityDateTime' => date('Y-m-d H:i:s'),
      'cUserName' => trim($this->session->userdata('UserName')),
      'cIPAddress' => $this->get_client_ip(),
      'cActivityDesc' => 'Edit DCR'
      );

      $newactivitylogid = $this->save_activity_details($new_activity_data);

      if($newactivitylogid)
      {
      $sql1="SELECT * FROM dcr_summary WHERE dcr_summary.iDCRId='".$hfDCRId."'";

      $query1=$this->db->query($sql1);

      if($query1)
      {
      if($query1->num_rows > 0)
      {
      $sql2="SELECT * FROM dcr_detail WHERE dcr_detail.iDCRId='".$hfDCRId."' AND bDelete=0";

      $query2=$this->db->query($sql2);

      if($query2->num_rows > 0)
      {
      $sql3="UPDATE dcr_detail SET dcr_detail.bDelete=1 WHERE dcr_detail.iDCRId='".$hfDCRId."'";

      $query3=$this->db->query($sql3);

      if($query3)
      {
      $Deleteflag=true;
      }
      }
      }
      }

      if($Deleteflag=='true')
      {
      $editData = array(
      'dDCRDate' => $DCRDate,
      'cDCRRemarks' => $DCRRemarks,
      'iActivityLogId' => trim($newactivitylogid),
      );

      $this->db->where('iDCRId', $hfDCRId);
      $editSummary = $this->db->update('dcr_summary', $editData);

      if($editSummary)
      {
      foreach($data['cmbTask'] as $key => $val)
      {
      if(!empty($data['cmbTask'][$key]) && ($data['cmbTask'][$key]!=''))
      {
      $addDetail = array(
      'iDCRId' => $hfDCRId,
      'iTaskId' => $data['cmbTask'][$key],
      'iClientReqId' => $data['cmbClientReq'][$key],
      'iRequirementId' => $data['cmbRequirement'][$key],
      'iClientPropId' => $data['cmbClientProp'][$key],
      'iPropertyId' => $data['cmbProperty'][$key],
      'cDCRSummary' => $data['txtDCRSummary'][$key],
      );

      $insertDetail = $this->db->insert('dcr_detail', $addDetail);

      if($insertDetail)
      {
      $Saveflag=true;
      }
      }
      }
      }
      }
      }
      if($Saveflag==true)
      {
      return json_encode(Array("status"=>"1","msg"=>SUCCESS_INSERT_MSG));
      }
      else
      {
      return json_encode(Array("status"=>"0","msg"=>ERROR_UPDATE_MSG));
      }
      }

      function delete_dcr($id)
      {
      $Deleteflag=false;

      $sql1="SELECT * FROM dcr_summary WHERE dcr_summary.iDCRId='".$id."'";

      $query1=$this->db->query($sql1);

      if($query1)
      {
      if($query1->num_rows > 0)
      {
      $sql2="SELECT * FROM dcr_detail WHERE dcr_detail.iDCRId='".$id."' AND bDelete=0";

      $query2=$this->db->query($sql2);

      if($query2->num_rows > 0)
      {
      $sql3="UPDATE dcr_detail SET dcr_detail.bDelete=1 WHERE dcr_detail.iDCRId='".$id."'";

      $query3=$this->db->query($sql3);

      if($query3)
      {
      $sql4="UPDATE dcr_summary SET dcr_summary.bDelete=1 WHERE dcr_summary.iDCRId='".$id."'";

      $query4=$this->db->query($sql4);

      if($query4)
      {
      $Deleteflag=true;
      }
      }
      }
      }
      }

      if($Deleteflag=='true')
      {
      return TRUE;
      }
      else
      {
      return FALSE;
      }
      } */


    /* function add_dcr($data)
      {
      $DCRMode = trim($data['txtDCRMode']);

      $UserId = trim($this->session->userdata('UserId'));

      $TaskAssignedByUserName = trim($this->session->userdata('Name'));

      $DCRDt = trim($data['txtDCRDate']);
      $splitdcrdt = explode('/',$DCRDt);
      $DCRDate = $splitdcrdt[2]."-".$splitdcrdt[1]."-".$splitdcrdt[0];

      $DCRRemarks = trim($data['txtDCRRemarks']);

      $Saveflag=false;
      $DCRflag=false;
      $AssignTaskflag=false;
      $TaskSaveflag=false;

      foreach($data['cmbTask'] as $key => $val)
      {
      if(!empty($data['cmbTask'][$key]) && ($data['cmbTask'][$key]!='') && empty($data['cmbAssignTaskTo'][$key]) && ($data['cmbAssignTaskTo'][$key]==''))
      {
      $DCRflag=true;
      }
      }

      foreach($data['cmbAssignTaskTo'] as $key => $val)
      {
      if(!empty($data['cmbTask'][$key]) && ($data['cmbTask'][$key]!='') && !empty($data['cmbAssignTaskTo'][$key]) && ($data['cmbAssignTaskTo'][$key]!=''))
      {
      $AssignTaskflag=true;
      }
      }

      if($DCRMode=='New')
      {
      $new_activity_data = array(
      'dActivityDateTime' => date('Y-m-d H:i:s'),
      'cUserName' => trim($this->session->userdata('UserName')),
      'cIPAddress' => $this->get_client_ip(),
      'cActivityDesc' => 'Add New DCR'
      );

      $newactivitylogid = $this->save_activity_details($new_activity_data);

      if($DCRflag==true)
      {
      $addData = array(
      'dDCRDate' => $DCRDate,
      'iUserId' => $UserId,
      'cDCRRemarks' => $DCRRemarks,
      'iActivityLogId' => trim($newactivitylogid),
      );

      $SaveData = $this->db->insert('dcr_summary', $addData);

      $DCRId = $this->db->insert_id();

      if($SaveData)
      {
      // DCR Entry
      foreach($data['cmbTask'] as $key => $val)
      {
      if(!empty($data['cmbTask'][$key]) && ($data['cmbTask'][$key]!='') && empty($data['cmbAssignTaskTo'][$key]) && ($data['cmbAssignTaskTo'][$key]==''))
      {
      $addDCRDetail = array(
      'iDCRId' => $DCRId,
      'iTaskId' => $data['cmbTask'][$key],
      'iClientReqId' => $data['cmbClientReq'][$key],
      'iRequirementId' => $data['cmbRequirement'][$key],
      'iClientPropId' => $data['cmbClientProp'][$key],
      'iPropertyId' => $data['cmbProperty'][$key],
      'cCurrentStatus' => $data['txtCurrentStatus'][$key],
      'cDCRSummary' => $data['txtDCRSummary'][$key],
      );

      $insertDCRDetail = $this->db->insert('dcr_detail', $addDCRDetail);

      if($insertDCRDetail)
      {
      $Saveflag=true;

      $sql1="UPDATE requirement_master SET requirement_master.cCurrentStatus='".$data['txtCurrentStatus'][$key]."' WHERE requirement_master.iRequirementId='".$data['cmbRequirement'][$key]."'";
      $query1 = $this->db->query($sql1);

      $sql2="UPDATE property_master SET property_master.cCurrentStatus='".$data['txtCurrentStatus'][$key]."' WHERE property_master.iPropertyId='".$data['cmbProperty'][$key]."'";
      $query2 = $this->db->query($sql2);
      }
      }
      }
      }
      }

      if($AssignTaskflag==true)
      {
      $addData = array(
      'dDCRDate' => $DCRDate,
      'iUserId' => $UserId,
      'cDCRRemarks' => $DCRRemarks,
      'iActivityLogId' => trim($newactivitylogid),
      );

      $SaveData = $this->db->insert('dcr_summary', $addData);

      $DCRId = $this->db->insert_id();

      // Assign Task Entry
      foreach($data['cmbAssignTaskTo'] as $key => $val)
      {
      if(!empty($data['cmbTask'][$key]) && ($data['cmbTask'][$key]!='') && !empty($data['cmbAssignTaskTo'][$key]) && ($data['cmbAssignTaskTo'][$key]!=''))
      {
      $txtTaskAssignDateTime = $data['txtTaskAssignDateTime'][$key];
      if(!empty($txtTaskAssignDateTime))
      {
      $txtTaskAssignDtTm = str_replace('/', '-', $txtTaskAssignDateTime);
      $TaskAssignDateTime=date('Y-m-d H:i:s', strtotime($txtTaskAssignDtTm));
      }
      else
      {
      $TaskAssignDateTime="";
      }

      $txtTaskTargetDateTime = $data['txtTaskTargetDateTime'][$key];
      if(!empty($txtTaskTargetDateTime))
      {
      $txtTaskTargetDtTm = str_replace('/', '-', $txtTaskTargetDateTime);
      $TaskTargetDateTime=date('Y-m-d H:i:s', strtotime($txtTaskTargetDtTm));
      }
      else
      {
      $TaskTargetDateTime="";
      }

      $txtReminderDateTime = $data['txtReminderDateTime'][$key];
      if(!empty($txtReminderDateTime))
      {
      $txtReminderDtTm = str_replace('/', '-', $txtReminderDateTime);
      $ReminderDateTime=date('Y-m-d H:i:s', strtotime($txtReminderDtTm));
      }
      else
      {
      $ReminderDateTime="";
      }

      $query = $this->db->query("SELECT cDepartmentName FROM department_master WHERE department_master.iDepartmentId='".$data['cmbAssignTaskTo'][$key]."'");
      $row = $query->row_array();
      $DepartmentName = trim($row['cDepartmentName']);

      $query1 = $this->db->query("SELECT cClientName FROM client_master WHERE client_master.iClientId='".$data['cmbClientReq'][$key]."'");
      $row1 = $query1->row_array();
      $ClientReqName = trim($row1['cClientName']);

      $query2 = $this->db->query("SELECT cRequirementTitle FROM requirement_master WHERE requirement_master.iRequirementId='".$data['cmbRequirement'][$key]."'");
      $row2 = $query2->row_array();
      $RequirementTitle = trim($row2['cRequirementTitle']);

      $query3 = $this->db->query("SELECT cClientName FROM client_master WHERE iClientId='".$data['cmbClientProp'][$key]."'");
      $row3 = $query3->row_array();
      $ClientPropName = trim($row3['cClientName']);

      $query4 = $this->db->query("SELECT cPropertyName FROM property_master WHERE iPropertyId='".$data['cmbProperty'][$key]."'");
      $row4 = $query4->row_array();
      $PropertyName = trim($row4['cPropertyName']);

      $query5 = $this->db->query("SELECT cTaskName FROM task_master WHERE task_master.iTaskId='".$data['cmbTask'][$key]."'");
      $row5 = $query5->row_array();
      $TaskName = trim($row5['cTaskName']);

      $TaskSummary = $data['txtAssignmentRemarks'][$key];

      ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

      $addDCRDetail = array(
      'iDCRId' => $DCRId,
      'iTaskId' => $data['cmbTask'][$key],
      'iClientReqId' => $data['cmbClientReq'][$key],
      'iRequirementId' => $data['cmbRequirement'][$key],
      'iClientPropId' => $data['cmbClientProp'][$key],
      'iPropertyId' => $data['cmbProperty'][$key],
      'cCurrentStatus' => $data['txtCurrentStatus'][$key],
      'cDCRSummary' => $data['txtDCRSummary'][$key],
      );

      $insertDCRDetail = $this->db->insert('dcr_detail', $addDCRDetail);

      if($insertDCRDetail)
      {
      $sql1="UPDATE requirement_master SET requirement_master.cCurrentStatus='".$data['txtCurrentStatus'][$key]."' WHERE requirement_master.iRequirementId='".$data['cmbRequirement'][$key]."'";
      $query1 = $this->db->query($sql1);

      $sql2="UPDATE property_master SET property_master.cCurrentStatus='".$data['txtCurrentStatus'][$key]."' WHERE property_master.iPropertyId='".$data['cmbProperty'][$key]."'";
      $query2 = $this->db->query($sql2);
      }

      ///////////////////////////////////////////////////////////////////

      $addTaskDetail = array(
      'dTaskAssignDateTime' => $TaskAssignDateTime,
      'iTaskAssignedByUserId' => $UserId,
      'iDepartmentId' => $data['cmbAssignTaskTo'][$key],
      'iClientReqId' => $data['cmbClientReq'][$key],
      'iRequirementId' => $data['cmbRequirement'][$key],
      'iClientPropId' => $data['cmbClientProp'][$key],
      'iPropertyId' => $data['cmbProperty'][$key],
      'iTaskId' => $data['cmbTask'][$key],
      'cTaskSummary' => $data['txtAssignmentRemarks'][$key],
      'dTaskTargetDateTime' => $TaskTargetDateTime,
      'dReminderDateTime' => $ReminderDateTime,
      'iDCRId' => $DCRId,
      );

      $insertTaskDetail = $this->db->insert('task_assign', $addTaskDetail);

      if($insertTaskDetail)
      {
      //-----------------Email to Staff-----------------------------------------

      $UserEmailSubject = "A New Task Assigned";

      $UserEmailMessage="Task Assigned Date Time : $txtTaskAssignDateTime"."\n\n";
      $UserEmailMessage.="Department : $DepartmentName"."\n\n";
      $UserEmailMessage.="Client Req : $ClientReqName"."\n\n";
      $UserEmailMessage.="Requirement : $RequirementTitle"."\n\n";
      $UserEmailMessage.="Client Prop : $ClientPropName"."\n\n";
      $UserEmailMessage.="Property : $PropertyName"."\n\n";
      $UserEmailMessage.="Task : $TaskName"."\n\n";
      $UserEmailMessage.="Task Summary : $TaskSummary"."\n\n";
      $UserEmailMessage.="Task Target DateTime : $txtTaskTargetDateTime"."\n\n";
      $UserEmailMessage.="Task Reminder DateTime : $txtReminderDateTime"."\n\n";
      $UserEmailMessage.="Task Assigned By : $TaskAssignedByUserName"."\n\n";

      //$UserEmailMessage = $txtTaskAssignDateTime."=>".$DepartmentName."=>".$ClientReqName."=>".$RequirementTitle."=>".$ClientPropName."=>".$PropertyName."=>".$TaskName."=>".$TaskSummary."=>".$txtTaskTargetDateTime."=>".$txtReminderDateTime."=>".$TaskAssignedByUserName;


      $mail = new PHPMailer();
      $mail->IsSMTP(); 		                                  // We are going to use SMTP
      $mail->SMTPAuth   = true;                                 // Enabled SMTP authentication
      $mail->SMTPSecure = "ssl";                                // Prefix for secure protocol to connect to the server
      $mail->Host       = "smtp.gmail.com";     		          // Setting GMail as our SMTP server
      $mail->Port       =  465;                                 // SMTP port to connect to GMail
      $mail->Username   = "support@linkersindia.com";           // User email address
      $mail->Password   = "manashids";                          // Password in GMail

      $mail->SetFrom('support@linkersindia.com', 'Linkers');     //Who is sending the email
      $mail->AddReplyTo("support@linkersindia.com', 'Linkers");  //Email address that receives the response
      $mail->Subject   = "$UserEmailSubject";
      $mail->Body  	 = "$UserEmailMessage";

      $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!";



      $sql = "SELECT user_master.cEmailAddress FROM user_master WHERE user_master.cEmailAddress<>'' AND user_master.bActive=1";

      $query = $this->db->query($sql);

      if($query)
      {
      if($query->num_rows > 0)
      {
      $rows = $query->result_array();

      foreach($rows as $row)
      {
      $UserRecipientEmailAddress = trim($row['cEmailAddress']);

      if((!empty($UserRecipientEmailAddress)) && (filter_var($UserRecipientEmailAddress, FILTER_VALIDATE_EMAIL) !== false))
      {
      $mail->AddAddress("$UserRecipientEmailAddress");
      }
      }
      }
      }

      if(!$mail->Send())
      {
      echo "Task User Email Error: " . $mail->ErrorInfo;
      //return false;
      }
      else
      {
      echo "Task User Email Sent Successfully...!";
      //return true;
      }

      $Saveflag=true;
      }
      }
      }
      }
      }

      if($DCRMode=='Replace')
      {
      $prevdeleteflag=false;

      $sql="SELECT * FROM dcr_summary WHERE dcr_summary.iUserId='".$UserId."' AND dcr_summary.dDCRDate='".$DCRDate."' AND dcr_summary.bDelete=0";

      $query = $this->db->query($sql);

      if($query->num_rows() > 0)
      {
      $row = $query->row_array();

      $DCRId = trim($row['iDCRId']);

      $this->db->where('iDCRId',$DCRId);
      $sql2 = $this->db->get('dcr_detail');

      if($sql2->num_rows() > 0)
      {
      $delarray = array('bDelete' => 1);

      $this->db->where('iDCRId',$DCRId);
      $delete_dcr_detail = $this->db->update('dcr_detail',$delarray);

      if($delete_dcr_detail)
      {
      $delarray = array('bDelete' => 1);

      $this->db->where('iDCRId',$DCRId);
      $delete_dcr_summary = $this->db->update('dcr_summary',$delarray);

      if($delete_dcr_summary)
      {
      $this->db->where('iDCRId',$DCRId);
      $sql3 = $this->db->get('task_assign');

      if($sql3->num_rows() > 0)
      {
      $delarray = array('bDelete' => 1);

      $this->db->where('iDCRId',$DCRId);
      $delete_task_assign = $this->db->update('task_assign',$delarray);
      }

      $prevdeleteflag=true;
      }
      }
      }
      }

      if($prevdeleteflag==true)
      {
      $new_activity_data = array(
      'dActivityDateTime' => date('Y-m-d H:i:s'),
      'cUserName' => trim($this->session->userdata('UserName')),
      'cIPAddress' => $this->get_client_ip(),
      'cActivityDesc' => 'Edit & Add New DCR'
      );

      $newactivitylogid = $this->save_activity_details($new_activity_data);

      if($DCRflag==true)
      {
      $addData = array(
      'dDCRDate' => $DCRDate,
      'iUserId' => $UserId,
      'cDCRRemarks' => $DCRRemarks,
      'iActivityLogId' => trim($newactivitylogid),
      );

      $SaveData = $this->db->insert('dcr_summary', $addData);

      $DCRId = $this->db->insert_id();

      if($SaveData)
      {
      // DCR Entry
      foreach($data['cmbTask'] as $key => $val)
      {
      if(!empty($data['cmbTask'][$key]) && ($data['cmbTask'][$key]!='') && empty($data['cmbAssignTaskTo'][$key]) && ($data['cmbAssignTaskTo'][$key]==''))
      {
      $addDCRDetail = array(
      'iDCRId' => $DCRId,
      'iTaskId' => $data['cmbTask'][$key],
      'iClientReqId' => $data['cmbClientReq'][$key],
      'iRequirementId' => $data['cmbRequirement'][$key],
      'iClientPropId' => $data['cmbClientProp'][$key],
      'iPropertyId' => $data['cmbProperty'][$key],
      'cCurrentStatus' => $data['txtCurrentStatus'][$key],
      'cDCRSummary' => $data['txtDCRSummary'][$key],
      );

      $insertDCRDetail = $this->db->insert('dcr_detail', $addDCRDetail);

      if($insertDCRDetail)
      {
      $Saveflag=true;

      $sql1="UPDATE requirement_master SET requirement_master.cCurrentStatus='".$data['txtCurrentStatus'][$key]."' WHERE requirement_master.iRequirementId='".$data['cmbRequirement'][$key]."'";
      $query1 = $this->db->query($sql1);

      $sql2="UPDATE property_master SET property_master.cCurrentStatus='".$data['txtCurrentStatus'][$key]."' WHERE property_master.iPropertyId='".$data['cmbProperty'][$key]."'";
      $query2 = $this->db->query($sql2);
      }
      }
      }
      }
      }

      if($AssignTaskflag==true)
      {
      $addData = array(
      'dDCRDate' => $DCRDate,
      'iUserId' => $UserId,
      'cDCRRemarks' => $DCRRemarks,
      'iActivityLogId' => trim($newactivitylogid),
      );

      $SaveData = $this->db->insert('dcr_summary', $addData);

      $DCRId = $this->db->insert_id();

      // Assign Task Entry
      foreach($data['cmbAssignTaskTo'] as $key => $val)
      {
      if(!empty($data['cmbTask'][$key]) && ($data['cmbTask'][$key]!='') && !empty($data['cmbAssignTaskTo'][$key]) && ($data['cmbAssignTaskTo'][$key]!=''))
      {
      $txtTaskAssignDateTime = $data['txtTaskAssignDateTime'][$key];
      if(!empty($txtTaskAssignDateTime))
      {
      $txtTaskAssignDtTm = str_replace('/', '-', $txtTaskAssignDateTime);
      $TaskAssignDateTime=date('Y-m-d H:i:s', strtotime($txtTaskAssignDtTm));
      }
      else
      {
      $TaskAssignDateTime="";
      }

      $txtTaskTargetDateTime = $data['txtTaskTargetDateTime'][$key];
      if(!empty($txtTaskTargetDateTime))
      {
      $txtTaskTargetDtTm = str_replace('/', '-', $txtTaskTargetDateTime);
      $TaskTargetDateTime=date('Y-m-d H:i:s', strtotime($txtTaskTargetDtTm));
      }
      else
      {
      $TaskTargetDateTime="";
      }

      $txtReminderDateTime = $data['txtReminderDateTime'][$key];
      if(!empty($txtReminderDateTime))
      {
      $txtReminderDtTm = str_replace('/', '-', $txtReminderDateTime);
      $ReminderDateTime=date('Y-m-d H:i:s', strtotime($txtReminderDtTm));
      }
      else
      {
      $ReminderDateTime="";
      }

      $query = $this->db->query("SELECT cDepartmentName FROM department_master WHERE department_master.iDepartmentId='".$data['cmbAssignTaskTo'][$key]."'");
      $row = $query->row_array();
      $DepartmentName = trim($row['cDepartmentName']);

      $query1 = $this->db->query("SELECT cClientName FROM client_master WHERE client_master.iClientId='".$data['cmbClientReq'][$key]."'");
      $row1 = $query1->row_array();
      $ClientReqName = trim($row1['cClientName']);

      $query2 = $this->db->query("SELECT cRequirementTitle FROM requirement_master WHERE requirement_master.iRequirementId='".$data['cmbRequirement'][$key]."'");
      $row2 = $query2->row_array();
      $RequirementTitle = trim($row2['cRequirementTitle']);

      $query3 = $this->db->query("SELECT cClientName FROM client_master WHERE iClientId='".$data['cmbClientProp'][$key]."'");
      $row3 = $query3->row_array();
      $ClientPropName = trim($row3['cClientName']);

      $query4 = $this->db->query("SELECT cPropertyName FROM property_master WHERE iPropertyId='".$data['cmbProperty'][$key]."'");
      $row4 = $query4->row_array();
      $PropertyName = trim($row4['cPropertyName']);

      $query5 = $this->db->query("SELECT cTaskName FROM task_master WHERE task_master.iTaskId='".$data['cmbTask'][$key]."'");
      $row5 = $query5->row_array();
      $TaskName = trim($row5['cTaskName']);

      $TaskSummary = $data['txtAssignmentRemarks'][$key];

      ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

      $addDCRDetail = array(
      'iDCRId' => $DCRId,
      'iTaskId' => $data['cmbTask'][$key],
      'iClientReqId' => $data['cmbClientReq'][$key],
      'iRequirementId' => $data['cmbRequirement'][$key],
      'iClientPropId' => $data['cmbClientProp'][$key],
      'iPropertyId' => $data['cmbProperty'][$key],
      'cCurrentStatus' => $data['txtCurrentStatus'][$key],
      'cDCRSummary' => $data['txtDCRSummary'][$key],
      );

      $insertDCRDetail = $this->db->insert('dcr_detail', $addDCRDetail);

      if($insertDCRDetail)
      {
      $sql1="UPDATE requirement_master SET requirement_master.cCurrentStatus='".$data['txtCurrentStatus'][$key]."' WHERE requirement_master.iRequirementId='".$data['cmbRequirement'][$key]."'";
      $query1 = $this->db->query($sql1);

      $sql2="UPDATE property_master SET property_master.cCurrentStatus='".$data['txtCurrentStatus'][$key]."' WHERE property_master.iPropertyId='".$data['cmbProperty'][$key]."'";
      $query2 = $this->db->query($sql2);
      }

      ///////////////////////////////////////////////////////////////////

      $addTaskDetail = array(
      'dTaskAssignDateTime' => $TaskAssignDateTime,
      'iTaskAssignedByUserId' => $UserId,
      'iDepartmentId' => $data['cmbAssignTaskTo'][$key],
      'iClientReqId' => $data['cmbClientReq'][$key],
      'iRequirementId' => $data['cmbRequirement'][$key],
      'iClientPropId' => $data['cmbClientProp'][$key],
      'iPropertyId' => $data['cmbProperty'][$key],
      'iTaskId' => $data['cmbTask'][$key],
      'cTaskSummary' => $data['txtAssignmentRemarks'][$key],
      'dTaskTargetDateTime' => $TaskTargetDateTime,
      'dReminderDateTime' => $ReminderDateTime,
      'iDCRId' => $DCRId,
      );

      $insertTaskDetail = $this->db->insert('task_assign', $addTaskDetail);

      if($insertTaskDetail)
      {
      //-----------------Email to Staff-----------------------------------------

      /*$UserEmailSubject = "A New Task Assigned";

      $UserEmailMessage="Task Assigned Date Time : $txtTaskAssignDateTime"."\n\n";
      $UserEmailMessage.="Department : $DepartmentName"."\n\n";
      $UserEmailMessage.="Client Req : $ClientReqName"."\n\n";
      $UserEmailMessage.="Requirement : $RequirementTitle"."\n\n";
      $UserEmailMessage.="Client Prop : $ClientPropName"."\n\n";
      $UserEmailMessage.="Property : $PropertyName"."\n\n";
      $UserEmailMessage.="Task : $TaskName"."\n\n";
      $UserEmailMessage.="Task Summary : $TaskSummary"."\n\n";
      $UserEmailMessage.="Task Target DateTime : $txtTaskTargetDateTime"."\n\n";
      $UserEmailMessage.="Task Reminder DateTime : $txtReminderDateTime"."\n\n";
      $UserEmailMessage.="Task Assigned By : $TaskAssignedByUserName"."\n\n";

      //$UserEmailMessage = $txtTaskAssignDateTime."=>".$DepartmentName."=>".$ClientReqName."=>".$RequirementTitle."=>".$ClientPropName."=>".$PropertyName."=>".$TaskName."=>".$TaskSummary."=>".$txtTaskTargetDateTime."=>".$txtReminderDateTime."=>".$TaskAssignedByUserName;


      $mail = new PHPMailer();
      $mail->IsSMTP(); 		                                  // We are going to use SMTP
      $mail->SMTPAuth   = true;                                 // Enabled SMTP authentication
      $mail->SMTPSecure = "ssl";                                // Prefix for secure protocol to connect to the server
      $mail->Host       = "smtp.gmail.com";     		          // Setting GMail as our SMTP server
      $mail->Port       =  465;                                 // SMTP port to connect to GMail
      $mail->Username   = "support@linkersindia.com";           // User email address
      $mail->Password   = "manashids";                          // Password in GMail

      $mail->SetFrom('support@linkersindia.com', 'Linkers');     //Who is sending the email
      $mail->AddReplyTo("support@linkersindia.com', 'Linkers");  //Email address that receives the response
      $mail->Subject   = "$UserEmailSubject";
      $mail->Body  	 = "$UserEmailMessage";

      $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!";



      $sql = "SELECT user_master.cEmailAddress FROM user_master WHERE user_master.cEmailAddress<>'' AND user_master.bActive=1";

      $query = $this->db->query($sql);

      if($query)
      {
      if($query->num_rows > 0)
      {
      $rows = $query->result_array();

      foreach($rows as $row)
      {
      $UserRecipientEmailAddress = trim($row['cEmailAddress']);

      if((!empty($UserRecipientEmailAddress)) && (filter_var($UserRecipientEmailAddress, FILTER_VALIDATE_EMAIL) !== false))
      {
      $mail->AddAddress("$UserRecipientEmailAddress");
      }
      }
      }
      }

      if(!$mail->Send())
      {
      echo "Task User Email Error: " . $mail->ErrorInfo;
      //return false;
      }
      else
      {
      echo "Task User Email Sent Successfully...!";
      //return true;
      }*

      $Saveflag=true;
      }
      }
      }
      }
      }
      }

      if($Saveflag=='true')
      {
      return json_encode(Array("status"=>"1","msg"=>SUCCESS_INSERT_MSG));
      }
      else
      {
      return json_encode(Array("status"=>"0","msg"=>ERROR_UPDATE_MSG));
      }
      } */

    function add_dcr1() {

        $data = array(
            'iDCRDetailId' => $this->input->post('txtDCRMode'),
            'iDCRId' => $this->input->post('txtDCRDate'),
            'iTaskId' => $this->input->post('cmbTask'),
            'iClientReqId' => $this->input->post('cmbClientReq'),
            'iRequirementId' => $this->input->post('cmbRequirement'),
            'iClientPropId' => $this->input->post('cmbClientProp'),
            'iPropertyId' => $this->input->post('cmbProperty'),
            'iCurrentStatusId' => $this->input->post('cmbCurrentStatus'),
            'cDCRSummary' => $this->input->post('txtDCRSummary'));
        $query = $this->db->insert('dcr_detail', $data);
        if ($query !== '')
            $data = array(
                'iDCRId' => $this->input->post('txtDCRMode'),
                'dDCRDate' => $this->input->post('txtDCRDate'),
                'iUserId' => $this->input->post('cmbTask'),
                'cDCRRemarks' => $this->input->post('txtDCRSummary'));
        $this->db->insert('dcr_summary', $data);
    }

//        function add_deal_lost1()
//        {
//          $addData = array(
//                              'dDate' => $this->input->post('txtDate'),
//                'iClientReqId' => $this->input->post('cmbClientReq'),
//                'iRequirementId' => $this->input->post('cmbRequirement'),
//                'iClientPropId' => $this->input->post('cmbClientProp'),
//                'iPropertyId' => $this->input->post('cmbProperty'),
//                'cSummaryOfDealLostReason' => $this->input->post('txtDealSummaryLostReason'),
//                'dFollowUpDate' => $this->input->post('txtFollowUpDate'));
//		$this->db->insert('deal_lost', $addData);
// 
//        }

    function add_dcr($data) {
        
//        
//        echo '<pre>';
//        print_r($data);
//        echo '</pre>';
//        die;
        
        $DCRMode = trim($data['txtDCRMode']);

        $UserId = trim($this->session->userdata('UserId'));

        $TaskAssignedByUserName = trim($this->session->userdata('Name'));

        $DCRDt = trim($data['txtDCRDate']);
        $splitdcrdt = explode('/', $DCRDt);
        $DCRDate = $splitdcrdt[2] . "-" . $splitdcrdt[1] . "-" . $splitdcrdt[0];

        $DCRRemarks = isset($data['txtDCRRemarks']) ? trim($data['txtDCRRemarks']) : '';

        $Saveflag = false;


//		if($DCRMode=='New')
//		{
        $new_activity_data = array(
            'dActivityDateTime' => date('Y-m-d H:i:s'),
            'cUserName' => trim($this->session->userdata('UserName')),
            'cIPAddress' => $this->get_client_ip(),
            'cActivityDesc' => 'Add New Task'
        );

        $newactivitylogid = $this->save_activity_details($new_activity_data);

        $addData = array(
            'dDCRDate' => $DCRDate,
            'iUserId' => $UserId,
            'cDCRRemarks' => $DCRRemarks,
            'iActivityLogId' => trim($newactivitylogid),
        );

        $SaveData = $this->db->insert('dcr_summary', $addData);
        $DCRId = $this->db->insert_id();

        if ($SaveData) {
            // DCR Entry
            foreach ($data['cmbTask'] as $key => $val) {
                if (!empty($data['cmbTask'][$key]) && ($data['cmbTask'][$key] != '')) {
                    $addDCRDetail = array(
                        'iDCRId' => $DCRId,
                        'iTaskId' => $data['cmbTask'][$key],
                        'iClientReqId' => $data['cmbClientReq'][$key],
                        'iRequirementId' => $data['cmbRequirement'][$key],
                        'iClientPropId' => $data['cmbClientProp'][$key] ? $data['cmbClientProp'][$key] : '' ,
                        'iPropertyId' => $data['cmbProperty'][$key],
                        'iCurrentStatusId' => $data['cmbCurrentStatus'][$key],
                        'cDCRSummary' => $data['txtDCRSummary'][$key],
                    );

                    $insertDCRDetail = $this->db->insert('dcr_detail', $addDCRDetail);

                    if ($insertDCRDetail) {
                        if (!empty($data['cmbCurrentStatus'][$key]) && ($data['cmbCurrentStatus'][$key] != '') && !empty($data['cmbRequirement'][$key]) && ($data['cmbRequirement'][$key] != '')) {
                            $sql1 = "SELECT * FROM requirement_master WHERE requirement_master.iRequirementId='" . $data['cmbRequirement'][$key] . "'";
                            $query1 = $this->db->query($sql1);
                            if ($query1) {
                                if ($query1->num_rows > 0) {
                                    $sql2 = "UPDATE requirement_master SET requirement_master.iCurrentStatusId='" . $data['cmbCurrentStatus'][$key] . "' WHERE requirement_master.iRequirementId='" . $data['cmbRequirement'][$key] . "'";
                                    $query2 = $this->db->query($sql2);
                                }
                            }
                        }

                        if (!empty($data['cmbCurrentStatus'][$key]) && ($data['cmbCurrentStatus'][$key] != '') && !empty($data['cmbProperty'][$key]) && ($data['cmbProperty'][$key] != '')) {
                            $sql3 = "SELECT * FROM property_master WHERE property_master.iPropertyId='" . $data['cmbProperty'][$key] . "'";
                            $query3 = $this->db->query($sql3);

                            if ($query3) {
                                if ($query3->num_rows > 0) {
                                    $sql4 = "UPDATE property_master SET property_master.iCurrentStatusId='" . $data['cmbCurrentStatus'][$key] . "' WHERE property_master.iPropertyId='" . $data['cmbProperty'][$key] . "'";
                                    $query4 = $this->db->query($sql4);
                                }
                            }
                        }

                        $Saveflag = true;
                    }
                }
            }
        }
//		}

        /* 		if($DCRMode=='Replace')
          {
          $prevdeleteflag=false;

          $sql="SELECT * FROM dcr_summary WHERE dcr_summary.iUserId='".$UserId."' AND dcr_summary.dDCRDate='".$DCRDate."' AND dcr_summary.bDelete=0";


          $query = $this->db->query($sql);


          if($query->num_rows() > 0)
          {
          $row = $query->row_array();

          $DCRId = trim($row['iDCRId']);

          $this->db->where('iDCRId',$DCRId);
          $sql2 = $this->db->get('dcr_detail');

          if($sql2->num_rows() > 0)
          {
          $delarray = array('bDelete' => 1);

          $this->db->where('iDCRId',$DCRId);
          $delete_dcr_detail = $this->db->update('dcr_detail',$delarray);

          if($delete_dcr_detail)
          {
          $delarray = array('bDelete' => 1);

          $this->db->where('iDCRId',$DCRId);
          $delete_dcr_summary = $this->db->update('dcr_summary',$delarray);

          if($delete_dcr_summary)
          {

          $prevdeleteflag=true;
          }
          }
          }
          }

          if($prevdeleteflag==true)
          {
          $new_activity_data = array(
          'dActivityDateTime' => date('Y-m-d H:i:s'),
          'cUserName' => trim($this->session->userdata('UserName')),
          'cIPAddress' => $this->get_client_ip(),
          'cActivityDesc' => 'Edit & Add New Task'
          );

          $newactivitylogid = $this->save_activity_details($new_activity_data);

          if($DCRflag==true)
          {
          $addData = array(
          'dDCRDate' => $DCRDate,
          'iUserId' => $UserId,
          'cDCRRemarks' => $DCRRemarks,
          'iActivityLogId' => trim($newactivitylogid),
          );

          $SaveData = $this->db->insert('dcr_summary', $addData);

          $DCRId = $this->db->insert_id();

          if($SaveData)
          {
          foreach($data['cmbTask'] as $key => $val)
          {
          if(!empty($data['cmbTask'][$key]) && ($data['cmbTask'][$key]!=''))
          {
          $addDCRDetail = array(
          'iDCRId' => $DCRId,
          'iTaskId' => $data['cmbTask'][$key],
          'iClientReqId' => $data['cmbClientReq'][$key],
          'iRequirementId' => $data['cmbRequirement'][$key],
          'iClientPropId' => $data['cmbClientProp'][$key],
          'iPropertyId' => $data['cmbProperty'][$key],
          'iCurrentStatusId' => $data['cmbCurrentStatus'][$key],
          'cDCRSummary' => $data['txtDCRSummary'][$key],
          );

          $insertDCRDetail = $this->db->insert('dcr_detail', $addDCRDetail);

          if($insertDCRDetail)
          {
          if(!empty($data['cmbCurrentStatus'][$key]) && ($data['cmbCurrentStatus'][$key]!='') && !empty($data['cmbRequirement'][$key]) && ($data['cmbRequirement'][$key]!=''))
          {
          $sql1="SELECT * FROM requirement_master WHERE requirement_master.iRequirementId='".$data['cmbRequirement'][$key]."'";
          $query1 = $this->db->query($sql1);
          if($query1)
          {
          if($query1->num_rows > 0)
          {
          $sql2="UPDATE requirement_master SET requirement_master.iCurrentStatusId='".$data['cmbCurrentStatus'][$key]."' WHERE requirement_master.iRequirementId='".$data['cmbRequirement'][$key]."'";
          $query2 = $this->db->query($sql2);
          }
          }
          }

          if(!empty($data['cmbCurrentStatus'][$key]) && ($data['cmbCurrentStatus'][$key]!='') && !empty($data['cmbProperty'][$key]) && ($data['cmbProperty'][$key]!=''))
          {
          $sql3="SELECT * FROM property_master WHERE property_master.iPropertyId='".$data['cmbProperty'][$key]."'";
          $query3 = $this->db->query($sql3);

          if($query3)
          {
          if($query3->num_rows > 0)
          {
          $sql4="UPDATE property_master SET property_master.iCurrentStatusId='".$data['cmbCurrentStatus'][$key]."' WHERE property_master.iPropertyId='".$data['cmbProperty'][$key]."'";
          $query4 = $this->db->query($sql4);
          }
          }
          }

          $Saveflag=true;
          }
          }
          }
          }
          }
          }
          } */

        if ($Saveflag == true) {
            return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
        } else {
            return json_encode(Array("status" => "0", "msg" => ERROR_UPDATE_MSG));
        }
    }

    function edit_dcr($data) {
        //$this->db->trans_start();

        $hfDCRId = trim($data['hfDCRId']);

        $DCRDt = trim($data['txtDCRDate']);
        $splitdcrdt = explode('/', $DCRDt);
        $DCRDate = $splitdcrdt[2] . "-" . $splitdcrdt[1] . "-" . $splitdcrdt[0];

        $UserId = trim($this->session->userdata('UserId'));

        $DCRRemarks = trim($data['txtDCRRemarks']);

        $Deleteflag = false;
        $Saveflag = false;

        $new_activity_data = array(
            'dActivityDateTime' => date('Y-m-d H:i:s'),
            'cUserName' => trim($this->session->userdata('UserName')),
            'cIPAddress' => $this->get_client_ip(),
            'cActivityDesc' => 'Edit Task'
        );

        $newactivitylogid = $this->save_activity_details($new_activity_data);

        if ($newactivitylogid) {
            $sql1 = "SELECT * FROM dcr_summary WHERE dcr_summary.iDCRId='" . $hfDCRId . "'";

            $query1 = $this->db->query($sql1);

            if ($query1) {
                if ($query1->num_rows > 0) {
                    $sql2 = "SELECT * FROM dcr_detail WHERE dcr_detail.iDCRId='" . $hfDCRId . "'";

                    $query2 = $this->db->query($sql2);

                    if ($query2->num_rows > 0) {
                        $sql3 = "UPDATE dcr_detail SET dcr_detail.bDelete=1 WHERE dcr_detail.iDCRId='" . $hfDCRId . "'";

                        $query3 = $this->db->query($sql3);

                        if ($query3) {
                            $Deleteflag = true;
                        }
                    }
                }
            }

            if ($Deleteflag == 'true') {
                $editData = array(
                    'dDCRDate' => $DCRDate,
                    'cDCRRemarks' => $DCRRemarks,
                    'iActivityLogId' => trim($newactivitylogid),
                );

                $this->db->where('iDCRId', $hfDCRId);
                $editSummary = $this->db->update('dcr_summary', $editData);

                if ($editSummary) {
                    foreach ($data['cmbTask'] as $key => $val) {
                        if (!empty($data['cmbTask'][$key]) && ($data['cmbTask'][$key] != '')) {
                            $addDCRDetail = array(
                                'iDCRId' => $hfDCRId,
                                'iTaskId' => $data['cmbTask'][$key],
                                'iClientReqId' => $data['cmbClientReq'][$key],
                                'iRequirementId' => $data['cmbRequirement'][$key],
                                'iClientPropId' => $data['cmbClientProp'][$key] ? $data['cmbClientProp'][$key] : '' ,
                                'iPropertyId' => $data['cmbProperty'][$key],
                                'iCurrentStatusId' => $data['cmbCurrentStatus'][$key],
                                'cDCRSummary' => $data['txtDCRSummary'][$key],
                            );

                            $insertDCRDetail = $this->db->insert('dcr_detail', $addDCRDetail);

                            if ($insertDCRDetail) {
                                if (!empty($data['cmbCurrentStatus'][$key]) && ($data['cmbCurrentStatus'][$key] != '') && !empty($data['cmbRequirement'][$key]) && ($data['cmbRequirement'][$key] != '')) {
                                    $sql1 = "SELECT * FROM requirement_master WHERE requirement_master.iRequirementId='" . $data['cmbRequirement'][$key] . "'";
                                    $query1 = $this->db->query($sql1);
                                    if ($query1) {
                                        if ($query1->num_rows > 0) {
                                            $sql2 = "UPDATE requirement_master SET requirement_master.iCurrentStatusId='" . $data['cmbCurrentStatus'][$key] . "' WHERE requirement_master.iRequirementId='" . $data['cmbRequirement'][$key] . "'";
                                            $query2 = $this->db->query($sql2);
                                        }
                                    }
                                }

                                if (!empty($data['cmbCurrentStatus'][$key]) && ($data['cmbCurrentStatus'][$key] != '') && !empty($data['cmbProperty'][$key]) && ($data['cmbProperty'][$key] != '')) {
                                    $sql3 = "SELECT * FROM property_master WHERE property_master.iPropertyId='" . $data['cmbProperty'][$key] . "'";
                                    $query3 = $this->db->query($sql3);

                                    if ($query3) {
                                        if ($query3->num_rows > 0) {
                                            $sql4 = "UPDATE property_master SET property_master.iCurrentStatusId='" . $data['cmbCurrentStatus'][$key] . "' WHERE property_master.iPropertyId='" . $data['cmbProperty'][$key] . "'";
                                            $query4 = $this->db->query($sql4);
                                        }
                                    }
                                }

                                $Saveflag = true;
                            }
                        }
                    }
                }
            }
        }

        if ($Saveflag == true) {
            return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
        } else {
            return json_encode(Array("status" => "0", "msg" => ERROR_UPDATE_MSG));
        }
    }

    function delete_dcr($id) {
        $Deleteflag = false;

        $sql1 = "SELECT * FROM dcr_summary WHERE dcr_summary.iDCRId='" . $id . "'";

        $query1 = $this->db->query($sql1);

        if ($query1) {
            if ($query1->num_rows > 0) {
                $sql2 = "SELECT * FROM dcr_detail WHERE dcr_detail.iDCRId='" . $id . "' AND bDelete=0";

                $query2 = $this->db->query($sql2);

                if ($query2->num_rows > 0) {
                    $sql3 = "UPDATE dcr_detail SET dcr_detail.bDelete=1 WHERE dcr_detail.iDCRId='" . $id . "'";

                    $query3 = $this->db->query($sql3);

                    if ($query3) {
                        $sql4 = "UPDATE dcr_summary SET dcr_summary.bDelete=1 WHERE dcr_summary.iDCRId='" . $id . "'";

                        $query4 = $this->db->query($sql4);

                        if ($query4) {
                            $Deleteflag = true;
                        }
                    }
                }
            }
        }

        if ($Deleteflag == 'true') {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    //--------------------------------------------------------------------------------------------------------------------------------------------------------
    //-----------------------------------------------------Source---------------------------------------------------------------------------------------------

    function get_all_source_master() {
        $sql = "SELECT source_master.iSourceId,source_master.cSourceName,CASE source_master.bActive WHEN 1 THEN 'Yes' ELSE 'No' END AS 'bActive' FROM source_master WHERE source_master.bDelete=0";

        $query = $this->db->query($sql);

        return $query;
    }

    function source_master_get_by_id($id) {
        $sql = "SELECT * FROM source_master WHERE source_master.iSourceId='" . $id . "'";

        $query = $this->db->query($sql);

        if ($query) {
            $result = $query->row_array();

            return $result;
        }
    }

    function add_source_master($data) {
        $SourceName = trim($data['txtSourceName']);
        $Active = (int) trim($data['chkActive']);

        $sql = "SELECT * FROM source_master WHERE source_master.cSourceName='" . $SourceName . "' AND source_master.bDelete=0";

        $query = $this->db->query($sql);

        if ($query) {
            if ($query->num_rows > 0) {
                return json_encode(Array("status" => "0", "msg" => EXIST_MSG));
            } else {
                $addData = array(
                    'cSourceName' => $SourceName,
                    'bActive' => $Active,
                );

                $insert = $this->db->insert('source_master', $addData);

                if ($insert) {
                    return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
                } else {
                    return json_encode(Array("status" => "0", "msg" => ERROR_INSERT_MSG));
                }
            }
        }
    }

    function edit_source_master($data) {
        $hfSourceId = trim($data['hfSourceId']);
        $SourceName = trim($data['txtSourceName']);
        $Active = trim($data['hfActive']);

        $sql = "SELECT * FROM source_master WHERE source_master.cSourceName='" . $SourceName . "' AND source_master.bDelete=0 AND source_master.iSourceId!='" . $hfSourceId . "'";

        $query = $this->db->query($sql);

        if ($query) {
            if ($query->num_rows > 0) {
                return json_encode(Array("status" => "0", "msg" => EXIST_MSG));
            } else {
                $editData = array(
                    'cSourceName' => $SourceName,
                    'bActive' => $Active,
                );

                $this->db->where('iSourceId', $hfSourceId);
                $update = $this->db->update('source_master', $editData);

                if ($update) {
                    return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
                } else {
                    return json_encode(Array("status" => "0", "msg" => ERROR_UPDATE_MSG));
                }
            }
        }
    }

    function delete_source_master($id) {
        $sql = "UPDATE source_master SET source_master.bDelete=1 WHERE source_master.iSourceId='" . $id . "'";

        $query = $this->db->query($sql);

        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    //-----------------------------------------------------Business Purpose---------------------------------------------------------------------------------------------

    function get_all_business_purpose_master() {
        $sql = "SELECT business_purpose_master.iBusinessPurposeId,business_purpose_master.cBusinessPurposeName,CASE business_purpose_master.bActive WHEN 1 THEN 'Yes' ELSE 'No' END AS 'bActive' FROM business_purpose_master WHERE business_purpose_master.bDelete=0";

        $query = $this->db->query($sql);

        return $query;
    }

    function business_purpose_master_get_by_id($id) {
        $sql = "SELECT * FROM business_purpose_master WHERE business_purpose_master.iBusinessPurposeId='" . $id . "'";

        $query = $this->db->query($sql);

        if ($query) {
            $result = $query->row_array();

            return $result;
        }
    }

    function add_business_purpose_master($data) {
        $BusinessPurposeName = trim($data['txtBusinessPurposeName']);
        $Active = (int) trim($data['chkActive']);

        $sql = "SELECT * FROM business_purpose_master WHERE business_purpose_master.cBusinessPurposeName='" . $BusinessPurposeName . "' AND business_purpose_master.bDelete=0";

        $query = $this->db->query($sql);

        if ($query) {
            if ($query->num_rows > 0) {
                return json_encode(Array("status" => "0", "msg" => EXIST_MSG));
            } else {
                $addData = array(
                    'cBusinessPurposeName' => $BusinessPurposeName,
                    'bActive' => $Active,
                );

                $insert = $this->db->insert('business_purpose_master', $addData);

                if ($insert) {
                    return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
                } else {
                    return json_encode(Array("status" => "0", "msg" => ERROR_INSERT_MSG));
                }
            }
        }
    }

    function edit_business_purpose_master($data) {
        $hfBusinessPurposeId = trim($data['hfBusinessPurposeId']);
        $BusinessPurposeName = trim($data['txtBusinessPurposeName']);
        $Active = trim($data['hfActive']);

        $sql = "SELECT * FROM business_purpose_master WHERE business_purpose_master.cBusinessPurposeName='" . $BusinessPurposeName . "' AND business_purpose_master.bDelete=0 AND business_purpose_master.iBusinessPurposeId!='" . $hfBusinessPurposeId . "'";

        $query = $this->db->query($sql);

        if ($query) {
            if ($query->num_rows > 0) {
                return json_encode(Array("status" => "0", "msg" => EXIST_MSG));
            } else {
                $editData = array(
                    'cBusinessPurposeName' => $BusinessPurposeName,
                    'bActive' => $Active,
                );

                $this->db->where('iBusinessPurposeId', $hfBusinessPurposeId);
                $update = $this->db->update('business_purpose_master', $editData);

                if ($update) {
                    return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
                } else {
                    return json_encode(Array("status" => "0", "msg" => ERROR_UPDATE_MSG));
                }
            }
        }
    }

    function delete_business_purpose_master($id) {
        $sql = "UPDATE business_purpose_master SET business_purpose_master.bDelete=1 WHERE business_purpose_master.iBusinessPurposeId='" . $id . "'";

        $query = $this->db->query($sql);

        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    //-----------------------------------------------------Department-----------------------------------------------------------------------------------------

    function get_all_department_master() {
        $sql = "SELECT department_master.iDepartmentId,department_master.cDepartmentName,CASE department_master.bActive WHEN 1 THEN 'Yes' ELSE 'No' END AS 'bActive' FROM department_master WHERE department_master.bDelete=0";

        $query = $this->db->query($sql);

        return $query;
    }

    function department_master_get_by_id($id) {
        $sql = "SELECT * FROM department_master WHERE department_master.iDepartmentId='" . $id . "'";

        $query = $this->db->query($sql);

        if ($query) {
            $result = $query->row_array();

            return $result;
        }
    }

    function add_department_master($data) {
        $DepartmentName = trim($data['txtDepartmentName']);
        $Active = (int) trim($data['chkActive']);

        $sql = "SELECT * FROM department_master WHERE department_master.cDepartmentName='" . $DepartmentName . "' AND department_master.bDelete=0";

        $query = $this->db->query($sql);

        if ($query) {
            if ($query->num_rows > 0) {
                return json_encode(Array("status" => "0", "msg" => EXIST_MSG));
            } else {
                $addData = array(
                    'cDepartmentName' => $DepartmentName,
                    'bActive' => $Active,
                );

                $insert = $this->db->insert('department_master', $addData);

                if ($insert) {
                    return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
                } else {
                    return json_encode(Array("status" => "0", "msg" => ERROR_INSERT_MSG));
                }
            }
        }
    }

    function edit_department_master($data) {
        $hfDepartmentId = trim($data['hfDepartmentId']);
        $DepartmentName = trim($data['txtDepartmentName']);
        $Active = trim($data['hfActive']);

        $sql = "SELECT * FROM department_master WHERE department_master.cDepartmentName='" . $DepartmentName . "' AND department_master.bDelete=0 AND department_master.iDepartmentId!='" . $hfDepartmentId . "'";

        $query = $this->db->query($sql);

        if ($query) {
            if ($query->num_rows > 0) {
                return json_encode(Array("status" => "0", "msg" => EXIST_MSG));
            } else {
                $editData = array(
                    'cDepartmentName' => $DepartmentName,
                    'bActive' => $Active,
                );

                $this->db->where('iDepartmentId', $hfDepartmentId);
                $update = $this->db->update('department_master', $editData);

                if ($update) {
                    return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
                } else {
                    return json_encode(Array("status" => "0", "msg" => ERROR_UPDATE_MSG));
                }
            }
        }
    }

    function delete_department_master($id) {
        $sql = "UPDATE department_master SET department_master.bDelete=1 WHERE department_master.iDepartmentId='" . $id . "'";

        $query = $this->db->query($sql);

        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    //-----------------------------------------------------Branch--------------------------------------------------------------------------------------------------------------------------------

    function get_all_branch_master() {
        $sql = "SELECT branch_master.iBranchId,branch_master.cBranchName,CASE branch_master.bActive WHEN 1 THEN 'Yes' ELSE 'No' END AS 'bActive' FROM branch_master WHERE branch_master.bDelete=0";

        $query = $this->db->query($sql);

        return $query;
    }

    function branch_master_get_by_id($id) {
        $sql = "SELECT * FROM branch_master WHERE branch_master.iBranchId='" . $id . "'";

        $query = $this->db->query($sql);

        if ($query) {
            $result = $query->row_array();

            return $result;
        }
    }

    function add_branch_master($data) {
        $BranchName = trim($data['txtBranchName']);
        $Active = (int) trim($data['chkActive']);

        $sql = "SELECT * FROM branch_master WHERE branch_master.cBranchName='" . $BranchName . "' AND branch_master.bDelete=0";

        $query = $this->db->query($sql);

        if ($query) {
            if ($query->num_rows > 0) {
                return json_encode(Array("status" => "0", "msg" => EXIST_MSG));
            } else {
                $addData = array(
                    'cBranchName' => $BranchName,
                    'bActive' => $Active,
                );

                $insert = $this->db->insert('branch_master', $addData);

                if ($insert) {
                    return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
                } else {
                    return json_encode(Array("status" => "0", "msg" => ERROR_INSERT_MSG));
                }
            }
        }
    }

    function edit_branch_master($data) {
        $hfBranchId = trim($data['hfBranchId']);
        $BranchName = trim($data['txtBranchName']);
        $Active = trim($data['hfActive']);

        $sql = "SELECT * FROM branch_master WHERE branch_master.cBranchName='" . $BranchName . "' AND branch_master.bDelete=0 AND branch_master.iBranchId!='" . $hfBranchId . "'";

        $query = $this->db->query($sql);

        if ($query) {
            if ($query->num_rows > 0) {
                return json_encode(Array("status" => "0", "msg" => EXIST_MSG));
            } else {
                $editData = array(
                    'cBranchName' => $BranchName,
                    'bActive' => $Active,
                );

                $this->db->where('iBranchId', $hfBranchId);
                $update = $this->db->update('branch_master', $editData);

                if ($update) {
                    return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
                } else {
                    return json_encode(Array("status" => "0", "msg" => ERROR_UPDATE_MSG));
                }
            }
        }
    }

    function delete_branch_master($id) {
        $sql = "UPDATE branch_master SET branch_master.bDelete=1 WHERE branch_master.iBranchId='" . $id . "'";

        $query = $this->db->query($sql);

        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    //-----------------------------------------------------Current Status------------------------------------------------------------------------------------------

    function get_all_current_status_master() {
        $sql = "SELECT current_status_master.iCurrentStatusId,current_status_master.cCurrentStatusName,CASE current_status_master.bActive WHEN 1 THEN 'Yes' ELSE 'No' END AS 'bActive' FROM current_status_master WHERE current_status_master.bDelete=0 ORDER BY current_status_master.cCurrentStatusName ASC";

        $query = $this->db->query($sql);

        return $query;
    }

    function current_status_master_get_by_id($id) {
        $sql = "SELECT * FROM current_status_master WHERE current_status_master.iCurrentStatusId='" . $id . "'";

        $query = $this->db->query($sql);

        if ($query) {
            $result = $query->row_array();

            return $result;
        }
    }

    function add_current_status_master($data) {
        $CurrentStatusName = trim($data['txtCurrentStatusName']);
        $Active = (int) trim($data['chkActive']);

        $sql = "SELECT * FROM current_status_master WHERE current_status_master.cCurrentStatusName='" . $CurrentStatusName . "' AND current_status_master.bDelete=0";

        $query = $this->db->query($sql);

        if ($query) {
            if ($query->num_rows > 0) {
                return json_encode(Array("status" => "0", "msg" => EXIST_MSG));
            } else {
                $addData = array(
                    'cCurrentStatusName' => $CurrentStatusName,
                    'bActive' => $Active,
                );

                $insert = $this->db->insert('current_status_master', $addData);

                if ($insert) {
                    return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
                } else {
                    return json_encode(Array("status" => "0", "msg" => ERROR_INSERT_MSG));
                }
            }
        }
    }

    function edit_current_status_master($data) {
        $hfCurrentStatusId = trim($data['hfCurrentStatusId']);
        $CurrentStatusName = trim($data['txtCurrentStatusName']);
        $Active = trim($data['hfActive']);

        $sql = "SELECT * FROM current_status_master WHERE current_status_master.cCurrentStatusName='" . $CurrentStatusName . "' AND current_status_master.bDelete=0 AND current_status_master.iCurrentStatusId!='" . $hfCurrentStatusId . "'";

        $query = $this->db->query($sql);

        if ($query) {
            if ($query->num_rows > 0) {
                return json_encode(Array("status" => "0", "msg" => EXIST_MSG));
            } else {
                $editData = array(
                    'cCurrentStatusName' => $CurrentStatusName,
                    'bActive' => $Active,
                );

                $this->db->where('iCurrentStatusId', $hfCurrentStatusId);
                $update = $this->db->update('current_status_master', $editData);

                if ($update) {
                    return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
                } else {
                    return json_encode(Array("status" => "0", "msg" => ERROR_UPDATE_MSG));
                }
            }
        }
    }

    function delete_current_status_master($id) {
        $sql = "UPDATE current_status_master SET current_status_master.bDelete=1 WHERE current_status_master.iCurrentStatusId='" . $id . "'";

        $query = $this->db->query($sql);

        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    //----------------------------------------------------- Task Assign --------------------------------------------------------------------------------------

    function get_all_task_assign() {
        $sql = "SELECT task_assign.iTaskAssignId,UMTAB.cName as cTaskAssignedByName,UMTDB.cName as cTaskDoneByName,department_master.cDepartmentName,CMREQ.cClientName as cReqClientName,requirement_master.cRequirementTitle,CMPROP.cClientName as cPropClientName,property_master.cPropertyName,
		      task_assign.dTaskAssignDateTime,task_assign.cTaskSummary,task_assign.dTaskTargetDateTime,task_assign.dReminderDateTime,CASE task_assign.bTaskDone WHEN 1 THEN 'Yes' ELSE 'No' END AS 'bTaskDone' 
			  FROM task_assign LEFT JOIN user_master as UMTAB ON task_assign.iTaskAssignedByUserId=UMTAB.iUserId LEFT JOIN user_master as UMTDB ON task_assign.iTaskDoneByUserId=UMTDB.iUserId LEFT JOIN department_master ON task_assign.iDepartmentId=department_master.iDepartmentId 
			  LEFT JOIN client_master as CMREQ ON task_assign.iClientReqId=CMREQ.iClientId LEFT JOIN client_master as CMPROP ON task_assign.iClientPropId=CMPROP.iClientId 
			  LEFT JOIN requirement_master ON task_assign.iRequirementId=requirement_master.iRequirementId LEFT JOIN property_master ON task_assign.iPropertyId=property_master.iPropertyId WHERE task_assign.bDelete=0 ORDER BY iTaskAssignId DESC";

        $query = $this->db->query($sql);

        return $query;
    }

    function task_assign_get_by_id($id) {
        $sql = "SELECT * FROM task_assign WHERE task_assign.iTaskAssignId='" . $id . "'";

        $query = $this->db->query($sql);

        if ($query) {
            $result = $query->row_array();

            return $result;
        }
    }

    function add_task_assign($data) {
        $TaskAssignedByUserId = trim($this->session->userdata('UserId'));

        $TaskAssignedByUserName = trim($this->session->userdata('Name'));

        $txtTaskAssignDateTime = trim($data['txtTaskAssignDateTime']);
        if (!empty($txtTaskAssignDateTime)) {
            $txtTaskAssignDtTm = str_replace('/', '-', $txtTaskAssignDateTime);
            $TaskAssignDateTime = date('Y-m-d H:i:s', strtotime($txtTaskAssignDtTm));
        } else {
            $TaskAssignDateTime = "";
        }

        $DepartmentId = trim($data['cmbDepartment']);

        $query = $this->db->query("SELECT cDepartmentName FROM department_master WHERE department_master.iDepartmentId='" . $DepartmentId . "'");
        $row = $query->row_array();
        $DepartmentName = trim($row['cDepartmentName']);

        $txtTaskTargetDateTime = trim($data['txtTaskTargetDateTime']);
        if (!empty($txtTaskTargetDateTime)) {
            $txtTaskTargetDtTm = str_replace('/', '-', $txtTaskTargetDateTime);
            $TaskTargetDateTime = date('Y-m-d H:i:s', strtotime($txtTaskTargetDtTm));
        } else {
            $TaskTargetDateTime = "";
        }

        $txtReminderDateTime = trim($data['txtReminderDateTime']);
        if (!empty($txtReminderDateTime)) {
            $txtReminderDtTm = str_replace('/', '-', $txtReminderDateTime);
            $ReminderDateTime = date('Y-m-d H:i:s', strtotime($txtReminderDtTm));
        } else {
            $ReminderDateTime = "";
        }

        $ClientReqId = trim($data['cmbClientReq']);

        $query1 = $this->db->query("SELECT cClientName FROM client_master WHERE client_master.iClientId='" . $ClientReqId . "'");
        $row1 = $query1->row_array();
        $ClientReqName = trim($row1['cClientName']);

        $RequirementId = trim($data['cmbRequirement']);

        $query2 = $this->db->query("SELECT cRequirementTitle FROM requirement_master WHERE requirement_master.iRequirementId='" . $RequirementId . "'");
        $row2 = $query2->row_array();
        $RequirementTitle = trim($row2['cRequirementTitle']);

        $ClientPropId = trim($data['cmbClientProp']);

        $query3 = $this->db->query("SELECT cClientName FROM client_master WHERE iClientId='" . $ClientPropId . "'");
        $row3 = $query3->row_array();
        $ClientPropName = trim($row3['cClientName']);

        $PropertyId = trim($data['cmbProperty']);

        $query4 = $this->db->query("SELECT cPropertyName FROM property_master WHERE iPropertyId='" . $PropertyId . "'");
        $row4 = $query4->row_array();
        $PropertyName = trim($row4['cPropertyName']);

        $TaskId = trim($data['cmbTask']);

        $query5 = $this->db->query("SELECT cTaskName FROM task_master WHERE task_master.iTaskId='" . $TaskId . "'");
        $row5 = $query5->row_array();
        $TaskName = trim($row5['cTaskName']);

        $TaskSummary = trim($data['txtTaskSummary']);

        $addData = array(
            'dTaskAssignDateTime' => $TaskAssignDateTime,
            'iTaskAssignedByUserId' => $TaskAssignedByUserId,
            'iDepartmentId' => $DepartmentId,
            'iClientReqId' => $ClientReqId,
            'iRequirementId' => $RequirementId,
            'iClientPropId' => $ClientPropId,
            'iPropertyId' => $PropertyId,
            'iTaskId' => $TaskId,
            'cTaskSummary' => $TaskSummary,
            'dTaskTargetDateTime' => $TaskTargetDateTime,
            'dReminderDateTime' => $ReminderDateTime,
        );

        $insert = $this->db->insert('task_assign', $addData);

        if ($insert) {
            //-----------------Email to Staff-----------------------------------

            $UserEmailSubject = "A New Task Assigned";

            $UserEmailMessage = "Task Assigned Date Time : $txtTaskAssignDateTime" . "\n\n";
            $UserEmailMessage.="Department : $DepartmentName" . "\n\n";
            $UserEmailMessage.="Client Req : $ClientReqName" . "\n\n";
            $UserEmailMessage.="Requirement : $RequirementTitle" . "\n\n";
            $UserEmailMessage.="Client Prop : $ClientPropName" . "\n\n";
            $UserEmailMessage.="Property : $PropertyName" . "\n\n";
            $UserEmailMessage.="Task : $TaskName" . "\n\n";
            $UserEmailMessage.="Task Summary : $TaskSummary" . "\n\n";
            $UserEmailMessage.="Task Target DateTime : $txtTaskTargetDateTime" . "\n\n";
            $UserEmailMessage.="Task Reminder DateTime : $txtReminderDateTime" . "\n\n";
            $UserEmailMessage.="Task Assigned By : $TaskAssignedByUserName" . "\n\n";


            $mail = new PHPMailer();
            $mail->IsSMTP();                                     // We are going to use SMTP
            $mail->SMTPAuth = true;                                 // Enabled SMTP authentication
            $mail->SMTPSecure = "ssl";                                // Prefix for secure protocol to connect to the server
            $mail->Host = "smtp.gmail.com";                 // Setting GMail as our SMTP server
            $mail->Port = 465;                                 // SMTP port to connect to GMail
            $mail->Username = "support@linkersindia.com";           // User email address
            $mail->Password = "manashids";                          // Password in GMail

            $mail->SetFrom('support@linkersindia.com', 'Linkers India');     //Who is sending the email
            $mail->AddReplyTo("support@linkersindia.com', 'Linkers India");  //Email address that receives the response
            $mail->Subject = "$UserEmailSubject";
            $mail->Body = "$UserEmailMessage";

            $mail->AltBody = "To view the message, please use an HTML compatible email viewer!";



            $sql = "SELECT user_master.cEmailAddress FROM user_master WHERE user_master.cEmailAddress<>'' AND user_master.bActive=1";

            $query = $this->db->query($sql);

            if ($query) {
                if ($query->num_rows > 0) {
                    $rows = $query->result_array();

                    foreach ($rows as $row) {
                        $UserRecipientEmailAddress = trim($row['cEmailAddress']);

                        if ((!empty($UserRecipientEmailAddress)) && (filter_var($UserRecipientEmailAddress, FILTER_VALIDATE_EMAIL) !== false)) {
                            $mail->AddAddress("$UserRecipientEmailAddress");
                        }
                    }
                }
            }

            if (!$mail->Send()) {
                echo "Assign Task User Email Error: " . $mail->ErrorInfo;
                //return false;
            } else {
                echo "Assign Task User Email Sent Successfully...!";
                //return true;
            }

            return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
        } else {
            return json_encode(Array("status" => "0", "msg" => ERROR_INSERT_MSG));
        }
    }

    function edit_task_assign($data) {
        $hfTaskAssignId = trim($data['hfTaskAssignId']);

        $TaskAssignedByUserId = trim($this->session->userdata('UserId'));

        $DepartmentId = trim($data['cmbDepartment']);

        $txtTaskAssignDateTime = trim($data['txtTaskAssignDateTime']);
        if (!empty($txtTaskAssignDateTime)) {
            $txtTaskAssignDtTm = str_replace('/', '-', $txtTaskAssignDateTime);
            $TaskAssignDateTime = date('Y-m-d H:i:s', strtotime($txtTaskAssignDtTm));
        } else {
            $TaskAssignDateTime = "";
        }

        $txtTaskTargetDateTime = trim($data['txtTaskTargetDateTime']);
        if (!empty($txtTaskTargetDateTime)) {
            $txtTaskTargetDtTm = str_replace('/', '-', $txtTaskTargetDateTime);
            $TaskTargetDateTime = date('Y-m-d H:i:s', strtotime($txtTaskTargetDtTm));
        } else {
            $TaskTargetDateTime = "";
        }

        $txtReminderDateTime = trim($data['txtReminderDateTime']);
        if (!empty($txtReminderDateTime)) {
            $txtReminderDtTm = str_replace('/', '-', $txtReminderDateTime);
            $ReminderDateTime = date('Y-m-d H:i:s', strtotime($txtReminderDtTm));
        } else {
            $ReminderDateTime = "";
        }

        $ClientReqId = trim($data['cmbClientReq']);

        $RequirementId = trim($data['cmbRequirement']);

        $ClientPropId = trim($data['cmbClientProp']);

        $PropertyId = trim($data['cmbProperty']);

        $TaskId = trim($data['cmbTask']);

        $TaskSummary = trim($data['txtTaskSummary']);

        $editData = array(
            'dTaskAssignDateTime' => $TaskAssignDateTime,
            'iTaskAssignedByUserId' => $TaskAssignedByUserId,
            'iDepartmentId' => $DepartmentId,
            'iClientReqId' => $ClientReqId,
            'iRequirementId' => $RequirementId,
            'iClientPropId' => $ClientPropId,
            'iPropertyId' => $PropertyId,
            'iTaskId' => $TaskId,
            'cTaskSummary' => $TaskSummary,
            'dTaskTargetDateTime' => $TaskTargetDateTime,
            'dReminderDateTime' => $ReminderDateTime,
        );

        $this->db->where('iTaskAssignId', $hfTaskAssignId);
        $update = $this->db->update('task_assign', $editData);

        if ($update) {
            return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
        } else {
            return json_encode(Array("status" => "0", "msg" => ERROR_UPDATE_MSG));
        }
    }

    function user_update_task_assigned($id) {
        $UserId = trim($this->session->userdata('UserId'));

        $CurrentDate = date('Y-m-d');

        $sql = "UPDATE task_assign SET task_assign.bTaskDone=1,dTaskDoneDate='" . $CurrentDate . "',iTaskDoneByUserId='" . $UserId . "' WHERE task_assign.iTaskAssignId='" . $id . "'";

        $query = $this->db->query($sql);

        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function delete_task_assign($id) {
        $sql = "UPDATE task_assign SET task_assign.bDelete=1 WHERE task_assign.iTaskAssignId='" . $id . "'";

        $query = $this->db->query($sql);

        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    //-----------------------------------------------------Property-------------------------------------------------------------------------------------------

    function get_all_property_master($client_id = 0) {
        $sql = "SELECT (select count(iTaskId) from dcr_detail where property_master.iPropertyId=dcr_detail.iPropertyId AND dcr_detail.iTaskId=3) as inspection,
                     (select count(iTaskId) from dcr_detail where property_master.iPropertyId=dcr_detail.iPropertyId AND dcr_detail.iTaskId=5) as delivery,
                     property_master.iPropertyId,property_master.cPropertyName,
                    current_status_master.cCurrentStatusName,CASE property_master.bAcceptTermsAndConditions 
                    WHEN 1 THEN 'Yes' ELSE 'No' END AS 'bAcceptTermsAndConditions',
                    CASE property_master.bActive WHEN 1 THEN 'Yes' ELSE 'No' END AS 'bActive' 
                    FROM property_master LEFT JOIN current_status_master ON property_master.iCurrentStatusId=current_status_master.iCurrentStatusId WHERE property_master.bDelete=0";
        if ($client_id != 0) {
            $sql = $sql . " and iClientId = " . $client_id;
        }
        $query = $this->db->query($sql);

        return $query;
    }

    function get_all_property_master_datatable($client_id = 0) {


        $iDisplayStart = $this->input->get_post('iDisplayStart', true);
        $iDisplayLength = $this->input->get_post('iDisplayLength', true);
        $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
        $iSortingCols = $this->input->get_post('iSortingCols', true);
        $sSearch = $this->input->get_post('sSearch', true);
        $sEcho = $this->input->get_post('sEcho', true);


        if ($client_id != 0) {
            $sql = $sql . " and iClientId = " . $client_id;
        }


        $aColumns = array("(select count(iTaskId) from dcr_detail where property_master.iPropertyId=dcr_detail.iPropertyId AND dcr_detail.iTaskId=3) as inspection,
        (select count(iTaskId) from dcr_detail where property_master.iPropertyId=dcr_detail.iPropertyId AND dcr_detail.iTaskId=5) as delivery,
        property_master.iPropertyId,property_master.cPropertyName,
        current_status_master.cCurrentStatusName,CASE property_master.bAcceptTermsAndConditions 
        WHEN 1 THEN 'Yes' ELSE 'No' END AS 'bAcceptTermsAndConditions',
        CASE property_master.bActive WHEN 1 THEN 'Yes' ELSE 'No' END AS 'bActive'");




        // DB table to use
        $sIndexColumn = 'property_master.iPropertyId';
        $sTable = 'property_master';
        $where = "  property_master.bDelete=0 " . $sql;


        /* Database connection information */


        // Paging
        if (isset($iDisplayStart) && $iDisplayLength != '-1') {
            $this->db->limit($this->db->escape_str($iDisplayLength), $this->db->escape_str($iDisplayStart));
        }

        if (isset($iSortCol_0)) {
            for ($i = 0; $i < intval($iSortingCols); $i++) {
                $iSortCol = $this->input->get_post('iSortCol_' . $i, true);
                $bSortable = $this->input->get_post('bSortable_' . intval($iSortCol), true);
                $sSortDir = $this->input->get_post('sSortDir_' . $i, true);

                if ($bSortable == 'true') {
                    $col = intval($this->db->escape_str($iSortCol));
                    $this->db->order_by('iPropertyId', $this->db->escape_str($sSortDir));
                }
            }
        }

        // Ordering


        /*
         * Ordering
         */

        /*
         * Filtering
         * NOTE this does not match the built-in DataTables filtering which does it
         * word by word on any field. It's possible to do here, but concerned about efficiency
         * on very large tables, and MySQL's regex functionality is very limited
         */


        $sWhere = $where;
        if (isset($_GET['sSearch']) && $_GET['sSearch'] != "") {
            $where = $where . " and (";
            $sWhere = " (" . $where;
            $sWhere .= " cPropertyName LIKE '%" . $this->db->escape_like_str($sSearch) . "%' ";
//            for ( $i=0 ; $i<count($aColumns) ; $i++ )
//            {
//
//                if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $i!=0 && $i!=1)
//                {
//                    
//                    //$this->db->or_like($aColumns[$i], $this->db->escape_like_str($sSearch));
//                    $sWhere .= ' '.$aColumns[$i]." LIKE '%".$this->db->escape_like_str($sSearch)."%' OR ";
//                }
//            }
//            $sWhere = substr_replace( $sWhere, "", -3 );
            $sWhere .= '))';
        }
        /* Individual column filtering */
        for ($i = 0; $i < count($aColumns); $i++) {

            if (isset($_GET['bSearchable_' . $i]) && $_GET['bSearchable_' . $i] == "true" && $_GET['sSearch_' . $i] != '' && $i != 0 && $i != 1) {
                if ($sWhere == "") {
                    $sWhere = $where;
                } else {
                    $sWhere .= " AND ";
                }


                $sWhere .= $aColumns[$i] . " LIKE '%" . mysql_real_escape_string($_GET['sSearch_' . $i]) . "%' ";
            }
        }

        $this->db->select('SQL_CALC_FOUND_ROWS ' . str_replace(' , ', ' ', implode(', ', $aColumns)), false);
        $this->db->from($sTable);
        $this->db->join("current_status_master", "property_master.iCurrentStatusId=current_status_master.iCurrentStatusId", "LEFT");
        $this->db->where($sWhere, null, false);
        $rResult = $this->db->get();


        //echo $this->db->last_query();die;


        $this->db->select('FOUND_ROWS() AS found_rows');
        $iFilteredTotal = $this->db->get()->row()->found_rows;

        // Total data set length

        $iTotal = $iFilteredTotal;

        // Output
        $output = array(
            'sEcho' => intval($sEcho),
            'iTotalRecords' => $iTotal,
            'iTotalDisplayRecords' => $iFilteredTotal,
            'aaData' => array()
        );


        $sno = 1;
        foreach ($rResult->result_array() as $aRow) {
            $row = array();
            foreach ($aRow as $col) {
                $row[] = $col;
            }


            $PropertyId = trim($aRow['iPropertyId']);

            $PropertyName = trim($aRow['cPropertyName']);

            if (!empty($aRow['cCurrentStatusName'])) {
                $CurrentStatusName = trim($aRow['cCurrentStatusName']);
            } else {
                $CurrentStatusName = "NA";
            }

            $insp = $aRow['inspection'];
            $delv = $aRow['delivery'];

            $AcceptTermsAndConditions = trim($aRow['bAcceptTermsAndConditions']);

            $Active = trim($aRow['bActive']);

            $inspectionurl = base_url() . 'index.php/dashboard/popup_for_inspection_delivery/' . $PropertyId . '/popup/3';

            $inspections = '<a  class="iframesss" href="' . $inspectionurl . '"  >' . $insp . '</a>';


            $deliverys = base_url() . 'index.php/dashboard/popup_for_inspection_delivery/' . $PropertyId . '/popup/5';

            $deliveryurl = '<a  class="iframesss" href="' . $deliverys . '"  >' . $delv . '</a>';


            $viewporturlhtml = base_url() . 'index.php/dashboard/viewproperty/' . $PropertyId;

            $viewporturlsht = '<a class="various" data-fancybox-type="iframe" href="' . $viewporturlhtml . '"><span class="ui-icon ui-icon-search"></span></a>';


            $editurl = base_url() . 'index.php/dashboard/edit_form_property_master/' . $PropertyId;

            $editurls = '<a class="various" data-fancybox-type="iframe" href="' . $editurl . '"><span class="ui-icon ui-icon-pencil"></span></a>';


            $propertydel = base_url() . 'index.php/dashboard/propertydelivery/' . $PropertyId;
            
            $delimg = '<img width="13" height="13" src="'.base_url().'images/pdf.png">';

            $propertydels = '<a class="various" data-fancybox-type="iframe" href="' . $propertydel . '" title="Print Delivery" target="_blank">'.$delimg.'</a>';


            $propertyhistory = base_url() . 'index.php/dashboard/propertyhistory/' . $PropertyId;

            $propertyhistorys = '<a class="various" data-fancybox-type="iframe" href="' . $propertyhistory . '" title="Print History" target="_blank"><span class="ui-icon ui-icon-print"></span></a>';


            //$row[0] = $PropertyId;
            $row[0] = $aRow['cPropertyName'];
            $row[1] = $CurrentStatusName;
            $row[2] = $AcceptTermsAndConditions;
            $row[3] = $inspections;
            $row[4] = $deliveryurl;
            $row[5] = $Active;
            $row[6] = $viewporturlsht;
            $row[7] = $editurls;
            $row[8] = $propertydels;
            $row[9] = $propertyhistorys;


            $sno++;
            $output['aaData'][] = $row;
        }

        echo json_encode($output);
    }

    function fatal_error($sErrorMessage = '') {
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error');
        die($sErrorMessage);
    }

    function get_all_property_master_datatable1($client_id = 0) {


        $this->datatable11();
        die;

        if ($client_id != 0) {
            $sql = $sql . " and iClientId = " . $client_id;
        }


        $aColumns = array('(select count(iTaskId) from dcr_detail where property_master.iPropertyId=dcr_detail.iPropertyId AND dcr_detail.iTaskId=3) as inspection',
            '(select count(iTaskId) from dcr_detail where property_master.iPropertyId=dcr_detail.iPropertyId AND dcr_detail.iTaskId=5) as delivery',
            'property_master.iPropertyId', 'property_master.cPropertyName',
            "CASE property_master.bAcceptTermsAndConditions WHEN 1 THEN 'Yes' ELSE 'No' END AS 'bAcceptTermsAndConditions'", "CASE property_master.bActive WHEN 1 THEN 'Yes' ELSE 'No' END AS 'bActive'");

        // DB table to use
        $sIndexColumn = 'property_master.iPropertyId';
        $sTable = 'property_master';
        $where = "  property_master.bDelete=0 " . $sql;

        /////





        /*
         * Paging
         */
        $sLimit = "";
        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
            $sLimit = "LIMIT " . intval($_GET['iDisplayStart']) . ", " .
                    intval($_GET['iDisplayLength']);
        }


        /*
         * Ordering
         */
        $sOrder = "";
        if (isset($_GET['iSortCol_0'])) {
            $sOrder = "ORDER BY  ";
            for ($i = 0; $i < intval($_GET['iSortingCols']); $i++) {
                if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true") {
                    $sOrder .= $aColumns[intval($_GET['iSortCol_' . $i])] . "
                    " . ($_GET['sSortDir_' . $i] === 'asc' ? 'asc' : 'desc') . ", ";
                }
            }

            $sOrder = substr_replace($sOrder, "", -2);
            if ($sOrder == "ORDER BY") {
                $sOrder = "";
            }
        }


        $sWhere = $where;



        if (isset($_GET['sSearch']) && $_GET['sSearch'] != "") {
            $where = $where . " and (";
            $sWhere = " (" . $where;
            for ($i = 0; $i < count($aColumns); $i++) {

                if (isset($_GET['bSearchable_' . $i]) && $_GET['bSearchable_' . $i] == "true") {

                    //$this->db->or_like($aColumns[$i], $this->db->escape_like_str($sSearch));
                    $sWhere .= ' ' . $aColumns[$i] . " LIKE '%" . $this->db->escape_like_str($sSearch) . "%' OR ";
                }
            }
            $sWhere = substr_replace($sWhere, "", -3);
            $sWhere .= '))';
        }
        /* Individual column filtering */
        for ($i = 0; $i < count($aColumns); $i++) {
            if (isset($_GET['bSearchable_' . $i]) && $_GET['bSearchable_' . $i] == "true" && $_GET['sSearch_' . $i] != '') {
                if ($sWhere == "") {
                    $sWhere = $where;
                } else {
                    $sWhere .= " AND ";
                }


                $sWhere .= $aColumns[$i] . " LIKE '%" . mysql_real_escape_string($_GET['sSearch_' . $i]) . "%' ";
            }
        }



        /*
         * SQL queries
         * Get data to display
         */


        $this->db->select('SQL_CALC_FOUND_ROWS ' . str_replace(' , ', ' ', implode(', ', $aColumns)), false);
        $this->db->from($sTable);
        $this->db->join("current_status_master", "property_master.iCurrentStatusId=current_status_master.iCurrentStatusId", "LEFT");
        $this->db->where($sWhere, null, false);
        $rResult = $this->db->get();











        $this->db->select('FOUND_ROWS() AS found_rows');
        $iFilteredTotal = $this->db->get()->row()->found_rows;

        // Total data set length

        $iTotal = $iFilteredTotal;


        /*
         * Output
         */


        // Output
        $output = array(
            'sEcho' => intval($sEcho),
            'iTotalRecords' => $iTotal,
            'iTotalDisplayRecords' => $iFilteredTotal,
            'aaData' => array()
        );
////        
//      echo '<pre>';
//        print_r($output);
//        echo '</pre>';die;




        foreach ($rResult->result_array() as $aRow) {
            $row = array();
            foreach ($aRow as $col) {
                $row[] = $col;
            }



            $output['aaData'][] = $row;
        }



        echo json_encode($output);
    }

    function datatable11() {



        $iDisplayStart = $this->input->get_post('iDisplayStart', true);
        $iDisplayLength = $this->input->get_post('iDisplayLength', true);
        $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
        $iSortingCols = $this->input->get_post('iSortingCols', true);
        $sSearch = $this->input->get_post('sSearch', true);
        $sEcho = $this->input->get_post('sEcho', true);


        if ($client_id != 0) {
            $sql = $sql . " and iClientId = " . $client_id;
        }



//        $sql = "SELECT (select count(iTaskId) from dcr_detail where property_master.iPropertyId=dcr_detail.iPropertyId AND dcr_detail.iTaskId=3) as inspection,
//                     (select count(iTaskId) from dcr_detail where property_master.iPropertyId=dcr_detail.iPropertyId AND dcr_detail.iTaskId=5) as delivery,
//                     property_master.iPropertyId,property_master.cPropertyName,
//                    current_status_master.cCurrentStatusName,CASE property_master.bAcceptTermsAndConditions 
//                    WHEN 1 THEN 'Yes' ELSE 'No' END AS 'bAcceptTermsAndConditions',
//                    CASE property_master.bActive WHEN 1 THEN 'Yes' ELSE 'No' END AS 'bActive' 
//                    FROM property_master LEFT JOIN current_status_master ON property_master.iCurrentStatusId=current_status_master.iCurrentStatusId WHERE property_master.bDelete=0";
//        
//        $aColumns = array('(select count(iTaskId) from dcr_detail where property_master.iPropertyId=dcr_detail.iPropertyId AND dcr_detail.iTaskId=3) as inspection',
//            '(select count(iTaskId) from dcr_detail where property_master.iPropertyId=dcr_detail.iPropertyId AND dcr_detail.iTaskId=5) as delivery',
//            'property_master.iPropertyId', 'property_master.cPropertyName',
//            "CASE property_master.bAcceptTermsAndConditions WHEN 1 THEN 'Yes' ELSE 'No' END AS 'bAcceptTermsAndConditions'", "CASE property_master.bActive WHEN 1 THEN 'Yes' ELSE 'No' END AS 'bActive'");


        $aColumns = array("(select count(iTaskId) from dcr_detail where property_master.iPropertyId=dcr_detail.iPropertyId AND dcr_detail.iTaskId=3) as inspection,
                     (select count(iTaskId) from dcr_detail where property_master.iPropertyId=dcr_detail.iPropertyId AND dcr_detail.iTaskId=5) as delivery,
                     property_master.iPropertyId,property_master.cPropertyName,
                    current_status_master.cCurrentStatusName,CASE property_master.bAcceptTermsAndConditions 
                    WHEN 1 THEN 'Yes' ELSE 'No' END AS 'bAcceptTermsAndConditions',
                    CASE property_master.bActive WHEN 1 THEN 'Yes' ELSE 'No' END AS 'bActive'");




        // DB table to use
        $sIndexColumn = 'property_master.iPropertyId';
        $sTable = 'property_master';
        $where = "  property_master.bDelete=0 " . $sql;


        /* Database connection information */


        /*
         * Paging
         */
//        $sLimit = "";
//        if (isset($_GET['iDisplayStart']) && $_GET['iDisplayLength'] != '-1') {
//            $sLimit = "LIMIT " . intval($_GET['iDisplayStart']) . ", " .
//                    intval($_GET['iDisplayLength']);
//        }
        // Paging
        if (isset($iDisplayStart) && $iDisplayLength != '-1') {
            $this->db->limit($this->db->escape_str($iDisplayLength), $this->db->escape_str($iDisplayStart));
        }

        if (isset($iSortCol_0)) {
            for ($i = 0; $i < intval($iSortingCols); $i++) {
                $iSortCol = $this->input->get_post('iSortCol_' . $i, true);
                $bSortable = $this->input->get_post('bSortable_' . intval($iSortCol), true);
                $sSortDir = $this->input->get_post('sSortDir_' . $i, true);

                if ($bSortable == 'true') {
                    $col = intval($this->db->escape_str($iSortCol));
                    $this->db->order_by('iPropertyId', $this->db->escape_str($sSortDir));
                }
            }
        }

        // Ordering


        /*
         * Ordering
         */

        /*
         * Filtering
         * NOTE this does not match the built-in DataTables filtering which does it
         * word by word on any field. It's possible to do here, but concerned about efficiency
         * on very large tables, and MySQL's regex functionality is very limited
         */


        $sWhere = $where;
        if (isset($_GET['sSearch']) && $_GET['sSearch'] != "") {
            $where = $where . " and (";
            $sWhere = " (" . $where;
            $sWhere .= " cPropertyName LIKE '%" . $this->db->escape_like_str($sSearch) . "%' ";
//            for ( $i=0 ; $i<count($aColumns) ; $i++ )
//            {
//
//                if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $i!=0 && $i!=1)
//                {
//                    
//                    //$this->db->or_like($aColumns[$i], $this->db->escape_like_str($sSearch));
//                    $sWhere .= ' '.$aColumns[$i]." LIKE '%".$this->db->escape_like_str($sSearch)."%' OR ";
//                }
//            }
//            $sWhere = substr_replace( $sWhere, "", -3 );
            $sWhere .= '))';
        }
        /* Individual column filtering */
        for ($i = 0; $i < count($aColumns); $i++) {

            if (isset($_GET['bSearchable_' . $i]) && $_GET['bSearchable_' . $i] == "true" && $_GET['sSearch_' . $i] != '' && $i != 0 && $i != 1) {
                if ($sWhere == "") {
                    $sWhere = $where;
                } else {
                    $sWhere .= " AND ";
                }


                $sWhere .= $aColumns[$i] . " LIKE '%" . mysql_real_escape_string($_GET['sSearch_' . $i]) . "%' ";
            }
        }

        $this->db->select('SQL_CALC_FOUND_ROWS ' . str_replace(' , ', ' ', implode(', ', $aColumns)), false);
        $this->db->from($sTable);
        $this->db->join("current_status_master", "property_master.iCurrentStatusId=current_status_master.iCurrentStatusId", "LEFT");
        $this->db->where($sWhere, null, false);
        $rResult = $this->db->get();




//echo $this->db->last_query();die;






        $this->db->select('FOUND_ROWS() AS found_rows');
        $iFilteredTotal = $this->db->get()->row()->found_rows;

        // Total data set length

        $iTotal = $iFilteredTotal;
// echo '<pre>';
//        print_r($rResult->result_array());
//        echo '</pre>';die;

        /*
         * Output
         */


        // Output
        $output = array(
            'sEcho' => intval($sEcho),
            'iTotalRecords' => $iTotal,
            'iTotalDisplayRecords' => $iFilteredTotal,
            'aaData' => array()
        );





        $sno = 1;
        foreach ($rResult->result_array() as $aRow) {
            $row = array();
            foreach ($aRow as $col) {
                $row[] = $col;
            }


            $PropertyId = trim($aRow['iPropertyId']);

            $PropertyName = trim($aRow['cPropertyName']);

            if (!empty($aRow['cCurrentStatusName'])) {
                $CurrentStatusName = trim($aRow['cCurrentStatusName']);
            } else {
                $CurrentStatusName = "NA";
            }

            $insp = $aRow['inspection'];
            $delv = $aRow['delivery'];

            $AcceptTermsAndConditions = trim($aRow['bAcceptTermsAndConditions']);

            $Active = trim($aRow['bActive']);

            $inspectionurl = base_url() . 'index.php/dashboard/popup_for_inspection_delivery/' . $PropertyId . '/popup/3';

            $inspections = '<a  class="iframesss" href="' . $inspectionurl . '"  >' . $insp . '</a>';


            $deliverys = base_url() . 'index.php/dashboard/popup_for_inspection_delivery/' . $PropertyId . '/popup/5';

            $deliveryurl = '<a  class="iframesss" href="' . $deliverys . '"  >' . $delv . '</a>';

            //$viewporturl = base_url().'"index.php/dashboard/viewproperty/'.$PropertyId;
            //$viewporturls = '<a class="various" data-fancybox-type="iframe" href="'.$viewporturl.'"><span class="ui-icon ui-icon-search"></span></a>';



            $viewporturlhtml = base_url() . 'index.php/dashboard/viewproperty/' . $PropertyId;

            $viewporturlsht = '<a class="various" data-fancybox-type="iframe" href="' . $viewporturlhtml . '"><span class="ui-icon ui-icon-search"></span></a>';


            $editurl = base_url() . 'index.php/dashboard/edit_form_property_master/' . $PropertyId;

            $editurls = '<a class="various" data-fancybox-type="iframe" href="' . $editurl . '"><span class="ui-icon ui-icon-pencil"></span></a>';


            $propertydel = base_url() . 'index.php/dashboard/propertydelivery/' . $PropertyId;

            $propertydels = '<a class="various" data-fancybox-type="iframe" href="' . $propertydel . '" title="Print Delivery" target="_blank"><span class="ui-icon ui-icon-print"></span></a>';


            $propertyhistory = base_url() . 'index.php/dashboard/propertyhistory/' . $PropertyId;

            $propertyhistorys = '<a class="various" data-fancybox-type="iframe" href="' . $propertyhistory . '" title="Print History" target="_blank"><span class="ui-icon ui-icon-print"></span></a>';







            $row[0] = $sno;
            $row[1] = $aRow['cPropertyName'];
            $row[2] = $CurrentStatusName;
            $row[3] = $AcceptTermsAndConditions;
            $row[4] = $inspections;
            $row[5] = $deliveryurl;
            $row[6] = $Active;
            $row[7] = $viewporturlsht;
            $row[8] = $editurls;
            $row[9] = $propertydels;
            $row[10] = $propertyhistorys;




            $sno++;
            $output['aaData'][] = $row;
        }



        echo json_encode($output);
    }

    function property_master_get_by_id($id) {
        $sql = "SELECT * FROM property_master WHERE iPropertyId='" . $id . "'";

        $query = $this->db->query($sql);

        if ($query) {
            $result = $query->row_array();

            return $result;
        }
    }

    function get_property_attachments_by_id($id) {
        $this->db->where('iPropertyId', $id);
        $this->db->where('bDelete', '0');
        $query = $this->db->get('property_attachments');

        if ($query) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    function add_property_master($data) {
        if (!empty($data['txtDate'])) {
            $Dt = trim($data['txtDate']);
            $splitdt = explode('/', $Dt);
            $Date = $splitdt[2] . "-" . $splitdt[1] . "-" . $splitdt[0];
        } else {
            $Date = "0000-00-00";
        }

        $AddedByUserId = trim($this->session->userdata('UserId'));

        $PropertyName = trim($data['txtPropertyName']);

        if (!empty($data['cmbClient'])) {
            $ClientId = trim($data['cmbClient']);
        } else {
            $ClientId = "";
        }

        if (!empty($data['cmbClient'])) {
            $ContactId = trim($data['cmbContactPerson']);
        } else {
            $ContactId = "";
        }

        if (!empty($ClientId)) {
            $query1 = $this->db->query("SELECT cClientName,cContactPerson1Email,cContactPerson1PhoneNo1 FROM client_master WHERE client_master.iClientId='" . $ClientId . "'");
            $row1 = $query1->row_array();
            $ClientName = trim($row1['cClientName']);
            $cContactPerson1Email = trim($row1['cContactPerson1Email']);
            $cContactPerson1PhoneNo1 = trim($row1['cContactPerson1PhoneNo1']);
        } else {
            $ClientName = "";
        }

        if (!empty($data['cmbBranch'])) {
            $BranchId = trim($data['cmbBranch']);
        } else {
            $BranchId = "";
        }

        if (!empty($BranchId)) {
            $query2 = $this->db->query("SELECT cBranchName FROM branch_master WHERE branch_master.iBranchId='" . $BranchId . "'");
            $row2 = $query2->row_array();
            $BranchName = trim($row2['cBranchName']);
        } else {
            $BranchName = "";
        }

        if (!empty($data['cmbState'])) {
            $StateId = trim($data['cmbState']);
        } else {
            $StateId = "";
        }

        if (!empty($StateId)) {
            $query3 = $this->db->query("SELECT cStateName FROM state_master WHERE state_master.iStateId='" . $StateId . "'");
            $row3 = $query3->row_array();
            $StateName = trim($row3['cStateName']);
        } else {
            $StateName = "";
        }

        if (!empty($data['cmbDistrict'])) {
            $DistrictId = trim($data['cmbDistrict']);
        } else {
            $DistrictId = "";
        }

        if (!empty($DistrictId)) {
            $query4 = $this->db->query("SELECT cDistrictName FROM district_master WHERE district_master.iDistrictId='" . $DistrictId . "'");
            $row4 = $query4->row_array();
            $DistrictName = trim($row4['cDistrictName']);
        } else {
            $DistrictName = "";
        }

        if (!empty($data['cmbCity'])) {
            $CityId = trim($data['cmbCity']);
        } else {
            $CityId = "";
        }

        if (!empty($CityId)) {
            $query5 = $this->db->query("SELECT cCityName FROM city_master WHERE city_master.iCityId='" . $CityId . "'");
            $row5 = $query5->row_array();
            $CityName = trim($row5['cCityName']);
        } else {
            $CityName = "";
        }

        if (!empty($data['cmbLocation'])) {
            $LocationId = trim($data['cmbLocation']);
        } else {
            $LocationId = "";
        }

        if (!empty($LocationId)) {
            $query6 = $this->db->query("SELECT cLocationName FROM location_master WHERE location_master.iLocationId='" . $LocationId . "'");
            $row6 = $query6->row_array();
            $LocationName = trim($row6['cLocationName']);
        } else {
            $LocationName = "";
        }

        $PropertyAddress = trim($data['txtPropertyAddress']);

        if (!empty($data['cmbSource'])) {
            $SourceId = trim($data['cmbSource']);
        } else {
            $SourceId = "";
        }

        if (!empty($SourceId)) {
            $query7 = $this->db->query("SELECT cSourceName FROM source_master WHERE source_master.iSourceId='" . $SourceId . "'");
            $row7 = $query7->row_array();
            $SourceName = trim($row7['cSourceName']);
        } else {
            $SourceName = "";
        }

        if (!empty($data['cmbPropertyCategory'])) {
            $PropertyCategoryId = trim($data['cmbPropertyCategory']);
        } else {
            $PropertyCategoryId = "";
        }

        if (!empty($PropertyCategoryId)) {
            $query8 = $this->db->query("SELECT cPropertyCategoryName FROM property_category_master WHERE property_category_master.iPropertyCategoryId='" . $PropertyCategoryId . "'");
            $row8 = $query8->row_array();
            $PropertyCategoryName = trim($row8['cPropertyCategoryName']);
        } else {
            $PropertyCategoryName = "";
        }

        if (!empty($data['cmbPropertyType'])) {
            $PropertyTypeId = trim($data['cmbPropertyType']);
        } else {
            $PropertyTypeId = "";
        }

        if (!empty($PropertyTypeId)) {
            $query9 = $this->db->query("SELECT cPropertyTypeName FROM property_type_master WHERE property_type_master.iPropertyTypeId='" . $PropertyTypeId . "'");
            $row9 = $query9->row_array();
            $PropertyTypeName = trim($row9['cPropertyTypeName']);
        } else {
            $PropertyTypeName = "";
        }

        if (!empty($data['cmbPropertyStatus'])) {
            $PropertyStatusId = trim($data['cmbPropertyStatus']);
        } else {
            $PropertyStatusId = "";
        }

        if (!empty($PropertyStatusId)) {
            $query10 = $this->db->query("SELECT cPropertyStatusName FROM property_status_master WHERE property_status_master.iPropertyStatusId='" . $PropertyStatusId . "'");
            $row10 = $query10->row_array();
            $PropertyStatusName = trim($row10['cPropertyStatusName']);
        } else {
            $PropertyStatusName = "";
        }


        $PropertyPurpose = trim($data['cmbPropertyPurpose']);
        $PropertyLegalStatus = trim($data['cmbPropertyLegalStatus']);
        $SurroundingBrands = trim($data['txtSurroundingBrands']);
        $PropertyTaglineForWebsite = trim($data['txtPropertyTaglineForWebsite']);

        $PropertyRemarks = trim($data['txtPropertyRemarks']);
        $TotalPlotArea = trim($data['txtTotalPlotArea']);
        $BuildingArea = trim($data['txtBuildingArea']);
        $NoOfFloorsInBuilding = trim($data['txtNoOfFloorsInBuilding']);
        $GroundCoverage = trim($data['txtGroundCoverage']);
        $FloorOffered = trim($data['txtFloorOffered']);
        $PlateAreaOfFloorOffered = trim($data['txtPlateAreaOfFloorOffered']);
        $Toilet = trim($data['cmbToilet']);
        $Parking = trim($data['cmbParking']);
        $CarpetArea = trim($data['txtCarpetArea']);
        $BuiltUpArea = trim($data['txtBuiltUpArea']);
        $SuperBuiltUpArea = trim($data['txtSuperBuiltUpArea']);
        $Frontage = trim($data['txtFrontage']);
        $Depth = trim($data['txtDepth']);
        $Height = trim($data['txtHeight']);
        $PropertyFurnishedStatus = trim($data['cmbPropertyFurnishedStatus']);
        $AgreementTypeId = trim($data['cmbAgreementType']);
        $DemandPerSqFeet = trim($data['txtDemandPerSqFeet']);
        $DemandGross = trim($data['txtDemandGross']);
        $SecurityDeposit = trim($data['txtSecurityDeposit']);
        $EscalationId = (int) trim($data['cmbEscalation']);
        $CAM = trim($data['txtCAM']);
        $ServiceTaxOnLessor = trim($data['txtServiceTaxOnLessor']);
        $ServiceTaxOnLessee = trim($data['txtServiceTaxOnLessee']);
        $PropertyTaxOnLessor = trim($data['txtPropertyTaxOnLessor']);
        $PropertyTaxOnLessee = trim($data['txtPropertyTaxOnLessee']);
        $StampDutyAndRegistration = trim($data['cmbStampDutyAndRegistration']);
        $LockIn = trim($data['cmbLockIn']);
        $LockInDuration = trim($data['txtLockInDuration']);
        $RentFreePeriod = trim($data['cmbRentFreePeriod']);
        $NoticePeriod = trim($data['txtNoticePeriod']);
        $PossessionStatus = trim($data['txtPossessionStatus']);
        $PowerLoad = trim($data['txtPowerLoad']);
        $PowerBackup = trim($data['txtPowerBackup']);
        $CurrentTenant = trim($data['txtCurrentTenant']);
        $LeaseUpToDate = trim($data['txtLeaseUpToDate']);
        $PreviousTenant = trim($data['txtPreviousTenant']);
        $AgreementDate = trim($data['txtAgreementDate']);
        $AgreementPlace = trim($data['txtAgreementPlace']);
        $Person1DuringAgreement = trim($data['txtPerson1DuringAgreement']);
        $Person2DuringAgreement = trim($data['txtPerson2DuringAgreement']);
        $AgreementFilePath = trim($data['hfAgreementFilePath']);
        $AgreementFileName = trim($data['hfAgreementFileName']);
        $TermsAndConditions = trim($data['txtTermsAndConditions']);
        $AcceptTermsAndConditions = isset($data['chkAcceptTermsAndConditions']) ? trim($data['chkAcceptTermsAndConditions']) : 0;
        $Active = (int) trim($data['chkActive']);

        //$AttachmentFilePath = trim($data['hfAttachmentFilePath']);
        //$AttachmentFileName = trim($data['hfAttachmentFileName']);
        //$AttachmentLength = count($AttachmentFileName);

        $saveflag = false;

        $sql = "SELECT * FROM property_master WHERE property_master.cPropertyName='" . $PropertyName . "' AND property_master.bDelete=0";

        $query = $this->db->query($sql);

        if ($query) {
            if ($query->num_rows > 0) {
                return json_encode(Array("status" => "0", "msg" => EXIST_MSG));
            } else {
                $addData = array(
                    'dDate' => $Date,
                    'iAddedByUserId' => $AddedByUserId,
                    'cPropertyName' => htmlentities($PropertyName, ENT_QUOTES),
                    'iClientId' => $ClientId,
                    'iContactId' => $ContactId,
                    'iBranchId' => $BranchId,
                    'iStateId' => $StateId,
                    'iDistrictId' => $DistrictId,
                    'iCityId' => $CityId,
                    'iLocationId' => $LocationId,
                    'cPropertyAddress' => htmlentities($PropertyAddress, ENT_QUOTES),
                    'iSourceId' => $SourceId,
                    'iPropertyCategoryId' => $PropertyCategoryId,
                    'iPropertyTypeId' => $PropertyTypeId,
                    'iPropertyStatusId' => $PropertyStatusId,
                    'cPropertyPurpose' => $PropertyPurpose,
                    'cPropertyLegalStatus' => $PropertyLegalStatus,
                    'cSurroundingBrands' => htmlentities($SurroundingBrands, ENT_QUOTES),
                    'cPropertyTaglineForWebsite' => htmlentities($PropertyTaglineForWebsite, ENT_QUOTES),
                    'cPropertyRemarks' => htmlentities($PropertyRemarks, ENT_QUOTES),
                    'cTotalPlotArea' => htmlentities($TotalPlotArea, ENT_QUOTES),
                    'cBuildingArea' => htmlentities($BuildingArea, ENT_QUOTES),
                    'iNoOfFloorsInBuilding' => $NoOfFloorsInBuilding,
                    'cGroundCoverage' => htmlentities($GroundCoverage, ENT_QUOTES),
                    'cFloorOffered' => $FloorOffered,
                    'cPlateAreaOfFloorOffered' => htmlentities($PlateAreaOfFloorOffered, ENT_QUOTES),
                    'cToilet' => $Toilet,
                    'cParking' => $Parking,
                    'cCarpetArea' => htmlentities($CarpetArea, ENT_QUOTES),
                    'cBuiltUpArea' => htmlentities($BuiltUpArea, ENT_QUOTES),
                    'cSuperBuiltUpArea' => htmlentities($SuperBuiltUpArea, ENT_QUOTES),
                    'cFrontage' => htmlentities($Frontage, ENT_QUOTES),
                    'cDepth' => htmlentities($Depth, ENT_QUOTES),
                    'cHeight' => htmlentities($Height, ENT_QUOTES),
                    'cPropertyFurnishedStatus' => $PropertyFurnishedStatus,
                    'iAgreementTypeId' => $AgreementTypeId,
                    'cDemandPerSqFeet' => htmlentities($DemandPerSqFeet, ENT_QUOTES),
                    'cDemandGross' => htmlentities($DemandGross, ENT_QUOTES),
                    'cSecurityDeposit' => htmlentities($SecurityDeposit, ENT_QUOTES),
                    'iEscalationId' => (int) $EscalationId,
                    'cCAM' => $CAM,
                    'cServiceTaxOnLessor' => $ServiceTaxOnLessor,
                    'cServiceTaxOnLessee' => $ServiceTaxOnLessee,
                    'cPropertyTaxOnLessor' => $PropertyTaxOnLessor,
                    'cPropertyTaxOnLessee' => $PropertyTaxOnLessee,
                    'cStampDutyAndRegistration' => $StampDutyAndRegistration,
                    'cLockIn' => $LockIn,
                    'cLockInDuration' => htmlentities($LockInDuration, ENT_QUOTES),
                    'cRentFreePeriod' => $RentFreePeriod,
                    'cNoticePeriod' => $NoticePeriod,
                    'cPossessionStatus' => $PossessionStatus,
                    'cPowerLoad' => $PowerLoad,
                    'cPowerBackup' => htmlentities($PowerBackup, ENT_QUOTES),
                    'cCurrentTenant' => htmlentities($CurrentTenant, ENT_QUOTES),
                    'dLeaseUpToDate' => $LeaseUpToDate,
                    'cPreviousTenant' => htmlentities($PreviousTenant, ENT_QUOTES),
                    'dAgreementDate' => $AgreementDate,
                    'cAgreementPlace' => $AgreementPlace,
                    'cPerson1DuringAgreement' => $Person1DuringAgreement,
                    'cPerson2DuringAgreement' => $Person2DuringAgreement,
                    'cAgreementFilePath' => $AgreementFilePath,
                    'cAgreementFileName' => $AgreementFileName,
                    'cTermsAndConditions' => htmlentities($TermsAndConditions, ENT_QUOTES),
                    'bAcceptTermsAndConditions' => $AcceptTermsAndConditions,
                    'bActive' => $Active,
                );

                //return print_r(count($data['hfAttachmentFileName']));
                //exit;

                $insert = $this->db->insert('property_master', $addData);

                $propertys_insert_id = $this->db->insert_id();

                /* Email to client after add PSR */

                $psradded = "";
                $psradded .='<div>';
                $psradded .='<p>Dear ' . ucfirst($ClientName) . '</p>';
                $psradded .='<p>Greetings from Linkers India!</p>
                                <p>We are pleased to share that we have added your Property Specification in our CRM.<br>We strive to deliver quality Corporate Leasing Services and assure that we shall soon get back with suitable options.</p>
                                <p>Thanks!</p>
                                <p>Best Regards,<br>Team Linkers India<br>Bakhatgarh Towers, 34/2, Race Course Rd, New Palasia, Old Palasia, Indore, Madhya Pradesh, 452001.<br>+91 731 4044406, +91 9993999996<br><a href="mailto:support@linkersindia.com" target="_blank">support@linkersindia.com</a></p>
                                </div>';

                $this->sendEmail($cContactPerson1Email, 'PSR is added', $psradded);


                /* Email send to internal staff after add PSR */

                $psraddInternalStaff = "";
                $psraddInternalStaff .= '<div><p>Hello,</p>';
                $psraddInternalStaff .= '<p>A new PSR ' . $PropertyName . ' is added by ' . $this->session->userdata('UserName') . ' on ' . date('d-m-Y H:i:s');
                $psraddInternalStaff .='<br>Please find following details:<br>' . $ClientName . '<br>' . $PropertyName . '<br>' . $LocationName . ' ' . $CityName . ' ' . $DistrictName . ' ' . $StateName;
                $psraddInternalStaff .='<br>' . $PropertyTypeName . '<br>' . $PropertyCategoryName . '<br>' . $PropertyStatusName . '<br>' . $cContactPerson1Email . '<br>' . $cContactPerson1PhoneNo1 . '</p>';
                $psraddInternalStaff .='<p>Best Regards,<br>Team Linkers India<br>Bakhatgarh Towers, 34/2, Race Course Rd, New Palasia, Old Palasia, Indore, Madhya Pradesh, 452001.<br>+91 731 4044406, +91 9993999996<br><a href="mailto:support@linkersindia.com" target="_blank">support@linkersindia.com</a></p>
                                <p>&nbsp;</p><div>&nbsp;</div></div>';

                $this->db->where('bActive', 1);
                $this->db->where('bDelete', 0);
                $query = $this->db->get('user_master');

                if ($query->result()) {
                    foreach ($query->result() as $req) {
                        $this->sendEmail($req->cEmailAddress, 'New PSR Added', $psraddInternalStaff);
                    }
                }

                /* Data insert in task tables */

                $UserId = trim($this->session->userdata('UserId'));

                $DCRDate = date('Y-m-d H:i:s');

                $DCRRemarks = "";

                $new_activity_data = array(
                    'dActivityDateTime' => date('Y-m-d H:i:s'),
                    'cUserName' => trim($this->session->userdata('UserName')),
                    'cIPAddress' => $this->get_client_ip(),
                    'cActivityDesc' => 'Add New Task'
                );

                $newactivitylogid = $this->save_activity_details($new_activity_data);

                $addData = array(
                    'dDCRDate' => $DCRDate,
                    'iUserId' => $UserId,
                    'cDCRRemarks' => $DCRRemarks,
                    'iActivityLogId' => trim($newactivitylogid),
                );

                $SaveData = $this->db->insert('dcr_summary', $addData);
                $DCRId = $this->db->insert_id();

                $addDCRDetail = array(
                    'iDCRId' => $DCRId,
                    'iClientReqId' => $ClientId,
                    'iPropertyId' => $propertys_insert_id,
                    'iTaskId'=>'9',
                    'cDCRSummary'=>'New PSR Added'
                );

                $insertDCRDetail = $this->db->insert('dcr_detail', $addDCRDetail);


                if ($insert) {
                    $property_insert_id = $this->db->insert_id();

                    //print_r($data['hfAttachmentFileName']);
                    //exit;	
                    $AttatchData = Array();
                    foreach ($data['hfAttachmentFileName'] as $key => $item) {
                        if (isset($data['hfAttachmentFileName'][$key]) && (!empty($data['txtAttachmentTitle'][$key]))) {
                            $AttatchData['iPropertyId'] = $property_insert_id;

                            $AttatchData['cAttachmentTitle'] = $data['txtAttachmentTitle'][$key];

                            $AttatchData['cAttachmentFilePath'] = $data['hfAttachmentFilePath'][$key];

                            $AttatchData['cAttachmentFileName'] = $data['hfAttachmentFileName'][$key];

                            $insertAttatchData = $this->db->insert('property_attachments', $AttatchData);

                            if ($insertAttatchData) {
                                $saveflag = true;
                            }
                        } else {
                            $saveflag = true;

                            //$UserEmailMessage = $PropertyName."=>".$ClientName;
                        }
                    }
                }

                if ($saveflag == true) {
                    /*
                      //-----------------Email to Staff-----------------------------------

                      $UserEmailSubject = "A New PSR added";

                      //$UserEmailMessage = $Dt."=>".$PropertyName."=>".$ClientName."=>".$BranchName."=>".$StateName."=>".$DistrictName."=>".$CityName."=>".$LocationName."=>".$PropertyAddress."=>".$SourceName."=>".$PropertyCategoryName."=>".$PropertyTypeName."=>".$PropertyStatusName."=>".$PropertyPurpose."=>".$PropertyLegalStatus."=>".$SurroundingBrands."=>".$PropertyRemarks;

                      $UserEmailMessage="Date : $Dt"."\n\n";
                      $UserEmailMessage.="Property Name : $PropertyName"."\n\n";
                      $UserEmailMessage.="Client : $ClientName"."\n\n";
                      $UserEmailMessage.="Branch : $BranchName"."\n\n";
                      $UserEmailMessage.="State : $StateName"."\n\n";
                      $UserEmailMessage.="District : $DistrictName"."\n\n";
                      $UserEmailMessage.="City : $CityName"."\n\n";
                      $UserEmailMessage.="Location : $LocationName"."\n\n";
                      $UserEmailMessage.="Property Address : $PropertyAddress"."\n\n";
                      $UserEmailMessage.="Source : $SourceName"."\n\n";
                      $UserEmailMessage.="Property Category : $PropertyCategoryName"."\n\n";
                      $UserEmailMessage.="Property Type : $PropertyTypeName"."\n\n";
                      $UserEmailMessage.="Property Status : $PropertyStatusName"."\n\n";
                      $UserEmailMessage.="Property Purpose : $PropertyPurpose"."\n\n";
                      $UserEmailMessage.="Property Legal Status : $PropertyLegalStatus"."\n\n";
                      $UserEmailMessage.="Surrounding Brands : $SurroundingBrands"."\n\n";
                      $UserEmailMessage.="Property Remarks : $PropertyRemarks"."\n\n";



                      $mail = new PHPMailer();
                      $mail->IsSMTP(); 		                                  // We are going to use SMTP
                      $mail->SMTPAuth   = true;                                 // Enabled SMTP authentication
                      $mail->SMTPSecure = "ssl";                                // Prefix for secure protocol to connect to the server
                      $mail->Host       = "smtp.gmail.com";     		          // Setting GMail as our SMTP server
                      $mail->Port       =  465;                                 // SMTP port to connect to GMail
                      $mail->Username   = "support@linkersindia.com";           // User email address
                      $mail->Password   = "manashids";                          // Password in GMail

                      $mail->SetFrom('support@linkersindia.com', 'Linkers');     //Who is sending the email
                      $mail->AddReplyTo("support@linkersindia.com', 'Linkers");  //Email address that receives the response
                      $mail->Subject   = "$UserEmailSubject";
                      $mail->Body  	 = "$UserEmailMessage";

                      $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!";



                      $sql = "SELECT user_master.cEmailAddress FROM user_master WHERE user_master.cEmailAddress<>'' AND user_master.bActive=1";

                      $query = $this->db->query($sql);

                      if($query)
                      {
                      if($query->num_rows > 0)
                      {
                      $rows = $query->result_array();

                      foreach($rows as $row)
                      {
                      $UserRecipientEmailAddress = trim($row['cEmailAddress']);

                      if((!empty($UserRecipientEmailAddress)) && (filter_var($UserRecipientEmailAddress, FILTER_VALIDATE_EMAIL) !== false))
                      {
                      $mail->AddAddress("$UserRecipientEmailAddress");
                      }
                      }
                      }
                      }

                      if(!$mail->Send())
                      {
                      echo "PSR User Email Error: " . $mail->ErrorInfo;
                      //return false;
                      }
                      else
                      {
                      echo "PSR User Email Sent Successfully...!";
                      //return true;
                      }

                      //------------------------------------------------------------------------


                      //---------------- Send Email to Client-----------------------------------

                      $sql = "SELECT cClientName,cContactPerson1Name,cContactPerson1Email FROM client_master WHERE client_master.iClientId='".$ClientId."'";

                      $query = $this->db->query($sql);

                      if($query)
                      {
                      if($query->num_rows > 0)
                      {
                      $row = $query->row_array();

                      $ClientName = trim($row['cClientName']);

                      $ContactPerson1Name = trim($row['cContactPerson1Name']);

                      $ContactPerson1Email = trim($row['cContactPerson1Email']);

                      $ClientRecipientEmailAddress = trim($row['cContactPerson1Email']);



                      $ClientEmailSubject = "Welcome to Linkers!";

                      $ClientEmailMessage="Dear $ClientName,"."\n\n";
                      $ClientEmailMessage.="We thank you for your confidence on Linkers India for your real estate solutions & wish to prove our mettle by giving you most suitable & amicable options. It’s always our endeavour to provide timely, reliable & ethical services to our valued clients."."\n\n";
                      $ClientEmailMessage.="Our team has entered your data into our CRM Application& shall start providing you suitable options as per your needs. Please feel free to get in touch with our Customer Support Officer at below mentioned numbers."."\n\n\n";
                      $ClientEmailMessage.="Thanks!!!."."\n\n\n";

                      $ClientEmailMessage.="Team Linkers India."."\n";
                      $ClientEmailMessage.="204, Silver Arch Plaza, New Palasia,Near Curewell Hospital, Zanjeerwala Square, Indore – 452001."."\n";
                      $ClientEmailMessage.="Email: support@linkersindia.com."."\n";
                      $ClientEmailMessage.="Phone: +91-731-4044406, +(91)-8349998452."."\n";



                      $mail = new PHPMailer();
                      $mail->IsSMTP(); 		                                  // We are going to use SMTP
                      $mail->SMTPAuth   = true;                                 // Enabled SMTP authentication
                      $mail->SMTPSecure = "ssl";                                // Prefix for secure protocol to connect to the server
                      $mail->Host       = "smtp.gmail.com";     		          // Setting GMail as our SMTP server
                      $mail->Port       =  465;                                 // SMTP port to connect to GMail
                      $mail->Username   = "support@linkersindia.com";           // User email address
                      $mail->Password   = "manashids";                          // Password in GMail

                      $mail->SetFrom('support@linkersindia.com', 'Linkers');     //Who is sending the email
                      $mail->AddReplyTo("support@linkersindia.com', 'Linkers");  //Email address that receives the response
                      $mail->Subject   = "$ClientEmailSubject";
                      $mail->Body  	 = "$ClientEmailMessage";

                      if((!empty($ClientRecipientMailAddress)) && (filter_var($ClientRecipientMailAddress, FILTER_VALIDATE_EMAIL) !== false))
                      {
                      $mail->AddAddress("$ClientRecipientMailAddress");

                      if(!$mail->Send())
                      {
                      echo "PSR Client Email Error: " . $mail->ErrorInfo;
                      //return false;
                      }
                      else
                      {
                      echo "PSR Client Email Sent Successfully...!";
                      //return true;
                      }
                      }
                      }
                      }

                      //--------------------------------------------------------------------------------------------------------
                     */
                    return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG)); //SUCCESS_INSERT_MSG $UserEmailMessage
                } else {
                    return json_encode(Array("status" => "0", "msg" => ERROR_INSERT_MSG));
                }
            }
        }
    }

    function edit_property_master($data) {
        $hfPropertyId = trim($data['hfPropertyId']);

        if (!empty($data['txtDate'])) {
            $Dt = trim($data['txtDate']);
            $splitdt = explode('/', $Dt);
            $Date = $splitdt[2] . "-" . $splitdt[1] . "-" . $splitdt[0];
        } else {
            $Date = "0000-00-00";
        }

        $PropertyName = trim($data['txtPropertyName']);
        $ClientId = trim($data['cmbClient']);
        $ContactId = trim($data['cmbContactPerson']);
        $BranchId = trim($data['cmbBranch']);
        $StateId = trim($data['cmbState']);
        $DistrictId = trim($data['cmbDistrict']);
        $CityId = trim($data['cmbCity']);
        $LocationId = trim($data['cmbLocation']);
        $PropertyAddress = trim($data['txtPropertyAddress']);
        $SourceId = trim($data['cmbSource']);
        $PropertyCategoryId = trim($data['cmbPropertyCategory']);
        $PropertyTypeId = trim($data['cmbPropertyType']);
        $PropertyStatusId = trim($data['cmbPropertyStatus']);
        $PropertyPurpose = trim($data['cmbPropertyPurpose']);
        $PropertyLegalStatus = trim($data['cmbPropertyLegalStatus']);
        $SurroundingBrands = trim($data['txtSurroundingBrands']);
        $PropertyTaglineForWebsite = trim($data['txtPropertyTaglineForWebsite']);
        $PropertyRemarks = trim($data['txtPropertyRemarks']);
        $TotalPlotArea = trim($data['txtTotalPlotArea']);
        $BuildingArea = trim($data['txtBuildingArea']);
        $NoOfFloorsInBuilding = trim($data['txtNoOfFloorsInBuilding']);
        $GroundCoverage = trim($data['txtGroundCoverage']);
        $FloorOffered = trim($data['txtFloorOffered']);
        $PlateAreaOfFloorOffered = trim($data['txtPlateAreaOfFloorOffered']);
        $Toilet = trim($data['cmbToilet']);
        $Parking = trim($data['cmbParking']);
        $CarpetArea = trim($data['txtCarpetArea']);
        $BuiltUpArea = trim($data['txtBuiltUpArea']);
        $SuperBuiltUpArea = trim($data['txtSuperBuiltUpArea']);
        $Frontage = trim($data['txtFrontage']);
        $Depth = trim($data['txtDepth']);
        $Height = trim($data['txtHeight']);
        $PropertyFurnishedStatus = trim($data['cmbPropertyFurnishedStatus']);
        $AgreementTypeId = trim($data['cmbAgreementType']);
        $DemandPerSqFeet = trim($data['txtDemandPerSqFeet']);
        $DemandGross = trim($data['txtDemandGross']);
        $SecurityDeposit = trim($data['txtSecurityDeposit']);
        $EscalationId = (int) trim($data['cmbEscalation']);
        $CAM = trim($data['txtCAM']);
        $ServiceTaxOnLessor = trim($data['txtServiceTaxOnLessor']);
        $ServiceTaxOnLessee = trim($data['txtServiceTaxOnLessee']);
        $PropertyTaxOnLessor = trim($data['txtPropertyTaxOnLessor']);
        $PropertyTaxOnLessee = trim($data['txtPropertyTaxOnLessee']);
        $StampDutyAndRegistration = trim($data['cmbStampDutyAndRegistration']);
        $LockIn = trim($data['cmbLockIn']);
        $LockInDuration = trim($data['txtLockInDuration']);
        $RentFreePeriod = trim($data['cmbRentFreePeriod']);
        $NoticePeriod = trim($data['txtNoticePeriod']);
        $PossessionStatus = trim($data['txtPossessionStatus']);
        $PowerLoad = trim($data['txtPowerLoad']);
        $PowerBackup = trim($data['txtPowerBackup']);
        $CurrentTenant = trim($data['txtCurrentTenant']);
        $LeaseUpToDate = trim($data['txtLeaseUpToDate']);
        $PreviousTenant = trim($data['txtPreviousTenant']);
        $AgreementDate = trim($data['txtAgreementDate']);
        $AgreementPlace = trim($data['txtAgreementPlace']);
        $Person1DuringAgreement = trim($data['txtPerson1DuringAgreement']);
        $Person2DuringAgreement = trim($data['txtPerson2DuringAgreement']);
        $TermsAndConditions = trim($data['txtTermsAndConditions']);
        $AgreementFilePath = trim($data['hfAgreementFilePath']);
        $AgreementFileName = trim($data['hfAgreementFileName']);
        $AcceptTermsAndConditions = trim($data['hfAcceptTermsAndConditions']);
        $Active = trim($data['hfActive']);


        $updateflag = false;

        $sql = "SELECT * FROM property_master WHERE property_master.cPropertyName='" . $PropertyName . "' AND property_master.bDelete=0 AND iPropertyId!='" . $hfPropertyId . "'";

        $query = $this->db->query($sql);

        if ($query) {
            if ($query->num_rows > 0) {
                return json_encode(Array("status" => "0", "msg" => EXIST_MSG));
            } else {
                $editData = array(
                    'dDate' => $Date,
                    'cPropertyName' => htmlentities($PropertyName, ENT_QUOTES),
                    'iClientId' => $ClientId,
                    'iContactId' => $ContactId,
                    'iBranchId' => $BranchId,
                    'iStateId' => $StateId,
                    'iDistrictId' => $DistrictId,
                    'iCityId' => $CityId,
                    'iLocationId' => $LocationId,
                    'cPropertyAddress' => htmlentities($PropertyAddress, ENT_QUOTES),
                    'iSourceId' => $SourceId,
                    'iPropertyCategoryId' => $PropertyCategoryId,
                    'iPropertyTypeId' => $PropertyTypeId,
                    'iPropertyStatusId' => $PropertyStatusId,
                    'cPropertyPurpose' => $PropertyPurpose,
                    'cSurroundingBrands' => htmlentities($SurroundingBrands, ENT_QUOTES),
                    'cPropertyLegalStatus' => $PropertyLegalStatus,
                    'cPropertyTaglineForWebsite' => htmlentities($PropertyTaglineForWebsite, ENT_QUOTES),
                    'cPropertyTaglineForWebsite' => $PropertyTaglineForWebsite,
                    'cPropertyRemarks' => htmlentities($PropertyRemarks, ENT_QUOTES),
                    'cTotalPlotArea' => htmlentities($TotalPlotArea, ENT_QUOTES),
                    'cBuildingArea' => htmlentities($BuildingArea, ENT_QUOTES),
                    'iNoOfFloorsInBuilding' => $NoOfFloorsInBuilding,
                    'cGroundCoverage' => htmlentities($GroundCoverage, ENT_QUOTES),
                    'cFloorOffered' => $FloorOffered,
                    'cPlateAreaOfFloorOffered' => htmlentities($PlateAreaOfFloorOffered, ENT_QUOTES),
                    'cToilet' => $Toilet,
                    'cParking' => $Parking,
                    'cCarpetArea' => htmlentities($CarpetArea, ENT_QUOTES),
                    'cBuiltUpArea' => htmlentities($BuiltUpArea, ENT_QUOTES),
                    'cSuperBuiltUpArea' => htmlentities($SuperBuiltUpArea, ENT_QUOTES),
                    'cFrontage' => htmlentities($Frontage, ENT_QUOTES),
                    'cDepth' => htmlentities($Depth, ENT_QUOTES),
                    'cHeight' => htmlentities($Height, ENT_QUOTES),
                    'cPropertyFurnishedStatus' => $PropertyFurnishedStatus,
                    'iAgreementTypeId' => $AgreementTypeId,
                    'cDemandPerSqFeet' => htmlentities($DemandPerSqFeet, ENT_QUOTES),
                    'cDemandGross' => htmlentities($DemandGross, ENT_QUOTES),
                    'cSecurityDeposit' => htmlentities($SecurityDeposit, ENT_QUOTES),
                    'iEscalationId' => (int) $EscalationId,
                    'cCAM' => $CAM,
                    'cServiceTaxOnLessor' => $ServiceTaxOnLessor,
                    'cServiceTaxOnLessee' => $ServiceTaxOnLessee,
                    'cPropertyTaxOnLessor' => $PropertyTaxOnLessor,
                    'cPropertyTaxOnLessee' => $PropertyTaxOnLessee,
                    'cStampDutyAndRegistration' => $StampDutyAndRegistration,
                    'cLockIn' => $LockIn,
                    'cLockInDuration' => htmlentities($LockInDuration, ENT_QUOTES),
                    'cRentFreePeriod' => $RentFreePeriod,
                    'cNoticePeriod' => $NoticePeriod,
                    'cPossessionStatus' => $PossessionStatus,
                    'cPowerLoad' => $PowerLoad,
                    'cPowerBackup' => htmlentities($PowerBackup, ENT_QUOTES),
                    'cCurrentTenant' => htmlentities($CurrentTenant, ENT_QUOTES),
                    'dLeaseUpToDate' => $LeaseUpToDate,
                    'cPreviousTenant' => htmlentities($PreviousTenant, ENT_QUOTES),
                    'dAgreementDate' => $AgreementDate,
                    'cAgreementPlace' => $AgreementPlace,
                    'cPerson1DuringAgreement' => $Person1DuringAgreement,
                    'cPerson2DuringAgreement' => $Person2DuringAgreement,
                    'cAgreementFilePath' => $AgreementFilePath,
                    'cAgreementFileName' => $AgreementFileName,
                    'cTermsAndConditions' => htmlentities($TermsAndConditions, ENT_QUOTES),
                    'bAcceptTermsAndConditions' => $AcceptTermsAndConditions,
                    'bActive' => $Active,
                );

                $this->db->where('iPropertyId', $hfPropertyId);
                $update = $this->db->update('property_master', $editData);

                if ($update) {
                    $AttatchData = Array();
                    foreach ($data['hfAttachmentFileName'] as $key => $item) {
                        if (isset($data['hfAttachmentFileName'][$key]) && (!empty($data['txtAttachmentTitle'][$key]))) {
                            $AttatchData['iPropertyId'] = $hfPropertyId;

                            $AttatchData['cAttachmentTitle'] = $data['txtAttachmentTitle'][$key];

                            $AttatchData['cAttachmentFilePath'] = $data['hfAttachmentFilePath'][$key];

                            $AttatchData['cAttachmentFileName'] = $data['hfAttachmentFileName'][$key];

                            $insertAttatchData = $this->db->insert('property_attachments', $AttatchData);

                            if ($insertAttatchData) {
                                $updateflag = true;
                            }
                        } else {
                            $updateflag = true;
                        }
                    }
                }

                if ($updateflag == 'true') {
                    return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
                } else {
                    return json_encode(Array("status" => "0", "msg" => ERROR_UPDATE_MSG));
                }
            }
        }
    }

    function delete_property_master($id) {
        $Deleteflag = false;

        $sql = "SELECT * FROM property_master WHERE property_master.iPropertyId='" . $id . "'";

        $query = $this->db->query($sql);

        if ($query) {
            if ($query->num_rows > 0) {
                $sql1 = "SELECT * FROM property_attachments WHERE property_attachments.iPropertyId='" . $id . "'";

                $query1 = $this->db->query($sql1);

                if ($query1->num_rows > 0) {
                    $sql2 = "UPDATE property_attachments SET property_attachments.bDelete=1 WHERE property_attachments.iPropertyId='" . $id . "'";

                    $query2 = $this->db->query($sql2);
                }

                $sql2 = "UPDATE property_master SET property_master.bDelete=1 WHERE property_master.iPropertyId='" . $id . "'";

                $query3 = $this->db->query($sql3);

                if ($query3) {
                    $Deleteflag = true;
                }
            }
        }

        if ($Deleteflag == true) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function property_existing_attachment_delete($AttachmentId, $AttachmentPath) {   // file not remove from folder & db, just update its db status to be deleted.									
        $this->db->where('iPropertyAttachmentId', $AttachmentId);
        $query = $this->db->get('property_attachments');

        if ($query) {
            if ($query->num_rows() > 0) {
                $delarray = array('bDelete' => 1);

                $this->db->where('iPropertyAttachmentId', $AttachmentId);
                $delsql = $this->db->update('property_attachments', $delarray);

                if ($delsql) {
                    return TRUE;
                } else {
                    return FALSE;
                }
            }
        }
    }

    //-----------------------------------------------------Requirement----------------------------------------------------------------------------------------

    function get_all_requirement_master($client_id = 0, $task_id = 0) {
        $sql = "SELECT requirement_master.iRequirementId,requirement_master.dDate
		,requirement_master.cRequirementTitle,client_master.cClientName
		,current_status_master.cCurrentStatusName,CASE requirement_master.bAcceptTermsAndConditions WHEN 1 THEN 'Yes' ELSE 'No' END AS 'bAcceptTermsAndConditions'
		,CASE requirement_master.bActive WHEN 1 THEN 'Yes' ELSE 'No' END AS 'bActive' 
		FROM requirement_master 
		LEFT JOIN client_master ON requirement_master.iClientId=client_master.iClientId 
		LEFT JOIN current_status_master ON requirement_master.iCurrentStatusId=current_status_master.iCurrentStatusId 
		WHERE requirement_master.bDelete=0";

        if ($client_id != 0) {
            $sql = $sql . " and requirement_master.iClientId = " . $client_id;
        }


        $query = $this->db->query($sql);

        return $query;
    }

    function get_all_requirement_master_datatable($client_id = 0, $task_id = 0) {
        /* $sql = "SELECT requirement_master.iRequirementId,requirement_master.dDate
          ,requirement_master.cRequirementTitle,client_master.cClientName
          ,current_status_master.cCurrentStatusName,CASE requirement_master.bAcceptTermsAndConditions WHEN 1 THEN 'Yes' ELSE 'No' END AS 'bAcceptTermsAndConditions'
          ,CASE requirement_master.bActive WHEN 1 THEN 'Yes' ELSE 'No' END AS 'bActive'
          FROM requirement_master
          LEFT JOIN client_master ON requirement_master.iClientId=client_master.iClientId
          LEFT JOIN current_status_master ON requirement_master.iCurrentStatusId=current_status_master.iCurrentStatusId
          WHERE requirement_master.bDelete=0";

          if ($client_id != 0) {
          $sql = $sql . " and requirement_master.iClientId = " . $client_id;
          }


          $query = $this->db->query($sql);

          return $query; */



        $iDisplayStart = $this->input->get_post('iDisplayStart', true);
        $iDisplayLength = $this->input->get_post('iDisplayLength', true);
        $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
        $iSortingCols = $this->input->get_post('iSortingCols', true);
        $sSearch = $this->input->get_post('sSearch', true);
        $sEcho = $this->input->get_post('sEcho', true);


        if ($client_id != 0) {
            $sql = $sql . " and requirement_master.iClientId = " . $client_id;
        }


        $aColumns = array("requirement_master.iRequirementId,requirement_master.dDate
		,requirement_master.cRequirementTitle,client_master.cClientName
		,current_status_master.cCurrentStatusName,CASE requirement_master.bAcceptTermsAndConditions WHEN 1 THEN 'Yes' ELSE 'No' END AS 'bAcceptTermsAndConditions'
		,CASE requirement_master.bActive WHEN 1 THEN 'Yes' ELSE 'No' END AS 'bActive'");




        // DB table to use
        $sIndexColumn = 'requirement_master.iRequirementId';
        $sTable = 'requirement_master';
        $where = "  requirement_master.bDelete=0 " . $sql;





        // Paging
        if (isset($iDisplayStart) && $iDisplayLength != '-1') {
            $this->db->limit($this->db->escape_str($iDisplayLength), $this->db->escape_str($iDisplayStart));
        }

        if (isset($iSortCol_0)) {
            for ($i = 0; $i < intval($iSortingCols); $i++) {
                $iSortCol = $this->input->get_post('iSortCol_' . $i, true);
                $bSortable = $this->input->get_post('bSortable_' . intval($iSortCol), true);
                $sSortDir = $this->input->get_post('sSortDir_' . $i, true);

                if ($bSortable == 'true') {
                    $col = intval($this->db->escape_str($iSortCol));
                    $this->db->order_by('iRequirementId', $this->db->escape_str($sSortDir));
                }
            }
        }

        // Ordering


        /*
         * Ordering
         */

        /*
         * Filtering
         * NOTE this does not match the built-in DataTables filtering which does it
         * word by word on any field. It's possible to do here, but concerned about efficiency
         * on very large tables, and MySQL's regex functionality is very limited
         */


        $sWhere = $where;
        if (isset($_GET['sSearch']) && $_GET['sSearch'] != "") {
            $where = $where . " and (";
            $sWhere = " (" . $where;
            $sWhere .= " cRequirementTitle LIKE '%" . $this->db->escape_like_str($sSearch) . "%' ";
//            for ( $i=0 ; $i<count($aColumns) ; $i++ )
//            {
//
//                if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $i!=0 && $i!=1)
//                {
//                    
//                    //$this->db->or_like($aColumns[$i], $this->db->escape_like_str($sSearch));
//                    $sWhere .= ' '.$aColumns[$i]." LIKE '%".$this->db->escape_like_str($sSearch)."%' OR ";
//                }
//            }
//            $sWhere = substr_replace( $sWhere, "", -3 );
            $sWhere .= '))';
        }
        /* Individual column filtering */
        for ($i = 0; $i < count($aColumns); $i++) {

            if (isset($_GET['bSearchable_' . $i]) && $_GET['bSearchable_' . $i] == "true" && $_GET['sSearch_' . $i] != '' && $i != 0 && $i != 1) {
                if ($sWhere == "") {
                    $sWhere = $where;
                } else {
                    $sWhere .= " AND ";
                }


                $sWhere .= $aColumns[$i] . " LIKE '%" . mysql_real_escape_string($_GET['sSearch_' . $i]) . "%' ";
            }
        }

        $this->db->select('SQL_CALC_FOUND_ROWS ' . str_replace(' , ', ' ', implode(', ', $aColumns)), false);
        $this->db->from($sTable);

        $this->db->join("client_master", "requirement_master.iClientId=client_master.iClientId", "LEFT");
        $this->db->join("current_status_master", "requirement_master.iCurrentStatusId=current_status_master.iCurrentStatusId", "LEFT");
        $this->db->where($sWhere, null, false);
        $rResult = $this->db->get();


        //echo $this->db->last_query();die;


        $this->db->select('FOUND_ROWS() AS found_rows');
        $iFilteredTotal = $this->db->get()->row()->found_rows;

        // Total data set length

        $iTotal = $iFilteredTotal;

        // Output
        $output = array(
            'sEcho' => intval($sEcho),
            'iTotalRecords' => $iTotal,
            'iTotalDisplayRecords' => $iFilteredTotal,
            'aaData' => array()
        );


        $sno = 1;
        foreach ($rResult->result_array() as $aRow) {
            $row = array();
            foreach ($aRow as $col) {
                $row[] = $col;
            }


            $RequirementId = trim($aRow['iRequirementId']);

            $dt = trim($aRow['dDate']);
            $splitdt = explode('-', $dt);
            $Date = $splitdt[2] . "/" . $splitdt[1] . "/" . $splitdt[0];

            $RequirementTitle = trim($aRow['cRequirementTitle']);

            $ClientName = trim($aRow['cClientName']);

            if (!empty($aRow['cCurrentStatusName'])) {
                $CurrentStatusName = trim($aRow['cCurrentStatusName']);
            } else {
                $CurrentStatusName = "NA";
            }

            $AcceptTermsAndConditions = trim($aRow['bAcceptTermsAndConditions']);

            $Active = trim($aRow['bActive']);





            $viewporturlhtml = base_url() . 'index.php/dashboard/viewrequisition/' . $RequirementId;

            $viewporturlsht = '<a class="various" data-fancybox-type="iframe" href="' . $viewporturlhtml . '"><span class="ui-icon ui-icon-search"></span></a>';




            $editurl = base_url() . 'index.php/dashboard/edit_form_requirement_master/' . $RequirementId;

            $editurls = '<a class="various" data-fancybox-type="iframe" href="' . $editurl . '"><span class="ui-icon ui-icon-pencil"></span></a>';


            $propertyhistory = base_url() . 'index.php/dashboard/requisitionhistory/' . $RequirementId;

            $propertyhistorys = '<a class="various" data-fancybox-type="iframe" href="' . $propertyhistory . '" title="Print Delivery" target="_blank" title="Print History"><span class="ui-icon ui-icon-print"></span></a>';

            //$row[0] = $RequirementId;
            //$row[1] = $Date;
            $row[0] = $RequirementTitle;
            $row[1] = $CurrentStatusName;
            $row[2] = $AcceptTermsAndConditions;
            $row[3] = $Active;
            $row[4] = $viewporturlsht;
            $row[5] = $editurls;
            $row[6] = $propertyhistorys;


            $sno++;
            $output['aaData'][] = $row;
        }

        echo json_encode($output);
    }

    function requirement_master_get_by_id($id) {
        $sql = "SELECT * FROM requirement_master WHERE requirement_master.iRequirementId='" . $id . "'";

        $query = $this->db->query($sql);

        if ($query) {
            $result = $query->row_array();

            return $result;
        }
    }

    function add_requirement_master($data) {
        $AddedByUserId = trim($this->session->userdata('UserId'));


        if (!empty($data['txtDate'])) {
            $Dat = trim($data['txtDate']);
            $splitdt = explode('/', $Dat);
            $Date = $splitdt[2] . "-" . $splitdt[1] . "-" . $splitdt[0];

            if ($splitdt[2] . $splitdt[1] . $splitdt[0] > date("Ymd")) {
                return json_encode(Array("status" => "0", "msg" => "Invalid Date. Can't enter future date."));
            }
        } else {
            $Date = "0000-00-00";
            return json_encode(Array("status" => "0", "msg" => "Invalid Date"));
        }



        if (!empty($data['txtRequirementTitle'])) {
            $RequirementTitle = trim($data['txtRequirementTitle']);
        } else {
            $RequirementTitle = "";
        }

        if (!empty($data['cmbClient'])) {
            $ClientId = trim($data['cmbClient']);
        } else {
            $ClientId = "";
        }

        if (!empty($data['cmbClient'])) {
            $ContactId = trim($data['cmbContactPerson']);
        } else {
            $ContactId = "";
        }

        if (!empty($ClientId)) {
            $query1 = $this->db->query("SELECT cClientName,cContactPerson1Email,cContactPerson1PhoneNo1 FROM client_master WHERE client_master.iClientId='" . $ClientId . "'");
            $row1 = $query1->row_array();
            $ClientName = trim($row1['cClientName']);
            $cContactPerson1Email = trim($row1['cContactPerson1Email']);
            $cContactPerson1PhoneNo1 = trim($row1['cContactPerson1PhoneNo1']);
        } else {
            $ClientName = "";
        }

        /* if(!empty($data['txtContactPerson1']))
          {
          $ContactPerson1 = trim($data['txtContactPerson1']);
          }
          else
          {
          $ContactPerson1="";
          }

          if(!empty($data['txtContactDetail1']))
          {
          $ContactDetail1 = trim($data['txtContactDetail1']);
          }
          else
          {
          $ContactDetail1="";
          }

          if(!empty($data['txtContactPerson2']))
          {
          $ContactPerson2 = trim($data['txtContactPerson2']);
          }
          else
          {
          $ContactPerson2="";
          }

          if(!empty($data['txtContactDetail2']))
          {
          $ContactDetail2 = trim($data['txtContactDetail2']);
          }
          else
          {
          $ContactDetail2="";
          }

          if(!empty($data['txtContactPerson3']))
          {
          $ContactPerson3 = trim($data['txtContactPerson3']);
          }
          else
          {
          $ContactPerson3="";
          }

          if(!empty($data['txtContactDetail3']))
          {
          $ContactDetail3 = trim($data['txtContactDetail3']);
          }
          else
          {
          $ContactDetail3="";
          } */

        if (!empty($data['cmbBranch'])) {
            $BranchId = trim($data['cmbBranch']);
        } else {
            $BranchId = "";
        }

        if (!empty($BranchId)) {
            $query2 = $this->db->query("SELECT cBranchName FROM branch_master WHERE branch_master.iBranchId='" . $BranchId . "'");
            $row2 = $query2->row_array();
            $BranchName = trim($row2['cBranchName']);
        } else {
            $BranchName = "";
        }

        if (!empty($data['cmbState'])) {
            $StateId = trim($data['cmbState']);
        } else {
            $StateId = "";
        }

        if (!empty($StateId)) {
            $query3 = $this->db->query("SELECT cStateName FROM state_master WHERE state_master.iStateId='" . $StateId . "'");
            $row3 = $query3->row_array();
            $StateName = trim($row3['cStateName']);
        } else {
            $StateName = "";
        }

        if (!empty($data['cmbDistrict'])) {
            $DistrictId = trim($data['cmbDistrict']);
        } else {
            $DistrictId = "";
        }

        if (!empty($DistrictId)) {
            $query4 = $this->db->query("SELECT cDistrictName FROM district_master WHERE district_master.iDistrictId='" . $DistrictId . "'");
            $row4 = $query4->row_array();
            $DistrictName = trim($row4['cDistrictName']);
        } else {
            $DistrictName = "";
        }

        if (!empty($data['cmbCity'])) {
            $CityId = trim($data['cmbCity']);
        } else {
            $CityId = "";
        }

        if (!empty($CityId)) {
            $query5 = $this->db->query("SELECT cCityName FROM city_master WHERE city_master.iCityId='" . $CityId . "'");
            $row5 = $query5->row_array();
            $CityName = trim($row5['cCityName']);
        } else {
            $CityName = "";
        }

        if (!empty($data['cmbLocation'])) {
            $LocationId = trim($data['cmbLocation']);
        } else {
            $LocationId = "";
        }

        if (!empty($LocationId)) {
            $query6 = $this->db->query("SELECT cLocationName FROM location_master WHERE location_master.iLocationId='" . $LocationId . "'");
            $row6 = $query6->row_array();
            $LocationName = trim($row6['cLocationName']);
        } else {
            $LocationName = "";
        }




        if (!empty($data['txtArea'])) {
            $Area = (int) trim($data['txtArea']);
        } else {
            $Area = "0";
        }

        if (!empty($data['txtHeight'])) {
            $Height = trim($data['txtHeight']);
        } else {
            $Height = "";
        }

        if (!empty($data['txtFrontage'])) {
            $Frontage = trim($data['txtFrontage']);
        } else {
            $Frontage = "";
        }

        if (!empty($data['cmbSource'])) {
            $SourceId = trim($data['cmbSource']);
        } else {
            $SourceId = "";
        }

        if (!empty($SourceId)) {
            $query7 = $this->db->query("SELECT cSourceName FROM source_master WHERE source_master.iSourceId='" . $SourceId . "'");
            $row7 = $query7->row_array();
            $SourceName = trim($row7['cSourceName']);
        } else {
            $SourceName = "";
        }

        //$PropertyPurpose = trim($data['cmbPropertyPurpose']);

        if (!empty($data['cmbBusinessPurpose'])) {
            $BusinessPurposeId = trim($data['cmbBusinessPurpose']);
        } else {
            $BusinessPurposeId = "";
        }

        if (!empty($BusinessPurposeId)) {
            $query8 = $this->db->query("SELECT cBusinessPurposeName FROM business_purpose_master WHERE business_purpose_master.iBusinessPurposeId='" . $BusinessPurposeId . "'");
            $row8 = $query8->row_array();
            $BusinessPurposeName = trim($row8['cBusinessPurposeName']);
        } else {
            $BusinessPurposeName = "";
        }

        if (!empty($data['cmbPropertyCategory'])) {
            $PropertyCategoryId = trim($data['cmbPropertyCategory']);
        } else {
            $PropertyCategoryId = "";
        }

        if (!empty($PropertyCategoryId)) {
            $query9 = $this->db->query("SELECT cPropertyCategoryName FROM property_category_master WHERE property_category_master.iPropertyCategoryId='" . $PropertyCategoryId . "'");
            $row9 = $query9->row_array();
            $PropertyCategoryName = trim($row9['cPropertyCategoryName']);
        } else {
            $PropertyCategoryName = "";
        }

        if (!empty($data['cmbRequirementType'])) {
            $RequirementType = trim($data['cmbRequirementType']);
        } else {
            $RequirementType = "";
        }

        if (!empty($data['txtBudgetPerMonth'])) {
            $BudgetPerMonth = trim($data['txtBudgetPerMonth']);
        } else {
            $BudgetPerMonth = "";
        }

        if (!empty($data['txtFloorLevelPreference'])) {
            $FloorLevelPreference = trim($data['txtFloorLevelPreference']);
        } else {
            $FloorLevelPreference = "";
        }

        if (!empty($data['cmbEscalation'])) {
            $EscalationId = (int) trim($data['cmbEscalation']);
        } else {
            $EscalationId = "0";
        }

        if (!empty($EscalationId)) {
            $query10 = $this->db->query("SELECT cEscalationName FROM escalation_master WHERE escalation_master.iEscalationId='" . $EscalationId . "'");
            $row10 = $query10->row_array();
            $EscalationName = trim($row10['cEscalationName']);
        } else {
            $EscalationName = "";
        }

        if (!empty($data['txtLeasePeriodPreference'])) {
            $LeasePeriodPreference = trim($data['txtLeasePeriodPreference']);
        } else {
            $LeasePeriodPreference = "";
        }

        if (!empty($data['txtRentFreeFitOutPeriod'])) {
            $RentFreeFitOutPeriod = trim($data['txtRentFreeFitOutPeriod']);
        } else {
            $RentFreeFitOutPeriod = "";
        }

        if (!empty($data['txtPowerLoad'])) {
            $PowerLoad = trim($data['txtPowerLoad']);
        } else {
            $PowerLoad = "";
        }

        if (!empty($data['cmbPowerBackup'])) {
            $PowerBackup = trim($data['cmbPowerBackup']);
        } else {
            $PowerBackup = "";
        }

        if (!empty($data['txtExpectedLaunchDate'])) {
            $ExpLaunchDat = trim($data['txtExpectedLaunchDate']);
            $splitlaunchdt = explode('/', $ExpLaunchDat);
            $ExpectedLaunchDate = $splitlaunchdt[2] . "-" . $splitlaunchdt[1] . "-" . $splitlaunchdt[0];
        } else {
            $ExpectedLaunchDate = "0000-00-00";
        }

        if (!empty($data['txtRequirementTaglineForWebsite'])) {
            $RequirementTaglineForWebsite = trim($data['txtRequirementTaglineForWebsite']);
        } else {
            $RequirementTaglineForWebsite = "";
        }

        if (!empty($data['txtRemarks'])) {
            $Remarks = trim($data['txtRemarks']);
        } else {
            $Remarks = "";
        }

        if (!empty($data['cmbRegistrationExpensesToBeBorneBy'])) {
            $RegistrationExpensesToBeBorneBy = trim($data['cmbRegistrationExpensesToBeBorneBy']);
        } else {
            $RegistrationExpensesToBeBorneBy = "";
        }

        if (!empty($data['cmbTaxationToBeBorneBy'])) {
            $TaxationToBeBorneBy = trim($data['cmbTaxationToBeBorneBy']);
        } else {
            $TaxationToBeBorneBy = "";
        }

        if (!empty($data['txtLockInPeriod'])) {
            $LockInPeriod = trim($data['txtLockInPeriod']);
        } else {
            $LockInPeriod = "";
        }

        if (!empty($data['txtEstimatedInteriorBudget'])) {
            $EstimatedInteriorBudget = trim($data['txtEstimatedInteriorBudget']);
        } else {
            $EstimatedInteriorBudget = "";
        }

        if (!empty($data['cmbParkingPreference'])) {
            $ParkingPreference = trim($data['cmbParkingPreference']);
        } else {
            $ParkingPreference = "";
        }

        if (!empty($data['txtAgreementDate'])) {
            $AgreeDat = trim($data['txtAgreementDate']);
            $splitagreedt = explode('/', $AgreeDat);
            $AgreementDate = $splitagreedt[2] . "-" . $splitagreedt[1] . "-" . $splitagreedt[0];
        } else {
            $AgreementDate = "0000-00-00";
        }

        if (!empty($data['txtAgreementPlace'])) {
            $AgreementPlace = trim($data['txtAgreementPlace']);
        } else {
            $AgreementPlace = "";
        }

        if (!empty($data['txtPerson1DuringAgreement'])) {
            $Person1DuringAgreement = trim($data['txtPerson1DuringAgreement']);
        } else {
            $Person1DuringAgreement = "";
        }

        if (!empty($data['txtPerson2DuringAgreement'])) {
            $Person2DuringAgreement = trim($data['txtPerson2DuringAgreement']);
        } else {
            $Person2DuringAgreement = "";
        }

        if (!empty($data['hfAgreementFilePath'])) {
            $AgreementFilePath = trim($data['hfAgreementFilePath']);
        } else {
            $AgreementFilePath = "";
        }

        if (!empty($data['hfAgreementFileName'])) {
            $AgreementFileName = trim($data['hfAgreementFileName']);
        } else {
            $AgreementFileName = "";
        }

        if (!empty($data['txtServiceChargesForLinkers'])) {
            $ServiceChargesForLinkers = trim($data['txtServiceChargesForLinkers']);
        } else {
            $ServiceChargesForLinkers = "";
        }

        if (!empty($data['txtTermsAndConditions'])) {
            $TermsAndConditions = trim($data['txtTermsAndConditions']);
        } else {
            $TermsAndConditions = "";
        }

        if (!empty($data['cmbFurnishedStatus'])) {
            $cmbFurnishedStatus = trim($data['cmbFurnishedStatus']);
        } else {
            $cmbFurnishedStatus = "";
        }

        $AcceptTermsAndConditions = isset($data['chkAcceptTermsAndConditions']) ? trim($data['chkAcceptTermsAndConditions']) : 0;

        $Active = (int) trim($data['chkActive']);


        $sql = "SELECT * FROM requirement_master WHERE requirement_master.cRequirementTitle='" . $RequirementTitle . "' AND requirement_master.bDelete=0";

        $query = $this->db->query($sql);

        if ($query) {
            if ($query->num_rows > 0) {
                return json_encode(Array("status" => "0", "msg" => EXIST_MSG));
            } else {
                $addData = array(
                    'dDate' => $Date,
                    'iAddedByUserId' => $AddedByUserId,
                    'cRequirementTitle' => htmlentities($RequirementTitle, ENT_QUOTES),
                    'iClientId' => $ClientId,
                    'iContactId' => (int) $ContactId,
                    /* 'cContactPerson1' => $ContactPerson1,
                      'cContactDetail1' => $ContactDetail1,
                      'cContactPerson2' => $ContactPerson2,
                      'cContactDetail2' => $ContactDetail2,
                      'cContactPerson3' => $ContactPerson3,
                      'cContactDetail3' => $ContactDetail3, */
                    'iBranchId' => (int) $BranchId,
                    'iStateId' => (int) $StateId,
                    'iDistrictId' => (int) $DistrictId,
                    'iCityId' => (int) $CityId,
                    'iLocationId' => (int) $LocationId,
                    'cArea' => htmlentities($Area, ENT_QUOTES),
                    'cHeight' => htmlentities($Height, ENT_QUOTES),
                    'cFrontage' => htmlentities($Frontage, ENT_QUOTES),
                    'cFurnishedStatus' => htmlentities($cmbFurnishedStatus, ENT_QUOTES),
                    'iSourceId' => (int) $SourceId,
                    //'cPropertyPurpose' => $PropertyPurpose,
                    'iBusinessPurposeId' => (int) $BusinessPurposeId,
                    'iPropertyCategoryId' => (int) $PropertyCategoryId,
                    'cRequirementType' => $RequirementType,
                    'cBudgetPerMonth' => $BudgetPerMonth,
                    'cFloorLevelPreference' => $FloorLevelPreference,
                    'iEscalationId' => (int) $EscalationId,
                    'cLeasePeriodPreference' => htmlentities($LeasePeriodPreference, ENT_QUOTES),
                    'cRentFreeFitOutPeriod' => htmlentities($RentFreeFitOutPeriod, ENT_QUOTES),
                    'cPowerLoad' => htmlentities($PowerLoad, ENT_QUOTES),
                    'cPowerBackup' => $PowerBackup,
                    'dExpectedLaunchDate' => $ExpectedLaunchDate,
                    'cRequirementTaglineForWebsite' => $RequirementTaglineForWebsite,
                    'cRemarks' => htmlentities($Remarks, ENT_QUOTES),
                    'cRegistrationExpensesToBeBorneBy' => $RegistrationExpensesToBeBorneBy,
                    'cTaxationToBeBorneBy' => $TaxationToBeBorneBy,
                    'cLockInPeriod' => $LockInPeriod,
                    'cEstimatedInteriorBudget' => $EstimatedInteriorBudget,
                    'cParkingPreference' => $ParkingPreference,
                    'dAgreementDate' => $AgreementDate,
                    'cAgreementPlace' => $AgreementPlace,
                    'cPerson1DuringAgreement' => $Person1DuringAgreement,
                    'cPerson2DuringAgreement' => $Person2DuringAgreement,
                    'cAgreementFilePath' => $AgreementFilePath,
                    'cAgreementFileName' => $AgreementFileName,
                    'cTermsAndConditions' => htmlentities($TermsAndConditions, ENT_QUOTES),
                    'bAcceptTermsAndConditions' => $AcceptTermsAndConditions,
                    'cServiceChargesForLinkers' => htmlentities($ServiceChargesForLinkers, ENT_QUOTES),
                    'bActive' => $Active,
                );

                $insert = $this->db->insert('requirement_master', $addData);
                $RFId = $this->db->insert_id();



                /* Data insert in task tables */

                $UserId = trim($this->session->userdata('UserId'));

                $DCRDate = date('Y-m-d H:i:s');

                $DCRRemarks = "";

                $new_activity_data = array(
                    'dActivityDateTime' => date('Y-m-d H:i:s'),
                    'cUserName' => trim($this->session->userdata('UserName')),
                    'cIPAddress' => $this->get_client_ip(),
                    'cActivityDesc' => 'Add New Task'
                );

                $newactivitylogid = $this->save_activity_details($new_activity_data);

                $addData = array(
                    'dDCRDate' => $DCRDate,
                    'iUserId' => $UserId,
                    'cDCRRemarks' => $DCRRemarks,
                    'iActivityLogId' => trim($newactivitylogid),
                );

                $SaveData = $this->db->insert('dcr_summary', $addData);
                $DCRId = $this->db->insert_id();

                $addDCRDetail = array(
                    'iDCRId' => $DCRId,
                    'iClientReqId' => $ClientId,
                    'iRequirementId' => $RFId,
                    'iTaskId'=>'10',
                    'cDCRSummary'=>'New RF Added'
                );

                $insertDCRDetail = $this->db->insert('dcr_detail', $addDCRDetail);


                /* After Rf add send email to internal staff */


                $Rfaddtointernalstaff = '';
                $Rfaddtointernalstaff.='<div><p>Hello,</p>';
                $Rfaddtointernalstaff.='<p>A new Requirement ' . $RequirementTitle . ' is added by ' . $this->session->userdata('UserName') . ' on ' . date('d-m-Y H:i:s');
                $Rfaddtointernalstaff.='<br>Please find following details:<br>';
                $Rfaddtointernalstaff.=$ClientName . '<br>' . $RequirementTitle . '<br>' . $LocationName . ' ' . $CityName . ' ' . $DistrictName . ' ' . $StateName .
                        '<br>' . $RequirementType . '<br>' . $PropertyCategoryName . '<br>' . $cmbFurnishedStatus . '<br>' . $cContactPerson1Email . '<br>' . $cContactPerson1PhoneNo1 . '</p>';
                $Rfaddtointernalstaff.='<p>Best Regards,<br>Team Linkers India<br>Bakhatgarh Towers, 34/2, Race Course Rd, New Palasia, Old Palasia, Indore, Madhya Pradesh, 452001.<br>+91 731 4044406, +91 9993999996<br><a href="mailto:support@linkersindia.com" target="_blank">support@linkersindia.com</a></p>
                                        </div>';

                $this->db->where('bActive', 1);
                $this->db->where('bDelete', 0);
                $query = $this->db->get('user_master');

                if ($query->result()) {
                    foreach ($query->result() as $req) {
                        $this->sendEmail($req->cEmailAddress, 'New RF Added', $Rfaddtointernalstaff);
                    }
                }

                if ($insert) {
                    /*
                      //---------------- Send Email to Staff-------------------------

                      $UserEmailSubject = "A New RF added";

                      $UserEmailMessage="Date : $Dat"."\n\n";
                      $UserEmailMessage.="RF Title : $RequirementTitle"."\n\n";
                      $UserEmailMessage.="Client : $ClientName"."\n\n";
                      $UserEmailMessage.="Contact Person 1 : $ContactPerson1"."\n\n";
                      $UserEmailMessage.="Contact Detail 1 : $ContactDetail1"."\n\n";
                      $UserEmailMessage.="Contact Person 2 : $ContactPerson2"."\n\n";
                      $UserEmailMessage.="Contact Detail 2 : $ContactDetail2"."\n\n";
                      $UserEmailMessage.="Contact Person 3 : $ContactPerson3"."\n\n";
                      $UserEmailMessage.="Contact Detail 3 : $ContactDetail3"."\n\n";

                      $UserEmailMessage.="Branch : $BranchName"."\n\n";
                      $UserEmailMessage.="State : $StateName"."\n\n";
                      $UserEmailMessage.="District : $DistrictName"."\n\n";
                      $UserEmailMessage.="City : $CityName"."\n\n";
                      $UserEmailMessage.="Location : $LocationName"."\n\n";

                      $UserEmailMessage.="Area : $Area"."\n\n";
                      $UserEmailMessage.="Height : $Height"."\n\n";
                      $UserEmailMessage.="Frontage : $Frontage"."\n\n";
                      $UserEmailMessage.="Source : $SourceName"."\n\n";
                      $UserEmailMessage.="Business Purpose : $BusinessPurposeName"."\n\n";
                      $UserEmailMessage.="Property Category : $PropertyCategoryName"."\n\n";
                      $UserEmailMessage.="Requirement Type : $RequirementType"."\n\n";
                      $UserEmailMessage.="Budget Per Month : $BudgetPerMonth"."\n\n";
                      $UserEmailMessage.="Floor Level Preference : $FloorLevelPreference"."\n\n";
                      $UserEmailMessage.="Escalation : $EscalationName"."\n\n";
                      $UserEmailMessage.="Lease Period Preference : $LeasePeriodPreference"."\n\n";
                      $UserEmailMessage.="Rent Free Fit Out Period : $RentFreeFitOutPeriod"."\n\n";
                      $UserEmailMessage.="Power Load : $PowerLoad"."\n\n";
                      $UserEmailMessage.="Power Backup : $PowerBackup"."\n\n";
                      $UserEmailMessage.="Expected Launch Date : $ExpectedLaunchDate"."\n\n";
                      $UserEmailMessage.="Remarks : $Remarks"."\n\n";


                      //$UserRecipientEmailAddress="";

                      $sql = "SELECT user_master.cEmailAddress FROM user_master WHERE user_master.cEmailAddress<>'' AND user_master.bActive=1";

                      $query = $this->db->query($sql);

                      if($query)
                      {
                      if($query->num_rows > 0)
                      {
                      $rows = $query->result_array();

                      $mail = new PHPMailer();
                      $mail->IsSMTP(); 		                                  // We are going to use SMTP
                      $mail->SMTPAuth   = true;                                 // Enabled SMTP authentication
                      $mail->SMTPSecure = "ssl";                                // Prefix for secure protocol to connect to the server
                      $mail->Host       = "smtp.gmail.com";     		          // Setting GMail as our SMTP server
                      $mail->Port       =  465;                                 // SMTP port to connect to GMail
                      $mail->Username   = "support@linkersindia.com";           // User email address
                      $mail->Password   = "manashids";                          // Password in GMail

                      $mail->SetFrom('support@linkersindia.com', 'Linkers');     //Who is sending the email
                      $mail->AddReplyTo("support@linkersindia.com', 'Linkers");  //Email address that receives the response
                      $mail->Subject   = "$UserEmailSubject";
                      $mail->Body  	 = "$UserEmailMessage";

                      $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!";

                      foreach($rows as $row)
                      {
                      $UserRecipientEmailAddress = trim($row['cEmailAddress']);

                      if((!empty($UserRecipientEmailAddress)) && (filter_var($UserRecipientEmailAddress, FILTER_VALIDATE_EMAIL) !== false))
                      {
                      $mail->AddAddress("$UserRecipientEmailAddress");
                      }
                      }

                      if(!$mail->Send())
                      {
                      echo "RF User Email Error: " . $mail->ErrorInfo;
                      //return false;
                      }
                      else
                      {
                      echo "RF User Email Sent Successfully...!";
                      //return true;
                      }
                      }
                      }


                      //-------------------------------------------------------------


                      //---------------- Send Email to Client------------------------

                      $ClientRecipientMailAddress="";

                      $sql = "SELECT cClientName,cContactPerson1Name,cContactPerson1Email FROM client_master WHERE client_master.iClientId='".$ClientId."'";

                      $query = $this->db->query($sql);

                      if($query)
                      {
                      if($query->num_rows > 0)
                      {
                      $row = $query->row_array();

                      $ClientName = trim($row['cClientName']);

                      $ContactPerson1Name = trim($row['cContactPerson1Name']);

                      $ContactPerson1Email = trim($row['cContactPerson1Email']);

                      $ClientRecipientMailAddress = trim($row['cContactPerson1Email']);



                      $ClientEmailSubject = "Welcome to Linkers !";

                      $ClientEmailMessage="Dear $ClientName,"."\n\n";
                      $ClientEmailMessage.="We thank you for your confidence on Linkers India for your real estate solutions & wish to prove our mettle by giving you most suitable & amicable options. It’s always our endeavour to provide timely, reliable & ethical services to our valued clients."."\n\n";
                      $ClientEmailMessage.="Our team has entered your data into our CRM Application& shall start providing you suitable options as per your needs. Please feel free to get in touch with our Customer Support Officer at below mentioned numbers."."\n\n\n";
                      $ClientEmailMessage.="Thanks!!!."."\n\n\n";

                      $ClientEmailMessage.="Team Linkers India."."\n";
                      $ClientEmailMessage.="204, Silver Arch Plaza, New Palasia,Near Curewell Hospital, Zanjeerwala Square, Indore – 452001."."\n";
                      $ClientEmailMessage.="Email: support@linkersindia.com."."\n";
                      $ClientEmailMessage.="Phone: +91-731-4044406, +(91)-8349998452."."\n";


                      $mail = new PHPMailer();
                      $mail->IsSMTP(); 		                                  // We are going to use SMTP
                      $mail->SMTPAuth   = true;                                 // Enabled SMTP authentication
                      $mail->SMTPSecure = "ssl";                                // Prefix for secure protocol to connect to the server
                      $mail->Host       = "smtp.gmail.com";     		          // Setting GMail as our SMTP server
                      $mail->Port       =  465;                                 // SMTP port to connect to GMail
                      $mail->Username   = "support@linkersindia.com";           // User email address
                      $mail->Password   = "manashids";                          // Password in GMail

                      $mail->SetFrom('support@linkersindia.com', 'Linkers');     //Who is sending the email
                      $mail->AddReplyTo("support@linkersindia.com', 'Linkers");  //Email address that receives the response
                      $mail->Subject   = "$ClientEmailSubject";
                      $mail->Body  	 = "$ClientEmailMessage";

                      $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!";

                      if((!empty($ClientRecipientMailAddress)) && (filter_var($ClientRecipientMailAddress, FILTER_VALIDATE_EMAIL) !== false))
                      {
                      $mail->AddAddress("$ClientRecipientMailAddress");

                      if(!$mail->Send())
                      {
                      echo "RF Client Email Error: " . $mail->ErrorInfo;
                      //return false;
                      }
                      else
                      {
                      echo "RF Client Email Sent Successfully...!";
                      //return true;
                      }
                      }
                      }
                      }

                      //-------------------------------------------------------------
                     */


                    /* Send email to client */


                    $RFaddmail = "";
                    $RFaddmail .= '<div>';
                    $RFaddmail .='<p>Dear ' . $ClientName . '</p>';
                    $RFaddmail .='<p>Greetings from Linkers India!</p>
                                    <p>We are pleased to share that we have added your Property Requirement in our CRM.<br>We strive to deliver quality Corporate Leasing Services and assure that we shall soon get back with suitable options.</p>
                                    <p>Thanks!</p>
                                    <p>Best Regards,<br>Team Linkers India<br>Bakhatgarh Towers, 34/2, Race Course Rd, New Palasia, Old Palasia, Indore, Madhya Pradesh, 452001.<br>+91 731 4044406, +91 9993999996<br><a href="mailto:support@linkersindia.com" target="_blank">support@linkersindia.com</a></p>
                                    </div>';


                    $this->sendEmail($cContactPerson1Email, 'New RF Added', $RFaddmail);




                    return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
                } else {
                    return json_encode(Array("status" => "0", "msg" => ERROR_INSERT_MSG));
                }
            }
        }
    }

    function edit_requirement_master($data) {
        $hfRequirementId = trim($data['hfRequirementId']);


        if (!empty($data['txtDate'])) {
            $Dat = trim($data['txtDate']);
            $splitdt = explode('/', $Dat);
            $Date = $splitdt[2] . "-" . $splitdt[1] . "-" . $splitdt[0];

            if ($splitdt[2] . $splitdt[1] . $splitdt[0] > date("Ymd")) {
                return json_encode(Array("status" => "0", "msg" => "Invalid Date. Can't enter future date."));
            }
        } else {
            $Date = "0000-00-00";
            return json_encode(Array("status" => "0", "msg" => "Invalid Date"));
        }


        if (!empty($data['txtRequirementTitle'])) {
            $RequirementTitle = trim($data['txtRequirementTitle']);
        } else {
            $RequirementTitle = "";
        }

        if (!empty($data['cmbClient'])) {
            $ClientId = trim($data['cmbClient']);
        } else {
            $ClientId = "";
        }

        if (!empty($data['cmbClient'])) {
            $ContactId = trim($data['cmbContactPerson']);
        } else {
            $ContactId = "";
        }
        /* if(!empty($data['txtContactPerson1']))
          {
          $ContactPerson1 = trim($data['txtContactPerson1']);
          }
          else
          {
          $ContactPerson1="";
          }

          if(!empty($data['txtContactDetail1']))
          {
          $ContactDetail1 = trim($data['txtContactDetail1']);
          }
          else
          {
          $ContactDetail1="";
          }

          if(!empty($data['txtContactPerson2']))
          {
          $ContactPerson2 = trim($data['txtContactPerson2']);
          }
          else
          {
          $ContactPerson2="";
          }

          if(!empty($data['txtContactDetail2']))
          {
          $ContactDetail2 = trim($data['txtContactDetail2']);
          }
          else
          {
          $ContactDetail2="";
          }

          if(!empty($data['txtContactPerson3']))
          {
          $ContactPerson3 = trim($data['txtContactPerson3']);
          }
          else
          {
          $ContactPerson3="";
          }

          if(!empty($data['txtContactDetail3']))
          {
          $ContactDetail3 = trim($data['txtContactDetail3']);
          }
          else
          {
          $ContactDetail3="";
          } */

        if (!empty($data['cmbBranch'])) {
            $BranchId = trim($data['cmbBranch']);
        } else {
            $BranchId = "";
        }

        if (!empty($data['cmbState'])) {
            $StateId = trim($data['cmbState']);
        } else {
            $StateId = "";
        }

        if (!empty($data['cmbDistrict'])) {
            $DistrictId = trim($data['cmbDistrict']);
        } else {
            $DistrictId = "";
        }

        if (!empty($data['cmbCity'])) {
            $CityId = trim($data['cmbCity']);
        } else {
            $CityId = "";
        }

        if (!empty($data['cmbLocation'])) {
            $LocationId = trim($data['cmbLocation']);
        } else {
            $LocationId = "";
        }

        if (!empty($data['txtArea'])) {
            $Area = (int) trim($data['txtArea']);
        } else {
            $Area = "0";
        }

        if (!empty($data['txtHeight'])) {
            $Height = trim($data['txtHeight']);
        } else {
            $Height = "";
        }

        if (!empty($data['txtFrontage'])) {
            $Frontage = trim($data['txtFrontage']);
        } else {
            $Frontage = "";
        }

        if (!empty($data['cmbSource'])) {
            $SourceId = trim($data['cmbSource']);
        } else {
            $SourceId = "";
        }

        //$PropertyPurpose = trim($data['cmbPropertyPurpose']);

        if (!empty($data['cmbBusinessPurpose'])) {
            $BusinessPurposeId = trim($data['cmbBusinessPurpose']);
        } else {
            $BusinessPurposeId = "";
        }

        if (!empty($data['cmbPropertyCategory'])) {
            $PropertyCategoryId = trim($data['cmbPropertyCategory']);
        } else {
            $PropertyCategoryId = "";
        }

        if (!empty($data['cmbRequirementType'])) {
            $RequirementType = trim($data['cmbRequirementType']);
        } else {
            $RequirementType = "";
        }

        if (!empty($data['txtBudgetPerMonth'])) {
            $BudgetPerMonth = trim($data['txtBudgetPerMonth']);
        } else {
            $BudgetPerMonth = "";
        }

        if (!empty($data['txtFloorLevelPreference'])) {
            $FloorLevelPreference = trim($data['txtFloorLevelPreference']);
        } else {
            $FloorLevelPreference = "";
        }

        if (!empty($data['cmbEscalation'])) {
            $EscalationId = trim($data['cmbEscalation']);
        } else {
            $EscalationId = "";
        }

        if (!empty($data['txtLeasePeriodPreference'])) {
            $LeasePeriodPreference = trim($data['txtLeasePeriodPreference']);
        } else {
            $LeasePeriodPreference = "";
        }

        if (!empty($data['txtRentFreeFitOutPeriod'])) {
            $RentFreeFitOutPeriod = trim($data['txtRentFreeFitOutPeriod']);
        } else {
            $RentFreeFitOutPeriod = "";
        }

        if (!empty($data['txtPowerLoad'])) {
            $PowerLoad = trim($data['txtPowerLoad']);
        } else {
            $PowerLoad = "";
        }

        if (!empty($data['cmbPowerBackup'])) {
            $PowerBackup = trim($data['cmbPowerBackup']);
        } else {
            $PowerBackup = "";
        }

        if (!empty($data['txtExpectedLaunchDate'])) {
            $ExpLaunchDat = trim($data['txtExpectedLaunchDate']);
            $splitlaunchdt = explode('/', $ExpLaunchDat);
            $ExpectedLaunchDate = $splitlaunchdt[2] . "-" . $splitlaunchdt[1] . "-" . $splitlaunchdt[0];
        } else {
            $ExpectedLaunchDate = "0000-00-00";
        }

        if (!empty($data['txtRequirementTaglineForWebsite'])) {
            $RequirementTaglineForWebsite = trim($data['txtRequirementTaglineForWebsite']);
        } else {
            $RequirementTaglineForWebsite = "";
        }

        if (!empty($data['txtRemarks'])) {
            $Remarks = trim($data['txtRemarks']);
        } else {
            $Remarks = "";
        }

        if (!empty($data['cmbRegistrationExpensesToBeBorneBy'])) {
            $RegistrationExpensesToBeBorneBy = trim($data['cmbRegistrationExpensesToBeBorneBy']);
        } else {
            $RegistrationExpensesToBeBorneBy = "";
        }

        if (!empty($data['cmbTaxationToBeBorneBy'])) {
            $TaxationToBeBorneBy = trim($data['cmbTaxationToBeBorneBy']);
        } else {
            $TaxationToBeBorneBy = "";
        }

        if (!empty($data['txtLockInPeriod'])) {
            $LockInPeriod = trim($data['txtLockInPeriod']);
        } else {
            $LockInPeriod = "";
        }

        if (!empty($data['txtEstimatedInteriorBudget'])) {
            $EstimatedInteriorBudget = trim($data['txtEstimatedInteriorBudget']);
        } else {
            $EstimatedInteriorBudget = "";
        }

        if (!empty($data['cmbParkingPreference'])) {
            $ParkingPreference = trim($data['cmbParkingPreference']);
        } else {
            $ParkingPreference = "";
        }

        if (!empty($data['txtAgreementDate'])) {
            $AgreeDat = trim($data['txtAgreementDate']);
            $splitagreedt = explode('/', $AgreeDat);
            $AgreementDate = $splitagreedt[2] . "-" . $splitagreedt[1] . "-" . $splitagreedt[0];
        } else {
            $AgreementDate = "0000-00-00";
        }

        if (!empty($data['txtAgreementPlace'])) {
            $AgreementPlace = trim($data['txtAgreementPlace']);
        } else {
            $AgreementPlace = "";
        }

        if (!empty($data['txtPerson1DuringAgreement'])) {
            $Person1DuringAgreement = trim($data['txtPerson1DuringAgreement']);
        } else {
            $Person1DuringAgreement = "";
        }

        if (!empty($data['txtPerson2DuringAgreement'])) {
            $Person2DuringAgreement = trim($data['txtPerson2DuringAgreement']);
        } else {
            $Person2DuringAgreement = "";
        }

        if (!empty($data['hfAgreementFilePath'])) {
            $AgreementFilePath = trim($data['hfAgreementFilePath']);
        } else {
            $AgreementFilePath = "";
        }

        if (!empty($data['hfAgreementFileName'])) {
            $AgreementFileName = trim($data['hfAgreementFileName']);
        } else {
            $AgreementFileName = "";
        }

        if (!empty($data['txtServiceChargesForLinkers'])) {
            $ServiceChargesForLinkers = trim($data['txtServiceChargesForLinkers']);
        } else {
            $ServiceChargesForLinkers = "";
        }

        if (!empty($data['txtTermsAndConditions'])) {
            $TermsAndConditions = trim($data['txtTermsAndConditions']);
        } else {
            $TermsAndConditions = "";
        }

        if (!empty($data['cmbFurnishedStatus'])) {
            $cmbFurnishedStatus = trim($data['cmbFurnishedStatus']);
        } else {
            $cmbFurnishedStatus = "";
        }

        $AcceptTermsAndConditions = isset($data['hfAcceptTermsAndConditions']) ? trim($data['hfAcceptTermsAndConditions']) : 0;

        $Active = trim($data['hfActive']);


        $sql = "SELECT * FROM requirement_master WHERE requirement_master.cRequirementTitle='" . $RequirementTitle . "' AND requirement_master.bDelete=0 AND iRequirementId!='" . $hfRequirementId . "'";

        $query = $this->db->query($sql);

        if ($query) {
            if ($query->num_rows > 0) {
                return json_encode(Array("status" => "0", "msg" => EXIST_MSG));
            } else {
                $editData = array(
                    'dDate' => $Date,
                    'cRequirementTitle' => htmlentities($RequirementTitle, ENT_QUOTES),
                    'iClientId' => (int) $ClientId,
                    'iContactId' => (int) $ContactId,
                    /* 'cContactPerson1' => $ContactPerson1,
                      'cContactDetail1' => $ContactDetail1,
                      'cContactPerson2' => $ContactPerson2,
                      'cContactDetail2' => $ContactDetail2,
                      'cContactPerson3' => $ContactPerson3,
                      'cContactDetail3' => $ContactDetail3, */
                    'iBranchId' => (int) $BranchId,
                    'iStateId' => (int) $StateId,
                    'iDistrictId' => (int) $DistrictId,
                    'iCityId' => (int) $CityId,
                    'iLocationId' => (int) $LocationId,
                    'cArea' => htmlentities($Area, ENT_QUOTES),
                    'cHeight' => htmlentities($Height, ENT_QUOTES),
                    'cFrontage' => htmlentities($Frontage, ENT_QUOTES),
                    'cFurnishedStatus' => htmlentities($cmbFurnishedStatus, ENT_QUOTES),
                    'iSourceId' => (int) $SourceId,
                    //'cPropertyPurpose' => $PropertyPurpose,
                    'iBusinessPurposeId' => (int) $BusinessPurposeId,
                    'iPropertyCategoryId' => (int) $PropertyCategoryId,
                    'cRequirementType' => $RequirementType,
                    'cBudgetPerMonth' => $BudgetPerMonth,
                    'cFloorLevelPreference' => $FloorLevelPreference,
                    'iEscalationId' => (int) $EscalationId,
                    'cLeasePeriodPreference' => htmlentities($LeasePeriodPreference, ENT_QUOTES),
                    'cRentFreeFitOutPeriod' => htmlentities($RentFreeFitOutPeriod, ENT_QUOTES),
                    'cPowerLoad' => htmlentities($PowerLoad, ENT_QUOTES),
                    'cPowerBackup' => $PowerBackup,
                    'dExpectedLaunchDate' => $ExpectedLaunchDate,
                    'cRequirementTaglineForWebsite' => $RequirementTaglineForWebsite,
                    'cRemarks' => htmlentities($Remarks, ENT_QUOTES),
                    'cRegistrationExpensesToBeBorneBy' => $RegistrationExpensesToBeBorneBy,
                    'cTaxationToBeBorneBy' => $TaxationToBeBorneBy,
                    'cLockInPeriod' => $LockInPeriod,
                    'cEstimatedInteriorBudget' => $EstimatedInteriorBudget,
                    'cParkingPreference' => $ParkingPreference,
                    'dAgreementDate' => $AgreementDate,
                    'cAgreementPlace' => $AgreementPlace,
                    'cPerson1DuringAgreement' => $Person1DuringAgreement,
                    'cPerson2DuringAgreement' => $Person2DuringAgreement,
                    'cAgreementFilePath' => $AgreementFilePath,
                    'cAgreementFileName' => $AgreementFileName,
                    'cTermsAndConditions' => htmlentities($TermsAndConditions, ENT_QUOTES),
                    'bAcceptTermsAndConditions' => $AcceptTermsAndConditions,
                    'cServiceChargesForLinkers' => htmlentities($ServiceChargesForLinkers, ENT_QUOTES),
                    'bActive' => $Active,
                );

                $this->db->where('iRequirementId', $hfRequirementId);
                $update = $this->db->update('requirement_master', $editData);

                if ($update) {
                    return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
                } else {
                    return json_encode(Array("status" => "0", "msg" => ERROR_UPDATE_MSG));
                }
            }
        }
    }

    function delete_requirement_master($id) {
        $sql = "UPDATE requirement_master SET requirement_master.bDelete=1 WHERE requirement_master.iRequirementId='" . $id . "'";

        $query = $this->db->query($sql);

        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    //-------------------------------------------------- Initiate Deal ---------------------------------------------------------------------------------------

    function get_all_deal_initiate() {
        $sql = "SELECT deal_initiate.iDealInitiateId,deal_initiate.dDealInitiateDate,property_master.cPropertyName FROM deal_initiate LEFT JOIN property_master ON deal_initiate.iPropertyId=property_master.iPropertyId WHERE deal_initiate.bDelete=0";

        $query = $this->db->query($sql);

        return $query;
    }

    function deal_initiate_get_by_id($id) {
        $sql = "SELECT * FROM deal_initiate WHERE deal_initiate.iDealInitiateId='" . $id . "'";

        $query = $this->db->query($sql);

        if ($query) {
            $result = $query->row_array();

            return $result;
        }
    }

    function add_deal_initiate($data) {
        //$UserId = trim($this->session->userdata('UserId'));

        $txtInitiateDate = trim($data['txtInitiateDate']);
        $splitinitdt = explode('/', $txtInitiateDate);
        if (sizeof($splitinitdt) > 1) {
            $InitiateDate = $splitinitdt[2] . "-" . $splitinitdt[1] . "-" . $splitinitdt[0];
        } else {
            $InitiateDate = "0000-00-00";
        }

        $BranchId = (int) trim($data['cmbBranch']);

        $ClientReqId = (int) trim($data['cmbClientReq']);

        $RequirementId = (int) trim($data['cmbRequirement']);

        $ClientPropId = (int) trim($data['cmbClientProp']);

        $PropertyId = (int) trim($data['cmbProperty']);

        $txtLeaseStartDate = trim($data['txtLeaseStartDate']);
        $splitleasestdt = explode('/', $txtLeaseStartDate);
        if (sizeof($splitleasestdt) > 1) {
            $LeaseStartDate = $splitleasestdt[2] . "-" . $splitleasestdt[1] . "-" . $splitleasestdt[0];
        } else {
            $LeaseStartDate = "0000-00-00";
        }

        $txtLeaseEndDate = trim($data['txtLeaseEndDate']);
        $splitleaseenddt = explode('/', $txtLeaseEndDate);
        if (sizeof($splitleaseenddt) > 1) {
            $LeaseEndDate = $splitleaseenddt[2] . "-" . $splitleaseenddt[1] . "-" . $splitleaseenddt[0];
        } else {
            $LeaseEndDate = "0000-00-00";
        }

        $txtLeaseRenewalReminderDate = trim($data['txtLeaseRenewalReminderDate']);
        $splitleaseremdt = explode('/', $txtLeaseRenewalReminderDate);
        if (sizeof($splitleaseremdt) > 1) {
            $LeaseRenewalReminderDate = $splitleaseremdt[2] . "-" . $splitleaseremdt[1] . "-" . $splitleaseremdt[0];
        } else {
            $LeaseRenewalReminderDate = "0000-00-00";
        }

        $ReminderForRenewal = trim($data['txtReminderForRenewal']);

        $TermsAndConditions = trim($data['txtTermsAndConditions']);

        $txtPossessionDate = trim($data['txtPossessionDate']);

        $splitpossdt = explode('/', $txtPossessionDate);
        if (sizeof($splitpossdt) > 1) {
            $PossessionDate = $splitpossdt[2] . "-" . $splitpossdt[1] . "-" . $splitpossdt[0];
        } else {
            $PossessionDate = "0000-00-00";
        }

        $PossessionDone = trim($data['cmbPossessionDone']);

        $txtPaymentDate = trim($data['txtPaymentDate']);
        $splitpmtdt = explode('/', $txtPaymentDate);
        if (sizeof($splitpmtdt) > 1) {
            $PaymentDate = $splitpmtdt[2] . "-" . $splitpmtdt[1] . "-" . $splitpmtdt[0];
        } else {
            $PaymentDate = "0000-00-00";
        }

        $PaymentReceivedCompletely = trim($data['cmbPaymentReceivedCompletely']);

        $TaglineForWebsite = trim($data['txtTaglineForWebsite']);

        $txtDealDoneDate = trim($data['txtDealDoneDate']);
        $splitdealdonedt = explode('/', $txtDealDoneDate);
        if (sizeof($splitdealdonedt) > 1) {
            $DealDoneDate = $splitdealdonedt[2] . "-" . $splitdealdonedt[1] . "-" . $splitdealdonedt[0];
        } else {
            $DealDoneDate = "0000-00-00";
        }

        $Active = (int) trim($data['chkActive']);

        $addData = array(
            'dDealInitiateDate' => $InitiateDate,
            'iBranchId' => $BranchId,
            'iClientReqId' => $ClientReqId,
            'iRequirementId' => $RequirementId,
            'iClientPropId' => $ClientPropId,
            'iPropertyId' => $PropertyId,
            'dLeaseStartDate' => $LeaseStartDate,
            'dLeaseEndDate' => $LeaseEndDate,
            'dLeaseRenewalReminderDate' => $LeaseRenewalReminderDate,
            'cReminderForRenewal' => $ReminderForRenewal,
            'cTermsAndConditions' => $TermsAndConditions,
            'dPossessionDate' => $PossessionDate,
            'cPossessionDone' => $PossessionDone,
            'dPaymentDate' => $PaymentDate,
            'cPaymentReceivedCompletely' => $PaymentReceivedCompletely,
            'cTaglineForWebsite' => $TaglineForWebsite,
            'dDealDoneDate' => $DealDoneDate,
            'bActive' => $Active,
        );

        $insert = $this->db->insert('deal_initiate', $addData);

        if ($insert) {
            $deal_insert_id = $this->db->insert_id();

            $AttatchData = Array();
            $AttatchData['iDealInitiateId'] = trim($deal_insert_id);

            if (isset($data['hfAttachmentFileName']) && count($data['hfAttachmentFileName[]']) > 0) {
                foreach ($data['hfAttachmentFileName[]'] as $key => $item) {
                    if (isset($data['hfAttachmentFileName[]']) && !empty($data['hfAttachmentFileName[]'])) {
                        $AttatchData['cAttachmentTitle'] = $data['txtAtttachmentTitle[]'][$key];

                        $AttatchData['cAttachmentPath'] = $data['hfAttachmentFilePath[]'][$key];

                        $AttatchData['cAttachmentName'] = $data['hfAttachmentFileName[]'][$key];


                        $insertAttatchData = $this->db->insert('deal_attachments', $AttatchData);

                        if ($insertAttatchData) {
                            $saveflag = true;
                        }
                    }
                }
            } else {
                $saveflag = true;
            }
        }

        if ($saveflag == true) {
            if ($Active == '1') {
                $sql1 = "UPDATE requirement_master SET requirement_master.bActive=0 WHERE requirement_master.iRequirementId='" . $RequirementId . "'";
                $query1 = $this->db->query($sql1);

                $sql2 = "UPDATE property_master SET property_master.bActive=0 WHERE property_master.iPropertyId='" . $PropertyId . "'";
                $query2 = $this->db->query($sql2);
            }

            return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
        } else {
            return json_encode(Array("status" => "0", "msg" => ERROR_INSERT_MSG));
        }
    }

    function edit_deal_initiate($data) {
        $hfDealInitiateId = trim($data['hfDealInitiateId']);






        $txtInitiateDate = trim($data['txtInitiateDate']);
        $splitinitdt = explode('/', $txtInitiateDate);
        if (sizeof($splitinitdt) > 1) {
            $InitiateDate = $splitinitdt[2] . "-" . $splitinitdt[1] . "-" . $splitinitdt[0];
        } else {
            $InitiateDate = "0000-00-00";
        }

        $BranchId = (int) trim($data['cmbBranch']);

        $ClientReqId = (int) trim($data['cmbClientReq']);

        $RequirementId = (int) trim($data['cmbRequirement']);

        $ClientPropId = (int) trim($data['cmbClientProp']);

        $PropertyId = (int) trim($data['cmbProperty']);

        $txtLeaseStartDate = trim($data['txtLeaseStartDate']);
        $splitleasestdt = explode('/', $txtLeaseStartDate);
        if (sizeof($splitleasestdt) > 1) {
            $LeaseStartDate = $splitleasestdt[2] . "-" . $splitleasestdt[1] . "-" . $splitleasestdt[0];
        } else {
            $LeaseStartDate = "0000-00-00";
        }

        $txtLeaseEndDate = trim($data['txtLeaseEndDate']);
        $splitleaseenddt = explode('/', $txtLeaseEndDate);
        if (sizeof($splitleaseenddt) > 1) {
            $LeaseEndDate = $splitleaseenddt[2] . "-" . $splitleaseenddt[1] . "-" . $splitleaseenddt[0];
        } else {
            $LeaseEndDate = "0000-00-00";
        }

        $txtLeaseRenewalReminderDate = trim($data['txtLeaseRenewalReminderDate']);
        $splitleaseremdt = explode('/', $txtLeaseRenewalReminderDate);
        if (sizeof($splitleaseremdt) > 1) {
            $LeaseRenewalReminderDate = $splitleaseremdt[2] . "-" . $splitleaseremdt[1] . "-" . $splitleaseremdt[0];
        } else {
            $LeaseRenewalReminderDate = "0000-00-00";
        }

        $ReminderForRenewal = trim($data['txtReminderForRenewal']);

        $TermsAndConditions = trim($data['txtTermsAndConditions']);

        $txtPossessionDate = trim($data['txtPossessionDate']);
        $splitleaseremdt = explode('/', $txtPossessionDate);
        if (sizeof($splitleaseremdt) > 1) {
            $PossessionDate = $splitleaseremdt[2] . "-" . $splitleaseremdt[1] . "-" . $splitleaseremdt[0];
        } else {
            $PossessionDate = "0000-00-00";
        }

        $PossessionDone = trim($data['cmbPossessionDone']);

        $txtPaymentDate = trim($data['txtPaymentDate']);
        $splitpmtdt = explode('/', $txtPaymentDate);
        if (sizeof($splitpmtdt) > 1) {
            $PaymentDate = $splitpmtdt[2] . "-" . $splitpmtdt[1] . "-" . $splitpmtdt[0];
        } else {
            $PaymentDate = "0000-00-00";
        }

        $PaymentReceivedCompletely = trim($data['cmbPaymentReceivedCompletely']);

        $TaglineForWebsite = trim($data['txtTaglineForWebsite']);

        $txtDealDoneDate = trim($data['txtDealDoneDate']);
        $splitdealdonedt = explode('/', $txtDealDoneDate);
        if (sizeof($splitdealdonedt) > 1) {
            $DealDoneDate = $splitdealdonedt[2] . "-" . $splitdealdonedt[1] . "-" . $splitdealdonedt[0];
        } else {
            $DealDoneDate = "0000-00-00";
        }

        $Active = (int) trim($data['hfActive']);

        $editData = array(
            'dDealInitiateDate' => $InitiateDate,
            'iBranchId' => $BranchId,
            'iClientReqId' => $ClientReqId,
            'iRequirementId' => $RequirementId,
            'iClientPropId' => $ClientPropId,
            'iPropertyId' => $PropertyId,
            'dLeaseStartDate' => $LeaseStartDate,
            'dLeaseEndDate' => $LeaseEndDate,
            'dLeaseRenewalReminderDate' => $LeaseRenewalReminderDate,
            'cReminderForRenewal' => $ReminderForRenewal,
            'cTermsAndConditions' => $TermsAndConditions,
            'dPossessionDate' => $PossessionDate,
            'cPossessionDone' => $PossessionDone,
            'dPaymentDate' => $PaymentDate,
            'cPaymentReceivedCompletely' => $PaymentReceivedCompletely,
            'cTaglineForWebsite' => $TaglineForWebsite,
            'dDealDoneDate' => $DealDoneDate,
            'bActive' => $Active,
        );

        $this->db->where('iDealInitiateId', $hfDealInitiateId);
        $update = $this->db->update('deal_initiate', $editData);

        if ($update) {
            if ($Active == '1') {
                $sql1 = "UPDATE requirement_master SET requirement_master.bActive=0 WHERE requirement_master.iRequirementId='" . $RequirementId . "'";
                $query1 = $this->db->query($sql1);

                $sql2 = "UPDATE property_master SET property_master.bActive=0 WHERE property_master.iPropertyId='" . $PropertyId . "'";
                $query2 = $this->db->query($sql2);
            }

            return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
        } else {
            return json_encode(Array("status" => "0", "msg" => ERROR_UPDATE_MSG));
        }
    }

    function get_deal_attachments_by_id($id) {
        $this->db->where('iDealInitiateId', $id);
        $this->db->where('bDelete', '0');
        $query = $this->db->get('deal_attachments');

        if ($query) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

    function delete_deal_initiate($id) {
        $sql = "UPDATE deal_initiate SET deal_initiate.bDelete=1 WHERE deal_initiate.iDealInitiateId='" . $id . "'";

        $query = $this->db->query($sql);

        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    //----------------------------------------------------- Deals Lost ---------------------------------------------------------------------------------------

    function get_all_deal_lost() {
        $sql = "SELECT deal_lost.iDealLostId,deal_lost.dDate,
ca1.cClientName as ClientNameReq,
requirement_master.cRequirementTitle,
ca2.cClientName as ClientNameProp,
property_master.cPropertyName,
deal_lost.cSummaryOfDealLostReason,
deal_lost.dFollowUpDate,
deal_lost.bActive,
deal_lost.bDelete
FROM deal_lost
left join client_master ca1 on ca1.iClientId = deal_lost.iClientReqId
left join client_master ca2 on ca2.iClientId = deal_lost.iClientPropId
LEFT JOIN requirement_master ON deal_lost.iRequirementId=requirement_master.iRequirementId
LEFT JOIN property_master ON deal_lost.iPropertyId=property_master.iPropertyId
WHERE deal_lost.bDelete=0";

        $query = $this->db->query($sql);

        return $query;
    }

    function deal_lost_get_by_id($id) {
        $sql = "SELECT * FROM deal_lost WHERE deal_lost.iDealLostId='" . $id . "'";

        $query = $this->db->query($sql);

        if ($query) {
            $result = $query->row_array();

            return $result;
        }
    }

    function add_deal_lost($data) {
        //$UserId = trim($this->session->userdata('UserId'));

        $txtDate = trim($data['txtDate']);
        $splitdt = explode('/', $txtDate);
        $Date = $splitdt[2] . "-" . $splitdt[1] . "-" . $splitdt[0];

        $ClientReqId = trim($data['cmbClientReq']);

        $RequirementId = trim($data['cmbRequirement']);

        $ClientPropId = trim($data['cmbClientProp']);

        $PropertyId = trim($data['cmbProperty']);

        $SummaryOfDealLostReason = trim($data['txtSummaryOfDealLostReason']);

        $txtFollowUpDate = trim($data['txtFollowUpDate']);
        $splitfupdt = explode('/', $txtDate);
        $FollowUpDate = $splitfupdt[2] . "-" . $splitfupdt[1] . "-" . $splitfupdt[0];

        $addData = array(
            'dDate' => $Date,
            'iClientReqId' => $ClientReqId,
            'iRequirementId' => $RequirementId,
            'iClientPropId' => $ClientPropId,
            'iPropertyId' => $PropertyId,
            'cSummaryOfDealLostReason' => $SummaryOfDealLostReason,
            'dFollowUpDate' => $FollowUpDate,
        );

        $insert = $this->db->insert('deal_lost', $addData);

        if ($insert) {
            return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
        } else {
            return json_encode(Array("status" => "0", "msg" => ERROR_INSERT_MSG));
        }
    }

    function edit_deal_lost($data) {

        $hfDealLostId = trim($data['hfDealLostId']);

        //$UserId = trim($this->session->userdata('UserId'));

        $txtDate = trim($data['txtDate']);
        $splitdt = explode('/', $txtDate);
        $Date = $splitdt[2] . "-" . $splitdt[1] . "-" . $splitdt[0];

        $ClientReqId = trim($data['cmbClientReq']);

        $RequirementId = trim($data['cmbRequirement']);

        $ClientPropId = trim($data['cmbClientProp']);

        $PropertyId = trim($data['cmbProperty']);

        $SummaryOfDealLostReason = trim($data['txtDealSummaryLostReason']);

        $txtFollowUpDate = trim($data['txtFollowUpDate']);
        $splitdt = explode('/', $txtFollowUpDate);
        $FollowUpDate = $splitdt[2] . "-" . $splitdt[1] . "-" . $splitdt[0];



        $editData = array(
            'dDate' => $Date,
            'iClientReqId' => $ClientReqId,
            'iRequirementId' => $RequirementId,
            'iClientPropId' => $ClientPropId,
            'iPropertyId' => $PropertyId,
            'cSummaryOfDealLostReason' => $SummaryOfDealLostReason,
            'dFollowUpDate' => $FollowUpDate,
        );

        $this->db->where('iDealLostId', $hfDealLostId);
        $update = $this->db->update('deal_lost', $editData);

        if ($update) {
            return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
        } else {
            return json_encode(Array("status" => "0", "msg" => ERROR_UPDATE_MSG));
        }
    }

    function delete_deal_lost($id) {
        $sql = "UPDATE deal_lost SET deal_lost.bDelete=1 WHERE deal_lost.iDealLostId='" . $id . "'";

        $query = $this->db->query($sql);

        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    //-----------------------------------------------------Success Story--------------------------------------------------------------------------------------

    function get_all_success_story() {
        $sql = "SELECT success_story.iSuccessStoryId,CMLSR.cClientName as cLessorName,CMLSE.cClientName as cLesseeName,property_master.cPropertyName,success_story.cContent,CASE success_story.bActive WHEN 1 THEN 'Yes' ELSE 'No' END AS 'bActive'
		      FROM success_story LEFT JOIN property_master ON success_story.iPropertyId=property_master.iPropertyId LEFT JOIN client_master as CMLSR ON success_story.iLessorId=CMLSR.iClientId LEFT JOIN client_master as CMLSE ON success_story.iLesseeId=CMLSE.iClientId WHERE success_story.bDelete=0";

        $query = $this->db->query($sql);

        return $query;
    }

    function success_story_get_by_id($id) {
        $sql = "SELECT * FROM success_story WHERE success_story.iSuccessStoryId='" . $id . "'";

        $query = $this->db->query($sql);

        if ($query) {
            $result = $query->row_array();

            return $result;
        }
    }

    function add_success_story($data) {
        $PropertyId = trim($data['cmbProperty']);
        $LessorId = trim($data['cmbLessor']);
        $LesseeId = trim($data['cmbLessee']);
        $Content = trim($data['txtContent']);
        $Active = (int) trim($data['chkActive']);

        $addData = array(
            'iPropertyId' => $PropertyId,
            'iLessorId' => $LessorId,
            'iLesseeId' => $LesseeId,
            'cContent' => $Content,
            'bActive' => $Active,
        );

        $insert = $this->db->insert('success_story', $addData);

        if ($insert) {
            return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
        } else {
            return json_encode(Array("status" => "0", "msg" => ERROR_INSERT_MSG));
        }
    }

    function edit_success_story($data) {
        $hfSuccessStoryId = trim($data['hfSuccessStoryId']);

        $PropertyId = trim($data['cmbProperty']);
        $LessorId = trim($data['cmbLessor']);
        $LesseeId = trim($data['cmbLessee']);
        $Content = trim($data['txtContent']);
        $Active = trim($data['hfActive']);

        $editData = array(
            'iPropertyId' => $PropertyId,
            'iLessorId' => $LessorId,
            'iLesseeId' => $LesseeId,
            'cContent' => $Content,
            'bActive' => $Active,
        );

        $this->db->where('iSuccessStoryId', $hfSuccessStoryId);
        $update = $this->db->update('success_story', $editData);

        if ($update) {
            return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
        } else {
            return json_encode(Array("status" => "0", "msg" => ERROR_UPDATE_MSG));
        }
    }

    function delete_success_story($id) {
        $sql = "UPDATE success_story SET success_story.bDelete=1 WHERE success_story.iSuccessStoryId='" . $id . "'";

        $query = $this->db->query($sql);

        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    //-----------------------------------------------------Client Testimonial--------------------------------------------------------------------------------------

    function get_all_client_testimonial() {
        $sql = "SELECT client_testimonial.iClientTestimonialId,client_master.cClientName,client_testimonial.cTestimonialContent,CASE client_testimonial.bActive WHEN 1 THEN 'Yes' ELSE 'No' END AS 'bActive'
		      FROM client_testimonial LEFT JOIN client_master ON client_testimonial.iClientId=client_master.iClientId WHERE client_testimonial.bDelete=0";

        $query = $this->db->query($sql);

        return $query;
    }

    function client_testimonial_get_by_id($id) {
        $sql = "SELECT * FROM client_testimonial WHERE client_testimonial.iClientTestimonialId='" . $id . "'";

        $query = $this->db->query($sql);

        if ($query) {
            $result = $query->row_array();

            return $result;
        }
    }

    function add_client_testimonial($data) {
        $ClientId = trim($data['cmbClient']);
        $TestimonialContent = trim($data['txtTestimonialContent']);
        $Active = (int) trim($data['chkActive']);

        $addData = array(
            'iClientId' => $ClientId,
            'cTestimonialContent' => $TestimonialContent,
            'bActive' => $Active,
        );

        $insert = $this->db->insert('client_testimonial', $addData);

        if ($insert) {
            return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
        } else {
            return json_encode(Array("status" => "0", "msg" => ERROR_INSERT_MSG));
        }
    }

    function edit_client_testimonial($data) {
        $hfClientTestimonialId = trim($data['hfClientTestimonialId']);

        $ClientId = trim($data['cmbClient']);
        $TestimonialContent = trim($data['txtTestimonialContent']);
        $Active = trim($data['hfActive']);

        $editData = array(
            'iClientId' => $ClientId,
            'cTestimonialContent' => $TestimonialContent,
            'bActive' => $Active,
        );

        $this->db->where('iClientTestimonialId', $hfClientTestimonialId);
        $update = $this->db->update('client_testimonial', $editData);

        if ($update) {
            return json_encode(Array("status" => "1", "msg" => SUCCESS_INSERT_MSG));
        } else {
            return json_encode(Array("status" => "0", "msg" => ERROR_UPDATE_MSG));
        }
    }

    function delete_client_testimonial($id) {
        $sql = "UPDATE client_testimonial SET client_testimonial.bDelete=1 WHERE client_testimonial.iClientTestimonialId='" . $id . "'";

        $query = $this->db->query($sql);

        if ($query) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    //--------------------------------------------------------------------------------------------------------------------------------------------------------

    function client_history_print_report($ClientId) {
        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set default header data
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
        //$pdf->setFooterData(array(0,64,0), array(0,64,128)); 
        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once(dirname(__FILE__) . '/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        // ---------------------------------------------------------    
        // set default font subsetting mode
        $pdf->setFontSubsetting(true);

        // set font
        $pdf->SetFont('helvetica', '', 9);

        // add a page
        // $pdf->AddPage();
        //$pdf->AddPage('P', 'A4');
        $pdf->AddPage('L', 'A4');

        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        $sql1 = "SELECT cClientName FROM client_master WHERE iClientId='" . $ClientId . "'";
        $query1 = $this->db->query($sql1);
        if ($query1) {
            $row1 = $query1->row_array();
            $ClientName = trim($row1['cClientName']);
        }

        /* $sql = "SELECT dcr_summary.dDCRDate,user_master.cName,dcr_summary.cDCRRemarks,task_master.cTaskName,property_master.cPropertyName,client_master.cClientName,dcr_detail.cDCRSummary
          FROM dcr_detail LEFT JOIN dcr_summary ON dcr_detail.iDCRId=dcr_summary.iDCRId LEFT JOIN user_master ON dcr_summary.iUserId=user_master.iUserId
          LEFT JOIN task_master ON dcr_detail.iTaskId=task_master.iTaskId LEFT JOIN property_master ON dcr_detail.iPropertyId=property_master.iPropertyId
          LEFT JOIN client_master ON dcr_detail.iClientId=client_master.iClientId	WHERE dcr_detail.iClientId='".$ClientId."' AND dcr_detail.bDelete=0 ORDER BY dcr_summary.dDCRDate ASC"; */

        $sql = "SELECT dcr_summary.dDCRDate,user_master.cName,dcr_summary.cDCRRemarks,task_master.cTaskName,property_master.cPropertyName,requirement_master.cRequirementTitle,CMREQ.cClientName as cReqClientName,CMPROP.cClientName as cPropClientName,dcr_detail.cDCRSummary
				FROM dcr_detail LEFT JOIN dcr_summary ON dcr_detail.iDCRId=dcr_summary.iDCRId LEFT JOIN user_master ON dcr_summary.iUserId=user_master.iUserId LEFT JOIN task_master ON dcr_detail.iTaskId=task_master.iTaskId LEFT JOIN property_master ON dcr_detail.iPropertyId=property_master.iPropertyId LEFT JOIN requirement_master ON dcr_detail.iRequirementId=requirement_master.iRequirementId 
				LEFT JOIN client_master as CMREQ ON dcr_detail.iClientReqId=CMREQ.iClientId LEFT JOIN client_master as CMPROP ON dcr_detail.iClientPropId=CMPROP.iClientId WHERE (dcr_detail.iClientReqId='" . $ClientId . "' OR dcr_detail.iClientPropId='" . $ClientId . "')  AND dcr_detail.bDelete=0 ORDER BY dcr_summary.dDCRDate ASC";

        $query = $this->db->query($sql);

        $tbl = "";
        $tbl.="<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">";
        $tbl.="<tr>
				 <td colspan=\"9\" width=\"100%\" align=\"center\" style=\"text-align:center; font-size:40px;\"><strong>Client - $ClientName</strong></td>
			   </tr>";
        $tbl.="<tr>
				 <td colspan=\"9\">&nbsp;</td>
			   </tr>";

        $tbl.="<tr style=\"background-color:#CCCCCC;\">
				<td width=\"3%\" align=\"center\"><b>SNo.</b></td> 
				<td width=\"7%\" align=\"left\"><b>Date</b></td>
				<td width=\"10%\" align=\"left\"><b>Task Type</b></td>
				<td width=\"10%\" align=\"left\"><b>User</b></td>
				<td width=\"10%\" align=\"left\"><b>Req Client</b></td>
				<td width=\"15%\" align=\"left\"><b>Requirement</b></td>
				<td width=\"10%\" align=\"left\"><b>Prop Client</b></td>
				<td width=\"15%\" align=\"left\"><b>Property</b></td>
				<td width=\"20%\" align=\"left\"><b>Description</b></td>
			   </tr>
			   <tr>
				 <td colspan=\"9\">&nbsp;</td>
			   </tr>";

        if ($query) {
            if ($query->num_rows() > 0) {
                $PSR_RF = "";

                $SNo = 1;
                foreach ($query->result_array() as $row) {
                    if ($row['dDCRDate'] != '') {
                        $DCRDt = trim($row['dDCRDate']);
                        $splitdcrdt = explode('-', $DCRDt);
                        $DCRDate = $splitdcrdt[2] . "/" . $splitdcrdt[1] . "/" . $splitdcrdt[0];
                    } else {
                        $DCRDate = "0000-00-00";
                    }

                    if ($row['cName'] != '') {
                        $Name = trim($row['cName']);
                    } else {
                        $Name = "";
                    }

                    if ($row['cTaskName'] != '') {
                        $TaskName = trim($row['cTaskName']);
                    } else {
                        $TaskName = "";
                    }

                    if ($row['cReqClientName'] != '') {
                        $ReqClientName = trim($row['cReqClientName']);
                    } else {
                        $ReqClientName = "";
                    }

                    if ($row['cRequirementTitle'] != '') {
                        $RequirementTitle = trim($row['cRequirementTitle']);
                    } else {
                        $RequirementTitle = "NA";
                    }

                    if ($row['cPropClientName'] != '') {
                        $PropClientName = trim($row['cPropClientName']);
                    } else {
                        $PropClientName = "";
                    }

                    if ($row['cPropertyName'] != '') {
                        $PropertyName = trim($row['cPropertyName']);
                    } else {
                        $PropertyName = "NA";
                    }

                    if ($row['cDCRSummary'] != '') {
                        $DCRSummary = trim($row['cDCRSummary']);
                    } else {
                        $DCRSummary = "";
                    }

                    $tbl.="<tr>";
                    $tbl.="<td align=\"center\">" . $SNo . ".</td>";
                    $tbl.="<td align=\"left\">" . $DCRDate . "</td>";
                    $tbl.="<td align=\"left\">" . $TaskName . "</td>";
                    $tbl.="<td align=\"left\">" . $Name . "</td>";
                    $tbl.="<td align=\"left\">" . $ReqClientName . "</td>";
                    $tbl.="<td align=\"left\">" . $RequirementTitle . "</td>";
                    $tbl.="<td align=\"left\">" . $PropClientName . "</td>";
                    $tbl.="<td align=\"left\">" . $PropertyName . "</td>";
                    $tbl.="<td align=\"left\">" . $DCRSummary . "</td>";
                    $tbl.="</tr>
							<tr>
								<td colspan=\"9\">&nbsp;</td>
							</tr>";

                    $SNo++;
                }
            } else {
                $tbl.="<tr>";
                $tbl.="<td colspan=\"9\" align=\"center\" style=\"font-size:40px;\">No result found</td>";
                $tbl.="</tr>";
            }
        }

        $tbl.="</table>";

        $pdf->writeHTML($tbl, true, false, false, false, '');

        //Close and output PDF document
        return $pdf->Output('client_history_report.pdf', 'I');

        //============================================================+
        // END OF FILE
        //============================================================+	
    }

    //--------------------------------------------------------------------------------------------------------------------------------------------------------

    function property_history_print_report($PropertyId) {
        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set default header data
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
        //$pdf->setFooterData(array(0,64,0), array(0,64,128)); 
        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once(dirname(__FILE__) . '/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        // ---------------------------------------------------------    
        // set default font subsetting mode
        $pdf->setFontSubsetting(true);

        // set font
        $pdf->SetFont('helvetica', '', 9);

        // add a page
        // $pdf->AddPage();
        //$pdf->AddPage('P', 'A4');
        $pdf->AddPage('L', 'A4');

        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        $sql1 = "SELECT property_master.dDate as dPropAddedOnDate,property_master.cPropertyName FROM property_master WHERE iPropertyId='" . $PropertyId . "'";
        $query1 = $this->db->query($sql1);
        if ($query1) {
            $row1 = $query1->row_array();
            $PropertyName = trim($row1['cPropertyName']);

            if ($row1['dPropAddedOnDate'] != '') {
                $PropAddedOnDt = trim($row1['dPropAddedOnDate']);
                $splitaddedondt = explode('-', $PropAddedOnDt);
                $PropAddedOnDate = $splitaddedondt[2] . "/" . $splitaddedondt[1] . "/" . $splitaddedondt[0];
            } else {
                $PropAddedOnDate = "0000-00-00";
            }
        }

        /* $sql = "SELECT dcr_summary.dDCRDate,user_master.cName,dcr_summary.cDCRRemarks,task_master.cTaskName,property_master.cPropertyName,client_master.cClientName,dcr_detail.cDCRSummary
          FROM dcr_detail LEFT JOIN dcr_summary ON dcr_detail.iDCRId=dcr_summary.iDCRId LEFT JOIN user_master ON dcr_summary.iUserId=user_master.iUserId LEFT JOIN task_master ON dcr_detail.iTaskId=task_master.iTaskId LEFT JOIN property_master ON dcr_detail.iPropertyId=property_master.iPropertyId
          LEFT JOIN client_master ON dcr_detail.iClientId=client_master.iClientId	WHERE dcr_detail.iPropertyId='".$PropertyId."' AND dcr_detail.bDelete=0 ORDER BY dcr_summary.dDCRDate ASC"; */

        $sql = "SELECT dcr_summary.dDCRDate,user_master.cName,dcr_summary.cDCRRemarks,task_master.cTaskName,requirement_master.cRequirementTitle,property_master.cPropertyName,CMREQ.cClientName as cReqClientName,CMPROP.cClientName as cPropClientName,dcr_detail.iPropertyId,dcr_detail.cDCRSummary
				FROM dcr_detail LEFT JOIN dcr_summary ON dcr_detail.iDCRId=dcr_summary.iDCRId LEFT JOIN user_master ON dcr_summary.iUserId=user_master.iUserId LEFT JOIN task_master ON dcr_detail.iTaskId=task_master.iTaskId LEFT JOIN requirement_master ON dcr_detail.iRequirementId=requirement_master.iRequirementId LEFT JOIN property_master ON dcr_detail.iPropertyId=property_master.iPropertyId
				LEFT JOIN client_master as CMREQ ON dcr_detail.iClientReqId=CMREQ.iClientId LEFT JOIN client_master as CMPROP ON dcr_detail.iClientPropId=CMPROP.iClientId WHERE dcr_detail.iPropertyId='" . $PropertyId . "' AND dcr_detail.bDelete=0 ORDER BY dcr_summary.dDCRDate ASC";

        $query = $this->db->query($sql);

        $tbl = "";
        $tbl.="<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">";
        $tbl.="<tr>
				 <td colspan=\"9\" width=\"100%\" align=\"center\" style=\"text-align:center; font-size:40px;\"><strong>Property - $PropertyName</strong></td>
			   </tr>";
        $tbl.="<tr>
				 <td colspan=\"9\" width=\"100%\" align=\"center\" style=\"text-align:center; font-size:36px;\">(Added on Date - <strong>$PropAddedOnDate</strong>)</td>
			   </tr>";
        $tbl.="<tr>
				 <td colspan=\"9\">&nbsp;</td>
			   </tr>";

        $tbl.="<tr style=\"background-color:#CCCCCC;\">
				<td width=\"3%\" align=\"center\"><b>SNo.</b></td> 
				<td width=\"7%\" align=\"left\"><b>Date</b></td>
				<td width=\"10%\" align=\"left\"><b>Task Type</b></td>
				<td width=\"10%\" align=\"left\"><b>User</b></td>
				<td width=\"10%\" align=\"left\"><b>Req Client</b></td>
				<td width=\"15%\" align=\"left\"><b>Requirement</b></td>
				<td width=\"10%\" align=\"left\"><b>Prop Client</b></td>
				<td width=\"15%\" align=\"left\"><b>Property</b></td>
				<td width=\"20%\" align=\"left\"><b>Description</b></td>
			   </tr>
			   <tr>
				 <td colspan=\"9\">&nbsp;</td>
			   </tr>";

        if ($query) {
            if ($query->num_rows() > 0) {
                $SNo = 1;
                foreach ($query->result_array() as $row) {
                    if ($row['dDCRDate'] != '') {
                        $DCRDt = trim($row['dDCRDate']);
                        $splitdcrdt = explode('-', $DCRDt);
                        $DCRDate = $splitdcrdt[2] . "/" . $splitdcrdt[1] . "/" . $splitdcrdt[0];
                    } else {
                        $DCRDate = "0000-00-00";
                    }

                    if ($row['cName'] != '') {
                        $Name = trim($row['cName']);
                    } else {
                        $Name = "";
                    }

                    if ($row['cTaskName'] != '') {
                        $TaskName = trim($row['cTaskName']);
                    } else {
                        $TaskName = "";
                    }

                    if ($row['cReqClientName'] != '') {
                        $ReqClientName = trim($row['cReqClientName']);
                    } else {
                        $ReqClientName = "";
                    }

                    if ($row['cRequirementTitle'] != '') {
                        $RequirementTitle = trim($row['cRequirementTitle']);
                    } else {
                        $RequirementTitle = "NA";
                    }

                    if ($row['cPropClientName'] != '') {
                        $PropClientName = trim($row['cPropClientName']);
                    } else {
                        $PropClientName = "";
                    }

                    if ($row['cPropertyName'] != '') {
                        $PropertyName = trim($row['cPropertyName']);
                    } else {
                        $PropertyName = "NA";
                    }

                    if ($row['cDCRSummary'] != '') {
                        $DCRSummary = trim($row['cDCRSummary']);
                    } else {
                        $DCRSummary = "";
                    }

                    $tbl.="<tr>";
                    $tbl.="<td align=\"center\">" . $SNo . ".</td>";
                    $tbl.="<td align=\"left\">" . $DCRDate . "</td>";
                    $tbl.="<td align=\"left\">" . $TaskName . "</td>";
                    $tbl.="<td align=\"left\">" . $Name . "</td>";
                    $tbl.="<td align=\"left\">" . $ReqClientName . "</td>";
                    $tbl.="<td align=\"left\">" . $RequirementTitle . "</td>";
                    $tbl.="<td align=\"left\">" . $PropClientName . "</td>";
                    $tbl.="<td align=\"left\">" . $PropertyName . "</td>";
                    $tbl.="<td align=\"left\">" . $DCRSummary . "</td>";
                    $tbl.="</tr>
							<tr>
								<td colspan=\"9\">&nbsp;</td>
							</tr>";

                    $SNo++;
                }
            } else {
                $tbl.="<tr>";
                $tbl.="<td colspan=\"9\" align=\"center\" style=\"font-size:40px;\">No result found</td>";
                $tbl.="</tr>";
            }
        }

        $tbl.="</table>";

        $pdf->writeHTML($tbl, true, false, false, false, '');

        //Close and output PDF document
        return $pdf->Output('property_history_report.pdf', 'I');

        //============================================================+
        // END OF FILE
        //============================================================+	
    }

    //--------------------------------------------------------------------------------------------------------------------------------------------------------

    function property_delivery_print_report($PropertyId) {
        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set default header data
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
        //$pdf->setFooterData(array(0,64,0), array(0,64,128)); 
//		$PDF_HEADER_LOGO_WIDTH = "35";

        $PDF_HEADER_TITLE = "";

        $PDF_HEADER_STRING = "";

//		$pdf->SetHeaderData(PDF_HEADER_LOGO, $PDF_HEADER_LOGO_WIDTH, $PDF_HEADER_TITLE, $PDF_HEADER_STRING);
        $pdf->SetHeaderData($PDF_HEADER_TITLE, $PDF_HEADER_STRING);

        // default PDF_HEADER_LOGO & default K_PATH_IMAGES constants has been commented in side the file 'application/libraries/tcpdf/tcpdf_config.php'. 
        // & again redefined in side the file 'application/libraries/Pdf.php' for our custom Header Logo display purpose.
        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        
        $pdf->setPrintHeader(false);
        
        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once(dirname(__FILE__) . '/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        // ---------------------------------------------------------    
        // set default font subsetting mode
        $pdf->setFontSubsetting(true);

        // set font
        $pdf->SetFont('helvetica', '', 11);
        $AttachmentRows = array();

        // add a page
        // $pdf->AddPage();
        // $pdf->AddPage('L', 'A4');

        $pdf->AddPage('P', 'A4');

        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        $sql = "SELECT property_master.*,client_master.cContactPerson1Name,client_master.cContactPerson1Designation,client_master.cContactPerson1PhoneNo1,client_master.cContactPerson1Email,client_master.cClientName,branch_master.cBranchName,state_master.cStateName,district_master.cDistrictName,city_master.cCityName,location_master.cLocationName,property_master.cPropertyAddress,property_master.cPropertyAddress,source_master.cSourceName,property_category_master.cPropertyCategoryName,property_type_master.cPropertyTypeName,property_status_master.cPropertyStatusName,property_master.cPropertyPurpose,property_master.cPropertyLegalStatus,property_master.cSurroundingBrands,property_master.cTotalPlotArea,property_master.cBuildingArea,property_master.iNoOfFloorsInBuilding,property_master.cGroundCoverage,property_master.cFloorOffered,property_master.cPlateAreaOfFloorOffered,property_master.cToilet,property_master.cParking,property_master.cCarpetArea,property_master.cBuiltUpArea,property_master.cSuperBuiltUpArea,property_master.cFrontage,property_master.cDepth,property_master.cHeight,agreement_type_master.cAgreementTypeName,property_master.cDemandPerSqFeet,property_master.cDemandGross,property_master.cSecurityDeposit,escalation_master.cEscalationName,property_master.cPowerLoad,property_master.cPowerBackup,property_master.cPowerBackup
		        FROM property_master LEFT JOIN client_master ON property_master.iClientId=client_master.iClientId LEFT JOIN branch_master ON property_master.iBranchId=branch_master.iBranchId LEFT JOIN state_master ON property_master.iStateId=state_master.iStateId LEFT JOIN district_master ON property_master.iDistrictId=district_master.iDistrictId LEFT JOIN city_master ON property_master.iCityId=city_master.iCityId LEFT JOIN location_master ON property_master.iLocationId=location_master.iLocationId 
				LEFT JOIN source_master ON property_master.iSourceId=source_master.iSourceId LEFT JOIN property_category_master ON property_master.iPropertyCategoryId=property_category_master.iPropertyCategoryId LEFT JOIN property_type_master ON property_master.iPropertyTypeId=property_type_master.iPropertyTypeId LEFT JOIN property_status_master ON property_master.iPropertyStatusId=property_status_master.iPropertyStatusId LEFT JOIN agreement_type_master ON property_master.iAgreementTypeId=agreement_type_master.iAgreementTypeId 
				LEFT JOIN escalation_master ON property_master.iEscalationId=escalation_master.iEscalationId WHERE property_master.iPropertyId='" . $PropertyId . "'";

        $query = $this->db->query($sql);
        
        
        
        
        
        
        $logourl = base_url().'images/linkers-india-logo.jpg';        
        /*$logourl = base_url().'images/linkers-india-logo.jpg';        
        $pdf->Image($logourl, 88, $pdf->gety(), 25, 20, $type = '', $link = '', $align = '', $resize = false, $dpi = 200, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false, $alt = false, $altimgs = array());
        $pdf->ln(23);
        
        $pdf->SetFont('helvetica', 'B', 15);
        $pdf->Cell(0, 5, "Linkers India", $border = 0, $ln = 1, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');

        $pdf->ln(2);
        
        $pdf->SetFont('helvetica', 'B', 15);
        $pdf->Cell(0, 5, "Property Proposal", $border = 0, $ln = 1, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');

        $pdf->ln(5);
        */
        
        
$AttachmentTitle11 = '';
        
$AttachmentTitle33 = 'Property Proposal';
           //     $pdf->MultiCell(330, 50, $Linkerindia
             //           , $border = 0, $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = true, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
                

               // $pdf->ln(20);
                
                


                $AttachmentTitles22 = wordwrap($AttachmentTitle11, 13, "<br>\n", TRUE);
                $pdf->Image($logourl, 18, $pdf->gety(), 30, 20, $type = '', $link = '', $align = '', $resize = false, $dpi = 200, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false, $alt = false, $altimgs = array());
                //$pdf->Cell(20, 5, "", $border = 0, $ln = 0, $align = '', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                // $pdf->M(20, 60, $SNo . ") " . $AttachmentTitles, $border = 0, $ln = 1, $align = '', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                $pdf->SetFont('helvetica', 'B', 15);
                $pdf->MultiCell(60, 5, $AttachmentTitles22.$AttachmentTitle33
                        , $border = 0, $align = 'L', $fill = false, $ln = 1, $x = '75', $y = '', $reseth = true, $stretch = 0, $ishtml = true, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
                $pdf->ln(18);
        

        if ($query) {
            if ($query->num_rows() > 0) {
                $AttachmentRows = $this->get_property_attachments_by_id($PropertyId);

                $row = $query->row_array();


//                echo '<pre>';
//                print_r($row);
//                echo '</pre>';die;

                if (!empty($row['dDate']) && $row['dDate'] != '0000-00-00') {
                    $splitdt = explode('-', $row['dDate']);
                    $Date = $splitdt[1] . "/" . $splitdt[2] . "/" . $splitdt[0];
                } else {
                    $Date = "0000-00-00";
                }

                /* New code */
                if (!empty($row['cPropertyName'])) {
                    $cPropertyName = trim($row['cPropertyName']);
                } else {
                    $cPropertyName = "";
                }

                if (!empty($row['cClientName'])) {
                    $cClientName = trim($row['cClientName']);
                } else {
                    $cClientName = "";
                }


                if (!empty($row['cContactPerson1Name'])) {
                    $cContactPerson1Name = trim($row['cContactPerson1Name']);
                } else {
                    $cContactPerson1Name = "";
                }

                if (!empty($row['cContactPerson1Designation'])) {
                    $cContactPerson1Designation = trim($row['cContactPerson1Designation']);
                } else {
                    $cContactPerson1Designation = "";
                }


                if (!empty($row['cContactPerson1PhoneNo1'])) {
                    $cContactPerson1PhoneNo1 = trim($row['cContactPerson1PhoneNo1']);
                } else {
                    $cContactPerson1PhoneNo1 = "";
                }


                if (!empty($row['cContactPerson1Email'])) {
                    $cContactPerson1Email = trim($row['cContactPerson1Email']);
                } else {
                    $cContactPerson1Email = "";
                }


                if (!empty($row['cBranchName'])) {
                    $cBranchName = trim($row['cBranchName']);
                } else {
                    $cBranchName = "";
                }



                if (!empty($row['cSourceName'])) {
                    $cSourceName = trim($row['cSourceName']);
                } else {
                    $cSourceName = "";
                }


                if (!empty($row['cPropertyTypeName'])) {
                    $cPropertyTypeName = trim($row['cPropertyTypeName']);
                } else {
                    $cPropertyTypeName = "";
                }

                if (!empty($row['cPropertyCategoryName'])) {
                    $cPropertyCategoryName = trim($row['cPropertyCategoryName']);
                } else {
                    $cPropertyCategoryName = "";
                }


                if (!empty($row['cPropertyTypeName'])) {
                    $cPropertyTypeName = trim($row['cPropertyTypeName']);
                } else {
                    $cPropertyTypeName = "";
                }


                if (!empty($row['cPropertyStatusName'])) {
                    $cPropertyStatusName = trim($row['cPropertyStatusName']);
                } else {
                    $cPropertyStatusName = "";
                }


                if (!empty($row['cSurroundingBrands'])) {
                    $cSurroundingBrands = trim($row['cSurroundingBrands']);
                } else {
                    $cSurroundingBrands = "";
                }


                if (!empty($row['cPropertyTaglineForWebsite'])) {
                    $cPropertyTaglineForWebsite = trim($row['cPropertyTaglineForWebsite']);
                } else {
                    $cPropertyTaglineForWebsite = "";
                }

                if (!empty($row['cPropertyRemarks'])) {
                    $cPropertyRemarks = trim($row['cPropertyRemarks']);
                } else {
                    $cPropertyRemarks = "";
                }

                if (!empty($row['cPropertyAddress'])) {
                    $cPropertyAddress = trim($row['cPropertyAddress']);
                } else {
                    $cPropertyAddress = "";
                }


                if (!empty($row['cPropertyPurpose'])) {
                    $cPropertyPurpose = trim($row['cPropertyPurpose']);
                } else {
                    $cPropertyPurpose = "";
                }

                if (!empty($row['cPropertyLegalStatus'])) {
                    $cPropertyLegalStatus = trim($row['cPropertyLegalStatus']);
                } else {
                    $cPropertyLegalStatus = "";
                }


                /* New Code End */



                if (!empty($row['cStateName'])) {
                    $StateName = trim($row['cStateName']);
                } else {
                    $StateName = "";
                }

                if (!empty($row['cDistrictName'])) {
                    $DistrictName = trim($row['cDistrictName']);
                } else {
                    $DistrictName = "";
                }

                if (!empty($row['cCityName'])) {
                    $CityName = trim($row['cCityName']);
                } else {
                    $CityName = "";
                }

                if (!empty($row['cLocationName'])) {
                    $LocationName = trim($row['cLocationName']);
                } else {
                    $LocationName = "";
                }

                if (!empty($row['cPropertyCategoryName'])) {
                    $PropertyCategoryName = trim($row['cPropertyCategoryName']);
                } else {
                    $PropertyCategoryName = "";
                }

                if (!empty($row['cPropertyPurpose'])) {
                    $PropertyPurpose = trim($row['cPropertyPurpose']);
                } else {
                    $PropertyPurpose = "";
                }

                if (!empty($row['cTotalPlotArea'])) {
                    $TotalPlotArea = trim($row['cTotalPlotArea']);
                } else {
                    $TotalPlotArea = "";
                }

                if (!empty($row['cBuildingArea'])) {
                    $BuildingArea = trim($row['cBuildingArea']);
                } else {
                    $BuildingArea = "";
                }

                if (!empty($row['iNoOfFloorsInBuilding'])) {
                    $NoOfFloorsInBuilding = trim($row['iNoOfFloorsInBuilding']);
                } else {
                    $NoOfFloorsInBuilding = "";
                }

                if (!empty($row['cFloorOffered'])) {
                    $FloorOffered = trim($row['cFloorOffered']);
                } else {
                    $FloorOffered = "";
                }

                if (!empty($row['cPlateAreaOfFloorOffered'])) {
                    $PlateAreaOfFloorOffered = trim($row['cPlateAreaOfFloorOffered']);
                } else {
                    $PlateAreaOfFloorOffered = "";
                }

                if (!empty($row['cGroundCoverage'])) {
                    $GroundCoverage = trim($row['cGroundCoverage']);
                } else {
                    $GroundCoverage = "";
                }

                if (!empty($row['cCarpetArea'])) {
                    $CarpetArea = trim($row['cCarpetArea']);
                } else {
                    $CarpetArea = "";
                }

                if (!empty($row['cBuiltUpArea'])) {
                    $BuiltUpArea = trim($row['cBuiltUpArea']);
                } else {
                    $BuiltUpArea = "";
                }

                if (!empty($row['cSuperBuiltUpArea'])) {
                    $SuperBuiltUpArea = trim($row['cSuperBuiltUpArea']);
                } else {
                    $SuperBuiltUpArea = "";
                }

                if (!empty($row['cFrontage'])) {
                    $Frontage = trim($row['cFrontage']);
                } else {
                    $Frontage = "";
                }

                if (!empty($row['cDepth'])) {
                    $Depth = trim($row['cDepth']);
                } else {
                    $Depth = "";
                }

                if (!empty($row['cHeight'])) {
                    $Height = trim($row['cHeight']);
                } else {
                    $Height = "";
                }

                if (!empty($row['cToilet'])) {
                    $Toilet = trim($row['cToilet']);
                } else {
                    $Toilet = "";
                }

                if (!empty($row['cParking'])) {
                    $Parking = trim($row['cParking']);
                } else {
                    $Parking = "";
                }

                if (!empty($row['cPowerLoad'])) {
                    $PowerLoad = trim($row['cPowerLoad']);
                } else {
                    $PowerLoad = "";
                }

                if (!empty($row['cPowerBackup'])) {
                    $PowerBackup = trim($row['cPowerBackup']);
                } else {
                    $PowerBackup = "";
                }

                if (!empty($row['cSurroundingBrands'])) {
                    $SurroundingBrands = trim($row['cSurroundingBrands']);
                } else {
                    $SurroundingBrands = "";
                }

                if (!empty($row['cAgreementTypeName'])) {
                    $AgreementTypeName = trim($row['cAgreementTypeName']);
                } else {
                    $AgreementTypeName = "";
                }

                if (!empty($row['cDemandPerSqFeet'])) {
                    $DemandPerSqFeet = trim($row['cDemandPerSqFeet']);
                } else {
                    $DemandPerSqFeet = "";
                }

                if (!empty($row['cDemandGross'])) {
                    $DemandGross = trim($row['cDemandGross']);
                } else {
                    $DemandGross = "";
                }

                if (!empty($row['cCAM'])) {
                    $CAM = trim($row['cCAM']);
                } else {
                    $CAM = "";
                }


                if (!empty($cPropertyName)) {
                    $pdf->SetFont('helvetica', 'B', 11);
                    $pdf->Cell(60, 5, "Property Name :", $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                    $pdf->SetFont('helvetica', '', 11);
                    $pdf->MultiCell(130, 5, $cPropertyName
                            , $border = 0, $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
                    $pdf->ln(1);
                }


               /* if (!empty($Date)) {
                    $pdf->Cell(60, 5, "Date :", $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                    $pdf->MultiCell(130, 5, $Date
                            , $border = 0, $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
                    $pdf->ln(1);
                }*/

//                if (!empty($cClientName)) {
//                    //$pdf->SetFont('helvetica', 'B', 11);
//                    $pdf->Cell(60, 5, "Client Name :", $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
//                    //$pdf->SetFont('helvetica', '', 11);
//                    $pdf->MultiCell(130, 5, $cClientName
//                            , $border = 0, $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
//                    $pdf->ln(1);
//                }


                if (!empty($LocationName)) {
                    $pdf->SetFont('helvetica', 'B', 11);
                    $pdf->Cell(60, 5, "Property Location :", $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                    $pdf->SetFont('helvetica', '', 11);
                    $pdf->MultiCell(130, 5, $LocationName . ", " . $CityName . ", " . $StateName
                            , $border = 0, $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
                    $pdf->ln(1);
                }



                /*if (!empty($cContactPerson1Name)) {
                    $pdf->Cell(60, 5, "Contact Person :", $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                    $pdf->MultiCell(130, 5, $cContactPerson1Name
                            , $border = 0, $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
                    $pdf->ln(1);
                }
                
                if (!empty($cContactPerson1Designation)) {
                $pdf->Cell(60, 5, "Designation :", $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                $pdf->MultiCell(130, 5, $cContactPerson1Designation
                        , $border = 0, $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
                $pdf->ln(1);
                }
                
                if (!empty($cContactPerson1PhoneNo1)) {
                $pdf->Cell(60, 5, "Phone No. :", $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                $pdf->MultiCell(130, 5, $cContactPerson1PhoneNo1
                        , $border = 0, $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
                $pdf->ln(1);
                }
                
                if (!empty($cContactPerson1Email)) {
                $pdf->Cell(60, 5, "Email :", $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                $pdf->MultiCell(130, 5, $cContactPerson1Email
                        , $border = 0, $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
                $pdf->ln(1);
                }
                
                if (!empty($cBranchName)) {
                $pdf->Cell(60, 5, "Branch Name :", $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                $pdf->MultiCell(130, 5, $cBranchName
                        , $border = 0, $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
                $pdf->ln(1);
                }*/
                
                if (!empty($cPropertyAddress)) {
                $pdf->Cell(60, 5, "Address :", $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                $pdf->MultiCell(130, 5, $cPropertyAddress
                        , $border = 0, $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
                $pdf->ln(1);
                }



                /*if (!empty($cSourceName)) {
                $pdf->Cell(60, 5, "Source :", $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                $pdf->MultiCell(130, 5, $cSourceName
                        , $border = 0, $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
                $pdf->ln(1);
                }*/

                if (!empty($cPropertyCategoryName)) {
                $pdf->Cell(60, 5, "Category :", $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                $pdf->MultiCell(130, 5, $cPropertyCategoryName
                        , $border = 0, $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
                $pdf->ln(1);
                }

                if (!empty($cPropertyTypeName)) {
                $pdf->Cell(60, 5, "Type :", $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                $pdf->MultiCell(130, 5, $cPropertyTypeName
                        , $border = 0, $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
                $pdf->ln(1);
                }
                
                if (!empty($cPropertyStatusName)) {
                $pdf->Cell(60, 5, "Status :", $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                $pdf->MultiCell(130, 5, $cPropertyStatusName
                        , $border = 0, $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
                $pdf->ln(1);
                }

                if (!empty($cPropertyPurpose)) {
                $pdf->Cell(60, 5, "Purpose :", $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                $pdf->MultiCell(130, 5, $cPropertyPurpose
                        , $border = 0, $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
                $pdf->ln(1);
                }
                
                if (!empty($cPropertyLegalStatus)) {
                $pdf->Cell(60, 5, "Legal Status :", $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                $pdf->MultiCell(130, 5, $cPropertyLegalStatus
                        , $border = 0, $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
                $pdf->ln(1);
                }

                if (!empty($cSurroundingBrands)) {
                $pdf->Cell(60, 5, "Brands :", $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                $pdf->MultiCell(130, 5, $cSurroundingBrands
                        , $border = 0, $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
                $pdf->ln(1);
                }

                if (!empty($cPropertyTaglineForWebsite)) {
                $pdf->Cell(60, 5, "Tagline :", $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                $pdf->MultiCell(130, 5, $cPropertyTaglineForWebsite
                        , $border = 0, $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
                $pdf->ln(1);
                }

                if (!empty($cPropertyRemarks)) {
                $pdf->Cell(60, 5, "Remarks :", $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                $pdf->MultiCell(130, 5, $cPropertyRemarks
                        , $border = 0, $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
                $pdf->ln(1);
                }

                //if (!empty($cPropertyRemarks)) {
                $pdf->SetFont('helvetica', 'B', 11);
                $pdf->Cell(60, 5, "Description :", $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                $pdf->SetFont('helvetica', '', 11);
                //}
                
                //if (!empty($PropertyCategoryName)) {
                $pdf->MultiCell(130, 5, $PropertyCategoryName . " for " . $PropertyPurpose . " with following specifications:"
                        , $border = 0, $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
                $pdf->ln(1);
               // }
                
                if (!empty($TotalPlotArea)) {
                    $pdf->Cell(60, 5, "Total Plot Area :", $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                    $pdf->MultiCell(130, 5, $TotalPlotArea
                            , $border = 0, $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
                    $pdf->ln(1);
                }

                if (!empty($BuildingArea)) {
                    $pdf->Cell(60, 5, "Total Building Area :", $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                    $pdf->MultiCell(130, 5, $BuildingArea
                            , $border = 0, $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
                    $pdf->ln(1);
                }

                if (!empty($NoOfFloorsInBuilding)) {
                    $pdf->Cell(60, 5, "No. of Floors in Building :", $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                    $pdf->MultiCell(130, 5, $NoOfFloorsInBuilding
                            , $border = 0, $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
                    $pdf->ln(1);
                }


                if (!empty($GroundCoverage)) {
                    $pdf->Cell(60, 5, "Ground Coverage :", $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                    $pdf->MultiCell(130, 5, $GroundCoverage
                            , $border = 0, $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
                    $pdf->ln(1);
                }


                if (!empty($FloorOffered)) {
                    $pdf->Cell(60, 5, "Floor Offered :", $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                    $pdf->MultiCell(130, 5, $FloorOffered
                            , $border = 0, $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
                    $pdf->ln(1);
                }

                if (!empty($PlateAreaOfFloorOffered)) {
                    $pdf->Cell(60, 5, "Plate Area of Floor Offered :", $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                    $pdf->MultiCell(130, 5, $PlateAreaOfFloorOffered
                            , $border = 0, $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
                    $pdf->ln(1);
                }

                if (!empty($Toilet)) {
                    $pdf->Cell(60, 5, "Toilet Available :", $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                    $pdf->MultiCell(130, 5, $Toilet
                            , $border = 0, $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
                    $pdf->ln(1);
                }

                if (!empty($Parking)) {
                    $pdf->Cell(60, 5, "Parking Available :", $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                    $pdf->MultiCell(130, 5, $Parking
                            , $border = 0, $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
                    $pdf->ln(1);
                }



                if (!empty($CarpetArea)) {
                    $pdf->Cell(60, 5, "Carpet Area :", $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                    $pdf->MultiCell(130, 5, $CarpetArea
                            , $border = 0, $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
                    $pdf->ln(1);
                }

                if (!empty($BuiltUpArea)) {
                    $pdf->Cell(60, 5, "Built-Up Area :", $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                    $pdf->MultiCell(130, 5, $BuiltUpArea
                            , $border = 0, $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
                    $pdf->ln(1);
                }

                if (!empty($SuperBuiltUpArea)) {
                    $pdf->Cell(60, 5, "Super Built-Up Area :", $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                    $pdf->MultiCell(130, 5, $SuperBuiltUpArea
                            , $border = 0, $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
                    $pdf->ln(1);
                }


                if (!empty($Frontage)) {
                    $pdf->Cell(60, 5, "Frontage :", $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                    $pdf->MultiCell(130, 5, $Frontage
                            , $border = 0, $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
                    $pdf->ln(1);
                }

                if (!empty($Depth)) {
                    $pdf->Cell(60, 5, "Depth :", $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                    $pdf->MultiCell(130, 5, $Depth
                            , $border = 0, $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
                    $pdf->ln(1);
                }

                if (!empty($Height)) {
                    $pdf->Cell(60, 5, "Height :", $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                    $pdf->MultiCell(130, 5, $Height
                            , $border = 0, $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
                    $pdf->ln(1);
                }



                if (!empty($PowerLoad)) {
                    $pdf->Cell(60, 5, "Power Load :", $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                    $pdf->MultiCell(130, 5, $PowerLoad
                            , $border = 0, $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
                    $pdf->ln(1);
                }

                if (!empty($PowerBackup)) {
                    $pdf->Cell(60, 5, "Power Backup :", $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                    $pdf->MultiCell(130, 5, $PowerBackup
                            , $border = 0, $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
                    $pdf->ln(1);
                }

                if (!empty($SurroundingBrands)) {
                    $pdf->Cell(60, 5, "Surrounding Brands :", $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                    $pdf->MultiCell(130, 5, $SurroundingBrands
                            , $border = 0, $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
                    $pdf->ln(1);
                }

                if (!empty($AgreementTypeName) || !empty($DemandPerSqFeet) || !empty($DemandGross)
                        || !empty($CAM)) {

                    $pdf->SetFont('helvetica', 'B', 11);

                    $pdf->Cell(60, 5, "Commercials :", $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                    $pdf->SetFont('helvetica', '', 11);
                    $pdf->MultiCell(130, 5, ""
                            , $border = 0, $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
                    $pdf->ln(1);
                }
                if (!empty($AgreementTypeName)) {
                    $pdf->Cell(60, 5, "Agreement Type :", $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                    $pdf->MultiCell(130, 5, $AgreementTypeName
                            , $border = 0, $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
                    $pdf->ln(1);
                }

                if (!empty($DemandPerSqFeet)) {
                    $pdf->Cell(60, 5, "Demand (per square feet)(INR) :", $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                    $pdf->MultiCell(130, 5, $DemandPerSqFeet
                            , $border = 0, $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
                    $pdf->ln(1);
                }

                if (!empty($DemandGross)) {
                    $pdf->Cell(60, 5, "Gross Demand (INR) :", $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                    $pdf->MultiCell(130, 5, $DemandGross
                            , $border = 0, $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
                    $pdf->ln(1);
                }

                if (!empty($CAM)) {
                    $pdf->Cell(60, 5, "CAM (INR) :", $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                    $pdf->MultiCell(130, 5, $CAM
                            , $border = 0, $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
                    $pdf->ln(1);
                }
            } else {
//				$tbl.="<tr>";
//				$tbl.="<td colspan=\"2\" align=\"center\" style=\"font-size:40px;\">No result found</td>";
//				$tbl.="</tr>";
                $pdf->Cell(0, 5, "No result found", $border = 0, $ln = 1, $align = '', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
            }
        }

        /* Blank */
        $pdf->Cell(60, 5, "", $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
        $pdf->MultiCell(130, 5, ''
                , $border = 0, $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
        $pdf->ln(1);



        if (isset($AttachmentRows) && count($AttachmentRows) > 0) {
            $pdf->SetFont('helvetica', 'B', 11);
            $pdf->Cell(20, 5, "Property Images :", $border = 0, $ln = 1, $align = '', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
            $pdf->SetFont('helvetica', '', 11);
            $SNo = 1;
            foreach ($AttachmentRows as $docrow) {
                $PropertyAttachmentId = trim($docrow['iPropertyAttachmentId']);
                $PropertyId = trim($docrow['iPropertyId']);
                $AttachmentTitle = trim($docrow['cAttachmentTitle']);
                $AttachmentFilePath = trim($docrow['cAttachmentFilePath']);
                $AttachmentFileName = trim($docrow['cAttachmentFileName']);

                $ImgUrl = base_url($AttachmentFilePath);


                $AttachmentTitlelen = strlen($AttachmentTitle);
                //echo $AttachmentTitlelen;
                if ($AttachmentTitlelen > 50) {
                    $AttachmentTitles = wordwrap($AttachmentTitle, 15, "<br>\n", TRUE);
                } else {
                    $AttachmentTitles = $AttachmentTitle;
                }


                $pdf->Image($ImgUrl, 76, $pdf->gety(), 58, 38, $type = '', $link = '', $align = '', $resize = false, $dpi = 200, $palign = '', $ismask = false, $imgmask = false, $border = 0, $fitbox = false, $hidden = false, $fitonpage = false, $alt = false, $altimgs = array());
                //$pdf->Cell(20, 5, "", $border = 0, $ln = 0, $align = '', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                // $pdf->M(20, 60, $SNo . ") " . $AttachmentTitles, $border = 0, $ln = 1, $align = '', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                
                $pdf->ln(13);
                $pdf->MultiCell(60, 5, $AttachmentTitle
                        , $border = 0, $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = true, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);


                $pdf->ln(2);

                /* For Blank cell */
                $pdf->Cell(60, 5, "", $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                $pdf->MultiCell(130, 5, ''
                        , $border = 0, $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
                $pdf->ln(1);

                $pdf->Cell(60, 5, "", $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                $pdf->MultiCell(130, 5, ''
                        , $border = 0, $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
                $pdf->ln(1);

                $pdf->Cell(60, 5, "", $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
                $pdf->MultiCell(130, 5, ''
                        , $border = 0, $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
                $pdf->ln(1);
                /* For Blank cell */

                $SNo++;
            }
        }

        $pdf->Cell(60, 5, "", $border = 0, $ln = 0, $align = 'L', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');
        $pdf->MultiCell(130, 5, ''
                , $border = 0, $align = 'L', $fill = false, $ln = 1, $x = '', $y = '', $reseth = true, $stretch = 0, $ishtml = false, $autopadding = true, $maxh = 0, $valign = 'T', $fitcell = false);
        $pdf->ln(1);
        $pdf->ln(5);
        $pdf->ln(5);

        $pdf->Cell(0, 5, "Thanks!!!", $border = 0, $ln = 1, $align = 'C', $fill = false, $link = '', $stretch = 0, $ignore_min_height = false, $calign = 'T', $valign = 'M');

        //Close and output PDF document
        return $pdf->Output('property_delivery_report.pdf', 'I');

        //============================================================+
        // END OF FILE
        //============================================================+	
    }

    //--------------------------------------------------------------------------------------------------------------------------------------------------------

    function requisition_history_print_report($RequirementId) {
        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set default header data
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
        //$pdf->setFooterData(array(0,64,0), array(0,64,128)); 
        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once(dirname(__FILE__) . '/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        // ---------------------------------------------------------    
        // set default font subsetting mode
        $pdf->setFontSubsetting(true);

        // set font
        $pdf->SetFont('helvetica', '', 9);

        // add a page
        // $pdf->AddPage();
        //$pdf->AddPage('P', 'A4');
        $pdf->AddPage('L', 'A4');

        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        /* $sql = "SELECT requirement_master.iRequirementId,requirement_master.dDate,client_master.cClientName,requirement_master.cContactPerson,branch_master.cBranchName,state_master.cStateName,district_master.cDistrictName,city_master.cCityName,location_master.cLocationName,requirement_master.cArea,requirement_master.cHeight,requirement_master.cFrontage,source_master.cSourceName,requirement_master.cPropertyPurpose,requirement_master.cPropertyPurpose,business_purpose_master.cBusinessPurposeName,property_category_master.cPropertyCategoryName,requirement_master.cRequirementType,requirement_master.cBudgetPerMonth,requirement_master.cFloorLevelPreference,escalation_master.cEscalationName,requirement_master.cLeasePeriodPreference,requirement_master.cRentFreeFitOutPeriod,requirement_master.cPowerLoad,requirement_master.cPowerBackup,requirement_master.dExpectedLaunchDate,requirement_master.cRemarks,requirement_master.cRegistrationExpensesToBeBorneBy,requirement_master.cTaxationToBeBorneBy,requirement_master.cLockInPeriod,requirement_master.cEstimatedInteriorBudget,requirement_master.cParkingPreference,requirement_master.dAgreementDate,requirement_master.cAgreementPlace,requirement_master.cPerson1DuringAgreement,requirement_master.cPerson2DuringAgreement,requirement_master.cTermsAndConditions,requirement_master.cServiceChargesForLinkers
          FROM requirement_master LEFT JOIN client_master ON requirement_master.iClientId=client_master.iClientId LEFT JOIN branch_master ON requirement_master.iBranchId=branch_master.iBranchId LEFT JOIN state_master ON requirement_master.iStateId=state_master.iStateId LEFT JOIN district_master ON requirement_master.iDistrictId=district_master.iDistrictId LEFT JOIN city_master ON requirement_master.iCityId=city_master.iCityId LEFT JOIN location_master ON requirement_master.iLocationId=location_master.iLocationId LEFT JOIN source_master ON requirement_master.iSourceId=source_master.iSourceId LEFT JOIN business_purpose_master ON requirement_master.iBusinessPurposeId=business_purpose_master.iBusinessPurposeId LEFT JOIN property_category_master ON requirement_master.iPropertyCategoryId=property_category_master.iPropertyCategoryId LEFT JOIN escalation_master ON requirement_master.iEscalationId=escalation_master.iEscalationId
          WHERE requirement_master.iRequirementId='".$RequirementId."'"; */

        $sql1 = "SELECT requirement_master.dDate as dReqAddedOnDate,requirement_master.cRequirementTitle FROM requirement_master WHERE iRequirementId='" . $RequirementId . "'";
        $query1 = $this->db->query($sql1);
        if ($query1) {
            $row1 = $query1->row_array();

            $RequirementTitle = trim($row1['cRequirementTitle']);

            if ($row1['dReqAddedOnDate'] != '') {
                $AddedOnDt = trim($row1['dReqAddedOnDate']);
                $splitaddedondt = explode('-', $AddedOnDt);
                $ReqAddedOnDate = $splitaddedondt[2] . "/" . $splitaddedondt[1] . "/" . $splitaddedondt[0];
            } else {
                $ReqAddedOnDate = "";
            }
        }

        /* $sql = "SELECT dcr_summary.dDCRDate,user_master.cName,dcr_summary.cDCRRemarks,task_master.cTaskName,requirement_master.cRequirementTitle,client_master.cClientName,dcr_detail.cDCRSummary
          FROM dcr_detail LEFT JOIN dcr_summary ON dcr_detail.iDCRId=dcr_summary.iDCRId LEFT JOIN user_master ON dcr_summary.iUserId=user_master.iUserId LEFT JOIN task_master ON dcr_detail.iTaskId=task_master.iTaskId LEFT JOIN requirement_master ON dcr_detail.iRequirementId=requirement_master.iRequirementId
          LEFT JOIN client_master ON dcr_detail.iClientId=client_master.iClientId	WHERE dcr_detail.iRequirementId='".$RequirementId."' AND dcr_detail.bDelete=0 ORDER BY dcr_summary.dDCRDate ASC"; */

        $sql = "SELECT dcr_summary.dDCRDate,user_master.cName,dcr_summary.cDCRRemarks,task_master.cTaskName,requirement_master.cRequirementTitle,CMREQ.cClientName as cReqClientName,property_master.cPropertyName,CMPROP.cClientName as cPropClientName,dcr_detail.iRequirementId,dcr_detail.cDCRSummary
				FROM dcr_detail LEFT JOIN dcr_summary ON dcr_detail.iDCRId=dcr_summary.iDCRId LEFT JOIN user_master ON dcr_summary.iUserId=user_master.iUserId LEFT JOIN task_master ON dcr_detail.iTaskId=task_master.iTaskId LEFT JOIN requirement_master ON dcr_detail.iRequirementId=requirement_master.iRequirementId LEFT JOIN property_master ON dcr_detail.iPropertyId=property_master.iPropertyId
				LEFT JOIN client_master as CMREQ ON dcr_detail.iClientReqId=CMREQ.iClientId LEFT JOIN client_master as CMPROP ON dcr_detail.iClientPropId=CMPROP.iClientId WHERE dcr_detail.iRequirementId='" . $RequirementId . "' AND dcr_detail.bDelete=0 ORDER BY dcr_summary.dDCRDate ASC";

        $query = $this->db->query($sql);

        $tbl = "";
        $tbl.="<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">";
        $tbl.="<tr>
				 <td colspan=\"9\" width=\"100%\" align=\"center\" style=\"text-align:center; font-size:40px;\">Requisition - <strong>$RequirementTitle</strong></td>
			   </tr>";
        $tbl.="<tr>
				 <td colspan=\"9\" width=\"100%\" align=\"center\" style=\"text-align:center; font-size:36px;\">(Added on Date - <strong>$ReqAddedOnDate</strong>)</td>
			   </tr>";
        $tbl.="<tr>
				 <td colspan=\"9\">&nbsp;</td>
			   </tr>";

        $tbl.="<tr style=\"background-color:#CCCCCC;\">
				<td width=\"3%\" align=\"center\"><b>SNo.</b></td> 
				<td width=\"7%\" align=\"left\"><b>Date</b></td>
				<td width=\"10%\" align=\"left\"><b>Task Type</b></td>
				<td width=\"10%\" align=\"left\"><b>User</b></td>
				<td width=\"10%\" align=\"left\"><b>Req Client</b></td>
				<td width=\"15%\" align=\"left\"><b>Requirement</b></td>
				<td width=\"10%\" align=\"left\"><b>Prop Client</b></td>
				<td width=\"15%\" align=\"left\"><b>Property</b></td>
				<td width=\"20%\" align=\"left\"><b>Description</b></td>
			   </tr>
			   <tr>
				 <td colspan=\"9\">&nbsp;</td>
			   </tr>";

        if ($query) {
            if ($query->num_rows() > 0) {
                $SNo = 1;
                foreach ($query->result_array() as $row) {
                    if ($row['dDCRDate'] != '') {
                        $DCRDt = trim($row['dDCRDate']);
                        $splitdcrdt = explode('-', $DCRDt);
                        $DCRDate = $splitdcrdt[2] . "/" . $splitdcrdt[1] . "/" . $splitdcrdt[0];
                    } else {
                        $DCRDate = "";
                    }

                    if ($row['cName'] != '') {
                        $Name = trim($row['cName']);
                    } else {
                        $Name = "";
                    }

                    if ($row['cTaskName'] != '') {
                        $TaskName = trim($row['cTaskName']);
                    } else {
                        $TaskName = "";
                    }

                    if ($row['cReqClientName'] != '') {
                        $ReqClientName = trim($row['cReqClientName']);
                    } else {
                        $ReqClientName = "NA";
                    }

                    if ($row['cRequirementTitle'] != '') {
                        $RequirementTitle = trim($row['cRequirementTitle']);
                    } else {
                        $RequirementTitle = "NA";
                    }

                    if ($row['cPropClientName'] != '') {
                        $PropClientName = trim($row['cPropClientName']);
                    } else {
                        $PropClientName = "NA";
                    }

                    if ($row['cPropertyName'] != '') {
                        $PropertyName = trim($row['cPropertyName']);
                    } else {
                        $PropertyName = "NA";
                    }

                    if ($row['cDCRSummary'] != '') {
                        $DCRSummary = trim($row['cDCRSummary']);
                    } else {
                        $DCRSummary = "";
                    }

                    $tbl.="<tr>";
                    $tbl.="<td align=\"center\">" . $SNo . ".</td>";
                    $tbl.="<td align=\"left\">" . $DCRDate . "</td>";
                    $tbl.="<td align=\"left\">" . $TaskName . "</td>";
                    $tbl.="<td align=\"left\">" . $Name . "</td>";
                    $tbl.="<td align=\"left\">" . $ReqClientName . "</td>";
                    $tbl.="<td align=\"left\">" . $RequirementTitle . "</td>";
                    $tbl.="<td align=\"left\">" . $PropClientName . "</td>";
                    $tbl.="<td align=\"left\">" . $PropertyName . "</td>";
                    $tbl.="<td align=\"left\">" . $DCRSummary . "</td>";
                    $tbl.="</tr>
							<tr>
								<td colspan=\"9\">&nbsp;</td>
							</tr>";

                    $SNo++;
                }
            } else {
                $tbl.="<tr>";
                $tbl.="<td colspan=\"9\" align=\"center\" style=\"font-size:40px;\">No result found</td>";
                $tbl.="</tr>";
            }
        }

        $tbl.="</table>";

        $pdf->writeHTML($tbl, true, false, false, false, '');

        //Close and output PDF document
        return $pdf->Output('requisition_history_report.pdf', 'I');

        //============================================================+
        // END OF FILE
        //============================================================+	
    }

    //--------------------------------------------------------------------------------------------------------------------------------------------------------

    /* function datewise_dcr_print_report($UserId,$Date)
      {
      // create new PDF document
      $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

      // set default header data
      //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
      //$pdf->setFooterData(array(0,64,0), array(0,64,128));

      // set header and footer fonts
      $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
      $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

      // set default monospaced font
      $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

      // set margins
      $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
      $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
      $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

      // set auto page breaks
      $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

      // set image scale factor
      $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

      // set some language-dependent strings (optional)
      if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
      require_once(dirname(__FILE__).'/lang/eng.php');
      $pdf->setLanguageArray($l);
      }

      // ---------------------------------------------------------

      // set default font subsetting mode
      $pdf->setFontSubsetting(true);

      // set font
      $pdf->SetFont('helvetica', '', 11);

      // add a page
      // $pdf->AddPage();
      //$pdf->AddPage('L', 'A4');
      $pdf->AddPage('P', 'A4');

      /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

      /*$sql = "SELECT requirement_master.iRequirementId,requirement_master.dDate,client_master.cClientName,requirement_master.cContactPerson,branch_master.cBranchName,state_master.cStateName,district_master.cDistrictName,city_master.cCityName,location_master.cLocationName,requirement_master.cArea,requirement_master.cHeight,requirement_master.cFrontage,source_master.cSourceName,requirement_master.cPropertyPurpose,requirement_master.cPropertyPurpose,business_purpose_master.cBusinessPurposeName,property_category_master.cPropertyCategoryName,requirement_master.cRequirementType,requirement_master.cBudgetPerMonth,requirement_master.cFloorLevelPreference,escalation_master.cEscalationName,requirement_master.cLeasePeriodPreference,requirement_master.cRentFreeFitOutPeriod,requirement_master.cPowerLoad,requirement_master.cPowerBackup,requirement_master.dExpectedLaunchDate,requirement_master.cRemarks,requirement_master.cRegistrationExpensesToBeBorneBy,requirement_master.cTaxationToBeBorneBy,requirement_master.cLockInPeriod,requirement_master.cEstimatedInteriorBudget,requirement_master.cParkingPreference,requirement_master.dAgreementDate,requirement_master.cAgreementPlace,requirement_master.cPerson1DuringAgreement,requirement_master.cPerson2DuringAgreement,requirement_master.cTermsAndConditions,requirement_master.cServiceChargesForLinkers
      FROM requirement_master LEFT JOIN client_master ON requirement_master.iClientId=client_master.iClientId LEFT JOIN branch_master ON requirement_master.iBranchId=branch_master.iBranchId LEFT JOIN state_master ON requirement_master.iStateId=state_master.iStateId LEFT JOIN district_master ON requirement_master.iDistrictId=district_master.iDistrictId LEFT JOIN city_master ON requirement_master.iCityId=city_master.iCityId LEFT JOIN location_master ON requirement_master.iLocationId=location_master.iLocationId LEFT JOIN source_master ON requirement_master.iSourceId=source_master.iSourceId LEFT JOIN business_purpose_master ON requirement_master.iBusinessPurposeId=business_purpose_master.iBusinessPurposeId LEFT JOIN property_category_master ON requirement_master.iPropertyCategoryId=property_category_master.iPropertyCategoryId LEFT JOIN escalation_master ON requirement_master.iEscalationId=escalation_master.iEscalationId
      WHERE requirement_master.iRequirementId='".$RequirementId."'";*

      $sql1 = "SELECT requirement_master.dDate as dReqAddedOnDate,cRequirementTitle FROM requirement_master WHERE iRequirementId='".$RequirementId."'";
      $query1 = $this->db->query($sql1);
      if($query1)
      {
      $row1 = $query1->row_array();
      $RequirementTitle = trim($row1['cRequirementTitle']);

      if($row1['dReqAddedOnDate']!='')
      {
      $AddedOnDt = trim($row1['dReqAddedOnDate']);
      $splitaddedondt = explode('-',$AddedOnDt);
      $ReqAddedOnDate = $splitaddedondt[2]."/".$splitaddedondt[1]."/".$splitaddedondt[0];
      }
      else
      {
      $ReqAddedOnDate="";
      }
      }

      $sql = "SELECT dcr_summary.dDCRDate,user_master.cName,dcr_summary.cDCRRemarks,task_master.cTaskName,requirement_master.cRequirementTitle,client_master.cClientName,dcr_detail.cDCRSummary
      FROM dcr_detail LEFT JOIN dcr_summary ON dcr_detail.iDCRId=dcr_summary.iDCRId LEFT JOIN user_master ON dcr_summary.iUserId=user_master.iUserId LEFT JOIN task_master ON dcr_detail.iTaskId=task_master.iTaskId LEFT JOIN requirement_master ON dcr_detail.iRequirementId=requirement_master.iRequirementId
      LEFT JOIN client_master ON dcr_detail.iClientId=client_master.iClientId	WHERE dcr_detail.iRequirementId='".$RequirementId."' AND dcr_detail.bDelete=0 ORDER BY dcr_summary.dDCRDate ASC";

      $query = $this->db->query($sql);

      $tbl="";
      $tbl.="<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">";
      $tbl.="<tr>
      <td colspan=\"4\" width=\"100%\" align=\"center\" style=\"text-align:center; font-size:40px;\"><strong>Requisition - $RequirementTitle</strong></td>
      </tr>";
      $tbl.="<tr>
      <td colspan=\"4\" width=\"100%\" align=\"center\" style=\"text-align:center; font-size:36px;\">(Added on Date - <strong>$ReqAddedOnDate</strong>)</td>
      </tr>";
      $tbl.="<tr>
      <td colspan=\"4\">&nbsp;</td>
      </tr>";

      $tbl.="<tr style=\"background-color:#CCCCCC;\">
      <td width=\"8%\" align=\"center\"><b>SNo.</b></td>
      <td width=\"12%\" align=\"left\"><b>Date</b></td>
      <td width=\"15%\" align=\"left\"><b>Task Type</b></td>
      <td width=\"20%\" align=\"left\"><b>User</b></td>
      <td width=\"45%\" align=\"left\"><b>Description</b></td>
      </tr>
      <tr>
      <td colspan=\"4\">&nbsp;</td>
      </tr>";

      if($query)
      {
      if($query->num_rows() > 0)
      {
      $SNo=1;
      foreach($query->result_array() as $row)
      {
      if($row['dDCRDate']!='')
      {
      $DCRDt = trim($row['dDCRDate']);
      $splitdcrdt = explode('-',$DCRDt);
      $DCRDate = $splitdcrdt[2]."/".$splitdcrdt[1]."/".$splitdcrdt[0];
      }
      else
      {
      $DCRDate="";
      }

      if($row['cName']!='')
      {
      $Name = trim($row['cName']);
      }
      else
      {
      $Name="";
      }

      if($row['cTaskName']!='')
      {
      $TaskName = trim($row['cTaskName']);
      }
      else
      {
      $TaskName="";
      }

      if($row['cDCRSummary']!='')
      {
      $DCRSummary = trim($row['cDCRSummary']);
      }
      else
      {
      $DCRSummary="";
      }

      $tbl.="<tr>";
      $tbl.="<td align=\"center\">".$SNo.".</td>";
      $tbl.="<td align=\"left\">".$DCRDate."</td>";
      $tbl.="<td align=\"left\">".$TaskName."</td>";
      $tbl.="<td align=\"left\">".$Name."</td>";
      $tbl.="<td align=\"left\">".$DCRSummary."</td>";
      $tbl.="</tr>
      <tr>
      <td colspan=\"4\">&nbsp;</td>
      </tr>";

      $SNo++;
      }
      }
      else
      {
      $tbl.="<tr>";
      $tbl.="<td colspan=\"4\" align=\"center\" style=\"font-size:40px;\">No result found</td>";
      $tbl.="</tr>";
      }
      }

      $tbl.="</table>";

      $pdf->writeHTML($tbl, true, false, false, false, '');

      //Close and output PDF document
      return $pdf->Output('datewise_dcr_report.pdf', 'I');

      //============================================================+
      // END OF FILE
      //============================================================+
      } */

    function datewise_dcr_print_report($Date) {
        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set default header data
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
        //$pdf->setFooterData(array(0,64,0), array(0,64,128)); 
        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once(dirname(__FILE__) . '/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        // ---------------------------------------------------------    
        // set default font subsetting mode
        $pdf->setFontSubsetting(true);

        // set font
        $pdf->SetFont('helvetica', '', 11);

        // add a page
        // $pdf->AddPage();
        $pdf->AddPage('L', 'A4');
        //$pdf->AddPage('P', 'A4');
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        $splitdt = explode('/', $Date);
        $DCRDate = $splitdt[2] . "-" . $splitdt[1] . "-" . $splitdt[0];

        $tbl = "";
        $tbl.="<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">";
        $tbl.="<tr>
				  <td align=\"center\" style=\"text-align:center; font-size:45px;text-decoration:underline;\"><strong>Task REPORT</strong></td>
			  </tr>
			  <tr>
				  <td>&nbsp;</td>
			  </tr>
			  <tr>
				  <td align=\"center\" style=\"text-align:center; font-size:45px;text-decoration:underline;\"><strong>Date : $Date</strong></td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
			  </tr>";


        //////////////////////////////////////////////// 7. Task Summary  /////////////////////////////////////////////////////////////////////////////////////

        $sql77 = "SELECT dcr_summary.iDCRId,user_master.cName FROM dcr_summary LEFT JOIN user_master ON dcr_summary.iUserId=user_master.iUserId WHERE dcr_summary.dDCRDate='" . $DCRDate . "' AND dcr_summary.bDelete=0";

        $query77 = $this->db->query($sql77);

        $tbl.="<tr>";
        $tbl.="<td>";
        $tbl.="<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">";
        $tbl.="<tr>";
        $tbl.="<td align=\"center\" style=\"font-size:40px;text-decoration:underline;\"><b>Task Summary</b></td>";
        $tbl.="</tr>";
        $tbl.="<tr>";
        $tbl.="<td>&nbsp;</td>";
        $tbl.="</tr>";

        if ($query77) {
            if ($query77->num_rows() > 0) {
                foreach ($query77->result_array() as $row77) {
                    if ($row77['iDCRId'] != '') {
                        $DCRId = trim($row77['iDCRId']);
                    } else {
                        $DCRId = "";
                    }

                    if ($row77['cName'] != '') {
                        $StaffName = trim($row77['cName']);
                    } else {
                        $StaffName = "";
                    }



                    $sql7 = "SELECT task_master.cTaskName,CMREQ.cClientName as cReqClientName,requirement_master.cRequirementTitle,CMPROP.cClientName as cPropClientName,property_master.cPropertyName,dcr_detail.cDCRSummary
							 FROM dcr_detail LEFT JOIN task_master ON dcr_detail.iTaskId=task_master.iTaskId LEFT JOIN property_master ON dcr_detail.iPropertyId=property_master.iPropertyId LEFT JOIN requirement_master ON dcr_detail.iRequirementId=requirement_master.iRequirementId
							 LEFT JOIN client_master as CMREQ ON dcr_detail.iClientReqId=CMREQ.iClientId LEFT JOIN client_master as CMPROP ON dcr_detail.iClientPropId=CMPROP.iClientId WHERE dcr_detail.iDCRId='" . $DCRId . "' AND  dcr_detail.bDelete=0";

                    $query7 = $this->db->query($sql7);

                    if ($query7) {
                        if ($query7->num_rows() > 0) {

                            $tbl.="<tr>";
                            $tbl.="<td align=\"center\" style=\"font-size:40px;\"><b>Staff Name : </b>" . $StaffName . "</td>";
                            $tbl.="</tr>";
                            $tbl.="<tr>
									   <td>&nbsp;</td>
								   </tr>";
                            $tbl.="<tr>";
                            $tbl.="<td align=\"center\">";
                            $tbl.="<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">
									<tr style=\"background-color:#CCCCCC;\">
									 <td width=\"5%\" align=\"center\"><b>SNo.</b></td>
									 <td width=\"10%\" align=\"left\"><b>Task</b></td>
									 <td width=\"17%\" align=\"left\"><b>Client Req</b></td>
									 <td width=\"15%\" align=\"left\"><b>RF</b></td>
									 <td width=\"20%\" align=\"left\"><b>Client PSR</b></td>
									 <td width=\"15%\" align=\"left\"><b>PSR</b></td>
									 <td width=\"18%\" align=\"left\"><b>Summary</b></td>
								   </tr>";


                            $S7No = 1;
                            foreach ($query7->result_array() as $row7) {
                                if ($row7['cTaskName'] != '') {
                                    $TaskName = trim($row7['cTaskName']);
                                } else {
                                    $TaskName = "";
                                }

                                if ($row7['cReqClientName'] != '') {
                                    $ReqClientName = trim($row7['cReqClientName']);
                                } else {
                                    $ReqClientName = "";
                                }

                                if ($row7['cRequirementTitle'] != '') {
                                    $RequirementTitle = trim($row7['cRequirementTitle']);
                                } else {
                                    $RequirementTitle = "";
                                }

                                if ($row7['cPropClientName'] != '') {
                                    $PropClientName = trim($row7['cPropClientName']);
                                } else {
                                    $PropClientName = "";
                                }

                                if ($row7['cPropertyName'] != '') {
                                    $PropertyName = trim($row7['cPropertyName']);
                                } else {
                                    $PropertyName = "";
                                }

                                if ($row7['cDCRSummary'] != '') {
                                    $DCRSummary = trim($row7['cDCRSummary']);
                                } else {
                                    $DCRSummary = "";
                                }

                                $tbl.="<tr>";
                                $tbl.="<td align=\"center\">" . $S7No . ".</td>";
                                $tbl.="<td align=\"left\">" . $TaskName . "</td>";
                                $tbl.="<td align=\"left\">" . $ReqClientName . "</td>";
                                $tbl.="<td align=\"left\">" . $RequirementTitle . "</td>";
                                $tbl.="<td align=\"left\">" . $PropClientName . "</td>";
                                $tbl.="<td align=\"left\">" . $PropertyName . "</td>";
                                $tbl.="<td align=\"left\">" . $DCRSummary . "</td>";
                                $tbl.="</tr>";
                                $tbl.="<tr>
										   <td colspan=\"7\"  ></td>
									   </tr>
									   ";

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
            } else {
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

//	  echo $tbl;
//	  exit;
        //return $tbl;

        $pdf->writeHTML($tbl, true, false, false, false, '');

        //Close and output PDF document
        return $pdf->Output('datewise_dcr_report.pdf', 'I');

        //============================================================+
        // END OF FILE
        //============================================================+	
    }

    function pending_rf_print_report() {
        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set default header data
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
        //$pdf->setFooterData(array(0,64,0), array(0,64,128)); 
        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once(dirname(__FILE__) . '/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        // ---------------------------------------------------------    
        // set default font subsetting mode
        $pdf->setFontSubsetting(true);

        // set font
        $pdf->SetFont('helvetica', '', 10);

        // add a page
        // $pdf->AddPage();
        $pdf->AddPage('P', 'A4');
        //$pdf->AddPage('L', 'A4');
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        $sql = "SELECT requirement_master.cRequirementTitle,requirement_master.dDate as dAddedOnDate,client_master.cClientName,user_master.cName as cAddedByStaffName,current_status_master.cCurrentStatusName FROM requirement_master LEFT JOIN client_master ON requirement_master.iClientId=client_master.iClientId LEFT JOIN user_master ON requirement_master.iAddedByUserId=user_master.iUserId LEFT JOIN current_status_master ON requirement_master.iCurrentStatusId=current_status_master.iCurrentStatusId WHERE requirement_master.bActive=1 AND requirement_master.bDelete=0 ORDER BY requirement_master.dDate DESC";

        $query = $this->db->query($sql);

        $tbl = "";
        $tbl.="<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">";
        $tbl.="<tr>
				   <td colspan=\"6\" align=\"center\" style=\"text-align:center; font-size:43px;\"><strong>Pending RF Report</strong></td>
			   </tr>
			   <tr>
				   <td colspan=\"6\">&nbsp;</td>
			   </tr>
			   <tr style=\"background-color:#CCCCCC; font-size:38px;\">
				<td width=\"5%\" align=\"center\"><b>SNo.</b></td> 
				<td width=\"20%\" align=\"left\"><b>Client</b></td>
				<td width=\"25%\" align=\"left\"><b>RF Title</b></td>
				<td width=\"13%\" align=\"center\"><b>Added On</b></td>
				<td width=\"17%\" align=\"left\"><b>Added By</b></td>
				<td width=\"20%\" align=\"left\"><b>Current Status</b></td>
			    </tr>
			    <tr>
				   <td colspan=\"6\">&nbsp;</td>
			   </tr>";

        if ($query) {
            if ($query->num_rows() > 0) {
                $SNo = 1;
                foreach ($query->result_array() as $row) {
                    if ($row['cClientName'] != '') {
                        $ClientName = trim($row['cClientName']);
                    } else {
                        $ClientName = "";
                    }

                    if ($row['cRequirementTitle'] != '') {
                        $RequirementTitle = trim($row['cRequirementTitle']);
                    } else {
                        $RequirementTitle = "";
                    }

                    if ($row['dAddedOnDate'] != '') {
                        $AddedOnDt = trim($row['dAddedOnDate']);
                        $splitaddondt = explode('-', $AddedOnDt);
                        $AddedOnDate = $splitaddondt[2] . "/" . $splitaddondt[1] . "/" . $splitaddondt[0];
                    } else {
                        $AddedOnDate = "";
                    }

                    if ($row['cAddedByStaffName'] != '') {
                        $AddedByStaffName = trim($row['cAddedByStaffName']);
                    } else {
                        $AddedByStaffName = "";
                    }

                    if ($row['cCurrentStatusName'] != '') {
                        $CurrentStatusName = trim($row['cCurrentStatusName']);
                    } else {
                        $CurrentStatusName = "NA";
                    }

                    $tbl.="<tr>";
                    $tbl.="<td align=\"center\">" . $SNo . ".</td>";
                    $tbl.="<td align=\"left\">" . $ClientName . "</td>";
                    $tbl.="<td align=\"left\">" . $RequirementTitle . "</td>";
                    $tbl.="<td align=\"center\">" . $AddedOnDate . "</td>";
                    $tbl.="<td align=\"left\">" . $AddedByStaffName . "</td>";
                    $tbl.="<td align=\"left\">" . $CurrentStatusName . "</td>";

                    $tbl.="</tr>
							<tr>
								<td colspan=\"6\">&nbsp;</td>
							</tr>";

                    $SNo++;
                }
            } else {
                $tbl.="<tr>";
                $tbl.="<td colspan=\"6\" align=\"center\" style=\"font-size:40px;\">No result found</td>";
                $tbl.="</tr>";
            }
        }

        $tbl.="</table>";

        $pdf->writeHTML($tbl, true, false, false, false, '');

        //Close and output PDF document
        return $pdf->Output('pending_rf_report.pdf', 'I');

        //============================================================+
        // END OF FILE
        //============================================================+	
    }

    function datewise_weekly_print_report($FromDt, $ToDt) {
        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set default header data
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
        //$pdf->setFooterData(array(0,64,0), array(0,64,128)); 
        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once(dirname(__FILE__) . '/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        // ---------------------------------------------------------    
        // set default font subsetting mode
        $pdf->setFontSubsetting(true);

        // set font
        $pdf->SetFont('helvetica', '', 11);

        // add a page
        // $pdf->AddPage();
        $pdf->AddPage('L', 'A4');
        //$pdf->AddPage('P', 'A4');
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        $splitfrmdt = explode('/', $FromDt);
        $FromDate = $splitfrmdt[2] . "-" . $splitfrmdt[1] . "-" . $splitfrmdt[0];

        $splittodt = explode('/', $ToDt);
        $ToDate = $splittodt[2] . "-" . $splittodt[1] . "-" . $splittodt[0];


        $pdf->SetFont('helvetica', 'B', 14);
        $pdf->cell(0, 5, "WEEKLY REPORT", "", 1, "C");
        $pdf->ln(5);
        $pdf->cell(0, 5, "FromDate : " . $FromDt . " ToDate : " . $ToDt, "", 1, "C");
        $pdf->ln(5);
        $pdf->SetFont('helvetica', '', 11);

        $tbl = "";
        $tbl.="<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"1\">";

        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        $DataArray = array();

        $sql1 = "SELECT task_master.iTaskId,task_master.cTaskName FROM task_master WHERE task_master.bActive=1 AND task_master.bDelete=0";

        $query1 = $this->db->query($sql1);

        if ($query1) {

            if ($query1->num_rows() > 0) {
                $xcolwidth = ( round(85 / $query1->num_rows(), 0) );
                $tbl.="<tr>
								<td style=\"width:15%;height:30px;\">&nbsp;</td>";

                foreach ($query1->result_array() as $row1) {
                    if ($row1['cTaskName'] != '') {
                        $TaskName = trim($row1['cTaskName']);
                    } else {
                        $TaskName = "";
                    }

                    $tbl.="<td style=\"width:" . $xcolwidth . "%; height:25px; text-align:center; font-size:35px;\">" . $TaskName . "</td>";
                }

                $tbl.="</tr>";
            }
        }

        $sql2 = "SELECT user_master.iUserId,user_master.cName FROM user_master WHERE user_master.bActive=1 AND user_master.bDelete=0";

        $query2 = $this->db->query($sql2);

        if ($query2) {
            if ($query2->num_rows() > 0) {
                $row = 0;
                foreach ($query2->result_array() as $row2) {
                    if ($row2['iUserId'] != '') {
                        $UserId = trim($row2['iUserId']);
                    } else {
                        $UserId = "";
                    }

                    if ($row2['cName'] != '') {
                        $Name = trim($row2['cName']);
                    } else {
                        $Name = "";
                    }

                    $tbl.="<tr>";
                    $tbl.="<td style=\"width:15%;height:30px;\">" . $Name . "</td>";
                    $col = 0;
                    foreach ($query1->result_array() as $row1) {
                        if ($row1['iTaskId'] != '') {
                            $TaskId = trim($row1['iTaskId']);
                        } else {
                            $TaskId = "";
                        }

                        if ($row1['cTaskName'] != '') {
                            $TaskName = trim($row1['cTaskName']);
                        } else {
                            $TaskName = "";
                        }

                        $sql3 = "SELECT COUNT(*) as CountTask FROM dcr_summary LEFT JOIN dcr_detail ON dcr_summary.iDCRId=dcr_detail.iDCRId WHERE dcr_summary.iUserId='" . $UserId . "' AND dcr_summary.dDCRDate BETWEEN '" . $FromDate . "' AND '" . $ToDate . "' AND dcr_detail.iTaskId='" . $TaskId . "' AND dcr_detail.bDelete=0";
                        $query3 = $this->db->query($sql3);
                        $row3 = $query3->row_array();

                        $CountTask = trim($row3['CountTask']);

                        $DataArray[$row][$col] = $CountTask;

                        $tbl.="<td style=\"width:" . $xcolwidth . "%; height:25px; text-align:center;\">" . $CountTask . "</td>";

                        $col++;
                    }

                    $tbl.="</tr>";

                    $row++;
                }

                /* $tbl.="<tr>
                  <td style=\"width:15%;height:30px;\"><b>Total</b></td>";
                  foreach($query1->result_array() as $row1)
                  {
                  $tbl.="<td style=\"width:10%; height:25px; text-align:center; font-size:35px;\">".$Total."</td>";
                  }
                  $tbl.="</tr>"; */
            } else {
                $tbl.="<tr>";
                $tbl.="<td align=\"center\">No result found</td>";
                $tbl.="</tr>";
            }
        }

        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        $tbl.="</table>";

        //echo $tbl;
        //return $tbl;

        $pdf->writeHTML($tbl, true, false, false, false, '');

        //Close and output PDF document
        return $pdf->Output('datewise_dcr_report.pdf', 'I');

        //============================================================+
        // END OF FILE
        //============================================================+	
    }

    function rf_pending_acceptance_print_report() {
        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set default header data
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
        //$pdf->setFooterData(array(0,64,0), array(0,64,128)); 
        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once(dirname(__FILE__) . '/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        // ---------------------------------------------------------    
        // set default font subsetting mode
        $pdf->setFontSubsetting(true);

        // set font
        $pdf->SetFont('helvetica', '', 10);

        // add a page
        // $pdf->AddPage();
        $pdf->AddPage('P', 'A4');
        //$pdf->AddPage('L', 'A4');
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        $sql = "SELECT requirement_master.cRequirementTitle,requirement_master.dDate as dAddedOnDate,client_master.cClientName,user_master.cName as cAddedByStaffName,current_status_master.cCurrentStatusName FROM requirement_master LEFT JOIN client_master ON requirement_master.iClientId=client_master.iClientId LEFT JOIN user_master ON requirement_master.iAddedByUserId=user_master.iUserId LEFT JOIN current_status_master ON requirement_master.iCurrentStatusId=current_status_master.iCurrentStatusId WHERE requirement_master.bAcceptTermsAndConditions=0 AND requirement_master.bActive=1 AND requirement_master.bDelete=0 ORDER BY requirement_master.dDate DESC";

        $query = $this->db->query($sql);

        $tbl = "";
        $tbl.="<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">";
        $tbl.="<tr>
				   <td colspan=\"6\" align=\"center\" style=\"text-align:center; font-size:43px;\"><strong>RFs Pending for Acceptance</strong></td>
			   </tr>
			   <tr>
				   <td colspan=\"6\">&nbsp;</td>
			   </tr>
			   <tr style=\"background-color:#CCCCCC; font-size:38px;\">
				<td width=\"5%\" align=\"center\"><b>SNo.</b></td> 
				<td width=\"20%\" align=\"left\"><b>Client</b></td>
				<td width=\"25%\" align=\"left\"><b>RF Title</b></td>
				<td width=\"13%\" align=\"center\"><b>Added On</b></td>
				<td width=\"17%\" align=\"left\"><b>Added By</b></td>
				<td width=\"20%\" align=\"left\"><b>Current Status</b></td>
			    </tr>
			    <tr>
				   <td colspan=\"6\">&nbsp;</td>
			   </tr>";

        if ($query) {
            if ($query->num_rows() > 0) {
                $SNo = 1;
                foreach ($query->result_array() as $row) {
                    if ($row['cClientName'] != '') {
                        $ClientName = trim($row['cClientName']);
                    } else {
                        $ClientName = "";
                    }

                    if ($row['cRequirementTitle'] != '') {
                        $RequirementTitle = trim($row['cRequirementTitle']);
                    } else {
                        $RequirementTitle = "";
                    }

                    if ($row['dAddedOnDate'] != '') {
                        $AddedOnDt = trim($row['dAddedOnDate']);
                        $splitaddondt = explode('-', $AddedOnDt);
                        $AddedOnDate = $splitaddondt[2] . "/" . $splitaddondt[1] . "/" . $splitaddondt[0];
                    } else {
                        $AddedOnDate = "";
                    }

                    if ($row['cAddedByStaffName'] != '') {
                        $AddedByStaffName = trim($row['cAddedByStaffName']);
                    } else {
                        $AddedByStaffName = "";
                    }

                    if ($row['cCurrentStatusName'] != '') {
                        $CurrentStatusName = trim($row['cCurrentStatusName']);
                    } else {
                        $CurrentStatusName = "NA";
                    }

                    $tbl.="<tr>";
                    $tbl.="<td align=\"center\">" . $SNo . ".</td>";
                    $tbl.="<td align=\"left\">" . $ClientName . "</td>";
                    $tbl.="<td align=\"left\">" . $RequirementTitle . "</td>";
                    $tbl.="<td align=\"center\">" . $AddedOnDate . "</td>";
                    $tbl.="<td align=\"left\">" . $AddedByStaffName . "</td>";
                    $tbl.="<td align=\"left\">" . $CurrentStatusName . "</td>";

                    $tbl.="</tr>
							<tr>
								<td colspan=\"6\">&nbsp;</td>
							</tr>";

                    $SNo++;
                }
            } else {
                $tbl.="<tr>";
                $tbl.="<td colspan=\"6\" align=\"center\" style=\"font-size:40px;\">No result found</td>";
                $tbl.="</tr>";
            }
        }

        $tbl.="</table>";

        $pdf->writeHTML($tbl, true, false, false, false, '');

        //Close and output PDF document
        return $pdf->Output('rf_pending_acceptance_report.pdf', 'I');

        //============================================================+
        // END OF FILE
        //============================================================+	
    }

    function psr_pending_acceptance_print_report() {
        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set default header data
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
        //$pdf->setFooterData(array(0,64,0), array(0,64,128)); 
        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once(dirname(__FILE__) . '/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        // ---------------------------------------------------------    
        // set default font subsetting mode
        $pdf->setFontSubsetting(true);

        // set font
        $pdf->SetFont('helvetica', '', 10);

        // add a page
        // $pdf->AddPage();
        $pdf->AddPage('P', 'A4');
        //$pdf->AddPage('L', 'A4');
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        $sql = "SELECT property_master.cPropertyName,property_master.dDate as dAddedOnDate,client_master.cClientName,user_master.cName as cAddedByStaffName,current_status_master.cCurrentStatusName FROM property_master LEFT JOIN client_master ON property_master.iClientId=client_master.iClientId LEFT JOIN user_master ON property_master.iAddedByUserId=user_master.iUserId LEFT JOIN current_status_master ON property_master.iCurrentStatusId=current_status_master.iCurrentStatusId WHERE property_master.bAcceptTermsAndConditions=0 AND property_master.bActive=1 AND property_master.bDelete=0 ORDER BY property_master.dDate DESC";

        $query = $this->db->query($sql);

        $tbl = "";
        $tbl.="<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">";
        $tbl.="<tr>
				   <td colspan=\"6\" align=\"center\" style=\"text-align:center; font-size:43px;\"><strong>PSRs Pending for Acceptance</strong></td>
			   </tr>
			   <tr>
				   <td colspan=\"6\">&nbsp;</td>
			   </tr>
			   <tr style=\"background-color:#CCCCCC; font-size:38px;\">
				<td width=\"5%\" align=\"center\"><b>SNo.</b></td> 
				<td width=\"20%\" align=\"left\"><b>Client</b></td>
				<td width=\"25%\" align=\"left\"><b>PSR Title</b></td>
				<td width=\"13%\" align=\"center\"><b>Added On</b></td>
				<td width=\"17%\" align=\"left\"><b>Added By</b></td>
				<td width=\"20%\" align=\"left\"><b>Current Status</b></td>
			    </tr>
			    <tr>
				   <td colspan=\"6\">&nbsp;</td>
			   </tr>";

        if ($query) {
            if ($query->num_rows() > 0) {
                $SNo = 1;
                foreach ($query->result_array() as $row) {
                    if ($row['cClientName'] != '') {
                        $ClientName = trim($row['cClientName']);
                    } else {
                        $ClientName = "";
                    }

                    if ($row['cPropertyName'] != '') {
                        $PropertyName = trim($row['cPropertyName']);
                    } else {
                        $PropertyName = "";
                    }

                    if ($row['dAddedOnDate'] != '') {
                        $AddedOnDt = trim($row['dAddedOnDate']);
                        $splitaddondt = explode('-', $AddedOnDt);
                        $AddedOnDate = $splitaddondt[2] . "/" . $splitaddondt[1] . "/" . $splitaddondt[0];
                    } else {
                        $AddedOnDate = "";
                    }

                    if ($row['cAddedByStaffName'] != '') {
                        $AddedByStaffName = trim($row['cAddedByStaffName']);
                    } else {
                        $AddedByStaffName = "";
                    }

                    if ($row['cCurrentStatusName'] != '') {
                        $CurrentStatusName = trim($row['cCurrentStatusName']);
                    } else {
                        $CurrentStatusName = "NA";
                    }

                    $tbl.="<tr>";
                    $tbl.="<td align=\"center\">" . $SNo . ".</td>";
                    $tbl.="<td align=\"left\">" . $ClientName . "</td>";
                    $tbl.="<td align=\"left\">" . $PropertyName . "</td>";
                    $tbl.="<td align=\"center\">" . $AddedOnDate . "</td>";
                    $tbl.="<td align=\"left\">" . $AddedByStaffName . "</td>";
                    $tbl.="<td align=\"left\">" . $CurrentStatusName . "</td>";

                    $tbl.="</tr>
							<tr>
								<td colspan=\"6\">&nbsp;</td>
							</tr>";

                    $SNo++;
                }
            } else {
                $tbl.="<tr>";
                $tbl.="<td colspan=\"6\" align=\"center\" style=\"font-size:40px;\">No result found</td>";
                $tbl.="</tr>";
            }
        }

        $tbl.="</table>";

        $pdf->writeHTML($tbl, true, false, false, false, '');

        //Close and output PDF document
        return $pdf->Output('psr_pending_acceptance_report.pdf', 'I');

        //============================================================+
        // END OF FILE
        //============================================================+	
    }

    function available_properties_print_report() {
        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set default header data
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
        //$pdf->setFooterData(array(0,64,0), array(0,64,128)); 
        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once(dirname(__FILE__) . '/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        // ---------------------------------------------------------    
        // set default font subsetting mode
        $pdf->setFontSubsetting(true);

        // set font
        $pdf->SetFont('helvetica', '', 10);

        // add a page
        // $pdf->AddPage();
        $pdf->AddPage('P', 'A4');
        //$pdf->AddPage('L', 'A4');
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        $sql = "SELECT property_master.cPropertyName,property_master.dDate as dAddedOnDate,client_master.cClientName,user_master.cName as cAddedByStaffName,current_status_master.cCurrentStatusName FROM property_master LEFT JOIN client_master ON property_master.iClientId=client_master.iClientId LEFT JOIN user_master ON property_master.iAddedByUserId=user_master.iUserId LEFT JOIN current_status_master ON property_master.iCurrentStatusId=current_status_master.iCurrentStatusId WHERE property_master.bActive=1 AND property_master.bDelete=0 ORDER BY property_master.dDate DESC";

        $query = $this->db->query($sql);

        $tbl = "";
        $tbl.="<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">";
        $tbl.="<tr>
				   <td colspan=\"6\" align=\"center\" style=\"text-align:center; font-size:43px;\"><strong>Available Properties</strong></td>
			   </tr>
			   <tr>
				   <td colspan=\"6\">&nbsp;</td>
			   </tr>
			   <tr style=\"background-color:#CCCCCC; font-size:38px;\">
				<td width=\"5%\" align=\"center\"><b>SNo.</b></td> 
				<td width=\"20%\" align=\"left\"><b>Client</b></td>
				<td width=\"25%\" align=\"left\"><b>PSR Title</b></td>
				<td width=\"13%\" align=\"center\"><b>Added On</b></td>
				<td width=\"17%\" align=\"left\"><b>Added By</b></td>
				<td width=\"20%\" align=\"left\"><b>Current Status</b></td>
			    </tr>
			    <tr>
				   <td colspan=\"6\">&nbsp;</td>
			   </tr>";

        if ($query) {
            if ($query->num_rows() > 0) {
                $SNo = 1;
                foreach ($query->result_array() as $row) {
                    if ($row['cClientName'] != '') {
                        $ClientName = trim($row['cClientName']);
                    } else {
                        $ClientName = "";
                    }

                    if ($row['cPropertyName'] != '') {
                        $PropertyName = trim($row['cPropertyName']);
                    } else {
                        $PropertyName = "";
                    }

                    if ($row['dAddedOnDate'] != '') {
                        $AddedOnDt = trim($row['dAddedOnDate']);
                        $splitaddondt = explode('-', $AddedOnDt);
                        $AddedOnDate = $splitaddondt[2] . "/" . $splitaddondt[1] . "/" . $splitaddondt[0];
                    } else {
                        $AddedOnDate = "";
                    }

                    if ($row['cAddedByStaffName'] != '') {
                        $AddedByStaffName = trim($row['cAddedByStaffName']);
                    } else {
                        $AddedByStaffName = "";
                    }

                    if ($row['cCurrentStatusName'] != '') {
                        $CurrentStatusName = trim($row['cCurrentStatusName']);
                    } else {
                        $CurrentStatusName = "NA";
                    }

                    $tbl.="<tr>";
                    $tbl.="<td align=\"center\">" . $SNo . ".</td>";
                    $tbl.="<td align=\"left\">" . $ClientName . "</td>";
                    $tbl.="<td align=\"left\">" . $PropertyName . "</td>";
                    $tbl.="<td align=\"center\">" . $AddedOnDate . "</td>";
                    $tbl.="<td align=\"left\">" . $AddedByStaffName . "</td>";
                    $tbl.="<td align=\"left\">" . $CurrentStatusName . "</td>";

                    $tbl.="</tr>
							<tr>
								<td colspan=\"6\">&nbsp;</td>
							</tr>";

                    $SNo++;
                }
            } else {
                $tbl.="<tr>";
                $tbl.="<td colspan=\"6\" align=\"center\" style=\"font-size:40px;\">No result found</td>";
                $tbl.="</tr>";
            }
        }

        $tbl.="</table>";

        $pdf->writeHTML($tbl, true, false, false, false, '');

        //Close and output PDF document
        return $pdf->Output('psr_pending_acceptance_report.pdf', 'I');

        //============================================================+
        // END OF FILE
        //============================================================+	
    }

    function property_search_print_report($StateId, $CityId, $PropertyCategoryId, $PropertyTypeId) {
        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set default header data
        //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
        //$pdf->setFooterData(array(0,64,0), array(0,64,128)); 
        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once(dirname(__FILE__) . '/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        // ---------------------------------------------------------    
        // set default font subsetting mode
        $pdf->setFontSubsetting(true);

        // set font
        $pdf->SetFont('helvetica', '', 10);

        // add a page
        // $pdf->AddPage();
        $pdf->AddPage('P', 'A4');
        //$pdf->AddPage('L', 'A4');
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        $sql2 = "";

        $sql3 = "";

        $sql1 = "SELECT property_master.cPropertyName,property_master.dDate as dAddedOnDate,client_master.cClientName,user_master.cName as cAddedByStaffName,current_status_master.cCurrentStatusName FROM property_master LEFT JOIN client_master ON property_master.iClientId=client_master.iClientId LEFT JOIN user_master ON property_master.iAddedByUserId=user_master.iUserId LEFT JOIN current_status_master ON property_master.iCurrentStatusId=current_status_master.iCurrentStatusId";

        if ($StateId != '') {
            if ($sql2 == '') {
                $sql2 = " WHERE property_master.iStateId=" . $StateId . "";
            } else {
                $sql2.=" AND property_master.iStateId=" . $StateId . "";
            }
        }

        if ($CityId != '') {
            if ($sql2 == '') {
                $sql2 = " WHERE property_master.iCityId=" . $CityId . "";
            } else {
                $sql2.=" AND property_master.iCityId=" . $CityId . "";
            }
        }

        if ($PropertyCategoryId != '') {
            if ($sql2 == '') {
                $sql2 = " WHERE property_master.iPropertyCategoryId=" . $PropertyCategoryId . "";
            } else {
                $sql2.=" AND property_master.iPropertyCategoryId=" . $PropertyCategoryId . "";
            }
        }

        if ($PropertyTypeId != '') {
            if ($sql2 == '') {
                $sql2 = " WHERE property_master.iPropertyTypeId=" . $PropertyTypeId . "";
            } else {
                $sql2.=" AND property_master.iPropertyTypeId=" . $PropertyTypeId . "";
            }
        }

        if ($sql2 == '') {
            $sql3 = " WHERE property_master.bActive=1 AND property_master.bDelete=0 ORDER BY property_master.dDate DESC";
        } else {
            $sql3.= " AND property_master.bActive=1 AND property_master.bDelete=0 ORDER BY property_master.dDate DESC";
        }


        $sql = $sql1 . $sql2 . $sql3;

        //echo $sql;
        //exit;

        $query = $this->db->query($sql);

        $tbl = "";
        $tbl.="<table width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">";
        $tbl.="<tr>
				   <td colspan=\"6\" align=\"center\" style=\"text-align:center; font-size:43px;\"><strong>Search Properties</strong></td>
			   </tr>
			   <tr>
				   <td colspan=\"6\">&nbsp;</td>
			   </tr>
			   <tr style=\"background-color:#CCCCCC; font-size:38px;\">
				<td width=\"5%\" align=\"center\"><b>SNo.</b></td> 
				<td width=\"20%\" align=\"left\"><b>Client</b></td>
				<td width=\"25%\" align=\"left\"><b>PSR Title</b></td>
				<td width=\"13%\" align=\"center\"><b>Added On</b></td>
				<td width=\"17%\" align=\"left\"><b>Added By</b></td>
				<td width=\"20%\" align=\"left\"><b>Current Status</b></td>
			    </tr>
			    <tr>
				   <td colspan=\"6\">&nbsp;</td>
			   </tr>";

        if ($query) {
            if ($query->num_rows() > 0) {
                $SNo = 1;
                foreach ($query->result_array() as $row) {
                    if ($row['cClientName'] != '') {
                        $ClientName = trim($row['cClientName']);
                    } else {
                        $ClientName = "";
                    }

                    if ($row['cPropertyName'] != '') {
                        $PropertyName = trim($row['cPropertyName']);
                    } else {
                        $PropertyName = "";
                    }

                    if ($row['dAddedOnDate'] != '') {
                        $AddedOnDt = trim($row['dAddedOnDate']);
                        $splitaddondt = explode('-', $AddedOnDt);
                        $AddedOnDate = $splitaddondt[2] . "/" . $splitaddondt[1] . "/" . $splitaddondt[0];
                    } else {
                        $AddedOnDate = "";
                    }

                    if ($row['cAddedByStaffName'] != '') {
                        $AddedByStaffName = trim($row['cAddedByStaffName']);
                    } else {
                        $AddedByStaffName = "";
                    }

                    if ($row['cCurrentStatusName'] != '') {
                        $CurrentStatusName = trim($row['cCurrentStatusName']);
                    } else {
                        $CurrentStatusName = "NA";
                    }

                    $tbl.="<tr>";
                    $tbl.="<td align=\"center\">" . $SNo . ".</td>";
                    $tbl.="<td align=\"left\">" . $ClientName . "</td>";
                    $tbl.="<td align=\"left\">" . $PropertyName . "</td>";
                    $tbl.="<td align=\"center\">" . $AddedOnDate . "</td>";
                    $tbl.="<td align=\"left\">" . $AddedByStaffName . "</td>";
                    $tbl.="<td align=\"left\">" . $CurrentStatusName . "</td>";

                    $tbl.="</tr>
							<tr>
								<td colspan=\"6\">&nbsp;</td>
							</tr>";

                    $SNo++;
                }
            } else {
                $tbl.="<tr>";
                $tbl.="<td colspan=\"6\" align=\"center\" style=\"font-size:40px;\">No result found</td>";
                $tbl.="</tr>";
            }
        }

        $tbl.="</table>";

        $pdf->writeHTML($tbl, true, false, false, false, '');

        //Close and output PDF document
        return $pdf->Output('property_search_report.pdf', 'I');

        //============================================================+
        // END OF FILE
        //============================================================+	
    }

    function property_title($property_id) {
        $sql = 'SELECT iPropertyId,cPropertyName FROM property_master WHERE iPropertyId ="' . $property_id . '"';
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    function popup_for_inspection_delivery($property_id, $is_ins_del) {


        $sql = "SELECT requirement_master.cRequirementTitle,DATE_FORMAT(dDCRDate,'%d/%m/%Y') AS dDCRDates ,iClientReqId From dcr_detail 
                   left join dcr_summary on dcr_detail.iDCRId=dcr_summary.iDCRId 
                   left join requirement_master on requirement_master.iRequirementId=dcr_detail.iRequirementId
                        where iTaskId='" . $is_ins_del . "' AND iPropertyId='" . $property_id . "'";
        //$sql="SELECT iClientReqId,iRequirementId From dcr_detail 
        //      where iTaskId='".$is_ins_del."' AND iPropertyId='".$property_id."'";


        $query = $this->db->query($sql);
        $result = $query->result_array();

        return $result;


//            $clientreid = array();
//            $iRequirementId = array();
//            $dcrDate = array();
//            
//            $resultsdata = array();
//            foreach($result as $res)
//            {
//                $clientreid[] = $res['iClientReqId'];
//                $iRequirementId[] = $res['iRequirementId'];
//                
//            //       $sql="SELECT cClientName From client_master where iClientId='".$res['iClientReqId']."' ";
//              //     $query = $this->db->query($sql);
//                //   $resultsdata[] = $query->result_array(); 
//                    
//                    
//                    $sql="SELECT iRequirementId,cRequirementTitle From requirement_master where iRequirementId='".$res['iRequirementId']."' ";
//                    $query = $this->db->query($sql);
//                    $resultsdata[] = $query->result_array(); 
//                   // $resultsdata['dDCRDate'][] = $res['dDCRDate'];
//                    //$dcrDate[] =$res['dDCRDate'];
//                    
//                    
//                    
//                    
//                
//            }
//            
//                $clientreidimp = implode(",",$clientreid);
//                $iRequirementId = implode(",",$iRequirementId);
//                
//           /*if(!empty($clientreidimp))
//            {
//                echo $sql="SELECT cClientName From client_master where iClientId IN({$clientreidimp})";
//                $query = $this->db->query($sql);
//                $result = $query->result_array();
//             
//            }*/
//                
//                return $resultsdata;
//            
//            
        //return $query;
    }

    function getDcrDate($reqid) {
        $sql = "SELECT dDCRDate From dcr_detail 
          left join dcr_summary on dcr_detail.iDCRId=dcr_summary.iDCRId  
                  where iTaskId='" . $reqid . "' AND iPropertyId='" . $property_id . "'";
    }

    /* -------------------------------------------------------------------------------------------------------------------------------------------------------- */
}

// close of Employee model 
?>