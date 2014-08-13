<?php
class Speaker extends CI_Controller {

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
		
		#get users (attendees) for event
		$data = array(
			'EventID'	=> $EventID
		);
		$event = $this->ConferenceApp_model->getEvent($data);
		
		#get event sessions
		$sessions = $this->ConferenceApp_model->getSessions($data);
		
		#get speaker ids for sessions
		$SessionIDs = array();
		foreach($sessions AS $session){
			$SessionIDs[] = $session['SessionID'];
		}
		if(count($SessionIDs) != 0){
			$sessionspeakers = $this->ConferenceApp_model->getEventSpeakers($SessionIDs);
		}
		
		#get speakers
		if(isset($sessionspeakers)){
			$SpeakerIDs = array();
			foreach($sessionspeakers AS $sessionspeaker){
				$SpeakerIDs[] = $sessionspeaker['SpeakerID'];
			}
			if(count($SpeakerIDs) != 0){
				$data['speakers'] = $this->ConferenceApp_model->getSpeakers($SpeakerIDs);
			}
		}
		
		$data['title'] = $event['EventName'];
		$data['content'] = 'speaker/listing';
		
		$this->load->view('templates/header', $data);
		$this->load->view('templates/event-offcanvas', $data);
		$this->load->view('templates/footer', $data);
	}
	
	/* Helper functions, and procedures
	================================================== */
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