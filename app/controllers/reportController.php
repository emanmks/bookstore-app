<?php

class Report extends Controller
{
	function __construct()
	{
		parent::__construct();
		Session::init();
	}

	function retail($url = '')
	{
		if($url == '')
		{
			$this->view->firstDate = date('Y-m-d');
			$this->view->lastDate = date('Y-m-d');
			$this->view->listRetail = $this->model->getListRetail(date('Y-m-d'),date('Y-m-d'));
			$this->view->render('report/retail/index');
		}
		else
		{
			$param = explode('_', $url);
			$first = $param[0];
			$last = $param[1];
			$this->view->firstDate = $first;
			$this->view->lastDate = $last;
			$this->view->listRetail = $this->model->getListRetail($first,$last);
			$this->view->render('report/retail/index',true);
		}
	}

	function retailDaily($date)
	{
		$this->view->listRetail = $this->model->getListDailyRetail($date);
		$this->view->date = $date;
		$this->view->render('report/retail/daily', true);
	}

	function retailDetails($id)
	{
		$this->view->listDetails = $this->model->getListRetailDetails($id);
		$this->view->retailDetails = array_shift($this->model->getRetailDetails($id));
		$this->view->render('report/retail/details', true);
	}


	/**
	 * Wholesale Report
	 */
	function wholesale($url = '')
	{
		if($url == '')
		{
			$this->view->firstDate = date('Y-m-d');
			$this->view->lastDate = date('Y-m-d');
			$this->view->listWholesale = $this->model->getListWholesale(date('Y-m-d'),date('Y-m-d'));
			$this->view->render('report/wholesale/index');
		}
		else
		{
			$param = explode('_', $url);
			$first = $param[0];
			$last = $param[1];
			$this->view->firstDate = $first;
			$this->view->lastDate = $last;
			$this->view->listWholesale = $this->model->getListWholesale($first,$last);
			$this->view->render('report/wholesale/index', true);
		}
		
	}

	function wholesaleDaily($date)
	{
		$this->view->listWholesale = $this->model->getListDailyWholesale($date);
		$this->view->date = $date;
		$this->view->render('report/wholesale/daily', true);
	}

	function wholesaleDetails($id)
	{
		$this->view->listDetails = $this->model->getListWholesaleDetails($id);
		$this->view->wholesaleDetails = array_shift($this->model->getWholesaleDetails($id));
		$this->view->render('report/wholesale/details');
	}

	/**
	 * Loan Report
	 */
	function loan()
	{
		$this->view->listLoan =  $this->model->getListLoan();
		$this->view->render('report/loan/index');
	}

	function loanCostumer($costumer)
	{
		$this->view->costumerDetails = array_shift($this->model->getCostumerDetails($costumer));
		$this->view->listLoan = $this->model->getLoanHistoryCostumer($costumer);
		$this->view->render('report/loan/costumer');
	}

	function loanPayment($loan)
	{
		$this->view->loanDetails = array_shift($this->model->getLoanDetails($loan));
		$this->view->listPayment = $this->model->getLoanHistoryPayment($loan);
		$this->view->render('report/loan/payment');
	}

	function loanByStatus($status)
	{
		$this->view->listLoan = $this->model->getListLoanBySettlement($status);
		$this->view->render('report/loan/settlement', true);
	}


	/**
	 * Payment Report
	 */
	function payment($url = '')
	{
		if($url == '')
		{
			$this->view->firstDate = date('Y-m-d');
			$this->view->lastDate = date('Y-m-d');
			$this->view->listPayment = $this->model->getListPayment(date('Y-m-d'),date('Y-m-d'));
			$this->view->render('report/payment/index');
		}
		else
		{
			$param = explode('_', $url);
			$first = $param[0];
			$last = $param[1];
			$this->view->firstDate = $first;
			$this->view->lastDate = $last;
			$this->view->listPayment = $this->model->getListPayment($first,$last);
			$this->view->render('report/payment/index', true);
		}
		
	}

	/**
	 * Consignment Report
	 */
	function consign($url = '')
	{
		if($url == '')
		{
			$this->view->firstDate = date('Y-m-d');
			$this->view->lastDate = date('Y-m-d');
			$this->view->listConsignment = $this->model->getListConsignment(date('Y-m-d'),date('Y-m-d'));
			$this->view->render('report/consignment/index');
		}
		else
		{
			$param = explode('_', $url);
			$first = $param[0];
			$last = $param[1];
			$this->view->firstDate = $first;
			$this->view->lastDate = $last;
			$this->view->listConsignment = $this->model->getListConsignment($first,$last);
			$this->view->render('report/consignment/index', true);
		}
		
	}

	function consignSupplier($supplier)
	{		
		$this->view->firstDate = date('Y-m-d');
		$this->view->lastDate = date('Y-m-d');

		$this->view->detailConsignment = array_shift($this->model->getListConsignmentSupplier($supplier));
		$this->view->listConsignment = $this->model->getListConsignmentSupplier($supplier);

		$this->view->render('report/consignment/supplier', true);
	}

	function consignSupplierDate($url)
	{
		$param = explode('_', $url);
		$supplier = $param[0];
		$first = $param[1];
		$last = $param[2];

		$this->view->firstDate = $first;
		$this->view->lastDate = $last;

		$this->view->detailConsignment = array_shift($this->model->getListConsignmentSupplierDate($supplier,$first,$last));
		$this->view->listConsignment = $this->model->getListConsignmentSupplierDate($supplier,$first,$last);

		$this->view->render('report/consignment/supplierdate', true);
	}

	/*
	* Stock Report
	*/

	function stock($publisher = '')
	{
		if($publisher == '')
		{
			$this->view->listPublisher = $this->model->getListPublisher();
			$this->view->listStock = $this->model->getListStock();

			$this->view->render('report/stock/index');
		}
		else
		{
			$this->view->listPublisher = $this->model->getListPublisher();
			$this->view->currPublisher = $publisher;
			$this->view->listStock = $this->model->getListStockFiltered($publisher);

			$this->view->render('report/stock/index');
		}
	}
}