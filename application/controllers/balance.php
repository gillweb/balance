<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Balance extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('ion_auth');

		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login');
		}

		$this->load->model('balance_model');
	}

	public function get_registery_sheets()
	{
		$data['reg_sheets'] = $this->balance_model->get_registery_sheets();
		print json_encode($data['reg_sheets']);
	}

	public function index()
	{
		$data['title'] = 'Balance';
		$jsfiles = array('balance.js', 'pickadate/picker.js', 'pickadate/picker.date.js'); //Loads additional js files into the footer template
    $cssfiles = array('pickadate/default.css', 'pickadate/default.date.css'); //Loads additional css files into the header template
    $data['css_to_load'] = $cssfiles;
    $data['js_to_load'] = $jsfiles;
		$this->load->view('templates/header', $data);
		$this->load->view('pages/balance/index', $data);
		$this->load->view('templates/footer', $data);
	}

	public function charts()
	{
		$data['title'] = 'Balance Data';
		$jsfiles = array('charts.js', 'Chart.min.js'); 
		$data['js_to_load'] = $jsfiles;
		$this->load->view('templates/header', $data);
		$this->load->view('pages/balance/charts', $data);
		$this->load->view('templates/footer', $data);
	}

	public function get_balance_json()
	{
		$data['balance'] = $this->balance_model->get_balance();
		print json_encode($data['balance']);
	}

	public function get_balance_by_date($start_date, $end_date)
	{
		$data['balance'] = $this->balance_model->get_balance_by_date($start_date, $end_date);
		print json_encode($data['balance']);
	}

	public function set_item()
	{
		$data['id'] = $this->input->post('id');
		$data['amount'] = $this->input->post('amount');
		$data['type'] = $this->input->post('type');
		$data['description'] = $this->input->post('description');
		$data['note'] = $this->input->post('note');
		$data['category'] = $this->input->post('category');
		$data['datetime'] = $this->input->post('datetime');
		$data['update'] = $this->input->post('update');

		if ($data['update'] == "false" || empty($data['update']) ) {
			$return = $this->balance_model->set_item($data);
		} else {
			$return = $this->balance_model->update_item($data);
		}

		print json_encode($return);
	}

	public function delete_item()
	{
		$data['id'] = $this->input->post('id');
		$this->balance_model->delete_item($data);
	}
}

/* End of file balance.php */
/* Location: ./application/controllers/balance.php */
