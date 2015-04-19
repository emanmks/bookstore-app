<?php

class Returnment extends Controller
{
	function __construct()
	{
		parent::__construct();
		Session::init();
	}

	function index()
	{
		$this->view->listReturnment = $this->model->getList();
		$this->view->render('returnment/index');
	}

	function addNew()
	{
		$this->model->addNew();
	}

	function transactions($returnment)
	{
		$this->view->returnmentDetails = array_shift($this->model->getDetails($returnment));
		$this->view->listDetails = $this->model->getListDetails($returnment);
		$this->view->render('returnment/transaction', true);
	}

	function addProduct()
	{
		$this->model->addNewDetails();
	}

	function deleteProduct()
	{
		$this->model->deleteDetails();
	}

	function details($returnment)
	{
		$this->view->returnmentDetails = array_shift($this->model->getDetails($returnment));
		$this->view->listDetails = $this->model->getListDetails($returnment);
		$this->view->render('returnment/details', true);
	}

	function printDetails($returnment)
	{
		$this->view->returnmentDetails = array_shift($this->model->getDetails($returnment));
		$this->view->listDetails = $this->model->getListDetails($returnment);
		$this->view->render('returnment/details', true);
	}
}