<?php

class Loan extends Controller
{
    function __construct()
    {
        parent::__construct();
        Session::init();
    }

    function index()
    {
        $this->view->listLoan = $this->model->getList();
        $this->view->render('loan/index');
    }
    
    /**
     * Operations
     */
    function addNew()
    {
        $this->model->addNew();
    }

    function addPayment()
    {
        $this->model->addPayment();
    }

    function closeLoan()
    {
        $this->model->closeLoan();
    }

    function deletePayment()
    {
        $this->model->deletePayment();
    }

    /**
     * Views Functions
     */

    function printPayment($id)
    {
        $this->view->detailPayment = array_shift($this->model->getDetailPayment($id));
        $this->view->render('loan/receipt');
    }

    function historyCostumer($costumer)
    {
        $this->view->costumerDetails = array_shift($this->model->getCostumerDetails($costumer));
        $this->view->listLoan = $this->model->getHistoryCostumer($costumer);
        $this->view->render('loan/costumer');
    }

    function costumerBook($costumer)
    {
        $this->view->costumerDetails = array_shift($this->model->getCostumerDetails($costumer));
        $this->view->listLoan = $this->model->getHistoryCostumer($costumer);
        $this->view->render('loan/costumerbook');
    }

    function historyPayment($loan)
    {
        $this->view->loanDetails = array_shift($this->model->getDetails($loan));
        $this->view->listPayment = $this->model->getHistoryPayment($loan);
        $this->view->render('loan/payment');
    }

    function paymentBook($loan)
    {
        $this->view->loanDetails = array_shift($this->model->getDetails($loan));
        $this->view->listPayment = $this->model->getHistoryPayment($loan);
        $this->view->render('loan/paymentbook');
    }

    function invoice($id)
    {
        $this->view->loanDetails = $this->model->getDetails($id);
        $this->view->render('loan/invoice');
    }

    function xListLoan()
    {
        $this->model->getJsonListLoan();
    }
}