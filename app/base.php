<?php
/**
 * 
 */
class Application
{
	private $uri;
	private $config = [];

	public function __construct($uri, $config)
	{
		$this->uri = $uri;
		$this->config = $config;

		$this->header();
		$this->auth();
	}

	public function controller($class)
	{
		$file = 'app/controller/'. $this->uri['controller'] .'.php';

		if(!file_exists($file)) {
			http_response_code(405);
			echo json_encode('Method not allowed!');
			die();
		}

		require_once($file);

		$controller = new $class();
		if (method_exists($controller, $this->uri['function'])) { 
			$controller->{$this->uri['function']}($this->uri['param']);
		}
		else {
			if ($this->uri['function']) {
				http_response_code(404);
				echo json_encode('Method not allowed!');
			}
			else {
				$controller->index();
			}
		}
	}

	public function model($model)
	{
		require_once('model/'.$model.'.php');

		// connect database
		$dbconnect = new DBConnect();
		$connection = $dbconnect->getConnection();

		$this->$model = new $model($connection);
	}

	protected function header()
	{
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json");
		header("Access-Control-Allow-Methods: OPTIONS, GET, POST, PUT, DELETE");
		header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
	}

	public function auth()
	{
		if (!isset($_SERVER['HTTP_AUTHORIZATION'])) {
			http_response_code(401);
			echo json_encode('Unauthorized!');
			die;
		}

		$token = substr($_SERVER['HTTP_AUTHORIZATION'], 6);

		if ($token != $this->config['token']) {
			http_response_code(401);
			echo json_encode('Unauthorized!');
			die;
		}
	}
}