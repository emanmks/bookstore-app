<?php

class Classes extends Controller
{
	function __construct()
	{
		parent::__construct();
		Session::init();
	}

	function index()
	{
		$this->view->listClass = $this->model->getListClass();
		$this->view->render('classes/index');
	}

	function addNewClass()
	{
		$this->model->addNewClass();
	}

	function updateClass()
	{
		$this->model->updateClass();
	}

	function deleteClass()
	{
		$this->model->deleteClass();
	}
}