<?php

/**
 * AccountController
 */
class AccountController extends Controller
{
	public function index()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		/**
		* Get all Doctor data from Db using Doctor Model method 
		**/
		$this->load->model('account');

		$data['result'] = $this->model_account->getAccounts();
		

		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}

		$data['page_title'] = 'Accounts';
		$data['page_add'] = $this->user_agent->hasPermission('account/add') ? true : false;
		$data['page_edit'] = $this->user_agent->hasPermission('account/edit') ? true : false;
		$data['page_delete'] = $this->user_agent->hasPermission('account/delete') ? true : false;

		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action_delete'] = URL.DIR_ROUTE.'account/delete';
		$data['delete_msg'] = 'All transactions related to this account will be deleted..';

		/*Render Doctor list view*/
		$this->response->setOutput($this->load->view('account/account_list', $data));
	}

	public function indexAdd()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		/* Set page title */
		$data['page_title'] = 'Add Account';
		/* Set empty data to array */
		$data['result'] =  NULL;
		
		$this->load->model('account');
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action'] = URL.DIR_ROUTE.'account/add';
		/*Render Doctor add view*/
		$this->response->setOutput($this->load->view('account/account_form', $data));
	}

	public function indexEdit()
	{
		/**
		* Check if id exist in url if not exist then redirect to Doctor list view 
		**/
		$id = (int)$this->url->get('id');
		if (empty($id) || !is_int($id)) {
			$this->url->redirect('accounts');
		}
		/**
		* Call getDoctor method from Blog model to get data from DB for single doctor
		* If Doctor does not exist then redirect it to doctor list view
		**/
		$this->load->model('account');
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);

		$data['result'] = $this->model_account->getAccount($id);
		
		if (empty($data['result'])) {
			$this->session->data['message'] = array('alert' => 'warning', 'value' => 'Account does not exist in database!');
			$this->url->redirect('accounts');
		}

		/* Set Doctor edit view page title in array */
		$data['page_title'] = 'Edit Account';	
		$data['result']['address'] = json_decode($data['result']['address'], true);
	
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}

		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action'] = URL.DIR_ROUTE.'account/edit';
		/*Render Doctor edit view*/
		$this->response->setOutput($this->load->view('account/account_form', $data));
	}

	public function indexAction()
	{
		$data = $this->url->post;
		$this->load->controller('common');
		if ($validate_field = $this->validateField($data)) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Please enter/select valid '.implode(", ",$validate_field).'!');
			if (!empty($data['account']['id'])) {
				$this->url->redirect('account/edit&id='.$data['account']['id']);
			} else {
				$this->url->redirect('account/add');
			}
		}

		$this->load->model('account');
		$data['account']['address'] = json_encode($data['account']['address']);
		$data['account']['user_id'] = $this->session->data['user_id'];
		$data['account']['datetime'] = date('Y-m-d H:i:s');
		if (!empty($data['account']['id'])) {
			$this->model_account->updateAccount($data['account']);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Account updated successfully.');
		} else {
			$data['account']['id'] = $this->model_account->createAccount($data['account']);
			$this->model_account->createAccountTransaction($data['account']);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Account created successfully.');	
		}
		$this->url->redirect('account/edit&id='.$data['account']['id']);
	}

	public function indexDelete()
	{
		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['delete']) || empty($this->url->post('id')) ) {
			$this->url->redirect('accounts');
		}

		$this->load->model('account');
		$this->model_account->deleteAccount($this->url->post('id'));
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Account deleted successfully.');
		$this->url->redirect('accounts');
	}

	protected function validateField($data)
	{
		$error = [];
		$error_flag = false;
		if ( $this->controller_common->validateText($data['account']['bank_name'])) {
			$error_flag = true;
			$error['bank_name'] = 'Bank name!';
		}

		if ( $this->controller_common->validateText($data['account']['account_name'])) {
			$error_flag = true;
			$error['account_name'] = 'Account Name!';
		}

		if ($this->controller_common->validateText($data['account']['account_no'])) {
			$error_flag = true;
			$error['account_no'] = 'Account Number!';
		}

		if ($this->controller_common->validateNumeric($data['account']['initial_balance'])) {
			$error_flag = true;
			$error['initial_balance'] = 'Initial Balance!';
		}
		
		if ($error_flag) {
			return $error;
		} else {
			return false;
		}
	}



	public function transactions()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		
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

		/**
		* Get all Doctor data from Db using Doctor Model method 
		**/
		$this->load->model('account');
		$data['result'] = $this->model_account->getTransactions($data['period']);

		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}

		$data['page_title'] = 'Transactions';
		$data['page_add'] = $this->user_agent->hasPermission('account/transaction/add') ? true : false;
		$data['page_edit'] = $this->user_agent->hasPermission('account/transaction/edit') ? true : false;
		$data['page_delete'] = $this->user_agent->hasPermission('account/transaction/delete') ? true : false;

		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action_delete'] = URL.DIR_ROUTE.'account/transaction/delete';

		/*Render Doctor list view*/
		$this->response->setOutput($this->load->view('account/transaction_list', $data));
	}

	public function transactionAdd()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);

		$this->load->model('account');
		$data['accounts'] = $this->model_account->getTransactionAccounts();
		$data['methods'] = $this->model_account->getPaymentMethod();
		
		/* Set page title */
		$data['page_title'] = 'Add Transaction';
		/* Set empty data to array */
		$data['result'] =  NULL;
		
		$this->load->model('account');
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action'] = URL.DIR_ROUTE.'account/transaction/add';
		/*Render Doctor add view*/
		$this->response->setOutput($this->load->view('account/transaction_form', $data));
	}

	public function transactionEdit()
	{
		/**
		* Check if id exist in url if not exist then redirect to Doctor list view 
		**/
		$id = (int)$this->url->get('id');
		if (empty($id) || !is_int($id)) {
			$this->url->redirect('account/transactions');
		}
		/**
		* Call getDoctor method from Blog model to get data from DB for single doctor
		* If Doctor does not exist then redirect it to doctor list view
		**/
		$this->load->model('account');
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);

		$data['result'] = $this->model_account->getTransaction($id);
		$data['accounts'] = $this->model_account->getTransactionAccounts();
		$data['methods'] = $this->model_account->getPaymentMethod();

		if (empty($data['result'])) {
			$this->session->data['message'] = array('alert' => 'warning', 'value' => 'Transactions does not exist in database!');
			$this->url->redirect('account/transactions');
		}

		/* Set Doctor edit view page title in array */
		$data['page_title'] = 'Edit Transactions';	
		
		/* Set confirmation message if page submitted before */
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}

		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action'] = URL.DIR_ROUTE.'account/transaction/edit';
		/*Render Doctor edit view*/
		$this->response->setOutput($this->load->view('account/transaction_form', $data));	
	}

	public function transactionAction()
	{
		$data = $this->url->post;
		$this->load->model('commons');
		$data['info'] = $this->model_commons->getSiteInfo();

		$this->load->controller('common');
		if ($validate_field = $this->validateTransactionField($data)) {
			$this->session->data['message'] = array('alert' => 'error', 'value' => 'Please enter/select valid '.implode(", ",$validate_field).'!');
			if (!empty($data['transaction']['id'])) {
				$this->url->redirect('account/transaction/edit&id='.$data['transaction']['id']);
			} else {
				$this->url->redirect('account/transaction/add');
			}
		}

		$this->load->model('account');

		$data['transaction']['date'] = DateTime::createFromFormat($data['info']['date_format'], $data['transaction']['date'])->format('Y-m-d');
		$data['transaction']['user_id'] = $this->session->data['user_id'];
		$data['transaction']['datetime'] = date('Y-m-d H:i:s');
		
		if (!empty($data['transaction']['id'])) {
			$this->model_account->updateTransaction($data['transaction']);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Transaction updated successfully.');
		} else {
			$data['transaction']['id'] = $this->model_account->createTransaction($data['transaction']);
			$this->session->data['message'] = array('alert' => 'success', 'value' => 'Transaction created successfully.');	
		}
		$this->url->redirect('account/transaction/edit&id='.$data['transaction']['id']);
	}

	public function transactionDelete()
	{
		/**
		* Check if from is submitted or not 
		**/
		if (!isset($_POST['delete']) || empty($this->url->post('id')) ) {
			$this->url->redirect('account/transactions');
		}

		$this->load->model('account');
		$this->model_account->deleteTransaction($this->url->post('id'));
		$this->session->data['message'] = array('alert' => 'success', 'value' => 'Transactions deleted successfully.');
		$this->url->redirect('account/transactions');
	}

	public function validateTransactionField($data)
	{
		$error = [];
		$error_flag = false;
		if ( $this->controller_common->validateNumber($data['transaction']['account_id'])) {
			$error_flag = true;
			$error['account_id'] = 'Account name!';
		}
		if ($this->controller_common->validateDate( $data['transaction']['date'], $data['info']['date_format'] )) {
				$error_flag = true;
				$error['date'] = 'Date!';
		}

		if ($this->controller_common->validateNumber($data['transaction']['transaction_type'])) {
			$error_flag = true;
			$error['transaction_type'] = 'Transaction type!';
		}

		if ($this->controller_common->validateNumeric($data['transaction']['amount'])) {
			$error_flag = true;
			$error['amount'] = 'Amount!';
		}
		
		if ($error_flag) {
			return $error;
		} else {
			return false;
		}
	}
}