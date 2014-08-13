<?php
class Session extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('ConferenceApp_model');
		$this->load->helper('form');
		$this->load->library('session');
	}
	
	public function listing($EventID = -1)
	{
		$User = $this->session->userdata('User');
		
		$this->IsUserSignedIn($User);
		$this->IsEventSelected($EventID);
		$this->DoesUserHaveAccess($User, $EventID);
		
		#get sessions (schedule) for event
		$data = array(
			'EventID'	=> $EventID
		);
		$event = $this->ConferenceApp_model->getEvent($data);
		$data['sessions'] = $this->ConferenceApp_model->getSessions($data);
		$data['usersessions'] = $this->ConferenceApp_model->getUserSessions(array( 'UserID'	=> $User['UserID'] ));
		$data['title'] = $event['EventName'];
		$data['content'] = 'session/listing';
		
		$this->load->view('templates/header', $data);
		$this->load->view('templates/event-offcanvas', $data);
		$this->load->view('templates/footer', $data);
	}
	
	public function view($SessionID = -1)
	{
		$User = $this->session->userdata('User');
		$CurrentEventID = $this->session->userdata('CurrentEventID');
		
		$this->IsUserSignedIn($User);
		$this->IsEventSelected($CurrentEventID);
		$this->IsSessionSelected($SessionID, $CurrentEventID);
		$this->DoesUserHaveAccess($User, $CurrentEventID);
		
		#get event details
		$condition = array(
			'EventID'	=> $CurrentEventID
		);
		$event = $this->ConferenceApp_model->getEvent($condition);
		
		#get session details
		$condition = array(
			'SessionID'	=> $SessionID
		);
		$data['session'] = $this->ConferenceApp_model->getSession($condition);
		
		#get speaker ids of the speakers of the session
		$sessionspeakers = $this->ConferenceApp_model->getSessionSpeakers($condition);
		
		#get speakers
		$SpeakerIDs = array();
		foreach($sessionspeakers AS $sessionspeaker){
			$SpeakerIDs[] = $sessionspeaker['SpeakerID'];
		}
		if(count($SpeakerIDs) != 0){
			$data['speakers'] = $this->ConferenceApp_model->getSpeakers($SpeakerIDs);
		}
		
		#get user's sessions ("My Schedule")
		$condition = array(
			'UserID'	=> $User['UserID']
		);
		$data['usersessions'] = $this->ConferenceApp_model->getUserSessions($condition);
		
		$data['title'] = $event['EventName'];
		$data['content'] = 'session/view';
		
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