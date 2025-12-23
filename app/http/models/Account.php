<?php

/**
 * Account
 */
class Account extends Model
{
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

	public function updateAccount($data)
	{
		$this->database->query("UPDATE `" . DB_PREFIX . "accounts` SET `bank_name` = ?, `account_name` = ?, `account_no` = ?, `initial_balance` = ?, `contact_person` = ?, `contact_person_phone` = ?, `bank_url` = ?, `address` = ?, `status` = ? WHERE `id` = ?", array($this->database->escape($data['bank_name']), $this->database->escape($data['account_name']), $this->database->escape($data['account_no']), $this->database->escape($data['initial_balance']), $this->database->escape($data['contact_person']), $this->database->escape($data['contact_person_phone']), $data['bank_url'], $data['address'], (int)$data['status'], (int)$data['id']));
		return true;
	}

	public function createAccount($data)
	{
		$query = $this->database->query("INSERT INTO `" . DB_PREFIX . "accounts` (`bank_name`, `account_name`, `account_no`, `initial_balance`, `contact_person`, `contact_person_phone`, `bank_url`, `address`, `status`, `user_id`, `date_of_joining`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", array($this->database->escape($data['bank_name']), $this->database->escape($data['account_name']), $this->database->escape($data['account_no']), $this->database->escape($data['initial_balance']), $this->database->escape($data['contact_person']), $data['contact_person_phone'], $data['bank_url'], $data['address'], (int)$data['status'], (int)$data['user_id'], $data['datetime']));
		if ($query->num_rows > 0) {
			return $this->database->last_id();
		} else {
			return false;
		}
	}

	public function createAccountTransaction($data)
	{
		$this->database->query("INSERT INTO `" . DB_PREFIX . "account_transaction` (`date`, `credit`, `description`, `transaction_type`, `account_id`, `user_id`, `date_of_joining`) VALUES (?, ?, ?, ?, ?, ?, ?)", array(date('Y-m-d'), $this->database->escape($data['initial_balance']), 'Initial Balance', 2, $data['id'], (int)$data['user_id'], $data['datetime']));
		return true;
	}

	public function deleteAccount($id)
	{
		$this->database->query("DELETE FROM `" . DB_PREFIX . "account_transaction` WHERE `account_id` = ?", array((int)$id));
		$this->database->query("DELETE FROM `" . DB_PREFIX . "accounts` WHERE `id` = ?", array((int)$id));
		return true;
	}


	public function getPaymentMethod()
	{
		$query = $this->database->query("SELECT id, name FROM `" . DB_PREFIX . "payment_method`");
		return $query->rows;
	}

	public function getTransactions($period)
	{
		$query = $this->database->query("SELECT at.*, a.account_name, a.bank_name, a.account_no FROM `" . DB_PREFIX . "account_transaction` AS at LEFT JOIN `" . DB_PREFIX . "accounts` AS a ON a.id = at.account_id WHERE at.date between '".$period['start']."' AND '".$period['end']."' ORDER BY at.date DESC");
		return $query->rows;
	}

	public function getTransactionAccounts()
	{
		$query = $this->database->query("SELECT id, bank_name, account_name FROM `" . DB_PREFIX . "accounts`");
		return $query->rows;
	}

	public function getTransaction($id)
	{
		$query = $this->database->query("SELECT at.*, a.account_name, a.bank_name, a.account_no FROM `" . DB_PREFIX . "account_transaction` AS at LEFT JOIN `" . DB_PREFIX . "accounts` AS a ON a.id = at.account_id WHERE at.id = ? LIMIT 1", array((int)$id));
		
		if ($query->num_rows > 0) {
			return $query->row;
		} else {
			return false;
		}
	}

	public function updateTransaction($data)
	{
		$this->database->query("UPDATE `" . DB_PREFIX . "account_transaction` SET `date` = ?, `amount` = ?, `code` = ?, `description` = ?, `transaction_type` = ?, `method` = ?, `account_id` = ? WHERE `id` = ?", array($this->database->escape($data['date']), $this->database->escape($data['amount']), $this->database->escape($data['code']), $data['description'], $this->database->escape($data['transaction_type']), $data['method'], $data['account_id'], (int)$data['id']));
		return true;
	}

	public function createTransaction($data)
	{
		if ($data['transaction_type'] == '1') {
			$query = $this->database->query("INSERT INTO `" . DB_PREFIX . "account_transaction` (`date`, `debit`, `code`, `description`, `transaction_type`, `method`, `account_id`, `user_id`, `date_of_joining`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)", array($this->database->escape($data['date']), $this->database->escape($data['amount']), $this->database->escape($data['code']), $data['description'], $this->database->escape($data['transaction_type']), $data['method'], $data['account_id'], (int)$data['user_id'], $data['datetime']));	
		} elseif ($data['transaction_type'] == '2') {
			$query = $this->database->query("INSERT INTO `" . DB_PREFIX . "account_transaction` (`date`, `credit`, `code`, `description`, `transaction_type`, `method`, `account_id`, `user_id`, `date_of_joining`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)", array($this->database->escape($data['date']), $this->database->escape($data['amount']), $this->database->escape($data['code']), $data['description'], $this->database->escape($data['transaction_type']), $data['method'], $data['account_id'], (int)$data['user_id'], $data['datetime']));
		}
		
		if ($query->num_rows > 0) {
			return $this->database->last_id();
		} else {
			return false;
		}
	}

	public function deleteTransaction($id)
	{
		$this->database->query("DELETE FROM `" . DB_PREFIX . "account_transaction` WHERE `id` = ?", array((int)$id));
		return true;
	}
}