<?php

class ConferenceApp_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	
	/* tlkpdivision
	================================================== */
	public function getAuthorCompanyDivisions()
	{
		$query = $this->db->order_by('DivisionName', 'ASC')->get_where('tlkpdivision','DivisionID > 0');
		return $query->result_array();
	}
	
	public function getDivision($data = array('DivisionID' => -1))
	{
		$query = $this->db->get_where('tlkpdivision', $data);
		return $query->row_array();
	}
	
	/* tlkpfile
	================================================== */
	public function getFiles($data = array(-1))
	{
		$query = $this->db->where_in('SessionID', $data)->get('tlkpfile');
		return $query->result_array();
	}
	
	public function getFile($data = array('FileID' => -1))
	{
		$query = $this->db->get_where('tlkpfile', $data);
		return $query->row_array();
	}
	
	/* tlkpsettings
	================================================== */
	public function getAppSettings()
	{
		$query = $this->db->get_where('tlkpsettings');
		return $query->result_array();
	}
	
	/* tmasevent
	================================================== */
	public function getAllEvents()
	{
		$query = $this->db->order_by('StartDate', 'DESC')->get_where('tmasevent','EventID > 0');
		return $query->result_array();
	}
	
	public function getEventsByPrivacy($data = array('Privacy' => 0))
	{
		$query = $this->db->order_by('StartDate', 'DESC')->get_where('tmasevent', $data);
		return $query->result_array();
	}
	
	public function getEvent($data = array('EventID' => -1))
	{
		$query = $this->db->get_where('tmasevent', $data);
		return $query->row_array();
	}
	
	
	/* tmassession
	================================================== */
	public function getSessions($data = array('EventID' => -1))
	{
		$query = $this->db->get_where('tmassession', $data);
		return $query->result_array();
	}
	
	public function getSession($data = array('SessionID' => -1))
	{
		$query = $this->db->get_where('tmassession', $data);
		return $query->row_array();
	}
	
	/* tmasspeaker
	================================================== */
	public function getSpeakers($data = array(-1))
	{
		$query = $this->db->where_in('SpeakerID', $data)->get('tmasspeaker');
		return $query->result_array();
	}
	
	/* tmasuser
	================================================== */
	public function getUser($data = array('UserID' => -1))
	{
		$query = $this->db->get_where('tmasuser', $data);
		return $query->row_array();
	}
	
	public function getUsers($data = array(-1))
	{
		$query = $this->db->where_in('UserID', $data)->get('tmasuser');
		return $query->result_array();
	}
	
	public function getUserSignin($data = array('Email' => "",'Password' => ""))
	{
		$query = $this->db->get_where('tmasuser', $data);
		return $query->row_array();
	}
	
	public function updateUserField($UserID = -1, $data = array('Field' => ""))
	{
		$this->db->where('UserID', $UserID);
		$this->db->update('tmasuser', $data); 
	}
	
	
	/* trelsessionspeaker
	================================================== */
	public function getEventSpeakers($data = array(-1))
	{
		$query = $this->db->where_in('SessionID', $data)->get('trelsessionspeaker');
		return $query->result_array();
	}
	
	public function getSessionSpeakers($data = array('SessionID' => -1))
	{
		$query = $this->db->get_where('trelsessionspeaker', $data);
		return $query->result_array();
	}
	
	/* treluserevent
	================================================== */
	public function getEventUsers($data = array('EventID' => -1))
	{
		$query = $this->db->get_where('treluserevent', $data);
		return $query->result_array();
	}
	
	public function getUserEvent($data = array('UserID' => -1,'EventID' => -1))
	{
		$query = $this->db->get_where('treluserevent', $data);
		return $query->row_array();
	}
	
	
	/* trelusersession
	================================================== */
	public function getUserSessions($data = array('UserID' => -1))
	{
		$query = $this->db->get_where('trelusersession', $data);
		return $query->result_array();
	}
	
	public function insertUserSession($data = array('UserID' => -1, 'SessionID' => -1))
	{
		if(($data['UserID'] == -1)||($data['SessionID'] == -1)){
			return false; #insert failed
		}else{
			$this->db->insert('trelusersession', $data);
			return true; #insert successful
		}
	}
	
	public function deleteUserSession($data = array('UserID' => -1, 'SessionID' => -1))
	{
		if(($data['UserID'] == -1)||($data['SessionID'] == -1)){
			return false; #delete failed
		}else{
			$this->db->delete('trelusersession', $data);
			return true; #delete successful
		}
	}
	
	/* ttrnalert
	================================================== */
	public function getAlerts($data = array('EventID' => -1))
	{
		$query = $this->db->order_by('Timestamp', 'DESC')->get_where('ttrnalert', $data);
		return $query->result_array();
	}
	
	/* ttrncomment
	================================================== */
	public function getComments($data = array(-1))
	{
		$query = $this->db->order_by('Timestamp', 'ASC')->where_in('PostID', $data)->get('ttrncomment');
		return $query->result_array();
	}
	
	public function getPostComments($data = array('PostID' => -1))
	{
		$query = $this->db->order_by('Timestamp', 'ASC')->get_where('ttrncomment', $data);
		return $query->result_array();
	}
	
	public function insertComment($data = array('UserID' => -1, 'PostID' => -1))
	{
		if(($data['UserID'] == -1)||($data['PostID'] == -1)){
			return false; #insert failed
		}else{
			$this->db->insert('ttrncomment', $data);
			return true; #insert successful
		}
	}
	
	/* ttrnpost
	================================================== */
	public function getPosts($data = array('EventID' => -1, 'To' => -2))
	{
		# = -1: private ("note")
		# =  0: public
		# >  0: to a specific session
		$query = $this->db->order_by('Timestamp', 'DESC')->get_where('ttrnpost', $data);
		return $query->result_array();
	}
	
	public function insertPost($data = array('UserID' => -1, 'EventID' => -1))
	{
		if(($data['UserID'] == -1)||($data['EventID'] == -1)){
			return false; #insert failed
		}else{
			$this->db->insert('ttrnpost', $data);
			return true; #insert successful
		}
	}
}

?>