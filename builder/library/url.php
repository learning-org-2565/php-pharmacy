<?php
require_once DIR_VENDOR.'ezyang/htmlpurifier/library/HTMLPurifier.auto.php';
/**
* URL
*/
class Url
{
	public function __construct()
	{
		$this->get = $this->clean($_GET);
		$this->post = $this->clean($_POST);
		$this->request = $this->clean($_REQUEST);
		$this->cookie = $this->clean($_COOKIE);
		$this->files = $this->clean($_FILES);
		$this->server = $this->clean($_SERVER);
	}

	public function clean($data) {
		if (is_array($data)) {
			foreach ($data as $key => $value) {
				unset($data[$key]);
				$data[$this->clean($key)] = $this->clean($value);
			}
		} else {
			$data = $this->htmlPurify($data);
			// $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
		}

		return $data;
	}

	public function htmlPurify($data)
	{
		$config = \HTMLPurifier_Config::createDefault();
		$purifier = new \HTMLPurifier($config);

		if (is_array($data)) {
			foreach ($data as $key => $value) {
				unset($data[$key]);
				$data[$this->htmlPurify($key)] = $this->htmlPurify($value);
			}
		} else {
			$data = $purifier->purify($data);
		}
		return $data;
	}

	public function noHTML(string $input, string $encoding = 'UTF-8'): string
	{
		return htmlentities($input, ENT_QUOTES | ENT_HTML5, $encoding);
	}

	public function post($key)
	{
		return (isset($_POST[$key])) ? $this->clean($_POST[$key]): false;
	}

	public function get($key)
	{
		return (isset($_GET[$key])) ? $this->clean($_GET[$key]) : false;
	}

	public function file($key)
	{
		return (isset($_FILES[$key])) ?  $_FILES[$key] : false;
	}

	public function request($key)
	{
		if (url::get($key)) {
			return url::get($key);
		}
		elseif (url::post[$key]) {
			return url::post($key);
		}
		else{
			return false;;
		}
	}

	public function build($url, $params = array())
	{
		if (strpos($url, '//')  === false) {
			$prefix = '//'.$GLOBALS['config']['domain'];
		} else {
			$prefix = '';
		}
		$append = '';
		foreach ($params as $key => $param) {
			$append .= ($append == '') ? '?' : '&' ;
			$append .= Urlencode($key). '='.Urlencode($param);
		}
		return $prefix.$append;
	}

	public function redirect($to, $exit = true, $status = 302)
	{
		if (headers_sent()) {
			echo '<script>window.location ='. URL . DIR_ROUTE . $to .'</script>';
		} else {
			header('location: '. URL. DIR_ROUTE . $to, true, $status);
		}

		if ($exit) {
			die();
		}
	}

	public function abs_redirect($to, $exit = true, $status = 302)
	{
		if (empty($to)) {
			$to = URL;
		}
		
		if (headers_sent()) {
			echo '<script>window.location ='. $to .'</script>';
		} else {
			header('location: '. $to, true, $status);
		}

		if ($exit) {
			die();
		}
	}
}