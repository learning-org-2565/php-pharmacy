<?php
/**
* Doctor Model 
*/
class Doctor extends Model
{
	public function getDoctors($user = NULL)
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "doctors` ORDER BY date_of_joining DESC");
		return $query->rows;
	}

	public function getDoctor($id, $user = NULL)
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "doctors` WHERE id = ? LIMIT 1", array((int)$id));
		if ($query->num_rows > 0) {
			return $query->row;
		} else {
			return false;
		}
	}

	public function updateDoctor($data)
	{
		$this->database->query("UPDATE `" . DB_PREFIX . "doctors` SET `firstname` = ?, `lastname` = ?, `email` = ?, `mobile` = ?, `gender` = ?, `address` = ?, `status` = ? WHERE `id` = ?", array($this->database->escape($data['firstname']), $this->database->escape($data['lastname']), $this->database->escape($data['mail']), $this->database->escape($data['mobile']), $this->database->escape($data['gender']), $data['address'], (int)$data['status'], (int)$data['id']));
		return true;
	}

	public function createDoctor($data)
	{
		$query = $this->database->query("INSERT INTO `" . DB_PREFIX . "doctors` (`firstname`, `lastname`, `email`, `mobile`, `gender`, `address`, `status`, `user_id`, `date_of_joining`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)", array($this->database->escape($data['firstname']), $this->database->escape($data['lastname']), $this->database->escape($data['mail']), $this->database->escape($data['mobile']), $this->database->escape($data['gender']), $data['address'], (int)$data['status'], (int)$data['user_id'], $data['datetime']));
		if ($query->num_rows > 0) {
			return $this->database->last_id();
		} else {
			return false;
		}
	}

	public function deleteDoctor($id)
	{
		$query = $this->database->query("DELETE FROM `" . DB_PREFIX . "doctors` WHERE `id` = ?", array((int)$id));
		return true;
	}

	public function getSearchedDoctor($data)
	{
		$query = $this->database->query("SELECT id, CONCAT(firstname, ' ', lastname) AS label FROM `" . DB_PREFIX . "doctors` WHERE firstname like '%".$this->database->escape($data)."%' LIMIT 5");
		return $query->rows;
	}
}