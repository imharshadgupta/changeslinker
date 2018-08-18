<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cron extends CI_Controller {

    function __construct() {
        parent::__construct();

        date_default_timezone_set('Asia/Calcutta');

        $this->load->model('cron/cron_model');
        $this->load->library('My_PHPMailer');
    }

    // http://www.linkers.e-automate.in/index.php/cron/daily_tracker_report_mailer

    function daily_tracker_report_mailer() {                // mail to be sent at 8.30pm
        ob_start();

        $CurrentLocalDate = date('Y-m-d');

        $tbl = $this->cron_model->daily_tracker_report_mailer($CurrentLocalDate);

        if ($tbl) {
            $mail = new PHPMailer();
            $mail->IsSMTP();                                    // we are going to use SMTP
            $mail->SMTPAuth = true;                                // enabled SMTP authentication
            $mail->SMTPSecure = "ssl";    // prefix for secure protocol to connect to the server
            $mail->Host = "smtp.gmail.com";                    // setting GMail as our SMTP server
            $mail->Port = 587;                                // SMTP port to connect to GMail
            $mail->Username = "support@linkersindia.com";          // user email address
            $mail->Password = "manashids";                         // password in GMail

            $mail->SetFrom('support@linkersindia.com', 'Linkers');    //Who is sending the email
            $mail->AddReplyTo("support@linkersindia.com', 'Linkers"); //email address that receives the response
            $mail->Subject = "Daily Status Report";
            $mail->Body = "$tbl";

            $mail->AltBody = "To view the message, please use an HTML compatible email viewer!";

            $mail->AddAddress("vijay@linkersindia.com");
            $mail->AddCC("support@linkersindia.com");
            $mail->AddCC("ravi.baid@rachitsoftsol.com");

            //$mail->AddAttachment("images/phpmailer.gif");      			// some attached files
            //$mail->AddAttachment("images/phpmailer_mini.gif"); 			// as many as you want

            if (!$mail->Send()) {
                //echo "Error: " . $mail->ErrorInfo;
                return false;
            } else {
                //echo "Message sent correctly!";
                return true;
            }
        }
    }

    function sendEmail_pre($RecipientEmailAddress, $EmailSubject, $EmailMessage) {
        $mail = new PHPMailer();
        $mail->IsSMTP();                               // we are going to use SMTP
        $mail->SMTPAuth = true;                           // enabled SMTP authentication
        $mail->SMTPSecure = "ssl";    // prefix for secure protocol to connect to the server
        $mail->Host = "smtp.gmail.com";        // setting GMail as our SMTP server
        $mail->Port = 587;                           // SMTP port to connect to GMail
        $mail->Username = "support@linkersindia.com";     // user email address
        $mail->Password = "manashids";                    // password in GMail

        $mail->SetFrom('support@linkersindia.com', 'Linkers');     //Who is sending the email
        $mail->AddReplyTo("support@linkersindia.com', 'Linkers");  //email address that receives the response
        $mail->Subject = "$EmailSubject";
        $mail->Body = "$EmailMessage";

        $mail->AltBody = "To view the message, please use an HTML compatible email viewer!";

        $mail->AddAddress("$RecipientEmailAddress");     // Who is addressed the email to
        //$mail->AddAttachment("images/phpmailer.gif");      // some attached files
        //$mail->AddAttachment("images/phpmailer_mini.gif"); // as many as you want

        if (!$mail->Send()) {
            echo "Error: " . $mail->ErrorInfo;
            // return false;
        } else {
            echo "Message sent correctly!";
            //return true;
        }
    }

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

    function staff_task_reminder_mailer() {
        ob_start();

        //$CurrentLocalDateTime = date('Y-m-d H:i:s');

        $CurrentLocalDate = date('Y-m-d');

        $rows = $this->cron_model->staff_task_reminder_detail($CurrentLocalDate);

        foreach ($rows as $row) {
            $TaskAssignId = trim($row['iTaskAssignId']);

            $getTaskAssignDateTime = trim($row['dTaskAssignDateTime']);
            $TaskAssignDateTime = date('d/m/Y h:i:s a', strtotime($getTaskAssignDateTime));

            $ReqClientName = trim($row['cReqClientName']);

            $username = trim($row['cName']);

            $RequirementTitle = trim($row['cRequirementTitle']);

            $PropClientName = trim($row['cPropClientName']);

            $PropertyName = trim($row['cPropertyName']);

            $TaskAssignedByName = trim($row['cTaskAssignedByName']);

            $DepartmentId = trim($row['iDepartmentId']);

            $DepartmentName = trim($row['cDepartmentName']);

            $TaskSummary = $row['cTaskSummary'];

            if (!empty($row['dTaskTargetDateTime']) && ($row['dTaskTargetDateTime'] != '0000-00-00 00:00:00')) {
                $getTaskTargetDateTime = trim($row['dTaskTargetDateTime']);
                $TaskTargetDateTime = date('d/m/Y h:i:s a', strtotime($getTaskTargetDateTime));
            } else {
                $TaskTargetDateTime = "";
            }

            if (!empty($row['dReminderDateTime']) && ($row['dReminderDateTime'] != '0000-00-00 00:00:00')) {
                $getSetReminderDateTime = trim($row['dReminderDateTime']);
                $SetReminderDateTime = date('d/m/Y h:i:s a', strtotime($getSetReminderDateTime));
            } else {
                $SetReminderDateTime = "";
            }


            $UserEmailSubject = "Staff Task Reminder";

            $UserEmailMessage = "<p>Staff Task Details :-" . "</p>";
            $UserEmailMessage .= "<p>Share Date : $TaskAssignDateTime" . "</p>";
            $UserEmailMessage .= "<p>Task Assigned TO : $username" . "</p>";
            $UserEmailMessage .= "<p>Client Req : $ReqClientName" . "</p>";
            $UserEmailMessage .= "<p>Requirement : $RequirementTitle" . "</p>";
            $UserEmailMessage .= "<p>Client Prop : $PropClientName" . "</p>";
            $UserEmailMessage .= "<p>Property : $PropertyName" . "</p>";
            $UserEmailMessage .= "<p>Task Summary : $TaskSummary" . "</p>";
            $UserEmailMessage .= "<p>Target Date : $TaskTargetDateTime" . "</p>";
            $UserEmailMessage .= "<p>Assigned By : $TaskAssignedByName" . "</p>";
            //$UserEmailMessage.="Reminder Date : $SetReminderDateTime"."\n\n";


            $UserRecipientEmailAddress = "";

            //$sql = "SELECT user_master.cEmailAddress FROM user_master WHERE user_master.iDepartmentId='".$DepartmentId."' AND user_master.cEmailAddress<>'' AND user_master.cUserType='Employee' AND user_master.bActive=1";

            $sql = "SELECT user_master.cEmailAddress FROM user_master WHERE user_master.cEmailAddress<>'' AND user_master.bActive=1";

            $query = $this->db->query($sql);

            if ($query) {
                if ($query->num_rows > 0) {
                    $rows = $query->result_array();

                    foreach ($rows as $row) {                        
                                               
                        $EmailAddress = trim($row['cEmailAddress']);
                        $SendEmail = $this->SendEmail($EmailAddress, $UserEmailSubject, $UserEmailMessage);

                        //if((!empty($EmailAddress)) && (filter_var($EmailAddress, FILTER_VALIDATE_EMAIL) !== false))
                        //{  
                                               
                        if ($EmailAddress != "") {
                            if ($UserRecipientEmailAddress == '') {
                                $UserRecipientEmailAddress = $EmailAddress;
                            } else {
                                $UserRecipientEmailAddress .= "," . $EmailAddress;
                            }
                        } 
                    }
                }
            }

            if (!empty($UserRecipientEmailAddress)) {
                //$SendEmail = $this->SendEmail($UserRecipientEmailAddress,$UserEmailSubject,$UserEmailMessage);
            }
        }
    }

}

//end class