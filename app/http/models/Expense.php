<?php

/**
* Expense
*/
class Expense extends Model
{

	public function getExpenses($period, $user = NULL)
	{
		$query = $this->database->query("SELECT e.*, et.name AS expense_type FROM `" . DB_PREFIX . "expenses` AS e LEFT JOIN `" . DB_PREFIX . "expense_type` AS et ON et.id = e.expense_type WHERE e.date between '".$period['start']."' AND '".$period['end']."' ORDER BY e.date_of_joining DESC");
		return $query->rows;
	}

	public function getExpense($id, $user = NULL)
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "expenses` WHERE `id` = ? LIMIT 1", array((int)$id));
		return $query->row;
	}
	
	public function expensesType()
	{
		$query = $this->database->query("SELECT `id`, `name` FROM `" . DB_PREFIX . "expense_type` WHERE `status` = ? ", array(1));
		return $query->rows;
	}

	public function getReceipt($id)
	{
		$query = $this->database->query("SELECT `id`, `file`, `ext` FROM `" . DB_PREFIX . "attached_files` WHERE `type` = ? AND `type_id` = ?", array('expense', $id));
		return $query->rows;
	}

	public function paymentMethod()
	{
		$query = $this->database->query("SELECT `id`, `name` FROM `" . DB_PREFIX . "payment_method` WHERE `status` = ? ", array(1));
		return $query->rows;
	}

	public function updateExpense($data)
	{
		$query = $this->database->query("UPDATE `" . DB_PREFIX . "expenses` SET `name` = ?, `expense_type` = ?, `amount` = ?, `method` = ?, `date` = ?, `description` = ? WHERE `id` = ?", array($this->database->escape($data['name']), (int)$data['expensetype'], $this->database->escape($data['amount']), (int)$data['method'], $data['date'], $data['description'], (int)$data['id']));
		
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function createExpense($data)
	{
		$query = $this->database->query("INSERT INTO `" . DB_PREFIX . "expenses` (`name`, `expense_type`, `amount`, `method`, `date`, `description`, `user_id`, `date_of_joining`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)", array( $this->database->escape($data['name']), (int)$data['expensetype'], $this->database->escape($data['amount']), (int)$data['method'], $this->database->escape($data['date']), $data['description'], (int)$data['user_id'], $data['datetime']));
		
		if ($query->num_rows > 0) {
			return $this->database->last_id();
		} else {
			return false;
		}
	}

	public function deleteExpense($id)
	{
		$query = $this->database->query("DELETE FROM `" . DB_PREFIX . "expenses` WHERE `id` = ?", array((int)$id ));
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}
}