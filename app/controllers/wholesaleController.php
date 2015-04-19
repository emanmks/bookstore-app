<?php

class Wholesale extends Controller
{
    function __construct()
    {
        parent::__construct();
        Session::init();
    }

    function index()
    {
        $this->view->listTransaction = $this->model->getListTransaction(date('Y-m-d'),date('Y-m-d'));
        $this->view->render('wholesale/index');
    }

    function details($selling)
    {
        $this->view->detailSelling = array_shift($this->model->getSellingDetails($selling));
        $this->view->listTransaction = $this->model->getListTransactionDetails($selling);
        $this->view->render('wholesale/details');
    }

    function newSelling()
    {
        $this->model->addNew();
    }

    function newTransaction($id)
    {
        $this->view->detailSelling = array_shift($this->model->getSellingDetails($id));
        $this->view->listTransaction = $this->model->getListTransactionDetails($id);
        $this->view->render('wholesale/transaction');
    }

    function addDetails()
    {
        $this->model->addNewDetails();
    }

    function reloadPage($selling)
    {
        $this->view->detailSelling = array_shift($this->model->getSellingDetails($selling));
        $this->view->listTransaction = $this->model->getListTransactionDetails($selling);
        $this->view->render('wholesale/filterdetails', true);
    }

    function filterByDate($date)
    {
        $this->view->listTransaction = $this->model->getListTransaction($date,$date);
        $this->view->render('wholesale/filter', true);
    }

    function deleteDetails()
    {
        $this->model->deleteDetails();
    }

    function payment($selling)
    {
        $this->model->closeSelling($selling);
        $this->model->setCash($selling);
        $this->view->detailSelling = array_shift($this->model->getSellingDetails($selling));
        $this->view->listTransaction = $this->model->getListTransactionDetails($selling);
        $this->view->render('wholesale/payment');
    }

    function rePayment($selling)
    {
        $this->view->detailSelling = array_shift($this->model->getSellingDetails($selling));
        $this->view->listTransaction = $this->model->getListTransactionDetails($selling);
        $this->view->render('wholesale/payment');
    }

    function invoice($url)
    {
        $param = explode("_", $url);
        $selling = $param[0];
        $loan = $param[1];
        $downpay = $param[2];

        $this->model->setLoan($selling);
        $this->model->closeSelling($selling);

        $this->view->loanDetails = array_shift($this->model->getLoanDetails($loan));
        $this->view->detailSelling = array_shift($this->model->getSellingDetails($selling));
        $this->view->listTransaction = $this->model->getListTransactionDetails($selling);
        $this->view->downPayment = $downpay;

        $this->view->render('wholesale/invoice');
    }

    function reInvoice($selling)
    {
        $this->view->loanDetails = array_shift($this->model->getLoanDetailsbySelling($selling));
        $this->view->detailSelling = array_shift($this->model->getSellingDetails($selling));
        $this->view->listTransaction = $this->model->getListTransactionDetails($selling);
        $this->view->render('wholesale/invoice');
    }
}