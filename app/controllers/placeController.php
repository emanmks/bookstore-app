<?php

class Place extends Controller
{
	function __construct()
	{
		parent::__construct();
		Session::init();
	}

	function index()
	{
		$this->view->listPlace = $this->model->getList();
		$this->view->render('place/index');
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