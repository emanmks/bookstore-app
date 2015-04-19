<?php

class Payment extends Controller
{
    function __construct()
    {
        parent::__construct();
        Session::init();
    }

    function index()
    {
        // $this->view->listPayment = $this->model->getList();
        $this->view->render('payment/index');
    }
}