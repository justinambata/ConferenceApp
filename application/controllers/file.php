<?php
class File extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('ConferenceApp_model');
		$this->load->helper('form');
		$this->load->helper('download');
		$this->load->library('session');
	}
	
	public function listing($EventID = -1)
	{
		$User = $this->session->userdata('User');
		
		$this->IsUserSignedIn($User);
		$this->IsEventSelected($EventID);
		$this->DoesUserHaveAccess($User, $EventID);
		
		$condition = array(
			'EventID'	=> $EventID
		);
		$event = $this->ConferenceApp_model->getEvent($condition);
		
		#get sessions (schedule) for event
		$data['sessions'] = $this->ConferenceApp_model->getSessions($condition);
		
		$SessionIDs = array();
		foreach($data['sessions'] AS $session){
			$SessionIDs[] = $session['SessionID'];
		}
		if(count($SessionIDs) != 0){
			$data['files'] = $this->ConferenceApp_model->getFiles($SessionIDs);
		}
		
		$data['title'] = $event['EventName'];
		$data['content'] = 'file/listing';
		
		$this->load->view('templates/header', $data);
		$this->load->view('templates/event-offcanvas', $data);
		$this->load->view('templates/footer', $data);
	}
	
	public function download($FileID = -1)
	{
		$User = $this->session->userdata('User');
		$CurrentEventID = $this->session->userdata('CurrentEventID');
		$FileID = $this->input->post('FileID');
		
		$this->IsUserSignedIn($User);
		$this->IsEventSelected($CurrentEventID);
		$this->IsFileSelected($FileID,$CurrentEventID);
		$this->DoesUserHaveAccess($User, $CurrentEventID);
		
		$condition = array(
			'FileID'	=> $FileID
		);
		$file = $this->ConferenceApp_model->getFile($condition);
		
		$name = $file['Filename'];
		$data = file_get_contents("files/".$CurrentEventID."/".$name); // Read the file's contents
		force_download($name, $data);
		
		//redirect($RedirectPage, 'location');
	}
	
	/* Helper functions, and procedures
	================================================== */
	public function setAlertStatusAndMessage($status, $message)
	{
		$this->session->set_flashdata('AlertStatus', $status);
		$this->session->set_flashdata('AlertMessage', $message);
	}
	
	public function IsUserSignedIn($User = false)
	{
		if($User == false){
			$AlertStatus = "danger";
			$AlertMessage = "To access this page, please sign in.";
			$this->setAlertStatusAndMessage($AlertStatus, $AlertMessage);
			redirect('/event/listing', 'location');
		}
	}
	
	public function IsEventSelected($EventID = -1)
	{
		if($EventID == -1){
			$AlertStatus = "danger";
			$AlertMessage = "Please select a valid event.";
			$this->setAlertStatusAndMessage($AlertStatus, $AlertMessage);
			redirect('/event/listing', 'location');
		}
	}
	
	public function IsFileSelected($FileID = -1, $EventID = -1)
	{
		if($FileID == -1){
			$AlertStatus = "danger";
			$AlertMessage = "Please select a valid file.";
			$this->setAlertStatusAndMessage($AlertStatus, $AlertMessage);
			redirect('/file/listing/'.$EventID, 'location');
		}
	}
	
	public function DoesUserHaveAccess($User = false, $EventID = -1)
	{
		#check if user has access in the selected event
		$data = array(
			'UserID'	=> $User['UserID'],
			'EventID'	=> $EventID
		);
		$data['userevent'] = $this->ConferenceApp_model->getUserEvent($data);
		if($data['userevent']){
			if($data['userevent']['WithAccess'] == true){
				#do nothing
			}else{
				$AlertStatus = "danger";
				$AlertMessage = "You do not have the necessary privileges to access this event. If you wish to request access to this event, please contact us.";
				$this->setAlertStatusAndMessage($AlertStatus, $AlertMessage);
				redirect('/event/listing', 'location');
			}
		}else{
			$AlertStatus = "danger";
			$AlertMessage = "You do not have the necessary privileges to access this event. If you wish to request access to this event, please contact us.";
			$this->setAlertStatusAndMessage($AlertStatus, $AlertMessage);
			redirect('/event/listing', 'location');
		}
	}
}
?>