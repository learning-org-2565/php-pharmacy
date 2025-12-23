<?php

/**
 * Patient.php
 */
class Customer extends Model
{
	public function getCustomers($period, $doctor = NULL)
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "customers` WHERE `date_of_joining` BETWEEN '".$period['start']."' AND '".$period['end']."' ORDER BY `date_of_joining` DESC");		
		return $query->rows;
	}

	public function getCustomer($id, $doctor = NULL)
	{
		$query = $this->database->query("SELECT *, TIMESTAMPDIFF(YEAR, dob, CURDATE()) AS age FROM `" . DB_PREFIX . "customers` WHERE `id` = ? ORDER BY `date_of_joining` DESC", array((int)$id));
		return $query->row;
	}

	public function getInvoices($data)
	{
		$query = $this->database->query("SELECT i.* FROM `" . DB_PREFIX . "invoice` AS i WHERE i.customer_id = ? OR i.email = ? ORDER BY i.invoicedate DESC LIMIT 20", array((int)$data['id'], $data['email']));
		return $query->rows;
	}

	public function getBills($data)
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "medicine_bill` WHERE customer_id = ? OR email = ? ORDER BY bill_date DESC LIMIT 20", array((int)$data['id'], $data['email']));
		return $query->rows;
	}

	public function getDocuments($data)
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "reports` WHERE patient_id = ? OR email = ? ORDER BY date_of_joining DESC", array((int)$data['id'], $data['email']));
		return $query->rows;
	}

	public function checkCustomerEmail($mail, $id = NULL)
	{
		if (!empty($id)) {
			$query = $this->database->query("SELECT count(*) AS total FROM `" . DB_PREFIX . "customers` WHERE `email` = ? AND id != ?", array($this->database->escape($mail), (int)$id));
		} else {
			$query = $this->database->query("SELECT count(*) AS total FROM `" . DB_PREFIX . "customers` WHERE `email` = ? ", array($this->database->escape($mail)));
		}

		if ($query->num_rows > 0) {
			return $query->row['total'];
		} else{
			return false;
		}
	}

	public function createCustomer($data)
	{
		$query = $this->database->query("INSERT INTO `" . DB_PREFIX . "customers` (`firstname`, `lastname`, `email`, `mobile`, `address`, `bloodgroup`, `gender`, `dob`, `status`, `user_id`, `date_of_joining`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", array($this->database->escape($data['firstname']), $this->database->escape($data['lastname']), $this->database->escape($data['mail']), $this->database->escape($data['mobile']), $this->database->escape($data['address']), $this->database->escape($data['bloodgroup']), $this->database->escape($data['gender']), $data['dob'], 1, (int)$data['user_id'], $data['datetime']));
		if ($this->database->error()) {
			return false;
		} else {
			return $this->database->last_id();
		}
	}

	public function updateCustomer($data)
	{
		$query = $this->database->query("UPDATE `" . DB_PREFIX . "customers` SET `firstname` = ?, `lastname` = ?, `email` = ?, `mobile` = ?, `address` = ?, `bloodgroup` = ?, `gender` = ?, `dob` = ?, `status` = ? WHERE `id` = ?" , array($this->database->escape($data['firstname']), $this->database->escape($data['lastname']), $this->database->escape($data['mail']), $this->database->escape($data['mobile']), $data['address'], $this->database->escape($data['bloodgroup']), $this->database->escape($data['gender']), $data['dob'], $data['status'], (int)$data['id']));
	}

	public function getSearchedCustomer($data)
	{
		$query = $this->database->query("SELECT id, CONCAT(firstname, ' ', lastname) AS label, email, mobile FROM `" . DB_PREFIX . "customers` WHERE firstname like '%".$data."%' OR lastname like '%".$this->database->escape($data)."%' OR mobile like '%".$this->database->escape($data)."%' LIMIT 7");
		return $query->rows;
	}

	public function deleteCustomer($id)
	{
		$query = $this->database->query("DELETE FROM `" . DB_PREFIX . "customers` WHERE `id` = ?", array((int)$id));
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}
}