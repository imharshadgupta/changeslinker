<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('dashboard_model');

        //$this->load->config('constants');

        $this->load->library("Pdf");

        $this->load->library('My_PHPMailer');

        date_default_timezone_set('Asia/Calcutta');
    }

    function index() {
        $data = array();
        $data['message'] = "";
        //$data['query'] = $this->dashboard_model->get_all_client_master();
        $data['page_url'] = "client_master_listing_datatable";
        $this->load->view('includes/template', $data);
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

    function home() {
        $data['page_url'] = "";

        $this->load->view('includes/template', $data);
    }

    function searchform() {
        $data['page_url'] = "search_listing";

        $this->load->view('includes/template', $data);
    }

    function search() {
        if (isset($_POST['txtSearch']) && ($_POST['txtSearch'] != '') && isset($_POST['cmbFilter']) && ($_POST['cmbFilter'] != '')) {
            $Filter = trim($_REQUEST['cmbFilter']);

            $txtSearch = trim($_REQUEST['txtSearch']);

            //echo $Filter."=>".$txtSearch;

            if ($Filter == 'Property') {
                $data = array();
                $data['message'] = "";
                $data['Filter'] = "Property";
                $data['txtSearch'] = $txtSearch;
                $data['query'] = $this->dashboard_model->search_by_text_in_property($txtSearch);
                $data['page_url'] = "search_listing";
                $this->load->view('includes/template', $data);
            }

            if ($Filter == 'Client') {
                $data = array();
                $data['message'] = "";
                $data['Filter'] = "Client";
                $data['txtSearch'] = $txtSearch;
                $data['query'] = $this->dashboard_model->search_by_text_in_client($txtSearch);
                $data['page_url'] = "search_listing";
                $this->load->view('includes/template', $data);
            }

            if ($Filter == 'Requisition') {
                $data = array();
                $data['message'] = "";
                $data['Filter'] = "Requisition";
                $data['txtSearch'] = $txtSearch;
                $data['query'] = $this->dashboard_model->search_by_text_in_requirement($txtSearch);
                $data['page_url'] = "search_listing";
                $this->load->view('includes/template', $data);
            }
        } else {
            $data = array();
            $data['message'] = "";
            $data['page_url'] = "search_listing";
            $this->load->view('includes/template', $data);
        }
    }

    function searchrfpsrform() {
        $data['SearchFor'] = trim($this->input->post('cmbSearchFor'));
        $data['ClientId'] = trim($this->input->post('cmbClient'));
        $data['RFPSRId'] = trim($this->input->post('cmbRFPSR'));
        $data['page_url'] = "search_rf_psr_listing";

        $this->load->view('includes/template', $data);
    }

    function searchclientwiseform() {
        $data['ClientId'] = trim($this->input->post('cmbClient'));

        $data['page_url'] = "search_clientwise_listing";

        $this->load->view('includes/template', $data);
    }

    //--------------------------------------------------------------------------------------------------------------------------------------------

    function getclientfromrfmaster() {
        $data['result'] = $this->dashboard_model->get_clients_from_requirement_master();
        $getdata = json_encode($data['result']);
        echo $getdata;
    }

    function getclientfrompsrmaster() {
        $data['result'] = $this->dashboard_model->get_clients_from_property_master();
        $getdata = json_encode($data['result']);
        echo $getdata;
    }

    function getrfbyclientid() {
        $ClientId = trim($this->input->post('cmbClient'));
        $data['result'] = $this->dashboard_model->get_requirement_by_client_id($ClientId);
        $getdata = json_encode($data['result']);
        echo $getdata;
    }

    function getpsrbyclientid() {
        $ClientId = trim($this->input->post('cmbClient'));
        $data['result'] = $this->dashboard_model->get_property_by_client_id($ClientId);
        $getdata = json_encode($data['result']);
        echo $getdata;
    }

    //--------------------------------------------------------------------------------------------------------------------------------------------

    function searchrfpsr() {
        if (isset($_POST['cmbSearchFor']) && ($_POST['cmbSearchFor'] != '') && isset($_POST['cmbRFPSR']) && ($_POST['cmbRFPSR'] != '')) {
            $SearchFor = trim($_REQUEST['cmbSearchFor']);

            $RFPSRId = trim($_REQUEST['cmbRFPSR']);

            //echo $Filter."=>".$txtSearch;

            if ($SearchFor == 'RF') {
                $data = array();
                $data['message'] = "";
                $data['SearchFor'] = "RF";
                $data['ClientId'] = $_POST['cmbClient'];
                $data['RFPSRId'] = $_POST['cmbRFPSR'];

                $sql = "SELECT iCityId,iLocationId,iPropertyCategoryId FROM requirement_master WHERE requirement_master.iRequirementId='" . $RFPSRId . "'";

                $query = $this->db->query($sql);

                if ($query) {
                    $row = $query->row_array();
                    if ($row) {
                        $CityId = trim($row['iCityId']);
                        $LocationId = trim($row['iLocationId']);
                        $PropertyCategoryId = trim($row['iPropertyCategoryId']);
                    } else {
                        $CityId = "";
                        $LocationId = "";
                        $PropertyCategoryId = "";
                    }

                    $data['query'] = $this->dashboard_model->search_by_location_propertytype_in_property($CityId, $LocationId, $PropertyCategoryId);
                    $data['page_url'] = "search_rf_psr_listing";
                    $this->load->view('includes/template', $data);
                }
            }

            if ($SearchFor == 'PSR') {
                $data = array();
                $data['message'] = "";
                $data['SearchFor'] = "PSR";
                $data['ClientId'] = $_POST['cmbClient'];
                $data['RFPSRId'] = $_POST['cmbRFPSR'];

                $sql = "SELECT iCityId,iLocationId,iPropertyCategoryId FROM property_master WHERE property_master.iPropertyId='" . $RFPSRId . "'";

                $query = $this->db->query($sql);

                if ($query) {
                    $row = $query->row_array();

                    $CityId = trim($row['iCityId']);
                    $LocationId = trim($row['iLocationId']);
                    $PropertyCategoryId = trim($row['iPropertyCategoryId']);

                    $data['query'] = $this->dashboard_model->search_by_location_propertytype_in_requirement($CityId, $LocationId, $PropertyCategoryId);
                    $data['page_url'] = "search_rf_psr_listing";
                    $this->load->view('includes/template', $data);
                }
            }
        } else {
            $data = array();
            $data['message'] = "";
            $data['page_url'] = "search_rf_psr_listing";
            $this->load->view('includes/template', $data);
        }
    }

    //-----------------------------------------------------------------------------------------------------------------------

    function searchclientwise() {
        $data = array();
        $data['message'] = "";
        $ClientId = $_POST['cmbClient'];
        $data['ClientId'] = $ClientId;
        $data['query'] = $this->dashboard_model->search_client_wise($ClientId);
        $data['page_url'] = "search_clientwise_listing";
        $this->load->view('includes/template', $data);
    }

    //----------------------------------------------------------------------------------------------------------------------

    private function handle_upload() {
        $config['upload_path'] = './uploads/profile_pics/'; //Make SURE that you chmod this directory to 777!
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '0'; // 0 = no limit on file size (this also depends on your PHP configuration)
        $config['remove_spaces'] = TRUE; //Remove spaces from the file name

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('txtSchoolLogo')) {
            $data['error'] = array('error' => $this->upload->display_errors());
            log_message('error', $data['error']);
        } else {
            $data = array('upload_data' => $this->upload->data());
        }
        return $data;
    }

    function userpendingtasklist() {
        //$UserId = trim($this->session->userdata('UserId'));
        //$data['query'] = $this->dashboard_model->user_pending_task_list_all($UserId);

        if (($this->session->userdata('UserType') == 'Admin')) {
            $data['query'] = $this->dashboard_model->user_pending_task_list_all();

            $data['page_url'] = 'user_pending_task_listing';

            $this->load->view('includes/template', $data);
        } else {
            $UserDeptId = trim($this->session->userdata('UserDeptId'));

            $data['query'] = $this->dashboard_model->user_pending_task_by_dept($UserDeptId);

            $data['page_url'] = 'user_pending_task_listing';

            $this->load->view('includes/template', $data);
        }
    }

    //---------------------------------------------------------------------------------------------------------------------------------------------------------

    /* public function upload_agreement_file()
      {
      $status="";
      $msg="";
      $uploadedagreementfilepath="";
      $uploadedagreementfilename="";
      $file_element_name='txtAgreement';

      if(!isset($_FILES['txtAgreement']['name']) && empty($_FILES['txtAgreement']['name']))
      {
      $status = "error";
      $msg = "Please select Agreement file";
      }

      $propertyattachdata=array();

      if($status!="error")
      {
      $config['file_name']='property_agreement'."_".time();
      $config['upload_path'] = './upload/property_attachments';
      $config['allowed_types'] = 'gif|jpg|png|doc|txt';
      $config['max_size']     = '0';   // 0 = no limit on file size (this also depends on your PHP configuration)
      $config['remove_spaces'] = TRUE; // Remove spaces from the file name
      //$config['encrypt_name'] = TRUE;

      $this->load->library('upload', $config);

      if(!$this->upload->do_upload($file_element_name))
      {
      $status = 'error';
      $msg = $this->upload->display_errors('', '');
      }
      else
      {
      $data = $this->upload->data();

      if($data)
      {
      $status = "success";
      $msg = "File successfully uploaded";
      $uploadedagreementfilepath='./uploads/property_attachments/'.$data['file_name'];
      $uploadedagreementfilename = $data['file_name'];
      }
      else
      {
      $status = "error";
      $msg = "Something went wrong when saving the file, please try again.";
      $uploadedagreementfilename="";
      }
      /*$file_id = $this->files_model->insert_file($data['file_name'], $_POST['title']);
      if($file_id)
      {
      $status = "success";
      $msg = "File successfully uploaded";
      }
      else
      {
      unlink($data['full_path']);
      $status = "error";
      $msg = "Something went wrong when saving the file, please try again.";
      }*
      }

      //@unlink($_FILES[$file_element_name]);
      }

      echo json_encode(array('status' => $status, 'msg' => $msg , 'agreementfilepath' => $uploadedagreementfilepath, 'agreementfilename' => $uploadedagreementfilename));

      } */

    //------------------------------------------------------Requirement---------------------------------------------------------------------------------

    public function upload_requirement_agreement_file() {
        $status = "";
        $msg = "";
        $uploadedagreementfilepath = "";
        $uploadedagreementfilename = "";
        $file_element_name = 'txtAgreement';

        /* if(empty($_POST['title']))
          {
          $status = "error";
          $msg = "Please enter a title";
          } */

        if (!isset($_FILES['txtAgreement']['name']) && empty($_FILES['txtAgreement']['name'])) {
            $status = "error";
            $msg = "Please select file";
        }

        if ($status != "error") {
            $config['file_name'] = 'requirement_agreement' . "_" . time();
            $config['upload_path'] = './uploads/requirement_attachments';
            $config['allowed_types'] = 'gif|jpg|png|doc|txt|xls|xlsx';
            //$config['max_size'] = 1024 * 8;
            //$config['encrypt_name'] = TRUE;
            $config['max_size'] = '0';   // 0 = no limit on file size (this also depends on your PHP configuration)
            $config['remove_spaces'] = TRUE; // Remove spaces from the file name

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload($file_element_name)) {
                $status = 'error'; //$file_element_name;
                $msg = $this->upload->display_errors('', '');
            } else {
                $data = $this->upload->data();

                if ($data) {
                    $status = "success";
                    $msg = "Agreement File successfully uploaded";
                    $uploadedagreementfilepath = './uploads/requirement_attachments/' . $data['file_name']; //$data['full_path']
                    $uploadedagreementfilename = $data['file_name'];
                } else {
                    unlink($data['full_path']);
                    $status = "error";
                    $msg = "Something went wrong when saving the file, please try again.";
                }
            }

            @unlink($_FILES[$file_element_name]);
        }

        //echo json_encode(array('status' => $status, 'msg' => $msg, 'attachment_file_path' => $uploadedattachmentfilepath, 'attachment_file_name' => $uploadedattachmentfilename));

        echo json_encode(array('status' => $status, 'msg' => $msg, 'agreement_file_path' => $uploadedagreementfilepath, 'agreement_file_name' => $uploadedagreementfilename));
    }

    //--------------------------------------------------------------------------------------------------------------------------------------------

    function delete_existing_requirement_agreement() {
        $PropertyId = trim($this->input->post('PropertyId'));
        $AgreementName = trim($this->input->post('AgreementName'));
        $AgreementPath = trim($this->input->post('AgreementPath'));

        if (file_exists($AgreementPath)) {
            $delete = unlink($AgreementPath);

            if ($delete) {
                $sql = "UPDATE requirement_master SET requirement_master.cAgreementPath='' AND property_master.cAgreementName='' WHERE requirement_master.iPropertyId='" . $PropertyId . "'";

                $query = $this->db->query($sql);

                if ($query) {
                    echo 'TRUE';
                } else {
                    echo 'FALSE';
                }
            }
        } else {
            echo "File not found";
        }
    }

    function delete_uploaded_requirement_agreement() {
        $AgreementName = trim($this->input->post('AgreementName'));
        $AgreementPath = trim($this->input->post('AgreementPath'));

        if (file_exists($AgreementPath)) {
            $delete = unlink($AgreementPath);

            if ($delete) {
                echo 'TRUE';
            } else {
                echo 'FALSE';
            }
        } else {
            echo "File not found";
        }
    }

    //---------------------------------------------------Property-----------------------------------------------------------------------------------------

    public function upload_property_agreement_file() {
        $status = "";
        $msg = "";
        $uploadedagreementfilepath = "";
        $uploadedagreementfilename = "";
        $file_element_name = 'txtAgreement';

        /* if(empty($_POST['title']))
          {
          $status = "error";
          $msg = "Please enter a title";
          } */

        if (!isset($_FILES['txtAgreement']['name']) && empty($_FILES['txtAgreement']['name'])) {
            $status = "error";
            $msg = "Please select file";
        }

        if ($status != "error") {
            $config['file_name'] = 'property_agreement' . "_" . time();
            $config['upload_path'] = './uploads/property_attachments';
            $config['allowed_types'] = 'gif|jpg|png|doc|txt|xls|xlsx';
            //$config['max_size'] = 1024 * 8;
            //$config['encrypt_name'] = TRUE;
            $config['max_size'] = '0';   // 0 = no limit on file size (this also depends on your PHP configuration)
            $config['remove_spaces'] = TRUE; // Remove spaces from the file name

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload($file_element_name)) {
                $status = 'error';
                $msg = $this->upload->display_errors('', '');
            } else {
                $data = $this->upload->data();

                if ($data) {
                    $status = "success";
                    $msg = "File successfully uploaded";
                    $uploadedagreementfilepath = './uploads/property_attachments/' . $data['file_name']; //$data['full_path']
                    $uploadedagreementfilename = $data['file_name'];
                } else {
                    unlink($data['full_path']);
                    $status = "error";
                    $msg = "Something went wrong when saving the file, please try again.";
                }
            }

            //@unlink($_FILES[$file_element_name]);
        }

        echo json_encode(array('status' => $status, 'msg' => $msg, 'agreement_file_path' => $uploadedagreementfilepath, 'agreement_file_name' => $uploadedagreementfilename));
    }

    //--------------------------------------------------------------------------------------------------------------------------------------------------------
    //-------------------------------------------------- Other Docs ------------------------------------------------------------------------------------------

    public function upload_property_attachment($attachno) {
        $status = "";
        $msg = "";
        $uploadedattachmentfilepath = "";
        $uploadedattachmentfilename = "";
        $file_element_name = 'txtAttachment' . $attachno;

        /* if(empty($_POST['title']))
          {
          $status = "error";
          $msg = "Please enter a title";
          } */

        if (!isset($_FILES['txtAttachment' . $attachno]['name']) && empty($_FILES['txtAttachment' . $attachno]['name'])) {
            $status = "error";
            $msg = "Please select file";
        }

        if ($status != "error") {
            $config['file_name'] = 'attachment' . "_" . time();
            $config['upload_path'] = './uploads/property_attachments/';
            $config['allowed_types'] = '*';       // accept all types of files. in CI 2.0			
            $config['max_size'] = '500';       // 500 kb.    // 0 = no limit on file size (this also depends on your PHP configuration)
            $config['remove_spaces'] = TRUE;        // Remove spaces from the file name 
            //$config['allowed_types'] = 'gif|jpg|png|doc|txt';
            //$config['max_size'] = 1024 * 8;
            //$config['encrypt_name'] = TRUE;	

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload($file_element_name)) {
                //$status = 'error'."=>".$file_element_name;
                $status = 'error';
                $msg = $this->upload->display_errors('', '');
            } else {
                $data = $this->upload->data();

                if ($data) {
                    $status = "success";
                    $msg = "Attachment $attachno successfully uploaded !";
                    $uploadedattachmentfilepath = './uploads/property_attachments/' . $data['file_name']; //$data['full_path']
                    $uploadedattachmentfilename = $data['file_name'];
                } else {
                    unlink($data['full_path']);
                    $status = "error";
                    $msg = "Something went wrong when saving the file, please try again.";
                }

                /* $file_id = $this->files_model->insert_file($data['file_name'], $_POST['title']);
                  if($file_id)
                  {
                  $status = "success";
                  $msg = "File successfully uploaded";
                  }
                  else
                  {
                  unlink($data['full_path']);
                  $status = "error";
                  $msg = "Something went wrong when saving the file, please try again.";
                  } */
            }

            @unlink($_FILES[$file_element_name]);
        }

        echo json_encode(array('status' => $status, 'msg' => $msg, 'attachment_file_path' => $uploadedattachmentfilepath, 'attachment_file_name' => $uploadedattachmentfilename));
    }

    function delete_existing_property_agreement() {
        $PropertyId = trim($this->input->post('PropertyId'));
        $AgreementName = trim($this->input->post('AgreementName'));
        $AgreementPath = trim($this->input->post('AgreementPath'));

        if (file_exists($AgreementPath)) {
            $delete = unlink($AgreementPath);

            if ($delete) {
                $sql = "UPDATE property_master SET property_master.cAgreementPath='' AND property_master.cAgreementName='' WHERE property_master.iPropertyId='" . $PropertyId . "'";

                $query = $this->db->query($sql);

                if ($query) {
                    echo 'TRUE';
                } else {
                    echo 'FALSE';
                }
            }
        } else {
            echo "File not found";
        }
    }

    function delete_uploaded_property_agreement() {
        $AgreementName = trim($this->input->post('AgreementName'));
        $AgreementPath = trim($this->input->post('AgreementPath'));

        if (file_exists($AgreementPath)) {
            $delete = unlink($AgreementPath);

            if ($delete) {
                echo 'TRUE';
            } else {
                echo 'FALSE';
            }
        } else {
            echo "File not found";
        }
    }

    function delete_uploaded_property_attachment() {
        $AttachmentName = trim($this->input->post('AttachmentName'));
        $AttachmentPath = trim($this->input->post('AttachmentPath'));

        if (file_exists($AttachmentPath)) {
            $delete = unlink($AttachmentPath);

            if ($delete) {
                echo 'TRUE';
            } else {
                echo 'FALSE';
            }
        } else {
            echo "File not found";
        }
    }

    function delete_existing_property_attachment() {
        $AttachmentId = trim($this->input->post('AttachmentId'));
        $PropertyId = trim($this->input->post('PropertyId'));
        $AttachmentName = trim($this->input->post('AttachmentName'));
        $AttachmentPath = trim($this->input->post('AttachmentPath'));

        $result = $this->dashboard_model->property_existing_attachment_delete($AttachmentId, $AttachmentPath);

        if ($result) {
            echo 'TRUE';
        } else {
            echo 'FALSE';
        }
    }

    /* function upload_attachment()
      {
      $status="";
      $msg="";
      $file_element_name='txtEmpDoc1';

      $uploadedDocFiles = array();

      if(isset($_FILES['txtEmpDoc1']['name']) && !empty($_FILES['txtEmpDoc1']['name']))
      {
      $config['file_name']='property_attachment'."_".time();
      $config2['upload_path'] = './uploads/property_attachments/';
      //$config2['allowed_types'] = 'gif|jpg|png|bmp|jpeg|txt|pdf|xls|xlsx|doc|rtf|csv';
      $config2['allowed_types'] = '*'; // accept all types of files. in CI 2.0
      $config2['max_size'] = '0';	    // 0 = no limit on file size (this also depends on your PHP configuration)
      $config2['remove_spaces']=TRUE; //Remove spaces from the file name

      /*$data = array();
      $count = count($_FILES);
      $len = ($count-1);
      //echo $len;
      //exit();

      $curdate_empcode = date('Ymd')."_".trim($this->input->post('txtEmployeeCode'));

      $j=1;
      $this->load->library('upload', $config2);

      for($i=0; $i<$len; $i++)
      {
      //echo $_FILES['txtEmpDoc'.$j]['name']."<br/ >";

      $upload = $this->upload->do_upload('txtEmpDoc'.$j);

      $data = array('upload_data' => $this->upload->data());

      // echo $data['upload_data']['file_name']."<br />";

      $uploadedDocFiles[$i]['emp_doc_title'] = trim($this->input->post('txtEmpDocTitle'.$j));
      $uploadedDocFiles[$i]['emp_doc_file_path'] = 'uploads/employee_docs/other_docs/'.$data['upload_data']['file_name'];
      $uploadedDocFiles[$i]['emp_doc_file_name'] = $data['upload_data']['file_name'];

      $j++;
      }
      //print_r($uploadedDocFiles);
      //exit();
     *
      }
      } */

    //-------------------------------------------------- Deal Docs ------------------------------------------------------------------------------------------

    public function upload_deal_attachment($attachno) {
        $status = "";
        $msg = "";
        $uploadedattachmentfilepath = "";
        $uploadedattachmentfilename = "";
        $file_element_name = 'txtAttachment' . $attachno;

        /* if(empty($_POST['title']))
          {
          $status = "error";
          $msg = "Please enter a title";
          } */

        if (!isset($_FILES['txtAttachment' . $attachno]['name']) && empty($_FILES['txtAttachment' . $attachno]['name'])) {
            $status = "error";
            $msg = "Please select file";
        }

        if ($status != "error") {
            $config['file_name'] = 'attachment' . "_" . time();
            $config['upload_path'] = './uploads/deal_attachments/';
            $config['allowed_types'] = '*'; // accept all types of files. in CI 2.0			
            $config['max_size'] = '0';     // 0 = no limit on file size (this also depends on your PHP configuration)
            $config['remove_spaces'] = TRUE; //Remove spaces from the file name 
            //$config['allowed_types'] = 'gif|jpg|png|doc|txt';
            //$config['max_size'] = 1024 * 8;
            //$config['encrypt_name'] = TRUE;	

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload($file_element_name)) {
                $status = 'error' . $file_element_name;
                $msg = $this->upload->display_errors('', '');
            } else {
                $data = $this->upload->data();

                if ($data) {
                    $status = "success";
                    $msg = "Attachment $attachno successfully uploaded !";
                    $uploadedattachmentfilepath = './uploads/deal_attachments/' . $data['file_name']; //$data['full_path']
                    $uploadedattachmentfilename = $data['file_name'];
                } else {
                    unlink($data['full_path']);
                    $status = "error";
                    $msg = "Something went wrong when saving the file, please try again.";
                }

                /* $file_id = $this->files_model->insert_file($data['file_name'], $_POST['title']);
                  if($file_id)
                  {
                  $status = "success";
                  $msg = "File successfully uploaded";
                  }
                  else
                  {
                  unlink($data['full_path']);
                  $status = "error";
                  $msg = "Something went wrong when saving the file, please try again.";
                  } */
            }

            @unlink($_FILES[$file_element_name]);
        }

        echo json_encode(array('status' => $status, 'msg' => $msg, 'attachment_file_path' => $uploadedattachmentfilepath, 'attachment_file_name' => $uploadedattachmentfilename));
    }

    function delete_uploaded_deal_attachment() {
        $AttachmentName = trim($this->input->post('AttachmentName'));
        $AttachmentPath = trim($this->input->post('AttachmentPath'));

        if (file_exists($AttachmentPath)) {
            $delete = unlink($AttachmentPath);

            if ($delete) {
                echo 'TRUE';
            } else {
                echo 'FALSE';
            }
        } else {
            echo "File not found";
        }
    }

    //---------------------------------------------------------------------------------------------------------------------------------------------------------
    //---------------------------------------------------------------------------------------------------------------------------------------------------------

    public function upload_file() {
        $status = "";
        $msg = "";
        $file_element_name = 'userfile';

        /* if(empty($_POST['title']))
          {
          $status = "error";
          $msg = "Please enter a title";
          } */

        if (!isset($_FILES['userfile']['name']) && empty($_FILES['userfile']['name'])) {
            $status = "error";
            $msg = "Please select file";
        }

        if ($status != "error") {
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'gif|jpg|png|doc|txt';
            $config['max_size'] = 1024 * 8;
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload($file_element_name)) {
                $status = 'error';
                $msg = $this->upload->display_errors('', '');
            } else {
                $data = $this->upload->data();

                if ($data) {
                    $status = "success";
                    $msg = "File successfully uploaded";
                } else {
                    $status = "error";
                    $msg = "Something went wrong when saving the file, please try again.";
                }

                /* $file_id = $this->files_model->insert_file($data['file_name'], $_POST['title']);
                  if($file_id)
                  {
                  $status = "success";
                  $msg = "File successfully uploaded";
                  }
                  else
                  {
                  unlink($data['full_path']);
                  $status = "error";
                  $msg = "Something went wrong when saving the file, please try again.";
                  } */
            }

            //@unlink($_FILES[$file_element_name]);
        }

        echo json_encode(array('status' => $status, 'msg' => $msg));
    }

    //--------------------------------------------------------------------------------------------------------------------------------------------

    function getdistrictbystate() {
        $StateId = trim($this->input->post('cmbState'));
        //echo $StateId;
        $data['result'] = $this->dashboard_model->get_district_by_state($StateId);
        $getdata = json_encode($data['result']);
        echo $getdata;
    }

    //--------------------------------------------------------------------------------------------------------------------------------------------

    function getcitybystateanddistrict() {
        $StateId = trim($this->input->post('cmbState'));
        $DistrictId = trim($this->input->post('cmbDistrict'));
        //echo $DistrictId;
        $data['result'] = $this->dashboard_model->get_city_by_state_and_district($StateId, $DistrictId);
        $getdata = json_encode($data['result']);
        echo $getdata;
    }

    //--------------------------------------------------------------------------------------------------------------------------------------------

    function getcitybystate() {
        $StateId = trim($this->input->post('cmbState'));
        //echo $StateId;
        $data['result'] = $this->dashboard_model->get_city_by_state($StateId);
        $getdata = json_encode($data['result']);
        echo $getdata;
    }

    //--------------------------------------------------------------------------------------------------------------------------------------------

    function getpropertyownerbyproperty() {
        $PropertyId = trim($this->input->post('cmbProperty'));
        //echo $StateId;
        $data['result'] = $this->dashboard_model->get_property_owner_by_property($PropertyId);
        $getdata = json_encode($data['result']);
        echo $getdata;
    }

    //--------------------------------------------------------------------------------------------------------------------------------------------

    function getlocationbystateanddistrictandcity() {
        $StateId = trim($this->input->post('cmbState'));
        $DistrictId = trim($this->input->post('cmbDistrict'));
        $CityId = trim($this->input->post('cmbCity'));
        //echo $DistrictId;
        $data['result'] = $this->dashboard_model->get_location_by_state_and_district_and_city($StateId, $DistrictId, $CityId);
        $getdata = json_encode($data['result']);
        echo $getdata;
    }

    //--------------------------------------------------------------------------------------------------------------------------------------------

    function getcontactpersonbyclient() {
        $ClientId = trim($this->input->post('cmbClient'));
        //echo $ClientId;
        $data['result'] = $this->dashboard_model->get_contact_person_by_client($ClientId);
        $getdata = json_encode($data['result']);
        echo $getdata;
    }

    //--------------------------------------------------------------------------------------------------------------------------------------------

    function getcontactdetailsbycontactperson() {
        $ClientId = trim($this->input->post('cmbClient'));
        $ColumnNo = trim($this->input->post('cmbContactPerson'));
        $data['result'] = $this->dashboard_model->get_contact_details_by_contact_person($ClientId, $ColumnNo);
        //$getdata=json_encode($data['result']);
        $getdata = $data['result'];
        echo $getdata;
    }

    //--------------------------------------------------------------------------------------------------------------------------------------------

    function suggestparties() {
        if ($_REQUEST['term']) {
            $partyname = trim($_REQUEST['term']);

            $data = $this->main->suggest_party_names($partyname);

            echo json_encode($data);
        }
    }

    //------------------------------------------------------------------------------------------------------------------------------------------------------

    function suggestproperties() {
        if ($_REQUEST['term']) {
            $propertyname = trim($_REQUEST['term']);

            $data = $this->main->suggest_property_names($propertyname);

            echo json_encode($data);
        }
    }

    //---------------------------------------------------------------------------------------------------------------------------------------------------------
    //--------------------------------------------------- Agreement Type --------------------------------------------------------------------------------------

    function listing_agreement_type_master() {
        $data = array();
        $data['message'] = "";
        $data['query'] = $this->dashboard_model->get_all_agreement_type_master();
        $data['page_url'] = "agreement_type_master_listing";
        $this->load->view('includes/template', $data);
    }

    function add_form_agreement_type_master() {
        $data = array();
        $data['message'] = "";
        $data['page_url'] = "agreement_type_master_add_form";
        $this->load->view('includes/template', $data);
    }

    function add_agreement_type_master() {
        if ($this->input->post()) {
            $data = $_POST;
            echo $this->dashboard_model->add_agreement_type_master($data);
            exit;
        }
    }

    function edit_form_agreement_type_master($id) {
        if ($id == null) {
            show_error('No identifier provided', 500);
        } else {
            $data = array();
            $data['message'] = '';

            $row = $this->dashboard_model->agreement_type_master_get_by_id($id);

            if ($row) {
                $data['AgreementTypeId'] = trim($row['iAgreementTypeId']);
                $data['AgreementTypeName'] = trim($row['cAgreementTypeName']);
                $data['Active'] = trim($row['bActive']);

                $data['page_url'] = 'agreement_type_master_edit_form';
                $this->load->view('includes/template', $data);
            } else {
                show_error('Error in retrieving data by id');
            }
        }
    }

    function edit_agreement_type_master() {
        if ($this->input->post()) {
            $data = $_POST;
            echo $this->dashboard_model->edit_agreement_type_master($data);
            exit;
        }
    }

    function delete_agreement_type_master($id) {
        $delete = $this->dashboard_model->delete_agreement_type_master($id);

        if ($delete) {
            redirect('dashboard/listing_agreement_type_master');
        }
    }

    //--------------------------------------------------- Call Type ------------------------------------------------------------------------------------------

    function listing_call_type_master() {
        $data = array();
        $data['message'] = "";
        $data['query'] = $this->dashboard_model->get_all_call_type_master();
        $data['page_url'] = "call_type_master_listing";
        $this->load->view('includes/template', $data);
    }

    function add_form_call_type_master() {
        $data = array();
        $data['message'] = "";
        $data['page_url'] = "call_type_master_add_form";
        $this->load->view('includes/template', $data);
    }

    function add_call_type_master() {
        if ($this->input->post()) {
            $data = $_POST;
            echo $this->dashboard_model->add_call_type_master($data);
            exit;
        }
    }

    function edit_form_call_type_master($id) {
        if ($id == null) {
            show_error('No identifier provided', 500);
        } else {
            $data = array();
            $data['message'] = '';

            $row = $this->dashboard_model->call_type_master_get_by_id($id);

            if ($row) {
                $data['CallTypeId'] = trim($row['iCallTypeId']);
                $data['CallTypeName'] = trim($row['cCallTypeName']);
                $data['Active'] = trim($row['bActive']);

                $data['page_url'] = 'call_type_master_edit_form';
                $this->load->view('includes/template', $data);
            } else {
                show_error('Error in retrieving data by id');
            }
        }
    }

    function edit_call_type_master() {
        if ($this->input->post()) {
            $data = $_POST;
            echo $this->dashboard_model->edit_call_type_master($data);
            exit;
        }
    }

    function delete_call_type_master($id) {
        $delete = $this->dashboard_model->delete_call_type_master($id);

        if ($delete) {
            redirect('dashboard/listing_call_type_master');
        }
    }

    //--------------------------------------------------- Party Type --------------------------------------------------------------------------------------

    /* function listing_party_type_master()
      {
      $data = array();
      $data['message']="";
      $data['query'] = $this->dashboard_model->get_all_party_type_master();
      $data['page_url']="party_type_master_listing";
      $this->load->view('includes/template', $data);
      }

      function add_form_party_type_master()
      {
      $data = array();
      $data['message']="";
      $data['page_url']="party_type_master_add_form";
      $this->load->view('includes/template', $data);
      }

      function add_party_type_master()
      {
      if($this->input->post()){
      $data = $_POST;
      echo $this->dashboard_model->add_party_type_master($data);
      exit;
      }
      }

      function edit_form_party_type_master($id)
      {
      if($id == null) {
      show_error('No identifier provided', 500);
      }
      else
      {
      $data = array();
      $data['message'] = '';

      $row = $this->dashboard_model->party_type_master_get_by_id($id);

      if($row)
      {
      $data['PartyTypeId'] = trim($row['iPartyTypeId']);
      $data['PartyTypeName'] = trim($row['cPartyTypeName']);
      $data['Active'] = trim($row['bActive']);

      $data['page_url'] = 'party_type_master_edit_form';
      $this->load->view('includes/template', $data);
      }
      else
      {
      show_error('Error in retrieving data by id');
      }
      }
      }

      function edit_party_type_master()
      {
      if($this->input->post()){
      $data = $_POST;
      echo $this->dashboard_model->edit_party_type_master($data);
      exit;
      }
      }

      function delete_party_type_master($id)
      {
      $delete = $this->dashboard_model->delete_party_type_master($id);

      if($delete)
      {
      redirect('dashboard/listing_party_type_master');
      }
      }

      //----------------------------------------------------- Party --------------------------------------------------------------------------------------

      function listing_party_master()
      {
      $data = array();
      $data['message']="";
      $data['query'] = $this->dashboard_model->get_all_party_master();
      $data['page_url']="party_master_listing";
      $this->load->view('includes/template', $data);
      }

      function add_form_party_master()
      {
      $data = array();
      $data['message']="";
      $data['page_url']="party_master_add_form";
      $this->load->view('includes/template', $data);
      }

      function add_party_master()
      {
      if($this->input->post()){
      $data = $_POST;
      echo $this->dashboard_model->add_party_master($data);
      exit;
      }
      }

      function edit_form_party_master($id)
      {
      if($id == null) {
      show_error('No identifier provided', 500);
      }
      else
      {
      $data = array();
      $data['message'] = '';

      $row = $this->dashboard_model->party_master_get_by_id($id);

      if($row)
      {
      $data['PartyId'] = trim($row['iPartyId']);
      $data['PartyTypeId'] = trim($row['iPartyTypeId']);
      $data['PartyName'] = trim($row['cPartyName']);

      $data['Address'] = trim($row['cAddress']);
      $data['StateId'] = trim($row['iStateId']);
      $data['DistrictId'] = trim($row['iDistrictId']);
      $data['CityId'] = trim($row['iCityId']);
      $data['Location'] = trim($row['cLocation']);
      $data['Landmark'] = trim($row['cLandmark']);

      $data['ContactPerson1Name'] = trim($row['cContactPerson1Name']);
      $data['ContactPerson1Designation'] = trim($row['cContactPerson1Designation']);
      $data['ContactPerson1PhoneNo1'] = trim($row['cContactPerson1PhoneNo1']);
      $data['ContactPerson1PhoneNo2'] = trim($row['cContactPerson1PhoneNo2']);
      $data['ContactPerson1Email'] = trim($row['cContactPerson1Email']);

      $data['ContactPerson2Name'] = trim($row['cContactPerson2Name']);
      $data['ContactPerson2Designation'] = trim($row['cContactPerson2Designation']);
      $data['ContactPerson2PhoneNo1'] = trim($row['cContactPerson2PhoneNo1']);
      $data['ContactPerson2PhoneNo2'] = trim($row['cContactPerson2PhoneNo2']);
      $data['ContactPerson2Email'] = trim($row['cContactPerson2Email']);

      $data['ContactPerson3Name'] = trim($row['cContactPerson3Name']);
      $data['ContactPerson3Designation'] = trim($row['cContactPerson3Designation']);
      $data['ContactPerson3PhoneNo1'] = trim($row['cContactPerson3PhoneNo1']);
      $data['ContactPerson3PhoneNo2'] = trim($row['cContactPerson3PhoneNo2']);
      $data['ContactPerson3Email'] = trim($row['cContactPerson3Email']);

      $data['Active'] = trim($row['bActive']);

      $data['page_url'] = 'party_master_edit_form';
      $this->load->view('includes/template', $data);
      }
      else
      {
      show_error('Error in retrieving data by id');
      }
      }
      }

      function edit_party_master()
      {
      if($this->input->post()){
      $data = $_POST;
      echo $this->dashboard_model->edit_party_master($data);
      exit;
      }
      }

      function delete_party_master($id)
      {
      $delete = $this->dashboard_model->delete_party_master($id);

      if($delete)
      {
      redirect('dashboard/listing_party_master');
      }
      } */

    //----------------------------------------------------- Client --------------------------------------------------------------------------------------

    function listing_client_master() {
        $data = array();
        $data['message'] = "";
        //$data['query'] = $this->dashboard_model->get_all_client_master();
        $data['page_url'] = "client_master_listing_datatable";
        $this->load->view('includes/template', $data);
    }

    function listing_client_master_datatable() {
        $data['query'] = $this->dashboard_model->get_all_client_master_datatable();
    }

    function add_form_client_master() {
        $data = array();
        $data['message'] = "";
        $data['page_url'] = "client_master_add_form";
        $this->load->view('includes/template', $data);
    }

    function add_client_master() {
        if ($this->input->post()) {
            $data = $_POST;
            echo $this->dashboard_model->add_client_master($data);
            exit;
        }
    }

    function edit_form_client_master($id) {
        if ($id == null) {
            show_error('No identifier provided', 500);
        } else {
            $data = array();
            $data['message'] = '';

            $row = $this->dashboard_model->client_master_get_by_id($id);

            if ($row) {
                $data['ClientId'] = trim($row['iClientId']);
                $data['ClientName'] = trim($row['cClientName']);
                $data['Address'] = trim($row['cAddress']);
                $data['BranchId'] = trim($row['iBranchId']);

                $data['StateId'] = trim($row['iStateId']);
                $data['DistrictId'] = trim($row['iDistrictId']);
                $data['CityId'] = trim($row['iCityId']);
                $data['LocationId'] = trim($row['iLocationId']);
                $data['Landmark'] = trim($row['cLandmark']);
                $data['SourceId'] = trim($row['iSourceId']);

                $data['ContactPerson1Name'] = trim($row['cContactPerson1Name']);
                $data['ContactPerson1Designation'] = trim($row['cContactPerson1Designation']);
                $data['ContactPerson1PhoneNo1'] = trim($row['cContactPerson1PhoneNo1']);
                $data['ContactPerson1PhoneNo2'] = trim($row['cContactPerson1PhoneNo2']);
                $data['ContactPerson1Email'] = trim($row['cContactPerson1Email']);

                $data['ContactPerson2Name'] = trim($row['cContactPerson2Name']);
                $data['ContactPerson2Designation'] = trim($row['cContactPerson2Designation']);
                $data['ContactPerson2PhoneNo1'] = trim($row['cContactPerson2PhoneNo1']);
                $data['ContactPerson2PhoneNo2'] = trim($row['cContactPerson2PhoneNo2']);
                $data['ContactPerson2Email'] = trim($row['cContactPerson2Email']);

                $data['ContactPerson3Name'] = trim($row['cContactPerson3Name']);
                $data['ContactPerson3Designation'] = trim($row['cContactPerson3Designation']);
                $data['ContactPerson3PhoneNo1'] = trim($row['cContactPerson3PhoneNo1']);
                $data['ContactPerson3PhoneNo2'] = trim($row['cContactPerson3PhoneNo2']);
                $data['ContactPerson3Email'] = trim($row['cContactPerson3Email']);

                $data['ContactPerson4Name'] = trim($row['cContactPerson4Name']);
                $data['ContactPerson4Designation'] = trim($row['cContactPerson4Designation']);
                $data['ContactPerson4PhoneNo1'] = trim($row['cContactPerson4PhoneNo1']);
                $data['ContactPerson4PhoneNo2'] = trim($row['cContactPerson4PhoneNo2']);
                $data['ContactPerson4Email'] = trim($row['cContactPerson4Email']);

                $data['ContactPerson5Name'] = trim($row['cContactPerson5Name']);
                $data['ContactPerson5Designation'] = trim($row['cContactPerson5Designation']);
                $data['ContactPerson5PhoneNo1'] = trim($row['cContactPerson5PhoneNo1']);
                $data['ContactPerson5PhoneNo2'] = trim($row['cContactPerson5PhoneNo2']);
                $data['ContactPerson5Email'] = trim($row['cContactPerson5Email']);

                $data['ContactPerson6Name'] = trim($row['cContactPerson6Name']);
                $data['ContactPerson6Designation'] = trim($row['cContactPerson6Designation']);
                $data['ContactPerson6PhoneNo1'] = trim($row['cContactPerson6PhoneNo1']);
                $data['ContactPerson6PhoneNo2'] = trim($row['cContactPerson6PhoneNo2']);
                $data['ContactPerson6Email'] = trim($row['cContactPerson6Email']);

                $data['ContactPerson7Name'] = trim($row['cContactPerson7Name']);
                $data['ContactPerson7Designation'] = trim($row['cContactPerson7Designation']);
                $data['ContactPerson7PhoneNo1'] = trim($row['cContactPerson7PhoneNo1']);
                $data['ContactPerson7PhoneNo2'] = trim($row['cContactPerson7PhoneNo2']);
                $data['ContactPerson7Email'] = trim($row['cContactPerson7Email']);

                $data['ContactPerson8Name'] = trim($row['cContactPerson8Name']);
                $data['ContactPerson8Designation'] = trim($row['cContactPerson8Designation']);
                $data['ContactPerson8PhoneNo1'] = trim($row['cContactPerson8PhoneNo1']);
                $data['ContactPerson8PhoneNo2'] = trim($row['cContactPerson8PhoneNo2']);
                $data['ContactPerson8Email'] = trim($row['cContactPerson8Email']);

                $data['ContactPerson9Name'] = trim($row['cContactPerson9Name']);
                $data['ContactPerson9Designation'] = trim($row['cContactPerson9Designation']);
                $data['ContactPerson9PhoneNo1'] = trim($row['cContactPerson9PhoneNo1']);
                $data['ContactPerson9PhoneNo2'] = trim($row['cContactPerson9PhoneNo2']);
                $data['ContactPerson9Email'] = trim($row['cContactPerson9Email']);

                $data['ContactPerson10Name'] = trim($row['cContactPerson10Name']);
                $data['ContactPerson10Designation'] = trim($row['cContactPerson10Designation']);
                $data['ContactPerson10PhoneNo1'] = trim($row['cContactPerson10PhoneNo1']);
                $data['ContactPerson10PhoneNo2'] = trim($row['cContactPerson10PhoneNo2']);
                $data['ContactPerson10Email'] = trim($row['cContactPerson10Email']);


                $data['Remarks'] = trim($row['cRemarks']);

                $data['Active'] = trim($row['bActive']);

                $data['page_url'] = 'client_master_edit_form';
                $this->load->view('includes/template', $data);
            } else {
                show_error('Error in retrieving data by id');
            }
        }
    }

    function edit_client_master() {
        if ($this->input->post()) {
            $data = $_POST;
            echo $this->dashboard_model->edit_client_master($data);
            exit;
        }
    }

    function delete_client_master($id) {
        $delete = $this->dashboard_model->delete_client_master($id);

        if ($delete) {
            redirect('dashboard/listing_client_master');
        }
    }

    function viewclient($id) {
        if ($id == null) {
            show_error('No identifier provided', 500);
        } else {
            $data = array();
            $data['message'] = '';

            $row = $this->dashboard_model->client_master_get_by_id($id);

            if ($row) {
                $data['ClientId'] = trim($row['iClientId']);
                $data['ClientName'] = trim($row['cClientName']);

                $data['Address'] = trim($row['cAddress']);
                $data['StateId'] = trim($row['iStateId']);
                $data['DistrictId'] = trim($row['iDistrictId']);
                $data['CityId'] = trim($row['iCityId']);
                $data['LocationId'] = trim($row['iLocationId']);
                $data['Landmark'] = trim($row['cLandmark']);
                $data['SourceId'] = trim($row['iSourceId']);

                $data['ContactPerson1Name'] = trim($row['cContactPerson1Name']);
                $data['ContactPerson1Designation'] = trim($row['cContactPerson1Designation']);
                $data['ContactPerson1PhoneNo1'] = trim($row['cContactPerson1PhoneNo1']);
                $data['ContactPerson1PhoneNo2'] = trim($row['cContactPerson1PhoneNo2']);
                $data['ContactPerson1Email'] = trim($row['cContactPerson1Email']);

                $data['ContactPerson2Name'] = trim($row['cContactPerson2Name']);
                $data['ContactPerson2Designation'] = trim($row['cContactPerson2Designation']);
                $data['ContactPerson2PhoneNo1'] = trim($row['cContactPerson2PhoneNo1']);
                $data['ContactPerson2PhoneNo2'] = trim($row['cContactPerson2PhoneNo2']);
                $data['ContactPerson2Email'] = trim($row['cContactPerson2Email']);

                $data['ContactPerson3Name'] = trim($row['cContactPerson3Name']);
                $data['ContactPerson3Designation'] = trim($row['cContactPerson3Designation']);
                $data['ContactPerson3PhoneNo1'] = trim($row['cContactPerson3PhoneNo1']);
                $data['ContactPerson3PhoneNo2'] = trim($row['cContactPerson3PhoneNo2']);
                $data['ContactPerson3Email'] = trim($row['cContactPerson3Email']);

                $data['ContactPerson4Name'] = trim($row['cContactPerson4Name']);
                $data['ContactPerson4Designation'] = trim($row['cContactPerson4Designation']);
                $data['ContactPerson4PhoneNo1'] = trim($row['cContactPerson4PhoneNo1']);
                $data['ContactPerson4PhoneNo2'] = trim($row['cContactPerson4PhoneNo2']);
                $data['ContactPerson4Email'] = trim($row['cContactPerson4Email']);

                $data['ContactPerson5Name'] = trim($row['cContactPerson5Name']);
                $data['ContactPerson5Designation'] = trim($row['cContactPerson5Designation']);
                $data['ContactPerson5PhoneNo1'] = trim($row['cContactPerson5PhoneNo1']);
                $data['ContactPerson5PhoneNo2'] = trim($row['cContactPerson5PhoneNo2']);
                $data['ContactPerson5Email'] = trim($row['cContactPerson5Email']);

                $data['ContactPerson6Name'] = trim($row['cContactPerson6Name']);
                $data['ContactPerson6Designation'] = trim($row['cContactPerson6Designation']);
                $data['ContactPerson6PhoneNo1'] = trim($row['cContactPerson6PhoneNo1']);
                $data['ContactPerson6PhoneNo2'] = trim($row['cContactPerson6PhoneNo2']);
                $data['ContactPerson6Email'] = trim($row['cContactPerson6Email']);

                $data['ContactPerson7Name'] = trim($row['cContactPerson7Name']);
                $data['ContactPerson7Designation'] = trim($row['cContactPerson7Designation']);
                $data['ContactPerson7PhoneNo1'] = trim($row['cContactPerson7PhoneNo1']);
                $data['ContactPerson7PhoneNo2'] = trim($row['cContactPerson7PhoneNo2']);
                $data['ContactPerson7Email'] = trim($row['cContactPerson7Email']);

                $data['ContactPerson8Name'] = trim($row['cContactPerson8Name']);
                $data['ContactPerson8Designation'] = trim($row['cContactPerson8Designation']);
                $data['ContactPerson8PhoneNo1'] = trim($row['cContactPerson8PhoneNo1']);
                $data['ContactPerson8PhoneNo2'] = trim($row['cContactPerson8PhoneNo2']);
                $data['ContactPerson8Email'] = trim($row['cContactPerson8Email']);

                $data['ContactPerson9Name'] = trim($row['cContactPerson9Name']);
                $data['ContactPerson9Designation'] = trim($row['cContactPerson9Designation']);
                $data['ContactPerson9PhoneNo1'] = trim($row['cContactPerson9PhoneNo1']);
                $data['ContactPerson9PhoneNo2'] = trim($row['cContactPerson9PhoneNo2']);
                $data['ContactPerson9Email'] = trim($row['cContactPerson9Email']);

                $data['ContactPerson10Name'] = trim($row['cContactPerson10Name']);
                $data['ContactPerson10Designation'] = trim($row['cContactPerson10Designation']);
                $data['ContactPerson10PhoneNo1'] = trim($row['cContactPerson10PhoneNo1']);
                $data['ContactPerson10PhoneNo2'] = trim($row['cContactPerson10PhoneNo2']);
                $data['ContactPerson10Email'] = trim($row['cContactPerson10Email']);

                $data['Remarks'] = trim($row['cRemarks']);

                $data['Active'] = trim($row['bActive']);

                $data['page_url'] = 'client_master_view_form';
                $this->load->view('includes/template', $data);
            } else {
                show_error('Error in retrieving data by id');
            }
        }
    }

    //---------------------------------------------- Property Category ---------------------------------------------------------------------------------------

    function listing_property_category_master() {
        $data = array();
        $data['message'] = "";
        $data['query'] = $this->dashboard_model->get_all_property_category_master();
        $data['page_url'] = "property_category_master_listing";
        $this->load->view('includes/template', $data);
    }

    function add_form_property_category_master() {
        $data = array();
        $data['message'] = "";
        $data['page_url'] = "property_category_master_add_form";
        $this->load->view('includes/template', $data);
    }

    function add_property_category_master() {
        if ($this->input->post()) {
            $data = $_POST;
            echo $this->dashboard_model->add_property_category_master($data);
            exit;
        }
    }

    function edit_form_property_category_master($id) {
        if ($id == null) {
            show_error('No identifier provided', 500);
        } else {
            $data = array();
            $data['message'] = '';

            $row = $this->dashboard_model->property_category_master_get_by_id($id);

            if ($row) {
                $data['PropertyCategoryId'] = trim($row['iPropertyCategoryId']);
                $data['PropertyCategoryName'] = trim($row['cPropertyCategoryName']);
                $data['Active'] = trim($row['bActive']);

                $data['page_url'] = 'property_category_master_edit_form';
                $this->load->view('includes/template', $data);
            } else {
                show_error('Error in retrieving data by id');
            }
        }
    }

    function edit_property_category_master() {
        if ($this->input->post()) {
            $data = $_POST;
            echo $this->dashboard_model->edit_property_category_master($data);
            exit;
        }
    }

    function delete_property_category_master($id) {
        $delete = $this->dashboard_model->delete_property_category_master($id);

        if ($delete) {
            redirect('dashboard/listing_property_category_master');
        }
    }

    //--------------------------------------------------- Property Status ----------------------------------------------------------------------------------

    function listing_property_status_master() {
        $data = array();
        $data['message'] = "";
        $data['query'] = $this->dashboard_model->get_all_property_status_master();
        $data['page_url'] = "property_status_master_listing";
        $this->load->view('includes/template', $data);
    }

    function add_form_property_status_master() {
        $data = array();
        $data['message'] = "";
        $data['page_url'] = "property_status_master_add_form";
        $this->load->view('includes/template', $data);
    }

    function add_property_status_master() {
        if ($this->input->post()) {
            $data = $_POST;
            echo $this->dashboard_model->add_property_status_master($data);
            exit;
        }
    }

    function edit_form_property_status_master($id) {
        if ($id == null) {
            show_error('No identifier provided', 500);
        } else {
            $data = array();
            $data['message'] = '';

            $row = $this->dashboard_model->property_status_master_get_by_id($id);

            if ($row) {
                $data['PropertyStatusId'] = trim($row['iPropertyStatusId']);
                $data['PropertyStatusName'] = trim($row['cPropertyStatusName']);
                $data['Active'] = trim($row['bActive']);

                $data['page_url'] = 'property_status_master_edit_form';
                $this->load->view('includes/template', $data);
            } else {
                show_error('Error in retrieving data by id');
            }
        }
    }

    function edit_property_status_master() {
        if ($this->input->post()) {
            $data = $_POST;
            echo $this->dashboard_model->edit_property_status_master($data);
            exit;
        }
    }

    function delete_property_status_master($id) {
        $delete = $this->dashboard_model->delete_property_status_master($id);

        if ($delete) {
            redirect('dashboard/listing_property_status_master');
        }
    }

    //--------------------------------------------------- Property Type ----------------------------------------------------------------------------------

    function listing_property_type_master() {
        $data = array();
        $data['message'] = "";
        $data['query'] = $this->dashboard_model->get_all_property_type_master();
        $data['page_url'] = "property_type_master_listing";
        $this->load->view('includes/template', $data);
    }

    function add_form_property_type_master() {
        $data = array();
        $data['message'] = "";
        $data['page_url'] = "property_type_master_add_form";
        $this->load->view('includes/template', $data);
    }

    function add_property_type_master() {
        if ($this->input->post()) {
            $data = $_POST;
            echo $this->dashboard_model->add_property_type_master($data);
            exit;
        }
    }

    function edit_form_property_type_master($id) {
        if ($id == null) {
            show_error('No identifier provided', 500);
        } else {
            $data = array();
            $data['message'] = '';

            $row = $this->dashboard_model->property_type_master_get_by_id($id);

            if ($row) {
                $data['PropertyTypeId'] = trim($row['iPropertyTypeId']);
                $data['PropertyTypeName'] = trim($row['cPropertyTypeName']);
                $data['Active'] = trim($row['bActive']);

                $data['page_url'] = 'property_type_master_edit_form';
                $this->load->view('includes/template', $data);
            } else {
                show_error('Error in retrieving data by id');
            }
        }
    }

    function edit_property_type_master() {
        if ($this->input->post()) {
            $data = $_POST;
            echo $this->dashboard_model->edit_property_type_master($data);
            exit;
        }
    }

    function delete_property_type_master($id) {
        $delete = $this->dashboard_model->delete_property_type_master($id);

        if ($delete) {
            redirect('dashboard/listing_property_type_master');
        }
    }

    //--------------------------------------------------- Task -------------------------------------------------------------------------------------	

    function listing_task_master() {
        $data = array();
        $data['message'] = "";
        $data['query'] = $this->dashboard_model->get_all_task_master();
        $data['page_url'] = "task_master_listing";
        $this->load->view('includes/template', $data);
    }

    function add_form_task_master() {
        $data = array();
        $data['message'] = "";
        $data['page_url'] = "task_master_add_form";
        $this->load->view('includes/template', $data);
    }

    function add_task_master() {
        if ($this->input->post()) {
            $data = $_POST;
            echo $this->dashboard_model->add_task_master($data);
            exit;
        }
    }

    function edit_form_task_master($id) {
        if ($id == null) {
            show_error('No identifier provided', 500);
        } else {
            $data = array();
            $data['message'] = '';

            $row = $this->dashboard_model->task_master_get_by_id($id);

            if ($row) {
                $data['TaskId'] = trim($row['iTaskId']);
                $data['TaskName'] = trim($row['cTaskName']);
                $data['Active'] = trim($row['bActive']);

                $data['page_url'] = 'task_master_edit_form';
                $this->load->view('includes/template', $data);
            } else {
                show_error('Error in retrieving data by id');
            }
        }
    }

    function edit_task_master() {
        if ($this->input->post()) {
            $data = $_POST;
            echo $this->dashboard_model->edit_task_master($data);
            exit;
        }
    }

    function delete_task_master($id) {
        $delete = $this->dashboard_model->delete_task_master($id);

        if ($delete) {
            redirect('dashboard/listing_task_master');
        }
    }

    //--------------------------------------------------- Location ---------------------------------------------------------------------------------------

    function listing_location_master() {
        $data = array();
        $data['message'] = "";
        $data['query'] = $this->dashboard_model->get_all_location_master();
        $data['page_url'] = "location_master_listing";
        $this->load->view('includes/template', $data);
    }

    function add_form_location_master() {
        $data = array();
        $data['message'] = "";
        $data['page_url'] = "location_master_add_form";
        $this->load->view('includes/template', $data);
    }

    function add_location_master() {
        if ($this->input->post()) {
            $data = $_POST;
            echo $this->dashboard_model->add_location_master($data);
            exit;
        }
    }

    function edit_form_location_master($id) {
        if ($id == null) {
            show_error('No identifier provided', 500);
        } else {
            $data = array();
            $data['message'] = '';

            $row = $this->dashboard_model->location_master_get_by_id($id);

            if ($row) {
                $data['LocationId'] = trim($row['iLocationId']);
                $data['LocationName'] = trim($row['cLocationName']);
                $data['CityId'] = trim($row['iCityId']);
                $data['DistrictId'] = trim($row['iDistrictId']);
                $data['StateId'] = trim($row['iStateId']);
                $data['Landmark'] = trim($row['cLandmark']);
                $data['Active'] = trim($row['bActive']);

                $data['page_url'] = 'location_master_edit_form';
                $this->load->view('includes/template', $data);
            } else {
                show_error('Error in retrieving data by id');
            }
        }
    }

    function edit_location_master() {
        if ($this->input->post()) {
            $data = $_POST;
            echo $this->dashboard_model->edit_location_master($data);
            exit;
        }
    }

    function delete_location_master($id) {
        $delete = $this->dashboard_model->delete_location_master($id);

        if ($delete) {
            redirect('dashboard/listing_location_master');
        }
    }

    //--------------------------------------------------- Escalation -------------------------------------------------------------------------------------	

    function listing_escalation_master() {
        $data = array();
        $data['message'] = "";
        $data['query'] = $this->dashboard_model->get_all_escalation_master();
        $data['page_url'] = "escalation_master_listing";
        $this->load->view('includes/template', $data);
    }

    function add_form_escalation_master() {
        $data = array();
        $data['message'] = "";
        $data['page_url'] = "escalation_master_add_form";
        $this->load->view('includes/template', $data);
    }

    function add_escalation_master() {
        if ($this->input->post()) {
            $data = $_POST;
            echo $this->dashboard_model->add_escalation_master($data);
            exit;
        }
    }

    function edit_form_escalation_master($id) {
        if ($id == null) {
            show_error('No identifier provided', 500);
        } else {
            $data = array();
            $data['message'] = '';

            $row = $this->dashboard_model->escalation_master_get_by_id($id);

            if ($row) {
                $data['EscalationId'] = trim($row['iEscalationId']);
                $data['EscalationName'] = trim($row['cEscalationName']);
                $data['Active'] = trim($row['bActive']);

                $data['page_url'] = 'escalation_master_edit_form';
                $this->load->view('includes/template', $data);
            } else {
                show_error('Error in retrieving data by id');
            }
        }
    }

    function edit_escalation_master() {
        if ($this->input->post()) {
            $data = $_POST;
            echo $this->dashboard_model->edit_escalation_master($data);
            exit;
        }
    }

    function delete_escalation_master($id) {
        $delete = $this->dashboard_model->delete_escalation_master($id);

        if ($delete) {
            redirect('dashboard/listing_escalation_master');
        }
    }

    //--------------------------------------------------- State -------------------------------------------------------------------------------------	

    function listing_state_master() {
        $data = array();
        $data['message'] = "";
        $data['query'] = $this->dashboard_model->get_all_state_master();
        $data['page_url'] = "state_master_listing";
        $this->load->view('includes/template', $data);
    }

    function add_form_state_master() {
        $data = array();
        $data['message'] = "";
        $data['page_url'] = "state_master_add_form";
        $this->load->view('includes/template', $data);
    }

    function add_state_master() {
        if ($this->input->post()) {
            $data = $_POST;
            echo $this->dashboard_model->add_state_master($data);
            exit;
        }
    }

    function edit_form_state_master($id) {
        if ($id == null) {
            show_error('No identifier provided', 500);
        } else {
            $data = array();
            $data['message'] = '';

            $row = $this->dashboard_model->state_master_get_by_id($id);

            if ($row) {
                $data['StateId'] = trim($row['iStateId']);
                $data['StateName'] = trim($row['cStateName']);
                $data['StateAbbreviation'] = trim($row['cStateAbbreviation']);
                $data['Active'] = trim($row['bActive']);

                $data['page_url'] = 'state_master_edit_form';
                $this->load->view('includes/template', $data);
            } else {
                show_error('Error in retrieving data by id');
            }
        }
    }

    function edit_state_master() {
        if ($this->input->post()) {
            $data = $_POST;
            echo $this->dashboard_model->edit_state_master($data);
            exit;
        }
    }

    function delete_state_master($id) {
        $delete = $this->dashboard_model->delete_state_master($id);

        if ($delete) {
            redirect('dashboard/listing_state_master');
        }
    }

    //--------------------------------------------------- District -------------------------------------------------------------------------------------	

    function listing_district_master() {
        $data = array();
        $data['message'] = "";
        $data['query'] = $this->dashboard_model->get_all_district_master();
        $data['page_url'] = "district_master_listing";
        $this->load->view('includes/template', $data);
    }

    function add_form_district_master() {
        $data = array();
        $data['message'] = "";
        $data['page_url'] = "district_master_add_form";
        $this->load->view('includes/template', $data);
    }

    function add_district_master() {
        if ($this->input->post()) {
            $data = $_POST;
            echo $this->dashboard_model->add_district_master($data);
            exit;
        }
    }

    function edit_form_district_master($id) {
        if ($id == null) {
            show_error('No identifier provided', 500);
        } else {
            $data = array();
            $data['message'] = '';

            $row = $this->dashboard_model->district_master_get_by_id($id);

            if ($row) {
                $data['DistrictId'] = trim($row['iDistrictId']);
                $data['StateId'] = trim($row['iStateId']);
                $data['DistrictName'] = trim($row['cDistrictName']);
                $data['Active'] = trim($row['bActive']);

                $data['page_url'] = 'district_master_edit_form';
                $this->load->view('includes/template', $data);
            } else {
                show_error('Error in retrieving data by id');
            }
        }
    }

    function edit_district_master() {
        if ($this->input->post()) {
            $data = $_POST;
            echo $this->dashboard_model->edit_district_master($data);
            exit;
        }
    }

    function delete_district_master($id) {
        $delete = $this->dashboard_model->delete_district_master($id);

        if ($delete) {
            redirect('dashboard/listing_district_master');
        }
    }

    //--------------------------------------------------- City -------------------------------------------------------------------------------------	

    function listing_city_master() {
        $data = array();
        $data['message'] = "";
        $data['query'] = $this->dashboard_model->get_all_city_master();
        $data['page_url'] = "city_master_listing";
        $this->load->view('includes/template', $data);
    }

    function add_form_city_master() {
        $data = array();
        $data['message'] = "";
        $data['page_url'] = "city_master_add_form";
        $this->load->view('includes/template', $data);
    }

    function add_city_master() {
        if ($this->input->post()) {
            $data = $_POST;
            echo $this->dashboard_model->add_city_master($data);
            exit;
        }
    }

    function edit_form_city_master($id) {
        if ($id == null) {
            show_error('No identifier provided', 500);
        } else {
            $data = array();
            $data['message'] = '';

            $row = $this->dashboard_model->city_master_get_by_id($id);

            if ($row) {
                $data['CityId'] = trim($row['iCityId']);
                $data['CityName'] = trim($row['cCityName']);
                $data['StateId'] = trim($row['iStateId']);
                $data['DistrictId'] = trim($row['iDistrictId']);
                $data['PinCode'] = trim($row['cPinCode']);
                $data['Active'] = trim($row['bActive']);

                $data['page_url'] = 'city_master_edit_form';
                $this->load->view('includes/template', $data);
            } else {
                show_error('Error in retrieving data by id');
            }
        }
    }

    function edit_city_master() {
        if ($this->input->post()) {
            $data = $_POST;
            echo $this->dashboard_model->edit_city_master($data);
            exit;
        }
    }

    function delete_city_master($id) {
        $delete = $this->dashboard_model->delete_city_master($id);

        if ($delete) {
            redirect('dashboard/listing_city_master');
        }
    }

    //--------------------------------------------------- User -------------------------------------------------------------------------------------	

    function listing_user_master() {
        $data = array();
        $data['message'] = "";
        $data['query'] = $this->dashboard_model->get_all_user_master();
        $data['page_url'] = "user_master_listing";
        $this->load->view('includes/template', $data);
    }

    function add_form_user_master() {
        $data = array();
        $data['message'] = "";
        $data['page_url'] = "user_master_add_form";
        $this->load->view('includes/template', $data);
    }

    function add_user_master() {
        if ($this->input->post()) {
            $data = $_POST;
            echo $this->dashboard_model->add_user_master($data);
            exit;
        }
    }

    function edit_form_user_master($id) {
        if ($id == null) {
            show_error('No identifier provided', 500);
        } else {
            $data = array();
            $data['message'] = '';

            $row = $this->dashboard_model->user_master_get_by_id($id);

            if ($row) {
                $data['UserId'] = trim($row['iUserId']);
                $data['Name'] = trim($row['cName']);
                $data['Designation'] = trim($row['cDesignation']);
                $data['DepartmentId'] = trim($row['iDepartmentId']);
                $data['Address'] = trim($row['cAddress']);
                $data['MobileNo'] = trim($row['iMobileNo']);
                $data['EmailAddress'] = trim($row['cEmailAddress']);
                $data['EmergencyContactName'] = trim($row['cEmergencyContactName']);
                $data['EmergencyContactPhoneNo'] = trim($row['cEmergencyContactPhoneNo']);
                $data['EmergencyContactEmailAddress'] = trim($row['cEmergencyContactEmailAddress']);
                $data['UserProfilePicPath'] = trim($row['cUserProfilePicPath']);
                $data['UserProfilePicName'] = trim($row['cUserProfilePicName']);
                $data['UserName'] = trim($row['cUserName']);
                $data['Password'] = trim($row['cPassword']);
                $data['UserType'] = trim($row['cUserType']);
                $data['Active'] = trim($row['bActive']);

                $data['page_url'] = 'user_master_edit_form';
                $this->load->view('includes/template', $data);
            } else {
                show_error('Error in retrieving data by id');
            }
        }
    }

    function edit_user_master() {
        if ($this->input->post()) {
            $data = $_POST;
            echo $this->dashboard_model->edit_user_master($data);
            exit;
        }
    }

    function delete_user_master($id) {
        $delete = $this->dashboard_model->delete_user_master($id);

        if ($delete) {
            redirect('dashboard/listing_user_master');
        }
    }

    function changepwdform() {
        $data = array();
        $data['UserId'] = trim($this->session->userdata('UserId'));
        $data['UserName'] = trim($this->session->userdata('UserName'));
        $data['message'] = "";
        $data['page_url'] = 'change_password_form_view';
        $this->load->view('includes/template', $data);
    }

    function changepassword() {
        $data = $_POST;

        $UserId = trim($data['hfUserId']);
        $UserName = trim($data['txtUserName']);
        $OldPassword = trim($data['txtOldPassword']);
        $NewPassword = trim($data['txtNewPassword']);

        //echo $UserId."=>".$UserName."=>".$OldPassword."=>".$NewPassword;
        //exit;

        $sql = "SELECT * FROM user_master WHERE cUserName='" . $UserName . "' AND cPassword='" . $OldPassword . "'";

        $query = $this->db->query($sql);

        if ($query) {
            if ($query->num_rows > 0) {
                $sql2 = "UPDATE user_master SET cPassword='" . $NewPassword . "' WHERE cUserName='" . $UserName . "' AND cPassword='" . $OldPassword . "'";

                $query2 = $this->db->query($sql2);

                if ($query2) {
                    echo 'true';
                } else {
                    echo 'false';
                }
            } else {
                echo 'noresultfound';
            }
        }
    }

    /*
      //--------------------------------------------------- Calls Record --------------------------------------------------------------------------------------

      function listing_call_record()
      {
      $data = array();
      $data['message']="";
      $data['query'] = $this->dashboard_model->get_all_call_record();
      $data['page_url']="call_record_listing";
      $this->load->view('includes/template', $data);
      }

      function add_form_call_record()
      {
      $data = array();
      $data['message']="";
      $data['page_url']="call_record_add_form";
      $this->load->view('includes/template', $data);
      }

      function add_call_record()
      {
      if($this->input->post()){
      $data = $_POST;
      echo $this->dashboard_model->add_call_record($data);
      exit;
      }
      }

      function edit_form_call_record($id)
      {
      if($id == null) {
      show_error('No identifier provided', 500);
      }
      else
      {
      $data = array();
      $data['message'] = '';

      $row = $this->dashboard_model->call_record_get_by_id($id);

      if($row)
      {
      $data['CallRecordId'] = trim($row['iCallRecordId']);
      $data['UserId'] = trim($row['iUserId']);
      $data['CallDateTime'] = trim($row['dCallDateTime']);
      $data['CallTypeId'] = trim($row['iCallTypeId']);
      $data['ContactNo'] = trim($row['cContactNo']);
      $data['PersonName'] = trim($row['cPersonName']);
      $data['PropertyId'] = trim($row['iPropertyId']);
      $data['CallDateTime'] = trim($row['dCallDateTime']);
      $data['CallSummary'] = trim($row['cCallSummary']);
      $data['NextCallDateTime'] = trim($row['dNextCallDateTime']);


      $data['page_url'] = 'call_record_edit_form';
      $this->load->view('includes/template', $data);
      }
      else
      {
      show_error('Error in retrieving data by id');
      }
      }
      }

      function edit_call_record()
      {
      if($this->input->post()){
      $data = $_POST;
      echo $this->dashboard_model->edit_call_record($data);
      exit;
      }
      }

      function delete_call_record($id)
      {
      $delete = $this->dashboard_model->delete_call_record($id);

      if($delete)
      {
      redirect('dashboard/listing_call_record');
      }
      }

      //--------------------------------------------------- Visits Record --------------------------------------------------------------------------------------

      function listing_visit_record()
      {
      $data = array();
      $data['message']="";
      $data['query'] = $this->dashboard_model->get_all_visit_record();
      $data['page_url']="visit_record_listing";
      $this->load->view('includes/template', $data);
      }

      function add_form_visit_record()
      {
      $data = array();
      $data['message']="";
      $data['page_url']="visit_record_add_form";
      $this->load->view('includes/template', $data);
      }

      function add_visit_record()
      {
      if($this->input->post()){
      $data = $_POST;
      echo $this->dashboard_model->add_visit_record($data);
      exit;
      }
      }

      function edit_form_visit_record($id)
      {
      if($id == null) {
      show_error('No identifier provided', 500);
      }
      else
      {
      $data = array();
      $data['message'] = '';

      $row = $this->dashboard_model->visit_record_get_by_id($id);

      if($row)
      {
      $data['VisitRecordId'] = trim($row['iVisitRecordId']);
      $data['UserId'] = trim($row['iUserId']);
      $data['VisitDateTime'] = trim($row['dVisitDateTime']);
      $data['PersonName'] = trim($row['cPersonName']);
      $data['PropertyId'] = trim($row['iPropertyId']);
      $data['VisitSummary'] = trim($row['cVisitSummary']);
      $data['NextVisitDateTime'] = trim($row['dNextVisitDateTime']);

      $data['page_url'] = 'visit_record_edit_form';
      $this->load->view('includes/template', $data);
      }
      else
      {
      show_error('Error in retrieving data by id');
      }
      }
      }

      function edit_visit_record()
      {
      if($this->input->post()){
      $data = $_POST;
      echo $this->dashboard_model->edit_visit_record($data);
      exit;
      }
      }

      function delete_visit_record($id)
      {
      $delete = $this->dashboard_model->delete_visit_record($id);

      if($delete)
      {
      redirect('dashboard/listing_visit_record');
      }
      }


      //--------------------------------------------------- Meetings Record --------------------------------------------------------------------------------------

      function listing_meeting_record()
      {
      $data = array();
      $data['message']="";
      $data['query'] = $this->dashboard_model->get_all_meeting_record();
      $data['page_url']="meeting_record_listing";
      $this->load->view('includes/template', $data);
      }

      function add_form_meeting_record()
      {
      $data = array();
      $data['message']="";
      $data['page_url']="meeting_record_add_form";
      $this->load->view('includes/template', $data);
      }

      function add_meeting_record()
      {
      if($this->input->post()){
      $data = $_POST;
      echo $this->dashboard_model->add_meeting_record($data);
      exit;
      }
      }

      function edit_form_meeting_record($id)
      {
      if($id == null) {
      show_error('No identifier provided', 500);
      }
      else
      {
      $data = array();
      $data['message'] = '';

      $row = $this->dashboard_model->meeting_record_get_by_id($id);

      if($row)
      {
      $data['MeetingRecordId'] = trim($row['iMeetingRecordId']);
      $data['UserId'] = trim($row['iUserId']);
      $data['MeetingDateTime'] = trim($row['dMeetingDateTime']);
      $data['MeetingDuration'] = trim($row['cMeetingDuration']);
      $data['PartyId'] = trim($row['iPartyId']);
      $data['PropertyId'] = trim($row['iPropertyId']);
      $data['MeetingSummary'] = trim($row['cMeetingSummary']);

      $data['page_url'] = 'meeting_record_edit_form';
      $this->load->view('includes/template', $data);
      }
      else
      {
      show_error('Error in retrieving data by id');
      }
      }
      }

      function edit_meeting_record()
      {
      if($this->input->post()){
      $data = $_POST;
      echo $this->dashboard_model->edit_meeting_record($data);
      exit;
      }
      }

      function delete_meeting_record($id)
      {
      $delete = $this->dashboard_model->delete_meeting_record($id);

      if($delete)
      {
      redirect('dashboard/listing_meeting_record');
      }
      }

      //--------------------------------------------------- Inspection Record --------------------------------------------------------------------------------------

      function listing_inspection_record()
      {
      $data = array();
      $data['message']="";
      $data['query'] = $this->dashboard_model->get_all_inspection_record();
      $data['page_url']="inspection_record_listing";
      $this->load->view('includes/template', $data);
      }

      function add_form_inspection_record()
      {
      $data = array();
      $data['message']="";
      $data['page_url']="inspection_record_add_form";
      $this->load->view('includes/template', $data);
      }

      function add_inspection_record()
      {
      if($this->input->post()){
      $data = $_POST;
      echo $this->dashboard_model->add_inspection_record($data);
      exit;
      }
      }

      function edit_form_inspection_record($id)
      {
      if($id == null) {
      show_error('No identifier provided', 500);
      }
      else
      {
      $data = array();
      $data['message'] = '';

      $row = $this->dashboard_model->inspection_record_get_by_id($id);

      if($row)
      {
      $data['InspectionRecordId'] = trim($row['iInspectionRecordId']);
      $data['UserId'] = trim($row['iUserId']);

      $getInspDate=trim($row['dInspectionDate']);
      $splitinspdt = explode('-',$getInspDate);
      $InspectionDate = $splitinspdt[2]."/".$splitinspdt[1]."/".$splitinspdt[0];

      $data['InspectionDate'] = $InspectionDate;
      $data['PartyId'] = trim($row['iPartyId']);
      $data['PropertyId'] = trim($row['iPropertyId']);
      $data['PeopleAtTheTimeOfInspection'] = trim($row['cPeopleAtTheTimeOfInspection']);
      $data['InspectionSummary'] = trim($row['cInspectionSummary']);

      $data['page_url'] = 'inspection_record_edit_form';
      $this->load->view('includes/template', $data);
      }
      else
      {
      show_error('Error in retrieving data by id');
      }
      }
      }

      function edit_inspection_record()
      {
      if($this->input->post()){
      $data = $_POST;
      echo $this->dashboard_model->edit_inspection_record($data);
      exit;
      }
      }

      function delete_inspection_record($id)
      {
      $delete = $this->dashboard_model->delete_inspection_record($id);

      if($delete)
      {
      redirect('dashboard/listing_inspection_record');
      }
      }
     */

    //--------------------------------------------------- DCR -----------------------------------------------------------------------------------------------

    function listing_dcr($client_id = 0) {
        $data = array();
        $data['message'] = "";
        $client_id = (int) $client_id;

        if (($this->session->userdata('UserType') == 'Admin')) {
            $data['query'] = $this->dashboard_model->get_all_dcr($client_id);
            $data['page_url'] = "dcr_listing";
            $this->load->view('includes/template', $data);
        } else {
            $UserId = trim($this->session->userdata('UserId'));

            $data['query'] = $this->dashboard_model->get_dcr_by_user_id($UserId, $client_id);
            $data['page_url'] = "dcr_listing";
            $this->load->view('includes/template', $data);
        }
    }

    function add_form_dcr() {
        $data = array();
        $data['message'] = "";
        $data['page_url'] = "dcr_add_form";
        $this->load->view('includes/template', $data);
    }

    function add_form_dcr_single($client_id, $ispopup = "") {
        $data = array();
        $data['selclient_id'] = $client_id;
        $data['ispopup'] = $ispopup;
        $data['message'] = "";       


        $data['clientsdata'] = $this->getrequirementbyclient();
        $data['propertydata'] = $this->getpropertybyclient();
        
        $data['page_url'] = "dcr_add_form_single";
        $this->load->view('includes/new_template', $data);
    }

    function popup_for_inspection_delivery($propertyid, $ispopup = "", $is_ins_del) {

        $data = array();
        $data['selclient_id'] = $client_id;
        $data['ispopup'] = $ispopup;
        $data['message'] = "";
        $data['result'] = $this->dashboard_model->popup_for_inspection_delivery($propertyid, $is_ins_del);
        $data['property_title'] = $this->dashboard_model->property_title($propertyid);
        $data['ins_del'] = $is_ins_del;
        $data['page_url'] = "popup_for_inspection_delivery";

        $this->load->view('popup_for_inspection_delivery', $data);
    }

    function check_user_dcr_date() {
        $UserId = trim($this->session->userdata('UserId'));

        $DCRDt = trim($this->input->post('txtDCRDate'));
        $splitdcrdt = explode('/', $DCRDt);
        $DCRDate = $splitdcrdt[2] . "-" . $splitdcrdt[1] . "-" . $splitdcrdt[0];

        $result = $this->dashboard_model->dcr_date_user_exists($UserId, $DCRDate);

        if ($result) {
            echo "alreadyexists"; // false
            //echo $result;
        } else {
            echo "notexists"; // true
        }
    }

    function check_user_dcr_date_single() {
        $UserId = trim($this->session->userdata('UserId'));

        $DCRDt = trim($this->input->post('txtDCRDate'));
        $splitdcrdt = explode('/', $DCRDt);
        $DCRDate = $splitdcrdt[2] . "-" . $splitdcrdt[1] . "-" . $splitdcrdt[0];

        $cmbClientReq1 = (int) $this->input->post('cmbClientReq1');

        $result = $this->dashboard_model->dcr_date_user_exists_single($UserId, $DCRDate, $cmbClientReq1);

        if ($result) {
            echo "alreadyexists"; // false
            //echo $result;
        } else {
            echo "notexists"; // true
        }
    }

    function add_dcr1() {
        $data = array();
        $data['object'] = $this->dashboard_model->add_dcr1($data);
        if ($data) {

            redirect('../index.php/dashboard', $data);
        }
    }

    function add_dcr() {
        if ($this->input->post()) {
            $data = $_POST;
            echo $this->dashboard_model->add_dcr($data);
            exit;
        }
    }

    function edit_form_dcr($id) {
        if ($id == null) {
            show_error('No identifier provided', 500);
        } else {
            $data = array();
            $data['message'] = '';

            $row = $this->dashboard_model->dcr_get_by_id($id);

            $DCRDetailRows = $this->dashboard_model->dcr_details_get_by_id($id);

            if ($row) {
                $data['DCRId'] = trim($row['iDCRId']);

                if (!empty($row['dDCRDate']) && $row['dDCRDate'] != '0000-00-00') {
                    $splitdcrdt = explode('-', $row['dDCRDate']);
                    $DCRDate = $splitdcrdt[2] . "/" . $splitdcrdt[1] . "/" . $splitdcrdt[0];
                    $data['DCRDate'] = $DCRDate;
                } else {
                    $data['DCRDate'] = "";
                }

                $data['UserId'] = trim($row['iUserId']);
                $data['DCRRemarks'] = trim($row['cDCRRemarks']);

                $data['DCRDetailRows'] = $DCRDetailRows;

                $data['page_url'] = 'dcr_edit_form';
                $this->load->view('includes/template', $data);
            } else {
                show_error('Error in retrieving data by id');
            }
        }
    }

    function edit_dcr() {
        if ($this->input->post()) {
            $data = $_POST;
            echo $this->dashboard_model->edit_dcr($data);
            exit;
        }
    }

    function delete_dcr($id) {
        $delete = $this->dashboard_model->delete_dcr($id);

        if ($delete) {
            redirect('dashboard/listing_dcr');
        }
    }

    function getrequirementbyclient() {
        $ClientId = trim($this->input->post('cmbClient'));
        return $result = $this->dashboard_model->get_requirement_by_client($ClientId);
        //$getdata = json_encode($data['result']);
        //echo $getdata;
    }

    function getpropertybyclient() {
        $ClientId = trim($this->input->post('cmbClient'));
        return $results = $this->dashboard_model->get_property_by_client($ClientId);
        //$getdata = json_encode($data['result']);
        //echo $getdata;
    }

    //--------------------------------------------------- Source -------------------------------------------------------------------------------------	

    function listing_source_master() {
        $data = array();
        $data['message'] = "";
        $data['query'] = $this->dashboard_model->get_all_source_master();
        $data['page_url'] = "source_master_listing";
        $this->load->view('includes/template', $data);
    }

    function add_form_source_master() {
        $data = array();
        $data['message'] = "";
        $data['page_url'] = "source_master_add_form";
        $this->load->view('includes/template', $data);
    }

    function add_source_master() {
        if ($this->input->post()) {
            $data = $_POST;
            echo $this->dashboard_model->add_source_master($data);
            exit;
        }
    }

    function edit_form_source_master($id) {
        if ($id == null) {
            show_error('No identifier provided', 500);
        } else {
            $data = array();
            $data['message'] = '';

            $row = $this->dashboard_model->source_master_get_by_id($id);

            if ($row) {
                $data['SourceId'] = trim($row['iSourceId']);
                $data['SourceName'] = trim($row['cSourceName']);
                $data['Active'] = trim($row['bActive']);

                $data['page_url'] = 'source_master_edit_form';
                $this->load->view('includes/template', $data);
            } else {
                show_error('Error in retrieving data by id');
            }
        }
    }

    function edit_source_master() {
        if ($this->input->post()) {
            $data = $_POST;
            echo $this->dashboard_model->edit_source_master($data);
            exit;
        }
    }

    function delete_source_master($id) {
        $delete = $this->dashboard_model->delete_source_master($id);

        if ($delete) {
            redirect('dashboard/listing_source_master');
        }
    }

    //----------------------------------------------- Business Purpose ---------------------------------------------------------------------------------------	

    function listing_business_purpose_master() {
        $data = array();
        $data['message'] = "";
        $data['query'] = $this->dashboard_model->get_all_business_purpose_master();
        $data['page_url'] = "business_purpose_master_listing";
        $this->load->view('includes/template', $data);
    }

    function add_form_business_purpose_master() {
        $data = array();
        $data['message'] = "";
        $data['page_url'] = "business_purpose_master_add_form";
        $this->load->view('includes/template', $data);
    }

    function add_business_purpose_master() {
        if ($this->input->post()) {
            $data = $_POST;
            echo $this->dashboard_model->add_business_purpose_master($data);
            exit;
        }
    }

    function edit_form_business_purpose_master($id) {
        if ($id == null) {
            show_error('No identifier provided', 500);
        } else {
            $data = array();
            $data['message'] = '';

            $row = $this->dashboard_model->business_purpose_master_get_by_id($id);

            if ($row) {
                $data['BusinessPurposeId'] = trim($row['iBusinessPurposeId']);
                $data['BusinessPurposeName'] = trim($row['cBusinessPurposeName']);
                $data['Active'] = trim($row['bActive']);

                $data['page_url'] = 'business_purpose_master_edit_form';
                $this->load->view('includes/template', $data);
            } else {
                show_error('Error in retrieving data by id');
            }
        }
    }

    function edit_business_purpose_master() {
        if ($this->input->post()) {
            $data = $_POST;
            echo $this->dashboard_model->edit_business_purpose_master($data);
            exit;
        }
    }

    function delete_business_purpose_master($id) {
        $delete = $this->dashboard_model->delete_business_purpose_master($id);

        if ($delete) {
            redirect('dashboard/listing_business_purpose_master');
        }
    }

    //------------------------------------------------- Department ------------------------------------------------------------------------------------------	

    function listing_department_master() {
        $data = array();
        $data['message'] = "";
        $data['query'] = $this->dashboard_model->get_all_department_master();
        $data['page_url'] = "department_master_listing";
        $this->load->view('includes/template', $data);
    }

    function add_form_department_master() {
        $data = array();
        $data['message'] = "";
        $data['page_url'] = "department_master_add_form";
        $this->load->view('includes/template', $data);
    }

    function add_department_master() {
        if ($this->input->post()) {
            $data = $_POST;
            echo $this->dashboard_model->add_department_master($data);
            exit;
        }
    }

    function edit_form_department_master($id) {
        if ($id == null) {
            show_error('No identifier provided', 500);
        } else {
            $data = array();
            $data['message'] = '';

            $row = $this->dashboard_model->department_master_get_by_id($id);

            if ($row) {
                $data['DepartmentId'] = trim($row['iDepartmentId']);
                $data['DepartmentName'] = trim($row['cDepartmentName']);
                $data['Active'] = trim($row['bActive']);

                $data['page_url'] = 'department_master_edit_form';
                $this->load->view('includes/template', $data);
            } else {
                show_error('Error in retrieving data by id');
            }
        }
    }

    function edit_department_master() {
        if ($this->input->post()) {
            $data = $_POST;
            echo $this->dashboard_model->edit_department_master($data);
            exit;
        }
    }

    function delete_department_master($id) {
        $delete = $this->dashboard_model->delete_department_master($id);

        if ($delete) {
            redirect('dashboard/listing_department_master');
        }
    }

    //---------------------------------------------- Branch ------------------------------------------------------------------------------------------------	

    function listing_branch_master() {
        $data = array();
        $data['message'] = "";
        $data['query'] = $this->dashboard_model->get_all_branch_master();
        $data['page_url'] = "branch_master_listing";
        $this->load->view('includes/template', $data);
    }

    function add_form_branch_master() {
        $data = array();
        $data['message'] = "";
        $data['page_url'] = "branch_master_add_form";
        $this->load->view('includes/template', $data);
    }

    function add_branch_master() {
        if ($this->input->post()) {
            $data = $_POST;
            echo $this->dashboard_model->add_branch_master($data);
            exit;
        }
    }

    function edit_form_branch_master($id) {
        if ($id == null) {
            show_error('No identifier provided', 500);
        } else {
            $data = array();
            $data['message'] = '';

            $row = $this->dashboard_model->branch_master_get_by_id($id);

            if ($row) {
                $data['BranchId'] = trim($row['iBranchId']);
                $data['BranchName'] = trim($row['cBranchName']);
                $data['Active'] = trim($row['bActive']);

                $data['page_url'] = 'branch_master_edit_form';
                $this->load->view('includes/template', $data);
            } else {
                show_error('Error in retrieving data by id');
            }
        }
    }

    function edit_branch_master() {
        if ($this->input->post()) {
            $data = $_POST;
            echo $this->dashboard_model->edit_branch_master($data);
            exit;
        }
    }

    function delete_branch_master($id) {
        $delete = $this->dashboard_model->delete_branch_master($id);

        if ($delete) {
            redirect('dashboard/listing_branch_master');
        }
    }

    //---------------------------------------------- Current Status ------------------------------------------------------------------------------------------------	

    function listing_current_status_master() {
        $data = array();
        $data['message'] = "";
        $data['query'] = $this->dashboard_model->get_all_current_status_master();
        $data['page_url'] = "current_status_master_listing";
        $this->load->view('includes/template', $data);
    }

    function add_form_current_status_master() {
        $data = array();
        $data['message'] = "";
        $data['page_url'] = "current_status_master_add_form";
        $this->load->view('includes/template', $data);
    }

    function add_current_status_master() {
        if ($this->input->post()) {
            $data = $_POST;
            echo $this->dashboard_model->add_current_status_master($data);
            exit;
        }
    }

    function edit_form_current_status_master($id) {
        if ($id == null) {
            show_error('No identifier provided', 500);
        } else {
            $data = array();
            $data['message'] = '';

            $row = $this->dashboard_model->current_status_master_get_by_id($id);

            if ($row) {
                $data['CurrentStatusId'] = trim($row['iCurrentStatusId']);
                $data['CurrentStatusName'] = trim($row['cCurrentStatusName']);
                $data['Active'] = trim($row['bActive']);

                $data['page_url'] = 'current_status_master_edit_form';
                $this->load->view('includes/template', $data);
            } else {
                show_error('Error in retrieving data by id');
            }
        }
    }

    function edit_current_status_master() {
        if ($this->input->post()) {
            $data = $_POST;
            echo $this->dashboard_model->edit_current_status_master($data);
            exit;
        }
    }

    function delete_current_status_master($id) {
        $delete = $this->dashboard_model->delete_current_status_master($id);

        if ($delete) {
            redirect('dashboard/listing_current_status_master');
        }
    }

    //--------------------------------------------------- Assign Task --------------------------------------------------------------------------------------

    function listing_task_assign() {
        $data = array();
        $data['message'] = "";
        $data['query'] = $this->dashboard_model->get_all_task_assign();
        $data['page_url'] = "task_assign_listing";
        $this->load->view('includes/template', $data);
    }

    function add_form_task_assign() {
        $data = array();
        $data['message'] = "";
        $data['page_url'] = "task_assign_add_form";
        $this->load->view('includes/template', $data);
    }

    function add_task_assign() {
        if ($this->input->post()) {
            $data = $_POST;
            echo $this->dashboard_model->add_task_assign($data);
            exit;
        }
    }

    function edit_form_task_assign($id) {
        if ($id == null) {
            show_error('No identifier provided', 500);
        } else {
            $data = array();
            $data['message'] = '';

            $row = $this->dashboard_model->task_assign_get_by_id($id);

            if ($row) {
                $data['TaskAssignId'] = trim($row['iTaskAssignId']);
                $data['DepartmentId'] = trim($row['iDepartmentId']);
                $data['TaskAssignDateTime'] = trim($row['dTaskAssignDateTime']);
                $data['ClientReqId'] = trim($row['iClientReqId']);
                $data['RequirementId'] = trim($row['iRequirementId']);
                $data['ClientPropId'] = trim($row['iClientPropId']);
                $data['PropertyId'] = trim($row['iPropertyId']);
                $data['TaskId'] = trim($row['iTaskId']);
                $data['TaskSummary'] = trim($row['cTaskSummary']);
                $data['TaskTargetDateTime'] = trim($row['dTaskTargetDateTime']);
                $data['ReminderDateTime'] = trim($row['dReminderDateTime']);
                $data['TaskDone'] = trim($row['bTaskDone']);

                $data['page_url'] = 'task_assign_edit_form';
                $this->load->view('includes/template', $data);
            } else {
                show_error('Error in retrieving data by id');
            }
        }
    }

    function edit_task_assign() {
        if ($this->input->post()) {
            $data = $_POST;
            echo $this->dashboard_model->edit_task_assign($data);
            exit;
        }
    }

    function update_task_assigned($id) {
        $userupdate = $this->dashboard_model->user_update_task_assigned($id);

        if ($userupdate) {
//			redirect('dashboard/userpendingtasklist');
            redirect('dashboard');
        }
    }

    function delete_task_assign($id) {
        $delete = $this->dashboard_model->delete_task_assign($id);

        if ($delete) {
            redirect('dashboard/listing_task_assign');
        }
    }

    //--------------------------------------------------- Property -------------------------------------------------------------------------------------------

    function listing_property_master($client_id = 0) {

        //  echo $client_id;die('aaaaaaaaa');
        $data = array();
        $data['message'] = "";
        //$data['query'] = $this->dashboard_model->get_all_property_master($client_id);
        //$data['page_url']="property_master_listing";
        $data['client_id'] = $client_id;
        $data['page_url'] = "property_master_listing_datatable";
        $this->load->view('includes/template', $data);
    }

    function add_form_property_master() {
        $data = array();
        $data['message'] = "";
        $data['page_url'] = "property_master_add_form";
        $this->load->view('includes/template', $data);
    }

    function add_property_master() {
        if ($this->input->post()) {
            $data = $_POST;
            echo $this->dashboard_model->add_property_master($data);
            exit;
        }
    }

    function edit_form_property_master($id) {
        if ($id == null) {
            show_error('No identifier provided', 500);
        } else {
            $data = array();
            $data['message'] = '';

            $row = $this->dashboard_model->property_master_get_by_id($id);

            $attachmentrows = $this->dashboard_model->get_property_attachments_by_id($id);

            if ($row) {
                $data['PropertyId'] = trim($row['iPropertyId']);

                if (!empty($row['dDate']) && $row['dDate'] != '0000-00-00') {
                    $splitdt = explode('-', $row['dDate']);
                    $Date = $splitdt[2] . "/" . $splitdt[1] . "/" . $splitdt[0];

                    $data['Date'] = trim($Date);
                } else {
                    $data['Date'] = "";
                }

                $data['PropertyName'] = trim($row['cPropertyName']);
                $data['ClientId'] = trim($row['iClientId']);
                //cmbContactPerson
                $data['ContactId'] = trim($row['iContactId']);
                $data['BranchId'] = trim($row['iBranchId']);
                $data['StateId'] = trim($row['iStateId']);
                $data['DistrictId'] = trim($row['iDistrictId']);
                $data['CityId'] = trim($row['iCityId']);
                $data['LocationId'] = trim($row['iLocationId']);
                $data['PropertyAddress'] = trim($row['cPropertyAddress']);
                $data['SourceId'] = trim($row['iSourceId']);
                $data['PropertyCatId'] = trim($row['iPropertyCategoryId']);
                $data['PropertyTypeId'] = trim($row['iPropertyTypeId']);
                $data['PropertyStatusId'] = trim($row['iPropertyStatusId']);
                $data['PropertyPurpose'] = trim($row['cPropertyPurpose']);
                $data['PropertyLegalStatus'] = trim($row['cPropertyLegalStatus']);
                $data['SurroundingBrands'] = trim($row['cSurroundingBrands']);
                $data['PropertyTaglineForWebsite'] = trim($row['cPropertyTaglineForWebsite']);
                $data['PropertyRemarks'] = trim($row['cPropertyRemarks']);
                $data['TotalPlotArea'] = trim($row['cTotalPlotArea']);
                $data['BuildingArea'] = trim($row['cBuildingArea']);
                $data['NoOfFloorsInBuilding'] = trim($row['iNoOfFloorsInBuilding']);
                $data['GroundCoverage'] = trim($row['cGroundCoverage']);
                $data['FloorOffered'] = trim($row['cFloorOffered']);
                $data['PlateAreaOfFloorOffered'] = trim($row['cPlateAreaOfFloorOffered']);
                $data['Toilet'] = trim($row['cToilet']);
                $data['Parking'] = trim($row['cParking']);
                $data['CarpetArea'] = trim($row['cCarpetArea']);
                $data['BuiltUpArea'] = trim($row['cBuiltUpArea']);
                $data['SuperBuiltUpArea'] = trim($row['cSuperBuiltUpArea']);
                $data['Frontage'] = trim($row['cFrontage']);
                $data['Depth'] = trim($row['cDepth']);
                $data['Height'] = trim($row['cHeight']);
                $data['PropertyFurnishedStatus'] = trim($row['cPropertyFurnishedStatus']);
                $data['AgreementTypeId'] = trim($row['iAgreementTypeId']);
                $data['DemandPerSqFeet'] = trim($row['cDemandPerSqFeet']);
                $data['DemandGross'] = trim($row['cDemandGross']);
                $data['SecurityDeposit'] = trim($row['cSecurityDeposit']);
                $data['EscalationId'] = trim($row['iEscalationId']);
                $data['CAM'] = trim($row['cCAM']);
                $data['ServiceTaxOnLessor'] = trim($row['cServiceTaxOnLessor']);
                $data['ServiceTaxOnLessee'] = trim($row['cServiceTaxOnLessee']);
                $data['PropertyTaxOnLessor'] = trim($row['cPropertyTaxOnLessor']);
                $data['PropertyTaxOnLessee'] = trim($row['cPropertyTaxOnLessee']);
                $data['StampDutyAndRegistration'] = trim($row['cStampDutyAndRegistration']);
                $data['LockIn'] = trim($row['cLockIn']);
                $data['LockInDuration'] = trim($row['cLockInDuration']);
                $data['RentFreePeriod'] = trim($row['cRentFreePeriod']);
                $data['NoticePeriod'] = trim($row['cNoticePeriod']);
                $data['PossessionStatus'] = trim($row['cPossessionStatus']);
                $data['PowerLoad'] = trim($row['cPowerLoad']);
                $data['PowerBackup'] = trim($row['cPowerBackup']);
                $data['CurrentTenant'] = trim($row['cCurrentTenant']);
                $data['LeaseUpToDate'] = trim($row['dLeaseUpToDate']);
                $data['PreviousTenant'] = trim($row['cPreviousTenant']);
                $data['AgreementDate'] = trim($row['dAgreementDate']);
                $data['AgreementPlace'] = trim($row['cAgreementPlace']);
                $data['Person1DuringAgreement'] = trim($row['cPerson1DuringAgreement']);
                $data['Person2DuringAgreement'] = trim($row['cPerson2DuringAgreement']);
                $data['AgreementFilePath'] = trim($row['cAgreementFilePath']);
                $data['AgreementFileName'] = trim($row['cAgreementFileName']);
                $data['TermsAndConditions'] = trim($row['cTermsAndConditions']);
                $data['AcceptTermsAndConditions'] = trim($row['bAcceptTermsAndConditions']);
                $data['Active'] = trim($row['bActive']);

                $data['AttachmentRows'] = $attachmentrows;

                $data['page_url'] = 'property_master_edit_form';
                $this->load->view('includes/template', $data);
            } else {
                show_error('Error in retrieving data by id');
            }
        }
    }

    function edit_property_master() {
        if ($this->input->post()) {
            $data = $_POST;
            echo $this->dashboard_model->edit_property_master($data);
            exit;
        }
    }

    function delete_property_master($id) {
        $delete = $this->dashboard_model->delete_property_master($id);

        if ($delete) {
            redirect('dashboard/listing_property_master');
        }
    }

    function viewproperty($id) {
        if ($id == null) {
            show_error('No identifier provided', 500);
        } else {
            $data = array();
            $data['message'] = '';

            $row = $this->dashboard_model->property_master_get_by_id($id);

            $attachmentrows = $this->dashboard_model->get_property_attachments_by_id($id);

            if ($row) {
                if (!empty($row['dDate']) && $row['dDate'] != '0000-00-00') {
                    $splitdt = explode('-', $row['dDate']);
                    $Date = $splitdt[2] . "/" . $splitdt[1] . "/" . $splitdt[0];

                    $data['Date'] = trim($Date);
                } else {
                    $data['Date'] = "";
                }

                $data['PropertyId'] = trim($row['iPropertyId']);
                $data['PropertyName'] = trim($row['cPropertyName']);
                $data['ClientId'] = trim($row['iClientId']);
                $data['ContactId'] = trim($row['iContactId']);
                $data['BranchId'] = trim($row['iBranchId']);
                $data['StateId'] = trim($row['iStateId']);
                $data['DistrictId'] = trim($row['iDistrictId']);
                $data['CityId'] = trim($row['iCityId']);
                $data['LocationId'] = trim($row['iLocationId']);
                $data['PropertyAddress'] = trim($row['cPropertyAddress']);
                $data['SourceId'] = trim($row['iSourceId']);
                $data['PropertyCatId'] = trim($row['iPropertyCategoryId']);
                $data['PropertyTypeId'] = trim($row['iPropertyTypeId']);
                $data['PropertyStatusId'] = trim($row['iPropertyStatusId']);
                $data['PropertyPurpose'] = trim($row['cPropertyPurpose']);
                $data['PropertyLegalStatus'] = trim($row['cPropertyLegalStatus']);
                $data['PropertyRemarks'] = trim($row['cPropertyRemarks']);
                $data['TotalPlotArea'] = trim($row['cTotalPlotArea']);
                $data['BuildingArea'] = trim($row['cBuildingArea']);
                $data['NoOfFloorsInBuilding'] = trim($row['iNoOfFloorsInBuilding']);
                $data['GroundCoverage'] = trim($row['cGroundCoverage']);
                $data['FloorOffered'] = trim($row['cFloorOffered']);
                $data['PlateAreaOfFloorOffered'] = trim($row['cPlateAreaOfFloorOffered']);
                $data['Toilet'] = trim($row['cToilet']);
                $data['Parking'] = trim($row['cParking']);
                $data['CarpetArea'] = trim($row['cCarpetArea']);
                $data['BuiltUpArea'] = trim($row['cBuiltUpArea']);
                $data['SuperBuiltUpArea'] = trim($row['cSuperBuiltUpArea']);
                $data['Frontage'] = trim($row['cFrontage']);
                $data['Depth'] = trim($row['cDepth']);
                $data['Height'] = trim($row['cHeight']);
                $data['PropertyFurnishedStatus'] = trim($row['cPropertyFurnishedStatus']);
                $data['AgreementTypeId'] = trim($row['iAgreementTypeId']);
                $data['DemandPerSqFeet'] = trim($row['cDemandPerSqFeet']);
                $data['DemandGross'] = trim($row['cDemandGross']);
                $data['SecurityDeposit'] = trim($row['cSecurityDeposit']);
                $data['EscalationId'] = trim($row['iEscalationId']);
                $data['CAM'] = trim($row['cCAM']);
                $data['ServiceTaxOnLessor'] = trim($row['cServiceTaxOnLessor']);
                $data['ServiceTaxOnLessee'] = trim($row['cServiceTaxOnLessee']);
                $data['PropertyTaxOnLessor'] = trim($row['cPropertyTaxOnLessor']);
                $data['PropertyTaxOnLessee'] = trim($row['cPropertyTaxOnLessee']);
                $data['StampDutyAndRegistration'] = trim($row['cStampDutyAndRegistration']);
                $data['LockIn'] = trim($row['cLockIn']);
                $data['LockInDuration'] = trim($row['cLockInDuration']);
                $data['RentFreePeriod'] = trim($row['cRentFreePeriod']);
                $data['NoticePeriod'] = trim($row['cNoticePeriod']);
                $data['PossessionStatus'] = trim($row['cPossessionStatus']);
                $data['PowerLoad'] = trim($row['cPowerLoad']);
                $data['PowerBackup'] = trim($row['cPowerBackup']);
                $data['CurrentTenant'] = trim($row['cCurrentTenant']);
                $data['LeaseUpToDate'] = trim($row['dLeaseUpToDate']);
                $data['PreviousTenant'] = trim($row['cPreviousTenant']);
                $data['AgreementDate'] = trim($row['dAgreementDate']);
                $data['AgreementPlace'] = trim($row['cAgreementPlace']);
                $data['Person1DuringAgreement'] = trim($row['cPerson1DuringAgreement']);
                $data['Person2DuringAgreement'] = trim($row['cPerson2DuringAgreement']);
                $data['AgreementFilePath'] = trim($row['cAgreementFilePath']);
                $data['AgreementFileName'] = trim($row['cAgreementFileName']);
                $data['TermsAndConditions'] = trim($row['cTermsAndConditions']);
                $data['Active'] = trim($row['bActive']);

                $data['AttachmentRows'] = $attachmentrows;

                $data['page_url'] = 'property_master_view_form';
                $this->load->view('includes/template', $data);
            } else {
                show_error('Error in retrieving data by id');
            }
        }
    }

    //--------------------------------------------------- Requirement ----------------------------------------------------------------------------------

    function listing_requirement_master($client_id = 0) {
        $data = array();
        $data['message'] = "";
        $data['client_id'] = $client_id;
        //	$data['query'] = $this->dashboard_model->get_all_requirement_master($client_id);
        $data['page_url'] = "requirement_master_listing_datatable";
        $this->load->view('includes/template', $data);
    }

    function listing_requirement_master_datatable($client_id = 0) {
        $data['query'] = $this->dashboard_model->get_all_requirement_master_datatable($client_id, $aColumns, $sIndexColumn, $sTable, $sWhere, $_GET);
    }

    function add_form_requirement_master() {
        $data = array();
        $data['message'] = "";
        $data['page_url'] = "requirement_master_add_form";
        $this->load->view('includes/template', $data);
    }

    function add_requirement_master() {
        if ($this->input->post()) {
            $data = $_POST;
            echo $this->dashboard_model->add_requirement_master($data);
            exit;
        }
    }

    function edit_form_requirement_master($id) {
        if ($id == null) {
            show_error('No identifier provided', 500);
        } else {
            $data = array();
            $data['message'] = '';

            $row = $this->dashboard_model->requirement_master_get_by_id($id);
            if ($row) {
                $data['RequirementId'] = trim($row['iRequirementId']);
                if (!empty($row['dDate']) && $row['dDate'] != '0000-00-00') {
                    $splitdt = explode('-', $row['dDate']);
                    $Date = $splitdt[2] . "/" . $splitdt[1] . "/" . $splitdt[0];

                    $data['Date'] = trim($Date);
                } else {
                    $data['Date'] = "";
                }
                $data['RequirementTitle'] = trim($row['cRequirementTitle']);
                $data['ClientId'] = trim($row['iClientId']);
                $data['ContactId'] = trim($row['iContactId']);
                $data['ContactPerson1'] = trim($row['cContactPerson1']);
                $data['ContactDetail1'] = trim($row['cContactDetail1']);
                $data['ContactPerson2'] = trim($row['cContactPerson2']);
                $data['ContactDetail2'] = trim($row['cContactDetail2']);
                $data['ContactPerson3'] = trim($row['cContactPerson3']);
                $data['ContactDetail3'] = trim($row['cContactDetail3']);
                $data['BranchId'] = trim($row['iBranchId']);
                $data['StateId'] = trim($row['iStateId']);
                $data['DistrictId'] = trim($row['iDistrictId']);
                $data['CityId'] = trim($row['iCityId']);
                $data['LocationId'] = trim($row['iLocationId']);
                $data['Area'] = trim($row['cArea']);
                $data['Height'] = trim($row['cHeight']);
                $data['Frontage'] = trim($row['cFrontage']);
                $data['cFurnishedStatus'] = trim($row['cFurnishedStatus']);
                $data['SourceId'] = trim($row['iSourceId']);
                //$data['PropertyPurpose'] = trim($row['cPropertyPurpose']);
                $data['BusinessPurposeId'] = trim($row['iBusinessPurposeId']);
                $data['PropertyCategoryId'] = trim($row['iPropertyCategoryId']);
                $data['RequirementType'] = trim($row['cRequirementType']);
                $data['BudgetPerMonth'] = trim($row['cBudgetPerMonth']);
                $data['FloorLevelPreference'] = trim($row['cFloorLevelPreference']);
                $data['EscalationId'] = trim($row['iEscalationId']);
                $data['LeasePeriodPreference'] = trim($row['cLeasePeriodPreference']);
                $data['RentFreeFitOutPeriod'] = trim($row['cRentFreeFitOutPeriod']);
                $data['PowerLoad'] = trim($row['cPowerLoad']);
                $data['PowerBackup'] = trim($row['cPowerBackup']);

                if (!empty($row['dExpectedLaunchDate']) && $row['dExpectedLaunchDate'] != '0000-00-00') {
                    $splitexpdt = explode('-', $row['dExpectedLaunchDate']);
                    $ExpectedLaunchDate = $splitexpdt[2] . "/" . $splitexpdt[1] . "/" . $splitexpdt[0];
                } else {
                    $ExpectedLaunchDate = "";
                }

                $data['ExpectedLaunchDate'] = trim($ExpectedLaunchDate);

                $data['RequirementTaglineForWebsite'] = trim($row['cRequirementTaglineForWebsite']);
                $data['Remarks'] = trim($row['cRemarks']);

                $data['RegistrationExpensesToBeBorneBy'] = trim($row['cRegistrationExpensesToBeBorneBy']);
                $data['TaxationToBeBorneBy'] = trim($row['cTaxationToBeBorneBy']);
                $data['LockInPeriod'] = trim($row['cLockInPeriod']);
                $data['EstimatedInteriorBudget'] = trim($row['cEstimatedInteriorBudget']);
                $data['ParkingPreference'] = trim($row['cParkingPreference']);

                if (!empty($row['dAgreementDate']) && $row['dAgreementDate'] != '0000-00-00') {
                    $splitagreedt = explode('-', $row['dAgreementDate']);
                    $AgreementDate = $splitagreedt[2] . "/" . $splitagreedt[1] . "/" . $splitagreedt[0];
                } else {
                    $AgreementDate = "";
                }

                $data['AgreementDate'] = trim($AgreementDate);
                $data['AgreementPlace'] = trim($row['cAgreementPlace']);
                $data['Person1DuringAgreement'] = trim($row['cPerson1DuringAgreement']);
                $data['Person2DuringAgreement'] = trim($row['cPerson2DuringAgreement']);
                $data['AgreementFilePath'] = trim($row['cAgreementFilePath']);
                $data['AgreementFileName'] = trim($row['cAgreementFileName']);

                $data['TermsAndConditions'] = trim($row['cTermsAndConditions']);
                $data['AcceptTermsAndConditions'] = trim($row['bAcceptTermsAndConditions']);
                $data['ServiceChargesForLinkers'] = trim($row['cServiceChargesForLinkers']);
                $data['Active'] = trim($row['bActive']);

                $data['page_url'] = 'requirement_master_edit_form';
                $this->load->view('includes/template', $data);
            } else {
                show_error('Error in retrieving data by id');
            }
        }
    }

    function edit_requirement_master() {
        if ($this->input->post()) {
            $data = $_POST;
            echo $this->dashboard_model->edit_requirement_master($data);
            exit;
        }
    }

    function delete_requirement_master($id) {
        $delete = $this->dashboard_model->delete_requirement_master($id);

        if ($delete) {
            redirect('dashboard/listing_requirement_master');
        }
    }

    function viewrequisition($id) {
        if ($id == null) {
            show_error('No identifier provided', 500);
        } else {
            $data = array();
            $data['message'] = '';

            $row = $this->dashboard_model->requirement_master_get_by_id($id);

            if ($row) {
                $data['RequirementId'] = trim($row['iRequirementId']);

                if (!empty($row['dDate']) && $row['dDate'] != '0000-00-00') {
                    $splitdt = explode('-', $row['dDate']);
                    $Date = $splitdt[2] . "/" . $splitdt[1] . "/" . $splitdt[0];
                    $data['Date'] = trim($Date);
                } else {
                    $data['Date'] = "";
                }

                $data['ClientId'] = trim($row['iClientId']);
                $data['ContactId'] = trim($row['iContactId']);
                $data['ContactPerson1'] = trim($row['cContactPerson1']);
                $data['ContactDetail1'] = trim($row['cContactDetail1']);
                $data['ContactPerson2'] = trim($row['cContactPerson2']);
                $data['ContactDetail2'] = trim($row['cContactDetail2']);
                $data['ContactPerson3'] = trim($row['cContactPerson3']);
                $data['ContactDetail3'] = trim($row['cContactDetail3']);
                $data['StateId'] = trim($row['iStateId']);
                $data['DistrictId'] = trim($row['iDistrictId']);
                $data['CityId'] = trim($row['iCityId']);
                $data['LocationId'] = trim($row['iLocationId']);
                $data['Area'] = trim($row['cArea']);
                $data['Height'] = trim($row['cHeight']);
                $data['Frontage'] = trim($row['cFrontage']);
                $data['SourceId'] = trim($row['iSourceId']);
                $data['PropertyPurpose'] = trim($row['cPropertyPurpose']);
                $data['BusinessPurposeId'] = trim($row['iBusinessPurposeId']);
                $data['PropertyCategoryId'] = trim($row['iPropertyCategoryId']);
                $data['RequirementType'] = trim($row['cRequirementType']);
                $data['BudgetPerMonth'] = trim($row['cBudgetPerMonth']);
                $data['FloorLevelPreference'] = trim($row['cFloorLevelPreference']);
                $data['EscalationId'] = trim($row['iEscalationId']);
                $data['LeasePeriodPreference'] = trim($row['cLeasePeriodPreference']);
                $data['RentFreeFitOutPeriod'] = trim($row['cRentFreeFitOutPeriod']);
                $data['PowerLoad'] = trim($row['cPowerLoad']);
                $data['PowerBackup'] = trim($row['cPowerBackup']);

                if (!empty($row['dExpectedLaunchDate']) && $row['dExpectedLaunchDate'] != '0000-00-00') {
                    $splitexpdt = explode('-', $row['dExpectedLaunchDate']);
                    $ExpectedLaunchDate = $splitexpdt[2] . "/" . $splitexpdt[1] . "/" . $splitexpdt[0];
                } else {
                    $ExpectedLaunchDate = "";
                }

                $data['ExpectedLaunchDate'] = $ExpectedLaunchDate;
                $data['Remarks'] = trim($row['cRemarks']);

                $data['RegistrationExpensesToBeBorneBy'] = trim($row['cRegistrationExpensesToBeBorneBy']);
                $data['TaxationToBeBorneBy'] = trim($row['cTaxationToBeBorneBy']);
                $data['LockInPeriod'] = trim($row['cLockInPeriod']);
                $data['EstimatedInteriorBudget'] = trim($row['cEstimatedInteriorBudget']);

                if (!empty($row['dAgreementDate']) && $row['dAgreementDate'] != '0000-00-00') {
                    $splitagreedt = explode('-', $row['dAgreementDate']);
                    $AgreementDate = $splitagreedt[2] . "/" . $splitagreedt[1] . "/" . $splitagreedt[0];
                } else {
                    $AgreementDate = "";
                }

                $data['AgreementDate'] = trim($AgreementDate);
                $data['AgreementPlace'] = trim($row['cAgreementPlace']);
                $data['Person1DuringAgreement'] = trim($row['cPerson1DuringAgreement']);
                $data['Person2DuringAgreement'] = trim($row['cPerson2DuringAgreement']);
                $data['AgreementFilePath'] = trim($row['cAgreementFilePath']);
                $data['TermsAndConditions'] = trim($row['cTermsAndConditions']);
                $data['ServiceChargesForLinkers'] = trim($row['cServiceChargesForLinkers']);
                $data['Active'] = trim($row['bActive']);

                $data['page_url'] = 'requirement_master_view_form';
                $this->load->view('includes/template', $data);
            } else {
                show_error('Error in retrieving data by id');
            }
        }
    }

    //--------------------------------------------------- Initiate Deal -------------------------------------------------------------------------------------

    function listing_deal_initiate() {
        $data = array();
        $data['message'] = "";
        $data['query'] = $this->dashboard_model->get_all_deal_initiate();
        $data['page_url'] = "deal_initiate_listing";
        $this->load->view('includes/template', $data);
    }

    function add_form_deal_initiate() {
        $data = array();
        $data['message'] = "";
        $data['page_url'] = "deal_initiate_add_form";
        $this->load->view('includes/template', $data);
    }

    function add_deal_initiate() {
        if ($this->input->post()) {
            $data = $_POST;
            echo $this->dashboard_model->add_deal_initiate($data);
            exit;
        }
    }

    function edit_form_deal_initiate($id) {
        if ($id == null) {
            show_error('No identifier provided', 500);
        } else {
            $data = array();
            $data['message'] = '';

            $row = $this->dashboard_model->deal_initiate_get_by_id($id);

            $attachmentrows = $this->dashboard_model->get_deal_attachments_by_id($id);
            if ($row) {
                $data['DealInitiateId'] = trim($row['iDealInitiateId']);

                if (!empty($row['dDealInitiateDate']) && $row['dDealInitiateDate'] != '0000-00-00') {
                    $splitinitdt = explode('-', $row['dDealInitiateDate']);
                    $DealInitiateDate = $splitinitdt[2] . "/" . $splitinitdt[1] . "/" . $splitinitdt[0];
                } else {
                    $DealInitiateDate = "";
                }

                $data['DealInitiateDate'] = trim($DealInitiateDate);
                $data['BranchId'] = trim($row['iBranchId']);
                $data['ClientReqId'] = trim($row['iClientReqId']);
                $data['RequirementId'] = trim($row['iRequirementId']);
                $data['ClientPropId'] = trim($row['iClientPropId']);
                $data['PropertyId'] = trim($row['iPropertyId']);

                if (!empty($row['dLeaseStartDate']) && $row['dLeaseStartDate'] != '0000-00-00') {
                    $splitleasestdt = explode('-', $row['dLeaseStartDate']);
                    $LeaseStartDate = $splitleasestdt[2] . "/" . $splitleasestdt[1] . "/" . $splitleasestdt[0];
                } else {
                    $LeaseStartDate = "";
                }

                $data['LeaseStartDate'] = trim($LeaseStartDate);

                if (!empty($row['dLeaseEndDate']) && $row['dLeaseEndDate'] != '0000-00-00') {
                    $splitleaseenddt = explode('-', $row['dLeaseEndDate']);
                    $LeaseEndDate = $splitleaseenddt[2] . "/" . $splitleaseenddt[1] . "/" . $splitleaseenddt[0];
                } else {
                    $LeaseEndDate = "";
                }

                $data['LeaseEndDate'] = trim($LeaseEndDate);


                if (!empty($row['dLeaseRenewalReminderDate']) && $row['dLeaseRenewalReminderDate'] != '0000-00-00') {
                    $splitleaseenddt = explode('-', $row['dLeaseRenewalReminderDate']);
                    $data['LeaseRenewalReminderDate'] = $splitleaseenddt[2] . "/" . $splitleaseenddt[1] . "/" . $splitleaseenddt[0];
                } else {
                    $data['LeaseRenewalReminderDate'] = "";
                }


                $data['ReminderForRenewal'] = trim($row['cReminderForRenewal']);

                $data['TermsAndConditions'] = trim($row['cTermsAndConditions']);


                if (!empty($row['dPossessionDate']) && $row['dPossessionDate'] != '0000-00-00') {
                    $splitleaseenddt = explode('-', $row['dPossessionDate']);
                    $data['PossessionDate'] = $splitleaseenddt[2] . "/" . $splitleaseenddt[1] . "/" . $splitleaseenddt[0];
                } else {
                    $data['PossessionDate'] = "";
                }

                $data['PossessionDone'] = trim($row['cPossessionDone']);

                if (!empty($row['dPaymentDate']) && $row['dPaymentDate'] != '0000-00-00') {
                    $splitleaseenddt = explode('-', $row['dPaymentDate']);
                    $data['PaymentDate'] = $splitleaseenddt[2] . "/" . $splitleaseenddt[1] . "/" . $splitleaseenddt[0];
                } else {
                    $data['PaymentDate'] = "";
                }

                $data['PaymentReceivedCompletely'] = trim($row['cPaymentReceivedCompletely']);
                $data['TaglineForWebsite'] = trim($row['cTaglineForWebsite']);

                if (!empty($row['dDealDoneDate']) && $row['dDealDoneDate'] != '0000-00-00') {
                    $splitdealdndt = explode('-', $row['dDealDoneDate']);
                    $DealDoneDate = $splitdealdndt[2] . "/" . $splitdealdndt[1] . "/" . $splitdealdndt[0];
                } else {
                    $DealDoneDate = "";
                }

                $data['DealDoneDate'] = trim($DealDoneDate);

                $data['Active'] = trim($row['bActive']);

                $data['AttachmentRows'] = $attachmentrows;

                $data['page_url'] = 'deal_initiate_edit_form';
                $this->load->view('includes/template', $data);
            } else {
                show_error('Error in retrieving data by id');
            }
        }
    }

    function edit_deal_initiate() {
        if ($this->input->post()) {
            $data = $_POST;
            echo $this->dashboard_model->edit_deal_initiate($data);
            exit;
        }
    }

    function delete_deal_initiate($id) {
        $delete = $this->dashboard_model->delete_deal_initiate($id);

        if ($delete) {
            redirect('dashboard/listing_deal_initiate');
        }
    }

    //--------------------------------------------------- Deal Lost -------------------------------------------------------------------------------------

    function listing_deal_lost() {
        $data = array();
        $data['message'] = "";
        $data['query'] = $this->dashboard_model->get_all_deal_lost();
        $data['page_url'] = "deal_lost_listing";
        $this->load->view('includes/template', $data);
    }

    function add_form_deal_lost() {
        $data = array();
        $data['message'] = "";
        $data['page_url'] = "deal_lost_add_form";
        $this->load->view('includes/template', $data);
    }

    function add_deal_lost1() {
        if ($this->input->post()) {
            $data = $_POST;
            echo $this->dashboard_model->add_deal_lost($data);
            exit;
        }
    }

