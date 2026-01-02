<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2019, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2019, British Columbia Institute of Technology (https://bcit.ca/)
 * @license	https://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Application Controller Class
 *
 * This class object is the super class that every library in
 * CodeIgniter will be assigned to.
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		EllisLab Dev Team
 * @link		https://codeigniter.com/user_guide/general/controllers.html
 */
class CI_Controller {

	/**
	 * Reference to the CI singleton
	 *
	 * @var	object
	 */
	private static $instance;

	/**
	 * CI_Loader
	 *
	 * @var	CI_Loader
	 */
	public $load;
		private $requestData;


	/**
	 * Class constructor
	 *
	 * @return	void
	 */
	public function __construct()
	{
		self::$instance =& $this;

		// Assign all the class objects that were instantiated by the
		// bootstrap file (CodeIgniter.php) to local class variables
		// so that CI can run as one big super object.
		foreach (is_loaded() as $var => $class)
		{
			$this->$var =& load_class($class);
		}
		
		// Check if the request contains JSON data
	    if (isset($_SERVER['CONTENT_TYPE']) && $_SERVER['CONTENT_TYPE'] === 'application/json') {
			// Parse JSON data
			$d = file_get_contents('php://input');
			$this->requestData = json_decode($d, true);
		} else {
			// Parse form data
			$this->requestData = array_merge($_POST ?? [], $_GET ?? []); // or use $this->input->post()
		}

		if (!empty($_FILES)) {
			foreach ($_FILES as $field => $file) {
				$this->requestData[$field] = $file;
			}
		}

		$this->load =& load_class('Loader', 'core');
		$this->load->initialize();
		log_message('info', 'Controller Class Initialized');
	}

	// --------------------------------------------------------------------

	/**
	 * Get the CI singleton
	 *
	 * @static
	 * @return	object
	 */
	public static function &get_instance()
	{
		return self::$instance;
	}
	
	/**
	 * Sending json responses to http client
	 * 
	 * @param mixed $data Expects an array otherwise, will be converted to array anyway.
	 * @param integer $status Response code, default is 200 (OK). Optional.
	 * @param array $customHeaders Set/add custom headers to your http response. Optional.
	 * @return boolean Indicates the success/failure of the operation.
	 */
	protected function json_response($data, $status = 200, $customHeaders = []) {
		try {
			if(is_array($customHeaders)) {
				foreach($customHeaders as $headerName => $headerValue) {
					$this->output->set_header("$headerName: $headerValue");
				}
			}

			$data = match($data) {
				null => 'null',
				true => 'true',
				false => 'false',
				default => $data,
			};
			
			$this->output->set_status_header($status);
			$this->output->set_content_type('application/json');
			$this->output->set_output(is_array($data) ? json_encode($data) : $data);
			return true;
		} catch(Exception $e) {
			$this->output->set_status_header(500);
			$this->output->set_output('An error has occured while processing the response.');
			return false;
		}
    }

	/**
	 * Get request data
	 */
	protected function request($key = null) {
		if($key === null) {
			return $this->requestData;
		}

		if(!is_array($key)) {
			return $this->requestData[$key] ?? null;
		} 

		$data = [];
		foreach($key as $k) {
			$data[$k] = $this->requestData[$k] ?? null;
		}

		return $data;
	} 

	/**
	 * Checking request method types
	 */
	protected function is_post_request() {
		return $_SERVER['REQUEST_METHOD'] === 'POST';
	}

	protected function is_get_request() {
		return $_SERVER['REQUEST_METHOD'] === 'GET';
	}

}
