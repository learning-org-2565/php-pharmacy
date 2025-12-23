<?php

/**
 * ReportController
 */
class ReportController extends Controller
{
	public function index()
	{
		$report = $this->url->get('name');
		
		if ($report == "invoice") {
			$this->reportInvoice();
		} elseif ($report == "purchase") {
			$this->reportPurchase();
		} elseif ($report == "bill") {
			$this->reportBill();
		} elseif ($report == "expenses") {
			$this->reportExpenses();
		} elseif ($report == "accountstatement") {
			$this->reportAccountStatement();
		} elseif ($report == "statement") {
			$this->reportStatement();
		} elseif ($report == "inventory") {
			$this->reportInventory();
		} elseif ($report == "outofstock") {
			$this->reportOutofStock();
		} elseif ($report == "income_expenses") {
			$this->reportIncome();
		} elseif ($report == "salary") {
			$this->reportSalary();
		} else {
			$this->reports();
		}
	}

	public function reports()
	{
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		$data['page_title'] = 'Reports';
		$this->response->setOutput($this->load->view('report/reports', $data));
	}

	public function reportInvoice()
	{
		$this->load->controller('common');
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		
		$data['period']['start'] = $this->url->get('start');
		$data['period']['end'] = $this->url->get('end');

		if (!empty($data['period']['start']) && !empty($data['period']['end']) && !$this->controller_common->validateDate($data['period']['start']) && !$this->controller_common->validateDate($data['period']['end'])) {
			$data['period']['start'] = date_format(date_create($data['period']['start'].'00:00:00'), "Y-m-d H:i:s");
			$data['period']['end'] = date_format(date_create($data['period']['end'].'23:59:59'), "Y-m-d H:i:s");
		} else {
			$data['period']['start'] = date('Y-m-d '.'00:00:00', strtotime("-1 month"));
			$data['period']['end'] = date('Y-m-d '.'23:59:59');
		}

		$this->load->model('report');
		$data['result'] = $this->model_report->getInvoices($data['period']);
		$data['chart_invoice'] = $this->formatChartDataWithMonth($this->model_report->getChartInvoice($data['period']));
		$data['chart_invoice_status'] = $this->formatChartData($this->model_report->getChartInvoicebyStatus($data['period']));

		$data['invoice_stats'] = $this->model_report->getInvoiceStats($data['period']);

		$data['page_title'] = 'Invoice Report';

		$this->response->setOutput($this->load->view('report/report_invoice', $data));
	}

	public function reportPurchase()
	{
		$this->load->controller('common');
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		
		$data['period']['start'] = $this->url->get('start');
		$data['period']['end'] = $this->url->get('end');

		if (!empty($data['period']['start']) && !empty($data['period']['end']) && !$this->controller_common->validateDate($data['period']['start']) && !$this->controller_common->validateDate($data['period']['end'])) {
			$data['period']['start'] = date_format(date_create($data['period']['start'].'00:00:00'), "Y-m-d H:i:s");
			$data['period']['end'] = date_format(date_create($data['period']['end'].'23:59:59'), "Y-m-d H:i:s");
		} else {
			$data['period']['start'] = date('Y-m-d '.'00:00:00', strtotime("-1 month"));
			$data['period']['end'] = date('Y-m-d '.'23:59:59');
		}

		$this->load->model('report');
		$data['result'] = $this->model_report->getPurchases($data['period']);

		$data['purchase_chart'] = $this->formatChartDataWithMonth($this->model_report->getChartPurchase($data['period']));
		$data['purchase_stats'] = $this->model_report->getPurchaseStats($data['period']);
		
		$data['page_title'] = 'Purchase Report';
		$this->response->setOutput($this->load->view('report/report_purchase', $data));
	}

	public function reportBill()
	{
		$this->load->controller('common');
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		
		$data['period']['start'] = $this->url->get('start');
		$data['period']['end'] = $this->url->get('end');

		if (!empty($data['period']['start']) && !empty($data['period']['end']) && !$this->controller_common->validateDate($data['period']['start']) && !$this->controller_common->validateDate($data['period']['end'])) {
			$data['period']['start'] = date_format(date_create($data['period']['start'].'00:00:00'), "Y-m-d H:i:s");
			$data['period']['end'] = date_format(date_create($data['period']['end'].'23:59:59'), "Y-m-d H:i:s");
		} else {
			$data['period']['start'] = date('Y-m-d '.'00:00:00', strtotime("-1 month"));
			$data['period']['end'] = date('Y-m-d '.'23:59:59');
		}

		$this->load->model('report');
		$data['result'] = $this->model_report->getBills($data['period']);
		$data['bill_chart'] = $this->formatChartDataWithMonth($this->model_report->getChartBills($data['period']));
		$data['bill_stats'] = $this->model_report->getBillsStats($data['period']);
		
		$data['page_title'] = 'POS/Bill Report';
		$this->response->setOutput($this->load->view('report/report_bill', $data));
	}

