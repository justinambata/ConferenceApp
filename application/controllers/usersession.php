<?php
class Usersession extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('ConferenceApp_model');
		$this->load->helper('form');
		$this->load->library('session');
	}
	
	public function update($SessionID = -1, $RedirectPage = '')
	{
		$User = $this->session->userdata('User');
		$CurrentEventID = $this->session->userdata('CurrentEventID');
		$SessionID = $this->input->post('SessionID');
		$RedirectPage = $this->input->post('RedirectPage');
		
		$this->IsUserSignedIn($User);
		$this->IsEventSelected($EventID);
		$this->IsSessionSelected($SessionID, $CurrentEventID);
		$this->DoesUserHaveAccess($User, $CurrentEventID);
		
		#Update usersession (My Schedule)
		$data = array(
			'UserID'	=> $User['UserID'],
			'SessionID'	=> $SessionID
		);
		if ( array_key_exists('submitInclude', $_POST) ){
			$bool = $this->ConferenceApp_model->insertUserSession($data);
			if($bool){
				$AlertStatus = "success";
				$AlertMessage = "Session successfully included in your schedule.";
			}else{
				$AlertStatus = "danger";
				$AlertMessage = "Failed to include session in your schedule.";
			}
			$this->setAlertStatusAndMessage($AlertStatus, $AlertMessage);
		}else if ( array_key_exists('submitRemove', $_POST) ){
			$bool = $this->ConferenceApp_model->deleteUserSession($data);
			if($bool){
				$AlertStatus = "warning";
				$AlertMessage = "Session successfully removed from your schedule.";
			}else{
				$AlertStatus = "danger";
				$AlertMessage = "Failed to remove session from your schedule.";
			}
			$this->setAlertStatusAndMessage($AlertStatus, $AlertMessage);
		}
		//redirect($RedirectPage.$CurrentEventID, 'location');
		redirect($RedirectPage, 'location');
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
		
		$condition = array(
			'UserID'	=> $User['UserID']
		);
		$data['usersessions'] = $this->ConferenceApp_model->getUserSessions($condition);
		$data['title'] = $event['EventName'];
		$data['content'] = 'usersession/listing';
		
		$this->load->view('templates/header', $data);
		$this->load->view('templates/event-offcanvas', $data);
		$this->load->view('templates/footer', $data);
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
	
	public function IsSessionSelected($SessionID = -1, $EventID = -1)
	{
		if($SessionID == -1){
			$AlertStatus = "danger";
			$AlertMessage = "Please select a valid session.";
			$this->setAlertStatusAndMessage($AlertStatus, $AlertMessage);
			redirect('/session/listing/'.$EventID, 'location');
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