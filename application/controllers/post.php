<?php
class Post extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('ConferenceApp_model');
		$this->load->helper('form');
		$this->load->library('session');
	}
	
	public function write()
	{
		$User = $this->session->userdata('User');
		$CurrentEventID = $this->session->userdata('CurrentEventID');
		
		$this->IsUserSignedIn($User);
		$this->IsEventSelected($CurrentEventID);
		$this->DoesUserHaveAccess($User, $CurrentEventID);
		
		$Text = $this->input->post('Text');
		$To = $this->input->post('To');
		$RedirectPage = $this->input->post('RedirectPage');
		
		$bool = false;
		if(strlen(trim($Text))==0){
		}else{
			#check if $to is in the list of sessions for event
			
			date_default_timezone_set('Asia/Manila');
			$data = array(
				'UserID'			=> $User['UserID'],
				'EventID'			=> $CurrentEventID,
				'To'				=> $To,
				'Text'				=> $Text,
				'Timestamp'			=> date('Y-m-d H:i:s', time()),
				'DisplayToSpeaker'	=> false
			);
			$bool = $this->ConferenceApp_model->insertPost($data);
			print_r($data);
		}
		
		if($bool){
			$status = "success";
			$message = "Post successfully published.";
			$this->setAlertStatusAndMessage($status, $message);
			redirect($RedirectPage, 'location');
		}else{
			$status = "danger";
			$message = "Unable to publish your post.";
			$this->setAlertStatusAndMessage($status, $message);
			redirect($RedirectPage, 'location');
		}
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