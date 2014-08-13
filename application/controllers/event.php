<?php
class Event extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('ConferenceApp_model');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('session');
	}

	public function listing()
	{
		$Settings = $this->ConferenceApp_model->getAppSettings();
		$this->session->set_userdata('Settings', $Settings);
		
		#determining the app privacy
		$Privacy = 0;
		foreach($Settings AS $setting){
			if($setting['Property'] == "Privacy"){
				$Privacy = $setting['Value'];
			}
		}
		
		#reset the CurrentEventID
		$CurrentEventID = $this->session->userdata('CurrentEventID');
		if($CurrentEventID){
			$this->session->unset_userdata('CurrentEventID');
		}
		
		$data['events'] = $this->ConferenceApp_model->getEventsByPrivacy(array('Privacy' => $Privacy));
		$data['title'] = 'Event Listing';
		
		$this->load->view('templates/header', $data);
		$this->load->view('event/listing', $data);
		$this->load->view('templates/footer', $data);
	}
	
	public function view($EventID = -1)
	{
		$User = $this->session->userdata('User');
		
		$this->IsUserSignedIn($User);
		$this->IsEventSelected($EventID);
		$this->DoesUserHaveAccess($User, $EventID);
		
		#get event details
		$condition = array(
			'EventID'	=> $EventID
		);
		$data['event'] = $this->ConferenceApp_model->getEvent($condition);
		#get posts for the event
		$data['posts'] = $this->ConferenceApp_model->getPosts($condition);
		
		if($data['posts']){
			#get comments for the post ids
			$PostIDs = array();
			foreach($data['posts'] AS $post){
				$PostIDs[] = $post['PostID'];
			}
			$data['comments'] = $this->ConferenceApp_model->getComments($PostIDs);
			
			#get attendees
			$usersevent = $this->ConferenceApp_model->getEventUsers($condition);
			$UserIDs = array();
			foreach($usersevent AS $userevent){
				$UserIDs[] = $userevent['UserID'];
			}
			$data['attendees'] = $this->ConferenceApp_model->getUsers($UserIDs);
			
			#prepend attendee data in posts
			foreach($data['posts'] AS &$post){
				foreach($data['attendees'] AS $attendee){
					if($post['UserID'] == $attendee['UserID']){
						$post['UserName'] = $attendee['FirstName']." ".$attendee['LastName'];
						$post['UserImage'] = $attendee['Image'];
					}
				}
			}
			
			#prepend attendee data in comments
			foreach($data['comments'] AS &$comment){
				foreach($data['attendees'] AS $attendee){
					if($comment['UserID'] == $attendee['UserID']){
						$comment['UserName'] = $attendee['FirstName']." ".$attendee['LastName'];
						$comment['UserImage'] = $attendee['Image'];
					}
				}
			}
		}
		
		#determine the active session
		if($data['event']['SessionID_Active'] > 0){
			$condition = array(
				'SessionID'	=> $data['event']['SessionID_Active']
			);
			$data['session'] = $this->ConferenceApp_model->getSession($condition);
		}
		
		$data['title'] = $data['event']['EventName'];
		$data['content'] = 'event/view';
		
		$this->session->set_userdata('CurrentEventID', $data['event']['EventID']);
		
		$this->load->view('templates/header', $data);
		$this->load->view('templates/event-offcanvas', $data);
		//$this->load->view('event/view', $data);
		$this->load->view('templates/footer', $data);
	}
	
	public function about($EventID = -1)
	{
		$User = $this->session->userdata('User');
		
		$this->IsUserSignedIn($User);
		$this->IsEventSelected($EventID);
		$this->DoesUserHaveAccess($User, $EventID);
		
		#get event details
		$data = array(
			'EventID'	=> $EventID
		);
		$data['event'] = $this->ConferenceApp_model->getEvent($data);
		$data['title'] = $data['event']['EventName'];
		$data['content'] = 'event/about';
		
		$this->load->view('templates/header', $data);
		$this->load->view('templates/event-offcanvas', $data);
		$this->load->view('templates/footer', $data);
	}
	
	public function info($EventID = -1)
	{
		$User = $this->session->userdata('User');
		
		$this->IsUserSignedIn($User);
		$this->IsEventSelected($EventID);
		$this->DoesUserHaveAccess($User, $EventID);
		
		#get event details
		$data = array(
			'EventID'	=> $EventID
		);
		$event = $this->ConferenceApp_model->getEvent($data);
		$data['title'] = $event['EventName'];
		$data['content'] = 'event/info';
		
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