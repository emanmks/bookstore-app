<?php

class Retail extends Controller
{
	function __construct()
	{
		parent::__construct();
		Session::init();
	}

	function index()
	{
		$this->view->listTransaction = $this->model->getListTransaction(date('Y-m-d'),date('Y-m-d'));
		$this->view->render('retail/index');
	}

	function details($selling)
	{
		$this->view->detailSelling = array_shift($this->model->getSellingDetails($selling));
		$this->view->listTransaction = $this->model->getListTransactionDetails($selling);
		$this->view->render('retail/details', true);
	}

	function newSelling()
	{
		$this->model->addNew();
	}

	function newTransaction($id)
	{
		$this->view->detailSelling = array_shift($this->model->getSellingDetails($id));
		$this->view->listTransaction = $this->model->getListTransactionDetails($id);
		$this->view->render('retail/transaction', true);
	}

	function addDetails()
	{
		$this->model->addNewDetails();
	}

	function reloadPage($selling)
	{
		$this->view->listTransaction = $this->model->getListTransactionDetails($selling);
		$this->view->render('retail/filterdetails', true);
	}

	function filterByProduct($product)
	{
		$this->view->listTransaction = $this->model->getListTransaction();
		$this->view->render('retail/filter', true);
	}

	function filterByDate($date)
	{
		$this->view->listTransaction = $this->model->getListTransaction($date,$date);
		$this->view->render('retail/filter', true);
	}

	function deleteDetails()
	{
		$this->model->deleteDetails();
	}

	function closeSelling($selling)
	{
		$this->model->closeSelling($selling);
	}

	function closing($url)
	{
		$param = explode('_', $url);
		$selling = $param[0];
		$payment = $param[1];

		$this->closeSelling($selling);
		$this->view->detailSelling = array_shift($this->model->getSellingDetails($selling));
		$this->view->payment = $payment;
		$this->view->listTransaction = $this->model->getListTransactionDetails($selling);
		$this->view->render('retail/receipt');
	}

	function reClosing($url)
	{
		$param = explode('_', $url);
		$selling = $param[0];
		$payment = $param[1];

		$this->view->detailSelling = array_shift($this->model->getSellingDetails($selling));
		$this->view->payment = $payment;
		$this->view->listTransaction = $this->model->getListTransactionDetails($selling);
		$this->view->render('retail/receipt');
	}
}