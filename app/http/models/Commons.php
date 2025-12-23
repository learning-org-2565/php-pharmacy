<?php

/**
* Commmons Model
*/
class Commons extends Model
{
	public function getCommonData($user_id)
	{
		$data['user'] = $this->getUserInfo($user_id);
		$data['info'] = $this->getSiteInfo();
		$data['theme'] = $this->getTheme();
		$data['page_search'] = $this->user_agent->hasPermission('customers');
		$data['new_bill'] = $this->user_agent->hasPermission('medicine/billing/add');
		$data['new_purchase'] = $this->user_agent->hasPermission('medicine/purchase/add');
		$data['new_transaction'] = $this->user_agent->hasPermission('account/transaction/add');
		$data['new_customer'] = $this->user_agent->hasPermission('customer/add');
		$data['live_stock'] = $this->user_agent->hasPermission('medicine/stock');
		$data['token'] = hash('sha512', TOKEN . TOKEN_SALT);
		$data['admin_menu'] = $this->createAdminMenu();
		return $data;
	}

	public function getUserInfo($user_id)
	{
		//$query = $this->database->query("SELECT u.user_id, u.firstname, u.lastname, u.picture, ur.id AS role_id, ur.name AS role, ur.permission, d.id AS doctor FROM `" . DB_PREFIX . "users` AS u LEFT JOIN `" . DB_PREFIX . "user_role` AS ur ON ur.id = u.user_role LEFT JOIN `" . DB_PREFIX . "doctors` AS d ON d.user_id = u.user_id WHERE u.user_id = ?", array((int)$user_id));
		$data = $this->user_agent->getUserData();
		if (!empty($data['picture']) && file_exists(DIR.'public/uploads/'.$data['picture'])) {
			$data['picture'] = 'public/uploads/'.$data['picture'];
		} else {
			$data['picture'] = false;
		}
		return $data;
	}

	public function getTheme()
	{
		$data = $this->user_agent->getTheme();
		if (!empty($data['logo']) && file_exists(DIR.'public/uploads/'.$data['logo'])) {
			$data['logo'] = 'public/uploads/'.$data['logo'];
		} else {
			$data['logo'] = 'public/images/logo.png';
		}
		if (!empty($data['logo']) && file_exists(DIR.'public/uploads/'.$data['logo_icon'])) {
			$data['logo_icon'] = 'public/uploads/'.$data['logo_icon'];
		} else {
			$data['logo_icon'] = 'public/images/icon.png';
		}
		if (!empty($data['favicon']) && file_exists(DIR.'public/uploads/'.$data['favicon'])) {
			$data['favicon'] = 'public/uploads/'.$data['favicon'];
		} else {
			$data['favicon'] = 'public/images/logo.png';
		}

		return $data;
	}

	public function getSiteInfo()
	{
		$data = $this->user_agent->getInfo();
		if (!empty($data['logo']) && file_exists(DIR.'public/uploads/'.$data['logo'])) {
			$data['logo'] = 'public/uploads/'.$data['logo'];
		} else {
			$data['logo'] = 'public/images/logo.png';
		}
		if (!empty($data['favicon']) && file_exists(DIR.'public/uploads/'.$data['favicon'])) {
			$data['favicon'] = 'public/uploads/'.$data['favicon'];
		} else {
			$data['favicon'] = 'public/images/logo.png';
		}

		$data['picker_date_format'] = str_replace(['d', 'm', 'Y'], ['dd', 'mm', 'yy'], $data['date_format']);
		$data['picker_my_format'] = str_replace(['m', 'Y'], ['mm', 'yy'], $data['date_my_format']);
		$data['range_my_format'] = str_replace(['m', 'Y'], ['MM', 'YYYY'], $data['date_my_format']);
		$data['range_date_format'] = str_replace(['d', 'm', 'Y'], ['DD', 'MM', 'YYYY'], $data['date_format']);
		
		$data['url'] = URL;
		$data['dir_route'] = DIR_ROUTE;
		$data['url_route'] = URL.DIR_ROUTE;

		return $data;
	}

	public function getAdminTheme()
	{
		$query = $this->database->query("SELECT `data` FROM `" . DB_PREFIX . "setting` WHERE `name` = ?", array('admintheme'));
		$data = json_decode($query->row['data'], true);
		if (!empty($data['logo']) && file_exists(DIR.'public/uploads/'.$data['logo'])) {
			$data['logo'] = 'public/uploads/'.$data['logo'];
		} else {
			$data['logo'] = 'public/images/logo.png';
		}
		if (!empty($data['favicon']) && file_exists(DIR.'public/uploads/'.$data['favicon'])) {
			$data['favicon'] = 'public/uploads/'.$data['favicon'];
		} else {
			$data['favicon'] = 'public/images/logo.png';
		}
		return $data;
	}

	public function getMailInfo()
	{
		$query = $this->database->query("SELECT `data` FROM `" . DB_PREFIX . "setting` WHERE `name` = ?", array('emailsetting'));
		return json_decode($query->row['data'], true);
	}

	public function getAppointmentDoctors()
	{
		$query = $this->database->query("SELECT d.id, CONCAT(d.firstname, ' ', d.lastname) AS name, d.weekly, d.national, dep.name AS department, dep.id AS department_id FROM `" . DB_PREFIX . "doctors` AS d LEFT JOIN `" . DB_PREFIX . "departments` AS dep ON dep.id = d.department_id WHERE d.appointment_status = ? ORDER BY d.department_id ASC", array(1));
		return $query->rows;
	}

	public function getInvoiceData()
	{
		return $this->user_agent->getInfo();
	}
	
