<?php defined('SYSPATH') or die('No direct script access.');

class Controller_devtools extends Controller {

	public $template;

	public function before()
	{
		$this->template = View::factory('devtools/template');
	}
	
	public function after()
	{
		$this->response->body($this->template->render());
	}

	/**
	 * Dump constants, Kohana::init() settings, loaded modules, and install.php 
	 */
	public function action_info()
	{
		$this->template->content = View::factory('devtools/info');
	}
	
	/**
	 * Show all classes that are getting transparent extended
	 */
	public function action_extension()
	{
		$classes = Arr::flatten(Kohana::list_files('classes'));
	
		$this->template->content = View::factory('devtools/extension',array('classes'=>$classes));
	}
	
	/**
	 * Test a route
	 */
	public function action_routetest()
	{
		// Check if a url was provided
		$url = Arr::get($_POST,'url',FALSE);
		
		if ( ! $url)
		{
			// Try to find a config file
			$url = Kohana::config('route-test');
		}
		$this->template->content = View::factory('devtools/route-test',array(
			// Get all the tests
			'tests' => Route_Tester::create_tests($url),
		));
	}
	
	/**
	 * Dump all routes
	 */
	public function action_routes()
	{
		$this->template->content = View::factory('devtools/route-dump');
	}
	
	/**
	 * Dump all config files
	 */
	public function action_config()
	{
		$files = Kohana::list_files('config');
		
		$configs = array();
		foreach($files as $key => $value)
		{
			// Trim off "config/" and ".php"
			$configs[$key] = substr($key,7,-strlen(EXT));
		}
		
		$this->template->content = View::factory('devtools/config',array('configs'=>$configs));
	}
	
	/**
	 * Dump all message files
	 */
	public function action_message()
	{
		$files = Kohana::list_files('messages');
		
		$messages = array();
		foreach($files as $key => $value)
		{
			// Trim off "messages/" and ".php"
			$messages[$key] = substr($key,9,-strlen(EXT));
		}
		$this->template->content = View::factory('devtools/message',array('messages'=>$messages));
	}
	
	/**
	 * Dump all i18n files
	 */
	public function action_i18n()
	{
		$files = Kohana::list_files('i18n');
		
		$i18n = array();
		foreach($files as $key => $value)
		{
			// Trim off "i18n/" and ".php"
			$i18n[$key] = substr($key,5,-strlen(EXT));
		}
		$this->template->content = View::factory('devtools/i18n',array('i18n'=>$i18n));
	}

}