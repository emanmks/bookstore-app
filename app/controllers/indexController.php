<?php

class Index extends Controller
{
	function __construct()
	{
		parent::__construct();
		Session::init();
	}
	
	function index()
	{
		$loggedStatus = Session::get('user_loggedIn');
		if($loggedStatus):
			$this->view->totalProduct = array_shift($this->model->getTotalProduct());
			$this->view->totalClass = array_shift($this->model->getTotalClass());
			$this->view->totalCostumer =array_shift( $this->model->getTotalCostumer());
			$this->view->totalSelling = array_shift($this->model->getTodaysSelling());
			$this->view->totalSellingValue = array_shift($this->model->getTodaysSellingValue());
			$this->view->render('home/index');
		else:
			$this->view->render('home/login');
		endif;
	}

	function login()
	{
		$this->model->login();
	}

	function logout()
	{
		Session::destroy();
	}
}