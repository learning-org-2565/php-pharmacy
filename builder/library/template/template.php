<?php
namespace Template;

require_once DIR_LIBRARY.'htmlpurifier/HTMLPurifier.auto.php';
final class Template {
	private $data = array();

	public function set($key, $value) {
		$this->data[$key] = $value;
	}

	public function render($template) {
		$file = DIR_VIEW.$template.'.tpl.php';
		// $this->data = $this->htmlPurify($this->data);

		if (is_file($file)) {
			extract($this->data);
			ob_start();
			require($file);
			return ob_get_clean();
		}
		throw new \Exception('Error: Could not load template ' . $file . '!');
		exit();
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
			if (!empty($data)) {
				$data = $purifier->purify($data);
			}
		}
		return $data;
	}

	public function filterData($data)
	{
		if (is_array($data)) {
			foreach ($data as $key => $value) {
				unset($data[$key]);
				$data[$this->filterData($key)] = $this->filterData($value);
			}
		} else {
			if (!empty($data)) {
				$data = self::noHTML($data);
			}
		}

		return $data;
	}

	public static function noHTML($input, string $encoding = 'UTF-8')
	{
		return htmlspecialchars($input, ENT_QUOTES | ENT_HTML5, $encoding);
	}
}
