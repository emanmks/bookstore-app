<?php

class Supplier extends Controller
{
	function __construct()
	{
		parent::__construct();
		Session::init();
	}

	function index()
	{
		$this->view->listSupplier = $this->model->getList();
		$this->view->render('supplier/index');
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

	function xListSupplier()
	{
		$this->model->getJsonListSupplier();
	}
}