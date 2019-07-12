<?php
/**
 * 
 */
class Guest extends Application
{
	public function __construct()
	{
	}

	public function index()
	{
		http_response_code(200);
		$print = [
			'Fase 2 - Online Application Development (9-14 Juli 2019, dikerjakan secara online)',
			'Muhammad Idrus (muhammadidrus919@gmail.com)'
		];

		echo json_encode($print);
	}
}