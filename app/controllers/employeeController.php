<?php

class Employee extends Controller
{
	function __construct()
	{
		parent::__construct();
		Session::init();
	}

	function index()
	{
		$this->view->listEmployee = $this->model->getList();
		$this->view->render('employee/index');
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
}