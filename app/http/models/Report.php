<?php 

/**
* Report
*/
class Report extends Model
{
	public function getTransactions($period)
	{
		$query = $this->database->query("SELECT at.*, a.account_name, a.bank_name, a.account_no FROM `" . DB_PREFIX . "account_transaction` AS at LEFT JOIN `" . DB_PREFIX . "accounts` AS a ON a.id = at.account_id ORDER BY date");
		return $query->rows;
	}

	public function getInvoices($period)
	{
		$query = $this->database->query("SELECT i.* FROM `" . DB_PREFIX . "invoice` AS i WHERE i.invoicedate between '".$period['start']."' AND '".$period['end']."' ORDER BY i.invoicedate DESC");
		return $query->rows;
	}

	public function getChartInvoice($period)
	{
		$query = $this->database->query("SELECT SUM(amount) AS amount, MONTH(invoicedate) AS month FROM `" . DB_PREFIX . "invoice` WHERE invoicedate > DATE_SUB(now(), INTERVAL 12 MONTH) GROUP BY MONTH(invoicedate)");
		return $query->rows;
	}

	public function getChartInvoicebyStatus($period)
	{
		$query = $this->database->query("SELECT COUNT(status) AS value, status AS label FROM `" . DB_PREFIX . "invoice` WHERE invoicedate > DATE_SUB(now(), INTERVAL 12 MONTH) GROUP BY status");
		return $query->rows;
	}

	public function getInvoiceStats($period)
	{
		$query = $this->database->query("SELECT SUM(amount) AS amount, IF(amount > 0, 100, 0) AS p_amount, SUM(paid) AS paid, (SUM(paid) / SUM(amount)) * 100 AS p_paid, SUM(due) AS due, (SUM(due) / SUM(amount)) * 100 AS p_due, SUM(discount_value) AS discount, (SUM(discount_value) / SUM(amount)) * 100 AS p_discount,  SUM(tax) AS tax, (SUM(tax) / SUM(amount)) * 100 AS p_tax FROM `" . DB_PREFIX . "invoice` WHERE invoicedate between '".$period['start']."' AND '".$period['end']."'");
		$data = $query->row;

		$data['p_paid'] = number_format((float)$query->row['p_paid'], 2, '.', '');
		$data['p_due'] = number_format((float)$query->row['p_due'], 2, '.', '');
		$data['p_discount'] = number_format((float)$query->row['p_discount'], 2, '.', '');
		$data['p_tax'] = number_format((float)$query->row['p_tax'], 2, '.', '');
		return $data;
	}


	public function getPurchases($period)
	{
		$query = $this->database->query("SELECT mp.*, s.name AS supplier FROM `" . DB_PREFIX . "medicine_purchase` AS mp LEFT JOIN `" . DB_PREFIX . "suppliers` AS s ON s.id = mp.supplier WHERE mp.date between '".$period['start']."' AND '".$period['end']."' ORDER BY date DESC");
		return $query->rows;
	}

	public function getChartPurchase($period)
	{
		$query = $this->database->query("SELECT SUM(amount) AS amount, MONTH(date) AS month FROM `" . DB_PREFIX . "medicine_purchase` WHERE date > DATE_SUB(now(), INTERVAL 12 MONTH) GROUP BY MONTH(date)");
		return $query->rows;
	}

	public function getPurchaseStats($period)
	{
		$query = $this->database->query("SELECT SUM(amount) AS amount, IF(amount > 0, 100, 0) AS p_amount, SUM(discount_value) AS discount, (SUM(discount_value) / SUM(amount)) * 100 AS p_discount,  SUM(tax) AS tax, (SUM(tax) / SUM(amount)) * 100 AS p_tax FROM `" . DB_PREFIX . "medicine_purchase` WHERE date between '".$period['start']."' AND '".$period['end']."'");
		$data = $query->row;

		$data['p_discount'] = number_format((float)$query->row['p_discount'], 2, '.', '');
		$data['p_tax'] = number_format((float)$query->row['p_tax'], 2, '.', '');
		return $data;
	}

