<?php

/**
 * CustomerController.php
 */
class CustomerController extends Controller
{
	/**
	* Customer index method
	* This method will be called on @PatientList view
	**/
	public function index()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);

		/**
		* Get all Customer data from DB using User model 
		**/
		$this->load->controller('common');
		$data['period']['start'] = $this->url->get('start');
		$data['period']['end'] = $this->url->get('end');

		if (!empty($data['period']['start']) && !empty($data['period']['end']) && !$this->controller_common->validateDate($data['period']['start']) && !$this->controller_common->validateDate($data['period']['end'])) {
			$data['period']['start'] = date_format(date_create($data['period']['start'].'00:00:00'), "Y-m-d H:i:s");
			$data['period']['end'] = date_format(date_create($data['period']['end'].'23:59:59'), "Y-m-d H:i:s");
		} else {
			$data['period']['start'] = date('Y-m-d '.'00:00:00', strtotime("-1 month"));
			$data['period']['end'] = date('Y-m-d '.'23:59:59');
		}

		$this->load->model('customer');
		$data['result'] = $this->model_customer->getCustomers($data['period']);

		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}

		/* Set page title */
		$data['page_title'] = 'Customers';
		$data['page_view'] = $this->user_agent->hasPermission('customer/view') ? true : false;
		$data['page_add'] = $this->user_agent->hasPermission('customer/add') ? true : false;
		$data['page_edit'] = $this->user_agent->hasPermission('customer/edit') ? true : false;
		$data['page_delete'] = $this->user_agent->hasPermission('customer/delete') ? true : false;

		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action_delete'] = URL.DIR_ROUTE.'customer/delete';

		/*Render User list view*/
		$this->response->setOutput($this->load->view('customer/customer_list', $data));
	}

	public function indexView()
	{
		$id = (int)$this->url->get('id');
		if (empty($id) || !is_int($id)) { $this->url->redirect('customers'); }

		$this->load->model('customer');
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);

		$data['result'] = $this->model_customer->getCustomer($id);
		if (empty($data['result'])) {
			$this->session->data['message'] = array('alert' => 'warning', 'value' => 'Customer does not exist in database!');
			$this->url->redirect('customers');
		}		
		$data['result']['address'] = json_decode($data['result']['address'], true);
		$data['invoices'] = $this->model_customer->getInvoices($data['result']);
		$data['bills'] = $this->model_customer->getBills($data['result']);

		$data['page_title'] = 'Customer View';
		$data['page_edit'] = $this->user_agent->hasPermission('customer/edit') ? true : false;
		$data['page_bills'] = $this->user_agent->hasPermission('medicine/billing') ? true : false;
		$data['bill_view'] = $this->user_agent->hasPermission('medicine/billing/view') ? true : false;
		$data['page_invoices'] = $this->user_agent->hasPermission('invoices') ? true : false;
		$data['invoice_view'] = $this->user_agent->hasPermission('invoice/view') ? true : false;
		$data['invoice_add'] = $this->user_agent->hasPermission('invoice/add') ? true : false;
		$data['invoice_delete'] = $this->user_agent->hasPermission('invoice/delete') ? true : false;
		$data['page_sendmail'] = $this->user_agent->hasPermission('customer/sendmail') ? true : false;

				
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}

		$data['action'] = URL.DIR_ROUTE.'customer/add';

		/*Render User add view*/
		$this->response->setOutput($this->load->view('customer/customer_view', $data));
	}

	public function indexAdd()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);

		$data['result'] = NULL;
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}

		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		
		$data['page_title'] = 'Add Customer';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action'] = URL.DIR_ROUTE.'customer/add';
		/*Render User add view*/
		$this->response->setOutput($this->load->view('customer/customer_form', $data));
	}

	public function indexEdit()
	{
		$id = (int)$this->url->get('id');
		if (empty($id) || !is_int($id)) { $this->url->redirect('customers'); }

		$this->load->model('customer');
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);

		$data['result'] = $this->model_customer->getCustomer($id);

		if (empty($data['result'])) {
			$this->session->data['message'] = array('alert' => 'warning', 'value' => 'Customer does not exist in database!');
			$this->url->redirect('customers');
		}

		
		$data['result']['address'] = json_decode($data['result']['address'], true);
		
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		$data['page_title'] = 'Edit Customer';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action'] = URL.DIR_ROUTE.'customer/edit&id='.$data['result']['id'];
		
		/*Render User add view*/
		$this->response->setOutput($this->load->view('customer/customer_form', $data));
	}

	public function indexAction()
	{
		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['submit'])) { $this->url->redirect('customers'); }

		$data = $this->url->post('customer');

		/**
		* Validate form data
		* If some data is missing or data does not match pattern
		* Return to info view 
		**/
		$this->load->model('commons');
		$data['info'] = $this->model_commons->getSiteInfo();

		$this->load->controller('common');
		if ($validate_field = $this->validateField($data)) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Please enter valid '.implode(", ",$validate_field).'!');
			if (!empty($data['id'])) {
				$this->url->redirect('customer/edit&id='.$data['id']);
			} else {
				$this->url->redirect('customer/add');
			}
		}

		$data['user'] = $this->model_commons->getUserInfo($this->session->data['user_id']);

		if (!empty($data['dob'])) {
			$data['dob'] = DateTime::createFromFormat($data['info']['date_format'], $data['dob'])->format('Y-m-d');
		} else {
			$data['dob'] = '';
		}
		
		$data['address'] = json_encode($data['address']);
		$data['user_id'] = $this->session->data['user_id'];
		$data['datetime'] = date('Y-m-d H:i:s');
		
		$this->load->model('customer');
		if (!empty($data['id'])) {
			if ($this->model_customer->checkCustomerEmail($data['mail'], $data['id']) >= 1) {
				$this->session->data['message'] = array('alert' => 'error', 'value' => 'Email  \'' . $this->url->post('email') . '\'  already exist in database.');
				$this->url->redirect('customer/edit&id='.$data['id']);
			}
			$result = $this->model_customer->updateCustomer($data);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Customer updated successfully.');
		} else {
			if ($this->model_customer->checkCustomerEmail($data['mail']) >= 1) {
				$this->session->data['message'] = array('alert' => 'error', 'value' => 'Email  \'' . $this->url->post('email') . '\'  already exist in database.');
				$this->url->redirect('customer/add');
			}
			$data['id'] = $this->model_customer->createCustomer($data);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Customer created successfully.');
		}
		$this->url->redirect('customer/view&id='.$data['id']);
	}

	public function indexDelete()
	{
		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['delete']) || empty($this->url->post('id')) ) {
			$this->url->redirect('customers');
		}
		$this->load->model('customer');
		$this->model_customer->deleteCustomer($this->url->post('id'));
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Customer deleted successfully.');
		$this->url->redirect('customers');
	}

	public function indexMail()
	{
		if (!isset($_POST['submit'])) {
			$this->url->redirect('customers');
		}

		$data = $this->url->post;
		$this->load->controller('common');
		$this->load->model('customer');
		$result = $this->model_customer->getCustomer($data['mail']['id']);
		if (empty($result)) {
			$this->url->redirect('customers');
		}

		$data['mail']['email'] = $result['email'];
		$data['mail']['name'] = $result['firstname'].' '.$result['lastname'];
		$data['mail']['redirect'] = 'customer/view&id='.$result['id'];
		
		$this->load->controller('Mail');
		$mail_result = $this->controller_mail->sendmail($data['mail']);

		if ($mail_result == 1) {
			$data['mail']['type'] = 'customer';
			$data['mail']['type_id'] = $data['mail']['id'];
			$data['mail']['user_id'] = $this->session->data['user_id'];
			
			$this->controller_mail->createMailLog($data['mail']);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Success: Message sent successfully.');
			$this->url->redirect('customer/view&id='.$result['id']);
		} else {
			$this->session->data['message'] = array('alert' => 'error', 'value' => $mail_result);
			$this->url->redirect('customer/view&id='.$result['id']);
		}
	}

	public function searchPatient()
	{
		$data = $this->url->get;
		$this->load->model('customer');
		$result = $this->model_customer->getSearchedCustomer($data['term']);
		echo json_encode($result);
	}

	public function validateField($data)
	{
		$error = [];
		$error_flag = false;
		if ($this->controller_common->validateText($data['firstname'])) {
			$error_flag = true;
			$error['firstname'] = 'First Name';
		}
		if ($this->controller_common->validateText($data['lastname'])) {
			$error_flag = true;
			$error['lastname'] = 'Last Name';
		}
		if ($this->controller_common->validateEmail($data['mail'])) {
			$error_flag = true;
			$error['email'] = 'Email Address';
		}
		if (!empty($data['dob'])) {
			if ($this->controller_common->validateDate( $data['dob'], $data['info']['date_format'] )) {
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