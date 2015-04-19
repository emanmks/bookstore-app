<?php

class Publisher extends Controller
{
	function __construct()
	{
		parent::__construct();
		Session::init();
	}

	function index()
	{
		$this->view->listPublisher = $this->model->getList();
		$this->view->render('publisher/index');
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