	public function getUserData($id)
	{
		$query = $this->database->query("SELECT `firstname`, `lastname` FROM `" . DB_PREFIX . "users` WHERE `user_id` = ?", array((int)$id));
		if ($query->num_rows > 0) {
			return $query->row['firstname'].' '.$query->row['lastname'];
		} else {
			return '';
		}
	}

	public function getTemplateAndInfo($id)
	{
		$query = $this->database->query("SELECT subject, message FROM `" . DB_PREFIX . "email_template` WHERE `template` = ? LIMIT 1", array($id));
		$data['template'] = $query->row;
		$data['common'] = $this->user_agent->getInfo();
		return $data;
	}

	public function createAdminMenu()
	{
		$tree = array();
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "menu` WHERE `status` = ? ORDER BY `priority` DESC", array(1));
		$list = $query->rows;
		if (!empty($list)) {
			$active = $this->activeMenuList($this->url->get('route'));
			foreach ($list as $key => $value) {
				if ($value['link'] == '#' || $this->user_agent->hasPermission($value['link'])) {
					if ($value['parent'] == 0) {
						$tree[$value['id']] = $value;
						if ($value['active'] == $active) {
							$tree[$value['id']]['active_menu'] = 1;
						}
					} else {
						$tree[$value['parent']]['child'][$value['id']] = $value;
					}
				}
			}
		}

		$menu = '<ul>';
		if (!empty($tree)) {
			foreach ($tree as $key => $value) { 
				if (isset($value['child']) && isset($value['link']) && $value['link'] == '#') {
					if (isset($value['active_menu'])) { $active = ' active'; } else { $active = ''; }
					$menu .= '<li class="has-sub'.$active.'"><a><i class="'.$value['icon'].'"></i><span>'.$value['name'].'</span><i class="arrow"></i></a><ul class="sub-menu">';
					foreach ($value['child'] as $s_key => $s_value) {
						$menu .= '<li><a href="'.URL.DIR_ROUTE.$s_value['link'].'"><span>'.$s_value['name'].'</span></a></li>';
					}
					$menu .= '</ul></li>';
				} elseif (isset($value['link']) && $value['link'] != '#') {
					if (isset($value['active_menu'])) { $active = 'active'; } else { $active = ''; }
					$menu .= '<li class="'.$active.'"><a href="'.URL.DIR_ROUTE.$value['link'].'"><i class="'.$value['icon'].'"></i><span>'.$value['name'].'</span></a></li>';
				}
			}
		}
		$menu .= '</ul>';
		
		return $menu;
	}

	public function activeMenuList($key)
	{
		$data = array(
			'dashboard' => 'dashboard',
			'customers' => 'customers',
			'customer/view' => 'customers',
			'customer/add' => 'customers',
			'customer/edit' => 'customers',
			'noticeboard' => 'noticeboard',
			'noticeboard/view' => 'noticeboard',
			'noticeboard/add' => 'noticeboard',
			'noticeboard/edit' => 'noticeboard',
			'accounts' => 'accounts',
			'account/add' => 'accounts',
			'account/edit' => 'accounts',
			'account/transactions' => 'accounts',
			'account/transaction/add' => 'accounts',
			'account/transaction/edit' => 'accounts',
			'users' => 'users',
			'user/add' => 'users',
			'user/edit' => 'users',
			'role' => 'users',
			'role/add' => 'users',
			'role/edit' => 'users',
			'invoices' => 'invoices',
			'invoice/view' => 'invoices',
			'invoice/add' => 'invoices',
			'invoice/edit' => 'invoices',
			'staffattendance' => 'staffattendance',
			'staffattendance/add' => 'staffattendance',
			'staffattendance/edit' => 'staffattendance',
			'staffattendance/view' => 'staffattendance',
			'medicines' => 'pharmacy',
			'reports' => 'reports',
			'medicine/view' => 'pharmacy',
			'medicine/add' => 'pharmacy',
			'medicine/edit' => 'pharmacy',
			'medicine/billing' => 'billing',
			'medicine/billing/add' => 'billing',
			'medicine/billing/edit' => 'billing',
			'medicine/billing/view' => 'billing',
			'medicine/purchase' => 'purchase',
			'medicine/purchase/add' => 'purchase',
			'medicine/purchase/edit' => 'purchase',
			'medicine/purchase/view' => 'purchase',
			'medicine/category' => 'settings',
			'medicine/stock' => 'stockadjustment',
			'salarytemplate' => 'payroll',
			'salarytemplate/add' => 'payroll',
			'salarytemplate/edit' => 'payroll',
			'makepayment' => 'payroll',
			'makepayment/add' => 'payroll',
			'managesalary' => 'payroll',
			'managesalary/view' => 'payroll',
			'managesalary/edit' => 'payroll',
			'managesalary/history' => 'payroll',
			'managesalary/history/view' => 'payroll',
			'expenses' => 'expenses',
			'expense/add' => 'expenses',
			'expense/edit' => 'expenses',
			'expensetype' => 'settings',
			'doctors' => 'settings',
			'doctor/add' => 'settings',
			'doctor/edit' => 'settings',
			'subscribers' => 'subscribers',
			'subscriber/add' => 'subscribers',
			'subscriber/edit' => 'subscribers',
			'info' => 'settings',
			'paymentmethod' => 'settings',
			'tax' => 'settings',
			'paymentgateway' => 'settings',
			'suppliers' => 'settings',
			'items' => 'settings',
			'send/email' => 'email',
			'sendbulk/email' => 'email',
			'emaillogs' => 'email',
			'emailtemplate' => 'email',
			'emailsetting' => 'email',
			'customization' => 'customization'
		);
		if (isset($data[$key])) {
			return $data[$key];
		} else {
			return false;
		}
	}
}