<?php
class User extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('ConferenceApp_model');
		$this->load->helper('form');
		$this->load->library('session');
	}
	
	public function signin()
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('Email', 'Email', 'required');
		$this->form_validation->set_rules('Password', 'Password', 'required');
		
		$settings = $this->ConferenceApp_model->getAppSettings();
		
		#determining the app privacy
		$Privacy = 0;
		foreach($settings AS $setting){
			if($setting['Property'] == "Privacy"){
				$Privacy = $setting['Value'];
			}
		}
		
		if ($this->form_validation->run() === FALSE)
		{
			$AlertStatus = "Sign in unsuccessful";
			$AlertMessage = ($Privacy == 0) ? "Default password is your UNILAB employee ID. If you're still unable to login the system, please contact us." : "Please check your confimation email for your login credentials.";
			$this->setAlertStatusAndMessage($AlertStatus, $AlertMessage);
			redirect('/event/listing', 'refresh');
		}
		else
		{
			$data = array(
				'Email' => $this->input->post('Email'),
				'Password' => $this->input->post('Password')
			);
			$user = $this->ConferenceApp_model->getUserSignin($data);
			if(!($user)){
				$AlertStatus = "Sign in unsuccessful";
				$AlertMessage = ($Privacy == 0) ? "Default password is your UNILAB employee ID. If you're still unable to login the system, please contact us." : "Please check your confimation email for your login credentials.";
				$this->setAlertStatusAndMessage($AlertStatus, $AlertMessage);
			}else{
				$AlertStatus = "success";
				$AlertMessage = "Welcome, ".$user['FirstName']." ".$user['LastName']."!";
				$this->setAlertStatusAndMessage($AlertStatus, $AlertMessage);
				$this->session->set_userdata('User', $user);
			}
			redirect('/event/listing', 'location');
		}
	}
	
	public function signout()
	{
		$AlertStatus = "Sign out successful";
		$AlertMessage = "You have been signed out of the system.";
		$this->setAlertStatusAndMessage($AlertStatus, $AlertMessage);
		
		$this->load->helper('form');
		$this->session->unset_userdata('User');
		$this->session->unset_userdata('Settings');
		$this->session->unset_userdata('CurrentEventID');
		$this->session->sess_destroy();
		redirect('/event/listing', 'location');
	}
	
	public function view($UserID = -1)
	{
		$CurrentEventID = $this->session->userdata('CurrentEventID');
		
		if($UserID == -1){
			$AlertStatus = "danger";
			$AlertMessage = "To access this page, please sign in.";
			$this->setAlertStatusAndMessage($AlertStatus, $AlertMessage);
			redirect('/event/listing', 'location');
		}
		$condition = array(
			'UserID' => $UserID
		);
		$data['user'] = $this->ConferenceApp_model->getUser($condition);
		
		
		if($CurrentEventID){
			$condition = array(
				'EventID' => $CurrentEventID
			);
			$event = $this->ConferenceApp_model->getEvent($condition);
			$data['title'] = $event['EventName'];
			$data['content'] = 'user/view';
			
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
				$attendees = $this->ConferenceApp_model->getUsers($UserIDs);
				
				#prepend attendee data in posts
				foreach($data['posts'] AS &$post){
					foreach($attendees AS $attendee){
						if($post['UserID'] == $attendee['UserID']){
							$post['UserName'] = $attendee['FirstName']." ".$attendee['LastName'];
							$post['UserImage'] = $attendee['Image'];
						}
					}
				}
				
				#prepend attendee data in comments
				foreach($data['comments'] AS &$comment){
					foreach($attendees AS $attendee){
						if($comment['UserID'] == $attendee['UserID']){
							$comment['UserName'] = $attendee['FirstName']." ".$attendee['LastName'];
							$comment['UserImage'] = $attendee['Image'];
						}
					}
				}
			}
			
			$this->load->view('templates/header', $data);
			$this->load->view('templates/event-offcanvas', $data);
			$this->load->view('templates/footer', $data);
		}else{
			$Settings = $this->session->userdata('Settings');
			
			$AppName = "";
			foreach($Settings as $setting){
				if($setting['Property'] == "AppName"){
					$AppName = $setting['Value'];
				}
			}
			
			$data['title'] = $AppName;
			$this->load->view('templates/header', $data);
			$this->load->view('user/view', $data);
			$this->load->view('templates/footer', $data);
		}
	}
	
	public function details()
	{
		$User = $this->session->userdata('User');
		$CurrentEventID = $this->session->userdata('CurrentEventID');
		
		if($User['UserID'] == -1){
			$AlertStatus = "danger";
			$AlertMessage = "To access this page, please sign in.";
			$this->setAlertStatusAndMessage($AlertStatus, $AlertMessage);
			redirect('/event/listing', 'location');
		}
		
		if($CurrentEventID){
			$condition = array(
				'EventID' => $CurrentEventID
			);
			$event = $this->ConferenceApp_model->getEvent($condition);
			$data['title'] = $event['EventName'];
			$data['content'] = 'user/details';
			
			$this->load->view('templates/header', $data);
			$this->load->view('templates/event-offcanvas', $data);
			$this->load->view('templates/footer', $data);
		}else{
			$Settings = $this->session->userdata('Settings');
			
			$AppName = "";
			foreach($Settings as $setting){
				if($setting['Property'] == "AppName"){
					$AppName = $setting['Value'];
				}
			}
			
			$data['title'] = $AppName;
			$this->load->view('templates/header', $data);
			$this->load->view('user/details', $data);
			$this->load->view('templates/footer', $data);
		}
	}
	
	public function edit($Field)
	{
		$Settings = $this->session->userdata('Settings');
		$User = $this->session->userdata('User');
		
		if($User == false){
			$AlertStatus = "danger";
			$AlertMessage = "To access this page, please sign in.";
			$this->setAlertStatusAndMessage($AlertStatus, $AlertMessage);
			redirect('/event/listing', 'location');
		}
		
		$AuthorCompany = "";
		foreach($Settings as $setting){
			if($setting['Property'] == "AuthorCompany"){
				$AuthorCompany = $setting['Value'];
			}
		}
		
		if($Field == "Email"){
			$this->goToMyAccount();
		}else if(($User['Company'] == $AuthorCompany)&&($Field == "Company")){
			$this->goToMyAccount();
		}else if(($Field == "DivisionID")||($Field == "DivisionName")){
			$data['divisions'] = $this->ConferenceApp_model->getAuthorCompanyDivisions();
		}
		
		$data['title'] = "Update";
		$data['field'] = $Field;
		
		$this->load->view('templates/header', $data);
		$this->load->view('user/edit', $data);
		$this->load->view('templates/footer', $data);
	}
	
	public function update($Field)
	{
		if ( array_key_exists('submitCancel', $_POST) ){
			$this->goToMyAccount();
		}else if ( array_key_exists('submitOK', $_POST) ){
			$updated = false;
			$Settings = $this->session->userdata('Settings');
			$User = $this->session->userdata('User');
			
			$AuthorCompany = "";
			foreach($Settings as $setting){
				if($setting['Property'] == "AuthorCompany"){
					$AuthorCompany = $setting['Value'];
				}
			}
			
			#update here...
			if(($Field == "DivisionID")||($Field == "DivisionName")){
				if($User['Company'] == $AuthorCompany){
					#Update DivisionID
					$data = array(
						'DivisionID'	=> $this->input->post('field')
					);
					$this->ConferenceApp_model->updateUserField($User['UserID'],$data);
					#Update DivisionName
					$division = $this->ConferenceApp_model->getDivision($data);
					$data = array(
						'DivisionName'	=> $division['DivisionName']
					);
					$this->ConferenceApp_model->updateUserField($User['UserID'],$data);
					$updated = true;
				}else{
					#Update DivisionID
					$data = array(
						'DivisionID'	=> -1
					);
					$this->ConferenceApp_model->updateUserField($User['UserID'],$data);
					#Update DivisionName
					$data = array(
						$Field	=> $this->input->post('field')
					);
					$this->ConferenceApp_model->updateUserField($User['UserID'],$data);
					$updated = true;
				}
			}else if($Field == "Company"){
				$company = $this->input->post('field');
				
				if($company == $AuthorCompany){
					#do nothing
					$updated = false;
				}else{
					$data = array(
						$Field	=> $company
					);
					$this->ConferenceApp_model->updateUserField($User['UserID'],$data);
					$updated = true;
				}
			}else{
				$data = array(
					$Field	=> $this->input->post('field')
				);
				$this->ConferenceApp_model->updateUserField($User['UserID'],$data);
				$updated = true;
			}
			
			#update 'User' userdata
			$data = array(
				'UserID'	=> $User['UserID']
			);
			$User = $this->ConferenceApp_model->getUser($data);
			$this->session->unset_userdata('User');
			$this->session->set_userdata('User', $User);
			
			#set alert message
			if($updated){
				$AlertStatus = "success";
				$AlertMessage = $Field." successfully updated.";
			}else{
				$AlertStatus = "danger";
				$AlertMessage = "Failed to update ".$Field.".";
			}
			$this->setAlertStatusAndMessage($AlertStatus, $AlertMessage);
			
			#redirect to my account
			$this->goToMyAccount();
		}
	}
	
	public function listing($EventID = -1)
	{
		$User = $this->session->userdata('User');
		
		$this->IsUserSignedIn($User);
		$this->IsEventSelected($EventID);
		$this->DoesUserHaveAccess($User, $EventID);
		
		#get users (attendees) for event
		$condition = array(
			'EventID'	=> $EventID
		);
		$event = $this->ConferenceApp_model->getEvent($condition);
		$usersevent = $this->ConferenceApp_model->getEventUsers($condition);
		
		$UserIDs = array();
		foreach($usersevent AS $userevent){
			$UserIDs[] = $userevent['UserID'];
		}
		
		$data['attendees'] = $this->ConferenceApp_model->getUsers($UserIDs);
		$data['title'] = $event['EventName'];
		$data['content'] = 'user/listing';
		
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
	
	public function goToMyAccount()
	{
		$User = $this->session->userdata('User');
		redirect('/user/details', 'location');
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