	public function getBills($period)
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "medicine_bill` WHERE bill_date BETWEEN ? AND ? ORDER BY bill_date DESC", array($period['start'], $period['end']));
		return $query->rows;
	}

	public function getChartBills($period)
	{
		$query = $this->database->query("SELECT SUM(amount) AS amount, MONTH(bill_date) AS month FROM `" . DB_PREFIX . "medicine_bill` WHERE bill_date > DATE_SUB(now(), INTERVAL 12 MONTH) GROUP BY MONTH(bill_date)");
		return $query->rows;
	}

	public function getBillsStats($period)
	{
		$query = $this->database->query("SELECT SUM(amount) AS amount, IF(amount > 0, 100, 0) AS p_amount, SUM(discount_value) AS discount, (SUM(discount_value) / SUM(amount)) * 100 AS p_discount,  SUM(tax) AS tax, (SUM(tax) / SUM(amount)) * 100 AS p_tax FROM `" . DB_PREFIX . "medicine_bill` WHERE bill_date between '".$period['start']."' AND '".$period['end']."'");
		$data = $query->row;
		$data['p_discount'] = number_format((float)$query->row['p_discount'], 2, '.', '');
		$data['p_tax'] = number_format((float)$query->row['p_tax'], 2, '.', '');
		return $data;
	}

	public function getExpenses($period)
	{
		$query = $this->database->query("SELECT e.*, et.name AS expense_type FROM `" . DB_PREFIX . "expenses` AS e LEFT JOIN `" . DB_PREFIX . "expense_type` AS et ON et.id = e.expense_type WHERE e.date between '".$period['start']."' AND '".$period['end']."' ORDER BY e.date_of_joining DESC");
		return $query->rows;
	}

	public function getChartExpenses($period)
	{
		$query = $this->database->query("SELECT SUM(amount) AS amount, MONTH(date) AS month FROM `" . DB_PREFIX . "expenses` WHERE date > DATE_SUB(now(), INTERVAL 12 MONTH) GROUP BY MONTH(date)");
		return $query->rows;
	}

	public function getExpensesStats($period)
	{
		$query = $this->database->query("SELECT SUM(amount) AS amount, IF(amount > 0, 100, 0) AS p_amount FROM `" . DB_PREFIX . "expenses` WHERE date between '".$period['start']."' AND '".$period['end']."'");
		return $query->row;
	}

	public function getAccounts()
	{
		$query = $this->database->query("SELECT a.*, SUM(at.credit) AS credit, SUM(at.debit) AS debit FROM `" . DB_PREFIX . "accounts` AS a LEFT JOIN `" . DB_PREFIX . "account_transaction` AS at on at.account_id = a.id GROUP BY a.id ORDER BY a.date_of_joining");
		return $query->rows;
	}

	public function getAccount($id)
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "accounts` WHERE id = ? LIMIT 1", array((int)$id));
		if ($query->num_rows > 0) {
			return $query->row;
		} else {
			return false;
		}
	}

	public function getAccountsStatement($id, $period)
	{
		$query = $this->database->query("SELECT at.*, a.id AS account_id, a.account_name, a.bank_name, a.account_no FROM `" . DB_PREFIX . "account_transaction` AS at LEFT JOIN `" . DB_PREFIX . "accounts` AS a ON a.id = at.account_id WHERE at.account_id = '".(int)$id."' AND at.date between '".$period['start']."' AND '".$period['end']."' ORDER BY date");
		return $query->rows;
	}


	public function getMedicines()
	{
		$query = $this->database->query("SELECT m.*, mc.name AS category_name, SUM(mb.qty) AS qty, SUM(mb.qty) - SUM(mb.sold) AS livestock FROM `" . DB_PREFIX . "medicines` AS m LEFT JOIN `" . DB_PREFIX . "medicine_category` AS mc ON mc.id = m.category LEFT JOIN `" . DB_PREFIX . "medicine_batch` AS mb ON mb.medicine_id = m.id AND mb.expiry > '".date('Y-m')."' GROUP BY m.id ORDER BY m.date_of_joining DESC");
		return $query->rows;
	}

	public function getOutofStock()
	{
		$query = $this->database->query("SELECT m.*, mc.name AS category_name, SUM(mb.qty) - SUM(mb.sold) AS livestock FROM `" . DB_PREFIX . "medicines` AS m LEFT JOIN `" . DB_PREFIX . "medicine_category` AS mc ON mc.id = m.category LEFT JOIN `" . DB_PREFIX . "medicine_batch` AS mb ON mb.medicine_id = m.id AND mb.expiry > '".date('Y-m')."' GROUP BY m.id ORDER BY m.date_of_joining DESC");
		return $query->rows;
	}


	public function getAllIncome($period)
	{
		$query = $this->database->query("SELECT SUM(amount) AS amount, SUM(paid) AS paid, SUM(due) AS due, SUM(discount_value) AS discount, SUM(tax) AS tax FROM `" . DB_PREFIX . "invoice` WHERE invoicedate between '".$period['start']."' AND '".$period['end']."'");
		$data['invoice'] = $query->row;
		$query = $this->database->query("SELECT SUM(amount) AS amount, SUM(discount_value) AS discount, SUM(tax) AS tax FROM `" . DB_PREFIX . "medicine_bill` WHERE bill_date between '".$period['start']."' AND '".$period['end']."'");
		$data['bill'] = $query->row;
		
		$data['amount'] = number_format((float)$data['invoice']['amount'] + $data['bill']['amount'], 2, '.', '');
		$data['paid'] = number_format((float)$data['invoice']['paid'] + $data['bill']['amount'], 2, '.', '');
		$data['tax'] = number_format((float)$data['invoice']['tax'] + $data['bill']['tax'], 2, '.', '');
		$data['due'] = number_format((float)$data['invoice']['due'], 2, '.', '');
		$data['discount'] = number_format((float)$data['invoice']['discount'] + $data['bill']['discount'], 2, '.', '');
		return $data;
	}

	public function getAllExpense($period)
	{
		$query = $this->database->query("SELECT SUM(amount) AS amount FROM `" . DB_PREFIX . "expenses` WHERE date between '".$period['start']."' AND '".$period['end']."'");
		$data['expense'] = number_format((float)$query->row['amount'], 2, '.', '');

		$query = $this->database->query("SELECT SUM(amount) AS amount FROM `" . DB_PREFIX . "staff_payment` WHERE month_year between '".$period['start']."' AND '".$period['end']."'");
		$data['salary'] = number_format((float)$query->row['amount'], 2, '.', '');

		$query = $this->database->query("SELECT SUM(amount) AS amount, SUM(discount_value) AS discount,  SUM(tax) AS tax FROM `" . DB_PREFIX . "medicine_purchase` WHERE date between '".$period['start']."' AND '".$period['end']."'");
		$data['purchase'] = number_format((float)$query->row['amount'], 2, '.', '');

		return $data;
	}

	public function getSalary($period)
	{
		$query = $this->database->query("SELECT sp.*, CONCAT(u.firstname, ' ', u.lastname) AS name FROM `" . DB_PREFIX . "staff_payment` AS sp LEFT JOIN `" . DB_PREFIX . "users` AS u ON u.user_id = sp.staff_id WHERE sp.date_of_joining between '".$period['start']."' AND '".$period['end']."' ORDER BY date_of_joining");
		return $query->rows;
	}
}