<?php

class Product extends Controller
{
	function __construct()
	{
		parent::__construct();
		Session::init();
	}

	function index()
	{
		$this->view->listClass = $this->model->getListClass();
		$this->view->listProduct = $this->model->getLastProduct();

		$this->view->render('product/index');
	}

	function addNew()
	{
		$this->model->addNew();
	}

	function update()
	{
		$this->model->updateDetails();
	}

	function opname()
	{
		$this->model->updateStock();
	}

	function updateClass()
	{
		$this->model->updateClass();
	}

	function updatePublisher()
	{
		$this->model->updatePublisher();
	}

	function updateConsignment()
	{
		$this->model->updateSupplier();
	}

	function delete()
	{
		$this->model->delete();
	}

	function details($id)
	{
		$this->view->detailsProduct = array_shift($this->model->getDetails($id));
		$this->view->listClass = $this->model->getListClass();
		$this->view->render('product/details', true);
	}

	function filter($classes)
	{
		$this->view->listProduct = $this->model->getList($classes);
		$this->view->render('product/filter', true);
	}

	function showFormaddNew()
	{
		$this->view->listClass = $this->model->getListClass();
		$this->view->render('product/addnew', true);
	}

	function xListProduct()
	{
		$this->model->getJsonListProduct();
	}

	function xListProductFilterSupplier()
	{
		$this->model->getJsonListProductFilterSupplier();
	}

	function xListSupplier()
	{
		$this->model->getJsonListSupplier();
	}

	function xListPublisher()
	{
		$this->model->getJsonListPublisher();
	}
}