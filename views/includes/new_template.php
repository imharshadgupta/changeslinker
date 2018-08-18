<?php 
$is_logged_in = $this->session->userdata('is_logged_in');
if(!isset($is_logged_in) || $is_logged_in != true)
{
	//If no session, redirect to login page
	redirect('login', 'refresh');
}
?>
    
<?php
	$this->load->view('includes/header_new'); 
?>	

<br />
<?php	
	if($page_url!=''){ 
		$this->load->view($page_url); 
	} 
?>

<?php
//	$this->load->view('includes/footer'); 
?>
