<?php

class paymentModel extends Model
{
    function __construct()
    {
        parent::__construct();
    }

    function addNew()
    {
        $data = array('loan' => $_POST['loan'],
                                'employee' => $_POST['employee'],
                                'code' => $this->getCode(),
                                'paydate' => date('Y-m-d', strtotime($_POST['paydate'])),
                                'payment' => $_POST['payment']);

        $this->db->insert("loanpayment", $data);
        $this->updateBalance($data['loan'], $data['payment']);
    }

    function updateBalance($loan,$payment)
    {
        $loanData = $this->db->select("select balance from loan where id = :loan", array(':loan' => $loan));
        $data = array_shift($loanData);

        $data = array('balance' => $data['balance'] - $payment);
        $this->db->update("loan", $data, "id = $loan");
    }

    function getCode()
    {
        $id = 0;
        $sth = $this->db->prepare("select id from payment order by id desc limit 1");
        $sth->execute();

        $data = $sth->fetch();
        $count = $sth->rowCount();

        if($count > 0)
        {
                $id = $data['id'] + 1;
        }
        else
        {
                $id = 1;
        }

        return '70'.$id;
    }

    function delete()
    {
        $id = $_POST['id'];

        $this->normalizeBalance($loanpayment);
        $this->db->delete("loanpayment", "id = $id");
    }

    function normalizeBalance($loanpayment)
    {
        $paymentData = $this->db->select("select loan.balance,loanpayment.id,loanpayment.payment from loan inner join loanpayment on loan.id = loanpayment.loan 
                                        where loanpayment.id = :id", array(':id' => $loanpayment));
        $data = array_shift($paymentData);

        $data = array('balance' => $data['balance'] + $data['payment']);
        $this->db->update("loan", $data, "id = $loan");
    }
}