//          	function add_deal_lost(){
//             $data = array();
//        $data['object'] = $this->dashboard_model->add_deal_lost1($data);
//        if ($data) {
//                    
//                        redirect('../listing_deal_lost/dashboard', $data);
//
//        }
//                }

    function edit_form_deal_lost($id) {
        if ($id == null) {
            show_error('No identifier provided', 500);
        } else {
            $data = array();
            $data['message'] = '';

            $row = $this->dashboard_model->deal_lost_get_by_id($id);

            if ($row) {
                $data['DealLostId'] = trim($row['iDealLostId']);
                if (!empty($row['dDate']) && trim($row['dDate']) != '0000-00-00') {
                    $data['Date'] = date("d/m/Y", strtotime($row['dDate']));
                } else {
                    $data['Date'] = "";
                }

                $data['ClientReqId'] = trim($row['iClientReqId']);
                $data['RequirementId'] = trim($row['iRequirementId']);
                $data['ClientPropId'] = trim($row['iClientPropId']);
                $data['PropertyId'] = trim($row['iPropertyId']);
                $data['SummaryOfDealLostReason'] = trim($row['cSummaryOfDealLostReason']);

                if (!empty($row['dFollowUpDate']) && trim($row['dFollowUpDate']) != '0000-00-00') {
                    $data['FollowUpDate'] = date("d/m/Y", strtotime($row['dFollowUpDate']));
                } else {
                    $data['FollowUpDate'] = "";
                }

                $data['Active'] = trim($row['bActive']);
                $data['Delete'] = trim($row['bDelete']);

                $data['page_url'] = 'deal_lost_edit_form';
                $this->load->view('includes/template', $data);
            } else {
                show_error('Error in retrieving data by id');
            }
        }
    }

    function edit_deal_lost() {
        if ($this->input->post()) {
            $data = $_POST;
            echo $this->dashboard_model->edit_deal_lost($data);
            exit;
        }
    }

    function delete_deal_lost($id) {
        $delete = $this->dashboard_model->delete_deal_lost($id);

        if ($delete) {
            redirect('dashboard/listing_deal_lost');
        }
    }

    //--------------------------------------------- Success Story --------------------------------------------------------------------------------------------

    function listing_success_story() {
        $data = array();
        $data['message'] = "";
        $data['query'] = $this->dashboard_model->get_all_success_story();
        $data['page_url'] = "success_story_listing";
        $this->load->view('includes/template', $data);
    }

    function add_form_success_story() {
        $data = array();
        $data['message'] = "";
        $data['page_url'] = "success_story_add_form";
        $this->load->view('includes/template', $data);
    }

    function add_success_story() {
        if ($this->input->post()) {
            $data = $_POST;
            echo $this->dashboard_model->add_success_story($data);
            exit;
        }
    }

    function edit_form_success_story($id) {
        if ($id == null) {
            show_error('No identifier provided', 500);
        } else {
            $data = array();
            $data['message'] = '';

            $row = $this->dashboard_model->success_story_get_by_id($id);

            if ($row) {
                $data['SuccessStoryId'] = trim($row['iSuccessStoryId']);
                $data['PropertyId'] = trim($row['iPropertyId']);
                $data['LessorId'] = trim($row['iLessorId']);
                $data['LesseeId'] = trim($row['iLesseeId']);
                $data['Content'] = trim($row['cContent']);
                $data['Active'] = trim($row['bActive']);

                $data['page_url'] = 'success_story_edit_form';
                $this->load->view('includes/template', $data);
            } else {
                show_error('Error in retrieving data by id');
            }
        }
    }

    function edit_success_story() {
        if ($this->input->post()) {
            $data = $_POST;
            echo $this->dashboard_model->edit_success_story($data);
            exit;
        }
    }

    function delete_success_story($id) {
        $delete = $this->dashboard_model->delete_success_story($id);

        if ($delete) {
            redirect('dashboard/listing_success_story');
        }
    }

    //---------------------------------------------------------------------------------------------------------------------------------------------------
    //--------------------------------------------------- Client Testimonial ----------------------------------------------------------------------------

    function listing_client_testimonial() {
        $data = array();
        $data['message'] = "";
        $data['query'] = $this->dashboard_model->get_all_client_testimonial();
        $data['page_url'] = "client_testimonial_listing";
        $this->load->view('includes/template', $data);
    }

    function add_form_client_testimonial() {
        $data = array();
        $data['message'] = "";
        $data['page_url'] = "client_testimonial_add_form";
        $this->load->view('includes/template', $data);
    }

    function add_client_testimonial() {
        if ($this->input->post()) {
            $data = $_POST;
            echo $this->dashboard_model->add_client_testimonial($data);
            exit;
        }
    }

    function edit_form_client_testimonial($id) {
        if ($id == null) {
            show_error('No identifier provided', 500);
        } else {
            $data = array();
            $data['message'] = '';

            $row = $this->dashboard_model->client_testimonial_get_by_id($id);

            if ($row) {
                $data['ClientTestimonialId'] = trim($row['iClientTestimonialId']);
                $data['ClientId'] = trim($row['iClientId']);
                $data['TestimonialContent'] = trim($row['cTestimonialContent']);
                $data['Active'] = trim($row['bActive']);

                $data['page_url'] = 'client_testimonial_edit_form';
                $this->load->view('includes/template', $data);
            } else {
                show_error('Error in retrieving data by id');
            }
        }
    }

    function edit_client_testimonial() {
        if ($this->input->post()) {
            $data = $_POST;
            echo $this->dashboard_model->edit_client_testimonial($data);
            exit;
        }
    }

    function delete_client_testimonial($id) {
        $delete = $this->dashboard_model->delete_client_testimonial($id);

        if ($delete) {
            redirect('dashboard/listing_client_testimonial');
        }
    }

    //---------------------------------------------------------------------------------------------------------------------------------------------------

    function clienthistory($ClientId) {
        ob_start();

        //$data = $_POST;

        $report = $this->dashboard_model->client_history_print_report($ClientId);

        if ($report) {
            echo $report;
        }
    }

    //---------------------------------------------------------------------------------------------------------------------------------------------------

    function propertyhistory($PropertyId) {
        ob_start();

        //$data = $_POST;

        $report = $this->dashboard_model->property_history_print_report($PropertyId);

        if ($report) {
            echo $report;
        }
    }

    //---------------------------------------------------------------------------------------------------------------------------------------------------

    function propertydelivery($PropertyId) {
        ob_start();

        //$data = $_POST;

        $report = $this->dashboard_model->property_delivery_print_report($PropertyId);

        if ($report) {
            echo $report;
        }
    }

    //---------------------------------------------------------------------------------------------------------------------------------------------------

    function requisitionhistory($RequirementId) {
        ob_start();

        //$data = $_POST;

        $report = $this->dashboard_model->requisition_history_print_report($RequirementId);

        if ($report) {
            echo $report;
        }
    }

    //---------------------------------------------------------------------------------------------------------------------------------------------------

    function dwdcrreportform() {
        $data = array();
        $data['message'] = "";
        $data['page_url'] = "datewise_dcr_report_form";
        $this->load->view('includes/template', $data);
    }

    function dwdcrprintreport() {
        ob_start();

        $txtDate = trim($this->input->post('txtDate'));

        $report = $this->dashboard_model->datewise_dcr_print_report($txtDate);

        if ($report) {
            echo $report;
        }
    }

    //---------------------------------------------------------------------------------------------------------------------------------------------------

    function pendingrfreport() {
        ob_start();

        $report = $this->dashboard_model->pending_rf_print_report();

        if ($report) {
            echo $report;
        }
    }

    //---------------------------------------------------------------------------------------------------------------------------------------------------

    function dwweeklyreportform() {
        $data = array();
        $data['message'] = "";
        $data['page_url'] = "datewise_weekly_report_form";
        $this->load->view('includes/template', $data);
    }

    function dwweeklyprintreport() {
        ob_start();

        $txtFromDate = trim($this->input->post('txtFromDate'));
        $txtToDate = trim($this->input->post('txtToDate'));

        $report = $this->dashboard_model->datewise_weekly_print_report($txtFromDate, $txtToDate);

        if ($report) {
            echo $report;
        }
    }

    //---------------------------------------------------------------------------------------------------------------------------------------------------

    function rfpendingacceptancereportform() {
        $data = array();
        $data['message'] = "";
        $data['page_url'] = "rf_pending_acceptance_report_form";
        $this->load->view('includes/template', $data);
    }

    function rfpendingacceptanceprintreport() {
        ob_start();

        $report = $this->dashboard_model->rf_pending_acceptance_print_report();

        if ($report) {
            echo $report;
        }
    }

    //---------------------------------------------------------------------------------------------------------------------------------------------------

    function psrpendingacceptancereportform() {
        $data = array();
        $data['message'] = "";
        $data['page_url'] = "psr_pending_acceptance_report_form";
        $this->load->view('includes/template', $data);
    }

    function psrpendingacceptanceprintreport() {
        ob_start();

        $report = $this->dashboard_model->psr_pending_acceptance_print_report();

        if ($report) {
            echo $report;
        }
    }

    //---------------------------------------------------------------------------------------------------------------------------------------------------

    function availablepropertiesreportform() {
        $data = array();
        $data['message'] = "";
        $data['page_url'] = "available_properties_report_form";
        $this->load->view('includes/template', $data);
    }

    function availablepropertiesprintreport() {
        ob_start();

        $report = $this->dashboard_model->available_properties_print_report();

        if ($report) {
            echo $report;
        }
    }

    //---------------------------------------------------------------------------------------------------------------------------------------------------

    function propertysearchreportform() {
        $data = array();
        $data['message'] = "";
        $data['page_url'] = "property_search_listing";
        $this->load->view('includes/template', $data);
    }

    function propertysearchprintreport() {
        ob_start();

        $StateId = trim($this->input->post('cmbState'));
        $CityId = trim($this->input->post('cmbCity'));
        $PropertyCategoryId = trim($this->input->post('cmbPropertyCategory'));
        $PropertyTypeId = trim($this->input->post('cmbPropertyType'));

        $report = $this->dashboard_model->property_search_print_report($StateId, $CityId, $PropertyCategoryId, $PropertyTypeId);

        if ($report) {
            echo $report;
        }
    }

    //---------------------------------------------------------------------------------------------------------------------------------------------------

    function checkMailer() {
        ob_start();

        $status = $this->dashboard_model->check_send_email();

        if ($status) {
            echo $status;
        }
    }

    //---------------------------------------------------------------------------------------------------------------------------------------------------


    function smtpmailer($to, $from, $from_name, $subject, $body) {

        $mail = new PHPMailer();
        $mail->IsSMTP();                                     // We are going to use SMTP
        $mail->SMTPAuth = true;                                 // Enabled SMTP authentication
        $mail->SMTPSecure = "ssl";                                // Prefix for secure protocol to connect to the server
        $mail->Host = "smtp.gmail.com";                 // Setting GMail as our SMTP server
        $mail->Port = 465;                                 // SMTP port to connect to GMail
        $mail->Username = "support@linkersindia.com";           // User email address
        $mail->Password = "manashids";                          // Password in GMail

        $mail->SetFrom('', 'Linkers India');     //Who is sending the email
        $mail->AddReplyTo("', 'Linkers India");  //Email address that receives the response
        $mail->AddAddress('', "Subject");

        $mail->Subject = 'Using PHPMailer';
        $mail->Body = 'Hi Iam using PHPMailer library to sent SMTP mail from localhost';

        if (!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
            exit;
        }

        echo 'Message has been sent';
    }

    function testfun() {
        $data = array();
        $data['message'] = "";
        //$data['query'] = $this->dashboard_model->get_all_escalation_master();
        $data['page_url'] = "testarray";
        $this->load->view('includes/template', $data);
    }

    function listing_property_master_datatable($client_id = 0) {

        $data['query'] = $this->dashboard_model->get_all_property_master_datatable($client_id, $aColumns, $sIndexColumn, $sTable, $sWhere, $_GET);
    }

    function testfunajax() {
        // DB table to use
        $table = 'datatables_demo';

// Table's primary key
        $primaryKey = 'id';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
        $columns = array(
            array('db' => 'first_name', 'dt' => 0),
            array('db' => 'last_name', 'dt' => 1),
            array('db' => 'position', 'dt' => 2),
            array('db' => 'office', 'dt' => 3),
            array(
                'db' => 'start_date',
                'dt' => 4,
                'formatter' => function( $d, $row ) {
                    return date('jS M y', strtotime($d));
                }
            ),
            array(
                'db' => 'salary',
                'dt' => 5,
                'formatter' => function( $d, $row ) {
                    return '$' . number_format($d);
                }
            )
        );

// SQL server connection information
        $sql_details = array(
            'user' => '',
            'pass' => '',
            'db' => '',
            'host' => ''
        );


        /*         * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
         * If you just want to use the basic configuration for DataTables with PHP
         * server-side, there is no need to edit below this line.
         */

        require( 'ssp.class.php' );

        echo json_encode(
                SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns)
        );
    }

}

// End of class Dashboard