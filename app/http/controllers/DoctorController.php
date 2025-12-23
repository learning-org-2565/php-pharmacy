<?php

/**
* Doctor Controller
*/
class DoctorController extends Controller
{
	/**
	* Doctor index method
	* This method will be called on doctor list view
	**/
	public function index()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		/**
		* Get all Doctor data from Db using Doctor Model method 
		**/
		$this->load->model('doctor');

		$data['result'] = $this->model_doctor->getDoctors();

		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}

		$data['page_title'] = 'Doctors';
		$data['page_add'] = $this->user_agent->hasPermission('doctor/add') ? true : false;
		$data['page_edit'] = $this->user_agent->hasPermission('doctor/edit') ? true : false;
		$data['page_delete'] = $this->user_agent->hasPermission('doctor/delete') ? true : false;

		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action_delete'] = URL.DIR_ROUTE.'doctor/delete';

		/*Render Doctor list view*/
		$this->response->setOutput($this->load->view('doctor/doctor_list', $data));
	}
	/**
	* Doctor index add method
	* This method will be called on Department add
	**/
	public function indexAdd()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		/* Set page title */
		$data['page_title'] = 'Add Doctor';
		/* Set empty data to array */
		$data['result'] =  NULL;
		/* Set department in array */
		$this->load->model('doctor');
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action'] = URL.DIR_ROUTE.'doctor/add';
		/*Render Doctor add view*/
		$this->response->setOutput($this->load->view('doctor/doctor_form', $data));
	}
	/**
	* Doctor index edit method
	* This method will be called on doctor edit view
	**/
	public function indexEdit()
	{
		/**
		* Check if id exist in url if not exist then redirect to Doctor list view 
		**/
		$id = (int)$this->url->get('id');
		if (empty($id) || !is_int($id)) {
			$this->url->redirect('doctors');
		}
		/**
		* Call getDoctor method from Blog model to get data from DB for single doctor
		* If Doctor does not exist then redirect it to doctor list view
		**/
		$this->load->model('doctor');
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);

		if ($data['common']['user']['role_id'] == '3' && $data['common']['user']['doctor'] != $id) {
			$data['result'] = NULL;
		} else {
			$data['result'] = $this->model_doctor->getDoctor($id);
		}
		
		if (empty($data['result'])) {
			$this->session->data['message'] = array('alert' => 'warning', 'value' => 'Doctor does not exist in database!');
			$this->url->redirect('doctors');
		}

		/* Set Doctor edit view page title in array */
		$data['page_title'] = 'Edit Doctor';
		$data['result']['address'] = json_decode($data['result']['address'], true);
		
		
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}

		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action'] = URL.DIR_ROUTE.'doctor/edit';
		/*Render Doctor edit view*/
		$this->response->setOutput($this->load->view('doctor/doctor_form', $data));
	}
	/**
	* Info index action method
	* This method will be called on Info submit/save view
	**/
	public function indexAction()
	{
		$data = $this->url->post;
		
		$this->load->controller('common');
		$this->load->model('commons');
		$data['info'] = $this->model_commons->getSiteInfo();

		if ($validate_field = $this->validateField($data)) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Please enter/select valid '.implode(", ",$validate_field).'!');
			if (!empty($data['doctor']['id'])) {
				$this->url->redirect('doctor/edit&id='.$data['doctor']['id']);
			} else {
				$this->url->redirect('doctor/add');
			}
		}

		if (!empty($data['doctor']['dob'])) {
			$data['doctor']['dob'] = DateTime::createFromFormat($data['info']['date_format'], $data['doctor']['dob'])->format('Y-m-d');
		} else {
			$data['doctor']['dob'] = '';
		}

		$this->load->model('doctor');
		
		$data['doctor']['address'] = json_encode($data['doctor']['address']);
		$data['doctor']['user_id'] = $this->session->data['user_id'];
		$data['doctor']['datetime'] = date('Y-m-d H:i:s');
		
		if (!empty($data['doctor']['id'])) {
			$this->model_doctor->updateDoctor($data['doctor']);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Doctor updated successfully.');
		} else {
			$data['doctor']['id'] = $this->model_doctor->createDoctor($data['doctor']);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Doctor created successfully.');	
		}
		$this->url->redirect('doctor/edit&id='.$data['doctor']['id']);
	}

	public function indexDelete()
	{
		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['delete']) || empty($this->url->post('id')) ) {
			$this->url->redirect('doctors');
		}

		$this->load->model('doctor');
		$this->model_doctor->deleteDoctor($this->url->post('id'));
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Doctor deleted successfully.');
		$this->url->redirect('doctors');
	}

	public function searchDoctor()
	{
		$data = $this->url->get;
		$this->load->model('doctor');
		$result = $this->model_doctor->getSearchedDoctor($data['term']);
		echo json_encode($result);
	}

	protected function validateField($data)
	{
		$error = [];
		$error_flag = false;
		if ( $this->controller_common->validateText($data['doctor']['firstname'])) {
			$error_flag = true;
			$error['fname'] = 'Please enter valid first name!';
		}

		if ( $this->controller_common->validateText($data['doctor']['lastname'])) {
			$error_flag = true;
			$error['fname'] = 'Please enter valid last name!';
		}

		if ($this->controller_common->validateEmail($data['doctor']['mail'])) {
			$error_flag = true;
			$error['email'] = 'Please enter valid email address!';
		}

		if ($this->controller_common->validatePhoneNumber($data['doctor']['mobile'])) {
			$error_flag = true;
			$error['mobile'] = 'Please enter valid Mobile Number!';
		}

		if (!empty($data['doctor']['dob'])) {
			if ($this->controller_common->validateDate( $data['doctor']['dob'], $data['info']['date_format'] )) {
				$error_flag = true;
				$error['date'] = 'Date of Birth';
			}
		}
		
		if ($error_flag) {
			return $error;
		} else {
			return false;
		}
	}
}