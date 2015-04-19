<?php

class User extends Controller
{
	function __construct()
	{
		parent::__construct();
		Session::init();
	}

	function index()
	{
		$this->view->listUser = $this->model->getList();
		$this->view->listEmployee = $this->model->getListEmployee();
		$this->view->render('user/index');
	}

	function addNew()
	{
		$this->model->addNew();
	}

	function updateDetails()
	{
		$this->model->updateDetails();
	}

	function updatePassword()
	{
		$this->model->updatePassword();
	}

	function delete()
	{
		$this->model->delete();
	}

}