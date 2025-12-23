<?php

namespace Template;


final class Twig {
	private $twig;
	private $data = array();
	
	public function __construct() {
		// include and register Twig auto-loader
		require_once DIR_BUILDER.'vendor/autoload.php';
	}
	
	public function set($key, $value) {
		$this->data[$key] = $value;
	}
	
	public function render($template, $cache = false) {
		// specify where to look for templates
		$loader = new \Twig\Loader\FilesystemLoader(DIR_APP.'views/');

		// initialize Twig environment
		$config = array('autoescape' => true);

		$twig = new \Twig\Environment($loader, [
			'cache' => false,
			'charset' => 'utf-8',
			'autoescape' => false
		]);

		$twig->addFilter(new \Twig\TwigFilter('html_entity_decode', function($str) {
			return html_entity_decode($str);
		}));

		$ondisk = new \Twig\TwigTest('ondisk', function ($file) {
			if (!empty($file) && file_exists(DIR.'public/uploads/'.$file)) {
				return true;
			} else {
				return false;
			}
		});
		$twig->addTest($ondisk);

		try {
			// load template
			return $twig->render($template.'.twig', $this->data);
		} catch (Exception $e) {
			trigger_error('Error: Could not load template ' . $template . '!');
			exit();	
		}
	}	
}
