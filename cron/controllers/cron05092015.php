<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cron extends CI_Controller {
 
    function __construct()
	{
		parent::__construct();
		
		date_default_timezone_set('Asia/Kolkata');
		
		$this->load->model('cron/cron_model');
		$this->load->library('My_PHPMailer');
	}

	//http://www.linkers.e-automate.in/index.php/cron/daily_tracker_report_mailer
	
    function daily_tracker_report_mailer()																// mail to be sent at 8.30pm
	{
		ob_start();
		
		$CurrentLocalDate = date('Y-m-d');
	
		$tbl = $this->cron_model->daily_tracker_report_mailer($CurrentLocalDate);

		if($tbl)
		{
			$mail = new PHPMailer();
			$mail->IsSMTP(); 		                                 // we are going to use SMTP
			$mail->SMTPAuth   = true;                                // enabled SMTP authentication
			$mail->SMTPSecure = "ssl";                               // prefix for secure protocol to connect to the server
			$mail->Host       = "smtp.gmail.com";                    // setting GMail as our SMTP server
			$mail->Port       =  465; //465                           // SMTP port to connect to GMail
			$mail->Username   = "support@linkersindia.com";          // user email address
			$mail->Password   = "manashids";                         // password in GMail
			
			$mail->SetFrom('support@linkersindia.com', 'Linkers');    //Who is sending the email
			$mail->AddReplyTo("support@linkersindia.com', 'Linkers"); //email address that receives the response
			$mail->Subject   = "Daily Status Report";
			$mail->Body  	 = "$tbl";
			
			$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!";
			
			//$mail->AddAddress("vijay@careerplusindia.com"); 			// Who is addressed the email to
			//$mail->AddCC("sushobhita@careerplusindia.com");
			//$mail->AddCC("ravi.baid@rachitsoftsol.com");
			//$mail->AddCC("mohatshim.rachitsoftsol@gmail.com");
			
			$mail->AddAddress("ravi.baid@rachitsoftsol.com");
			$mail->AddCC("mohatshim.rachitsoftsol@gmail.com");
		  
		  //$mail->AddAttachment("images/phpmailer.gif");      			// some attached files
		  //$mail->AddAttachment("images/phpmailer_mini.gif"); 			// as many as you want
			
			if(!$mail->Send()) {
			    //echo "Error: " . $mail->ErrorInfo;
				return false;
			}
			else 
			{
			   //echo "Message sent correctly!";
				return true;
			}
		}
	}

}//end class