	public function reportExpenses()
	{
		$this->load->controller('common');
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		
		$data['period']['start'] = $this->url->get('start');
		$data['period']['end'] = $this->url->get('end');

		if (!empty($data['period']['start']) && !empty($data['period']['end']) && !$this->controller_common->validateDate($data['period']['start']) && !$this->controller_common->validateDate($data['period']['end'])) {
			$data['period']['start'] = date_format(date_create($data['period']['start'].'00:00:00'), "Y-m-d H:i:s");
			$data['period']['end'] = date_format(date_create($data['period']['end'].'23:59:59'), "Y-m-d H:i:s");
		} else {
			$data['period']['start'] = date('Y-m-d '.'00:00:00', strtotime("-1 month"));
			$data['period']['end'] = date('Y-m-d '.'23:59:59');
		}

		$this->load->model('report');
		$data['result'] = $this->model_report->getExpenses($data['period']);
		$data['expense_chart'] = $this->formatChartDataWithMonth($this->model_report->getChartExpenses($data['period']));
		$data['expense_stats'] = $this->model_report->getExpensesStats($data['period']);
		
		$data['page_title'] = 'Expenses Report';
		$this->response->setOutput($this->load->view('report/report_expenses', $data));
	}

	public function reportAccountStatement()
	{
		$this->load->controller('common');
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		
		$data['period']['start'] = $this->url->get('start');
		$data['period']['end'] = $this->url->get('end');

		if (!empty($data['period']['start']) && !empty($data['period']['end']) && !$this->controller_common->validateDate($data['period']['start']) && !$this->controller_common->validateDate($data['period']['end'])) {
			$data['period']['start'] = date_format(date_create($data['period']['start'].'00:00:00'), "Y-m-d H:i:s");
			$data['period']['end'] = date_format(date_create($data['period']['end'].'23:59:59'), "Y-m-d H:i:s");
		} else {
			$data['period']['start'] = date('Y-m-d '.'00:00:00', strtotime("-1 month"));
			$data['period']['end'] = date('Y-m-d '.'23:59:59');
		}

		$this->load->model('report');
		$data['result'] = $this->model_report->getAccounts();
		
		$data['page_title'] = 'Account Statement';
		$this->response->setOutput($this->load->view('report/report_acconts', $data));
	}

	public function reportStatement()
	{
		$id = (int)$this->url->get('id');
		if (empty($id) || !is_int($id)) {
			$this->url->redirect('reports&name=accountstatement');
		}

		$this->load->controller('common');
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		
		$data['period']['start'] = $this->url->get('start');
		$data['period']['end'] = $this->url->get('end');

		if (!empty($data['period']['start']) && !empty($data['period']['end']) && !$this->controller_common->validateDate($data['period']['start']) && !$this->controller_common->validateDate($data['period']['end'])) {
			$data['period']['start'] = date_format(date_create($data['period']['start'].'00:00:00'), "Y-m-d H:i:s");
			$data['period']['end'] = date_format(date_create($data['period']['end'].'23:59:59'), "Y-m-d H:i:s");
		} else {
			$data['period']['start'] = date('Y-m-d '.'00:00:00', strtotime("-1 month"));
			$data['period']['end'] = date('Y-m-d '.'23:59:59');
		}

		$this->load->model('report');
		$data['account'] = $this->model_report->getAccount($id);

		if (empty($data['account'])) {
			$this->url->redirect('reports&name=accountstatement');
		}
		$data['result'] = $this->model_report->getAccountsStatement($id, $data['period']);

		$data['credit'] = 0;
		$data['debit'] = 0;
		$data['page_title'] = $data['account']['account_name'].' Statement';
		$this->response->setOutput($this->load->view('report/report_statement', $data));
	}

