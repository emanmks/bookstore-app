<?php

class Costumer extends Controller
{
	function __construct()
	{
		parent::__construct();
		Session::init();
	}

	function index()
	{
		$this->view->listCostumer = $this->model->getList();
		$this->view->render('costumer/index');
	}

	function addNew()
	{
		$this->model->addNew();
	}

	function update()
	{
		$this->model->update();
	}

	function delete()
	{
		$this->model->delete();
	}

	function xListCostumer()
	{
		$this->model->getListJson();
	}
}