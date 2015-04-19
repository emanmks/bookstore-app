<?php

class Supply extends Controller
{
	function __construct()
	{
		parent::__construct();
		Session::init();
	}

	function index()
	{
		$this->view->listSupply = $this->model->getList();
		$this->view->render('supply/index');
	}

	function addNew()
	{
		$this->model->addNew();
	}

	function cancel()
	{
		$this->model->delete();
	}

	function productHistory($product)
	{
		$this->view->listSupply = $this->model->getListFilterByProduct($product);
		$this->view->render('supply/filter', true);
	}

	function dateHistory($url)
	{
		$param = explode("_", $url);
		$first = $param[0];
		$last = $param[1];

		$this->view->listSupply = $this->model->getListFilterByDate($first, $last);
		$this->view->render('supply/filter', true);
	}
}