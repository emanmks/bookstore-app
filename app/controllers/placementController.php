<?php

class Placement extends Controller
{
	function __construct()
	{
		parent::__construct();
		Session::init();
	}

	function index()
	{
		$this->view->listPlace = $this->model->getListPlace();
		$this->view->listPlacement = $this->model->getList();
		$this->view->render('placement/index');
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

	function filterPlace($place)
	{
		$this->view->listPlacement = $this->model->getListFilterbyPlace($place);
		$this->view->render('placement/filter', true);
	}

	function filterProduct($product)
	{
		$this->view->listPlacement = $this->model->getListFilterbyProduct($product);
		$this->view->render('placement/filter', true);
	}
}