	public function reportInventory()
	{
		$this->load->controller('common');
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		
		$data['period']['start'] = $this->url->get('start');
		$data['period']['end'] = $this->url->get('end');

		if (!empty($data['period']['start']) && !empty($data['period']['end']) && !$this->controller_common->validateDate($data['period']['start']) && !$this->controller_common->validateDate($data['period']['end'])) {
			$data['period']['start'] = date_format(date_create($data['period']['start'].'00:00:00'), "Y-m-d H:i:s");
			$data['period']['end'] = date_format(date_create($data['period']['end'].'23:59:59'), "Y-m-d H:i:s");
		} else {
			$data['period']['start'] = date('Y-m-d '.'00:00:00', strtotime("-1 month"));
			$data['period']['end'] = date('Y-m-d '.'23:59:59');
		}
		
		$this->load->model('report');
		$data['result'] = $this->model_report->getMedicines($data['period']);

		// echo "<pre>";
		// print_r($data['result']);

		$data['page_title'] = 'Inventory Report';
		$this->response->setOutput($this->load->view('report/report_inventory', $data));
	}

	public function reportOutofStock()
	{
		$this->load->controller('common');
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		
		$data['period']['start'] = $this->url->get('start');
		$data['period']['end'] = $this->url->get('end');

		if (!empty($data['period']['start']) && !empty($data['period']['end']) && !$this->controller_common->validateDate($data['period']['start']) && !$this->controller_common->validateDate($data['period']['end'])) {
			$data['period']['start'] = date_format(date_create($data['period']['start'].'00:00:00'), "Y-m-d H:i:s");
			$data['period']['end'] = date_format(date_create($data['period']['end'].'23:59:59'), "Y-m-d H:i:s");
		} else {
			$data['period']['start'] = date('Y-m-d '.'00:00:00', strtotime("-1 month"));
			$data['period']['end'] = date('Y-m-d '.'23:59:59');
		}
		
		$this->load->model('report');
		$data['result'] = $this->model_report->getOutofStock($data['period']);

		$data['page_title'] = 'Out of Stock Report';
		$this->response->setOutput($this->load->view('report/report_outofstock', $data));
	}

	public function reportIncome()
	{
		$this->load->controller('common');
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		
		$data['period']['start'] = $this->url->get('start');
		$data['period']['end'] = $this->url->get('end');

		if (!empty($data['period']['start']) && !empty($data['period']['end']) && !$this->controller_common->validateDate($data['period']['start']) && !$this->controller_common->validateDate($data['period']['end'])) {
			$data['period']['start'] = date_format(date_create($data['period']['start'].'00:00:00'), "Y-m-d H:i:s");
			$data['period']['end'] = date_format(date_create($data['period']['end'].'23:59:59'), "Y-m-d H:i:s");
		} else {
			$data['period']['start'] = date('Y-m-d '.'00:00:00', strtotime("-1 month"));
			$data['period']['end'] = date('Y-m-d '.'23:59:59');
		}

		$this->load->model('report');
		$data['income'] = $this->model_report->getAllIncome($data['period']);
		$data['expense'] = $this->model_report->getAllExpense($data['period']);

		$data['page_title'] = 'Income & Expense Report';
		$this->response->setOutput($this->load->view('report/report_income_expense', $data));
	}

	public function reportSalary()
	{
		$this->load->controller('common');
		$this->load->model('commons');
		$data['common'] = $this->model_commons->getCommonData($this->session->data['user_id']);
		
		$data['period']['start'] = $this->url->get('start');
		$data['period']['end'] = $this->url->get('end');

		if (!empty($data['period']['start']) && !empty($data['period']['end']) && !$this->controller_common->validateDate($data['period']['start']) && !$this->controller_common->validateDate($data['period']['end'])) {
			$data['period']['start'] = date_format(date_create($data['period']['start'].'00:00:00'), "Y-m-d H:i:s");
			$data['period']['end'] = date_format(date_create($data['period']['end'].'23:59:59'), "Y-m-d H:i:s");
		} else {
			$data['period']['start'] = date('Y-m-d '.'00:00:00', strtotime("-1 month"));
			$data['period']['end'] = date('Y-m-d '.'23:59:59');
		}

		$this->load->model('report');
		$data['result'] = $this->model_report->getSalary($data['period']);

		$data['page_title'] = 'Salary Report';
		$this->response->setOutput($this->load->view('report/report_salary', $data));
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
						$result['value'][$i] = (float)$value['amount'];
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

	public function formatChartData($data)
	{
		$arr = array('Paid', 'Partially Paid', 'Unpaid', 'Pending', 'In Process', 'Cancelled');
		$result['label'] = array();
		$result['value'] = array();
		foreach ($arr as $key => $value) {
			if (!empty($data)) {
				foreach ($data as $k => $v) {
					if ($v['label'] == $value) {
						$result['value'][$key] = (float)$v['value'];
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
}