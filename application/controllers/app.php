<?php
class App extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('ConferenceApp_model');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('session');
	}
	
	public function help()
	{
		$data['title'] = 'Help';
		
		$this->load->view('templates/header', $data);
		$this->load->view('app/help', $data);
		$this->load->view('templates/footer', $data);
	}

	public function about()
	{
		$settings = $this->ConferenceApp_model->getAppSettings();
		$this->session->set_userdata('Settings', $settings);
		
		$data['title'] = 'About';
		
		$this->load->view('templates/header', $data);
		$this->load->view('app/about', $data);
		$this->load->view('templates/footer', $data);
	}

	public function contactus()
	{
		$data['title'] = 'Contact Us';
		
		$this->load->view('templates/header', $data);
		$this->load->view('app/contactus', $data);
		$this->load->view('templates/footer', $data);
	}
}
?>