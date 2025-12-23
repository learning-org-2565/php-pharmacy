<?php

/**
* Dashboard Controller
*/
class DashboardController extends Controller
{
	/**
	* Dashboard index method
	* This method will be called on dahsboard view
	**/
	public function index()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);

		if ($data['common']['user']['role_id'] == '1') {
			$this->adminDashboard($data['common']);
		} elseif ($data['common']['user']['role_id'] == '2') {
			$this->employeeDashbaord($data['common']);
		} elseif ($data['common']['user']['role_id'] == '3') {
			$this->employeeDashbaord($data['common']);
		} elseif ($data['common']['user']['role_id'] == '5') {
			$this->employeeDashbaord($data['common']);
		} elseif ($data['common']['user']['role_id'] == '6') {
			$this->employeeDashbaord($data['common']);
		} else {
			$this->employeeDashbaord($data['common']);
		}
	}

	protected function adminDashboard($common)
	{
		$data['common'] = $common;
		$this->load->model('dashboard');

		$data['title'] = 'Dashboard';
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		$data['period']['start'] = date("Y-m-d", strtotime( date( 'Y-m-01' )." -11 months"));
		$data['period']['end'] = date("Y-m-d", strtotime( date( 'Y-m-d' )));

		$data['chart_invoice'] = $this->formatChartDataWithMonth($this->model_dashboard->getChartInvoice());
		$data['chart_bill'] = $this->formatChartDataWithMonth($this->model_dashboard->getChartBill());
		$data['chart_purchase'] = $this->formatChartDataWithMonth($this->model_dashboard->getChartPurchase());
		$data['chart_expense'] = $this->formatChartDataWithMonth($this->model_dashboard->getChartExpense());
		$data['chart_salary'] = $this->formatChartDataWithMonth($this->model_dashboard->getChartSalary());
		$data['chart_customer'] = $this->formatChartDataWithMonth($this->model_dashboard->getChartCustomer());
		$data['chart_transaction'] = $this->formatTransactionWithMonth($this->model_dashboard->getChartTransaction());
	
		$data['chart_expense_type'] = $this->formatPieChartData($this->model_dashboard->getChartExpensebyType());

		$data['main_stats'] = $this->model_dashboard->getMainStats();
		$data['revenue_stats'] = $this->model_dashboard->getRevenueStats();
		$data['income_stats'] = $this->model_dashboard->getIncomeStats();
		$data['notices'] = $this->model_dashboard->getNotices();

		$data['page_title'] = 'Dashboard';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);

		/*Render dahsboard view*/
		$this->response->setOutput($this->load->view('dashboard/dashboard-admin', $data));
	}

	protected function deanDashboard($common)
	{
		$data['common'] = $common;
		$this->load->model('dashboard');
		$data['doctors'] = $this->model_dashboard->getDoctors();

		$data['title'] = 'Dashboard';
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		$data['period']['start'] = date("Y-m-d", strtotime( date( 'Y-m-01' )." -11 months"));
		$data['period']['end'] = date("Y-m-d", strtotime( date( 'Y-m-d' )));
		
		$data['chart_appointment'] = $this->formatChartDataWithMonth($this->model_dashboard->getChartAppointment());
		$data['chart_patient'] = $this->formatChartDataWithMonth($this->model_dashboard->getChartpatient());
		$data['appointment_stats'] = $this->model_dashboard->getAppointmentStats();
		$data['clinic_stats'] = $this->model_dashboard->getClinicStats();
		$data['notices'] = $this->model_dashboard->getNotices();

		$data['page_title'] = 'Dashboard';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action_new_appointment'] = URL.DIR_ROUTE.'appointment/add';
		/*Render dahsboard view*/
		$this->response->setOutput($this->load->view('dashboard/dashboard-dean', $data));
	}

	protected function doctorDashboard($common)
	{
		$data['common'] = $common;
		$this->load->model('dashboard');
		$data['doctors'] = $this->model_dashboard->getDoctors();

		$data['title'] = 'Dashboard';
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		$data['period']['start'] = date("Y-m-d", strtotime( date( 'Y-m-01' )." -11 months"));
		$data['period']['end'] = date("Y-m-d", strtotime( date( 'Y-m-d' )));
		
		$data['chart_patient'] = $this->formatChartDataWithMonth($this->model_dashboard->getChartpatient($common['user']['doctor']));
		$data['chart_expense'] = $this->formatChartDataWithMonth($this->model_dashboard->getChartExpense($common['user']['user_id']));
		$data['chart_appointment'] = $this->formatChartDataWithMonth($this->model_dashboard->getChartAppointment($common['user']['doctor']));
		$data['appointment_stats'] = $this->model_dashboard->getAppointmentStats($common['user']['doctor']);
		$data['notices'] = $this->model_dashboard->getNotices();
		
		$data['page_title'] = 'Dashboard';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action_new_appointment'] = URL.DIR_ROUTE.'appointment/add';
		/*Render dahsboard view*/
		$this->response->setOutput($this->load->view('dashboard/dashboard-doctor', $data));
	}

	protected function accountantDashboard($common)
	{
		$data['common'] = $common;
		$this->load->model('dashboard');
		$data['doctors'] = $this->model_dashboard->getDoctors();

		$data['title'] = 'Dashboard';
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		$data['period']['start'] = date("Y-m-d", strtotime( date( 'Y-m-01' )." -11 months"));
		$data['period']['end'] = date("Y-m-d", strtotime( date( 'Y-m-d' )));
		
		$data['chart_income'] = $this->formatChartDataWithMonth($this->model_dashboard->getChartIncome());
		$data['chart_bill'] = $this->formatChartDataWithMonth($this->model_dashboard->getChartIncomeBill());
		$data['chart_purchase'] = $this->formatChartDataWithMonth($this->model_dashboard->getChartPurchase());
		$data['chart_expense'] = $this->formatChartDataWithMonth($this->model_dashboard->getChartExpense());
		$data['chart_invoice_status'] = $this->formatChartData($this->model_dashboard->getChartInvoiceStatus());
		$data['income_stats'] = $this->model_dashboard->getIncomeStats();
		$data['bill_stats'] = $this->model_dashboard->getBillStats();
		$data['invoice_stats'] = $this->model_dashboard->getInvoiceStats();
		$data['notices'] = $this->model_dashboard->getNotices();

		$data['page_title'] = 'Dashboard';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action'] = URL.DIR_ROUTE.'appointment/sidebar';
		/*Render dahsboard view*/
		$this->response->setOutput($this->load->view('dashboard/dashboard-accountant', $data));
	}

	protected function pharmacistDashboard($common)
	{
		$data['common'] = $common;
		$this->load->model('dashboard');
		$data['doctors'] = $this->model_dashboard->getDoctors();

		$data['title'] = 'Dashboard';
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		$data['period']['start'] = date("Y-m-d", strtotime( date( 'Y-m-01' )." -11 months"));
		$data['period']['end'] = date("Y-m-d", strtotime( date( 'Y-m-d' )));
		
		$data['chart_bill'] = $this->formatChartDataWithMonth($this->model_dashboard->getChartIncomeBill());
		$data['chart_purchase'] = $this->formatChartDataWithMonth($this->model_dashboard->getChartPurchase());
		$data['bill_stats'] = $this->model_dashboard->getBillStats();
		$data['purchase'] = $this->model_dashboard->getLatestPurchase();
		
		$data['bill_stats'] = $this->model_dashboard->getBillStats();
		$data['notices'] = $this->model_dashboard->getNotices();

		$data['page_title'] = 'Dashboard';
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['action'] = URL.DIR_ROUTE.'appointment/sidebar';
		/*Render dahsboard view*/
		$this->response->setOutput($this->load->view('dashboard/dashboard-pharmacist', $data));
	}

	protected function employeeDashbaord($common)
	{
		$data['common'] = $common;
		$this->load->model('dashboard');
		$data['notices'] = $this->model_dashboard->getNotices();
		
		$data['page_title'] = 'Dashboard';
		$data['title'] = 'Dashboard';
		if (isset($this->session->data['message'])) {
			$data['message'] = $this->session->data['message'];
			unset($this->session->data['message']);
		}
		
		/*Render dahsboard view*/
		$this->response->setOutput($this->load->view('dashboard/dashboard_employee', $data));
	}

	public function formatChartDataWithMonth($data)
	{
		$months = array();
		$result['label'] = array();
		$result['value'] = array();
		for ($i = 0; $i < 12; $i++) {
			$month = date("m", strtotime( date( 'Y-m-01' )." -$i months"));
			$month_name = date("M", strtotime( date( 'Y-m-01' )." -$i months"));

			if (!empty($data)) {
				foreach ($data as $key => $value) {
					if ($value['month'] == $month) {
						$result['value'][$i] = number_format((float)$value['amount'], 2, '.', '');
						$result['label'][$i] = $month_name;
					}
				}
			}

			if (!isset($result['value'][$i])) {
				$result['value'][$i] = 0;
				$result['label'][$i] = $month_name;
			}
		}
		
		$result['label'] = json_encode(array_reverse($result['label']));
		$result['value'] = json_encode(array_reverse($result['value']));
		return $result;
	}

	public function formatTransactionWithMonth($data)
	{
		$months = array();
		$result['label'] = array();
		$result['credit'] = array();
		$result['debit'] = array();
		for ($i = 0; $i < 12; $i++) {
			$month = date("m", strtotime( date( 'Y-m-01' )." -$i months"));
			$month_name = date("M", strtotime( date( 'Y-m-01' )." -$i months"));
			
			if (!empty($data)) {
				foreach ($data as $key => $value) {
					if ($value['month'] == $month) {
						$result['credit'][$i] = number_format((float)$value['credit'], 2, '.', '');
						$result['debit'][$i] = number_format((float)$value['debit'], 2, '.', '');
						$result['label'][$i] = $month_name;
					}
				}
			}

			if (!isset($result['credit'][$i])) {
				$result['credit'][$i] = 0;
				$result['debit'][$i] = 0;
				$result['label'][$i] = $month_name;
			}
		}
		
		$result['label'] = json_encode(array_reverse($result['label']));
		$result['debit'] = json_encode(array_reverse($result['debit']));
		$result['credit'] = json_encode(array_reverse($result['credit']));
		return $result;
	}

	public function formatChartData($data)
	{
		$arr = array('Paid', 'Partially Paid', 'Unpaid', 'Pending', 'In Process', 'Cancelled');
		$result['label'] = array();
		$result['value'] = array();
		foreach ($arr as $key => $value) {
			if (!empty($data)) {
				foreach ($data as $k => $v) {
					if ($v['label'] == $value) {
						$result['value'][$key] = number_format((float)$v['value'], 2, '.', '');
						$result['label'][$key] = $v['label'];
					}
				}
			}

			if (!isset($result['value'][$key])) {
				$result['value'][$key] = 0;
				$result['label'][$key] = $value;
			}
		}
		
		$result['label'] = json_encode(array_reverse($result['label']));
		$result['value'] = json_encode(array_reverse($result['value']));
		return $result;
	}

	public function formatPieChartData($data)
	{
		$result['label'] = array();
		$result['value'] = array();

		if (!empty($data)) {
			foreach ($data as $key => $value) {
				$result['label'][$key] = $value['label'];
				$result['value'][$key] = number_format((float)$value['value'], 2, '.', '');
 			}	
		}

		$result['label'] = json_encode($result['label']);
		$result['value'] = json_encode($result['value']);
		return $result;
	}
}