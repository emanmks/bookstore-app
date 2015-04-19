<?php

class loanModel extends Model
{
    function __construct()
    {
        parent::__construct();
    }

    function addNew()
    {
        $data = array('selling' => $_POST['selling'],
                    'costumer' => $_POST['costumer'],
                    'employee' => $_POST['employee'],
                    'code' => $this->getCode(),
                    'total' => $_POST['totalprice'],
                    'dp' => $_POST['downpay'],
                    'balance' => $_POST['totalprice']-$_POST['downpay'],
                    'deadline' => date('Y-m-d', strtotime($_POST['deadline'])));

        $this->db->insert("loan", $data);
        $loan = $this->db->lastInsertId();

        if($_POST['downpay'] > 0)
        {
            $payData = array('loan' => $loan,
                            'employee' => $_POST['employee'],
                            'code' => $this->getPaymentCode(),
                            'paydate' => $_POST['selldate'],
                            'payment' => $_POST['downpay'],
                            'info' => 'Down Payment');
            $this->db->insert('loanpayment', $payData);
        }

        echo json_encode(array('loan' => $loan));
    }

    function getCode()
    {
        $id = 0;
        $sth = $this->db->prepare("select id from loan order by id desc limit 1");
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

        return '60'.$id;
    }

    function addPayment()
    {
        $payData = array('loan' => $_POST['loan'],
                        'employee' => $_POST['employee'],
                        'code' => $this->getPaymentCode(),
                        'paydate' => $_POST['paydate'],
                        'payment' => $_POST['payment'],
                        'info' => $_POST['info']);

        $this->db->insert('loanpayment', $payData);

        $id = $this->db->lastInsertId();

        $this->setStatus($_POST['loan'],$_POST['status']);
        $this->updateBalance($_POST['loan'],$_POST['payment']);

        echo json_encode(array('id' => $id));
    }

    function setStatus($loan,$status)
    {
        $newStatus = array('settled' => $status);
        $this->db->update('loan', $newStatus, "id = $loan");
    }

    function updateBalance($loan,$payment)
    {
        $sth = $this->db->prepare("select balance from loan where id = :loan");
        $sth->execute(array(':loan' => $loan));

        $data = $sth->fetch();
        $count = $sth->rowCount();

        if($count > 0)
        {
            $newBalance = array('balance' => $data['balance'] - $payment);
            $this->db->update('loan', $newBalance, "id = $loan");
        }
    }

    function getPaymentCode()
    {
        $id = 0;
        $sth = $this->db->prepare("select id from loanpayment order by id desc limit 1");
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

    function closeLoan()
    {
        $id = $_POST['id'];
        $status = array('balance' => 0, 'settled' => 1);

        $this->db->update("loan", $status, "id = $id");
    }

    function deletePayment()
    {
        $id = $_POST['id'];

        $this->normalizeBalance($id);
        $this->db->delete("loanpayment", "id = $id");
    }

    function normalizeBalance($payment)
    {
        $sth = $this->db->prepare("select loan.balance,loanpayment.payment,loanpayment.loan from loan inner join loanpayment on loan.id = loanpayment.loan 
                                where loanpayment.id = :id");
        $sth->execute(array(':id' => $payment));

        $data = $sth->fetch();
        $count = $sth->rowCount();

        if($data > 0)
        {
            $loan = $data['loan'];
            $newBalance = array('balance' => $data['balance'] + $data['payment'],'settled' => 0);
            $this->db->update('loan', $newBalance, "id = $loan");
        }
    }

    function getList()
    {
        return $this->db->select("select costumer.id as costumerid,costumer.name as costumername,selling.id as sellingid,selling.code as sellingcode,
                                loan.* from (costumer,selling) 
                                inner join loan on costumer.id = loan.costumer and selling.id = loan.selling");
    }

    function getDetails($id)
    {
        return $this->db->select("select selling.code as sellcode,selling.selldate,
                                costumer.id as costumerid, costumer.code as costumercode, costumer.name as costumername,
                                employee.id as employeeid, employee.code as employeecode, employee.name as employeename,
                                loan.* from (costumer,employee,selling)
                                inner join loan on costumer.id = loan.costumer and employee.id = loan.employee and selling.id = loan.selling 
                                where loan.id = :id", 
                                array(':id' => $id));
    }

    function getDetailPayment($id)
    {
        return $this->db->select("select loan.code as loancode,loan.*,loanpayment.*,employee.name as employeename from 
                                        ((select selling.code as sellcode,selling.selldate,
                                        costumer.id as costumerid, costumer.code as costumercode, costumer.name as costumername, costumer.address,costumer.phone,
                                        loan.* from (costumer,selling)
                                        inner join loan on costumer.id = loan.costumer and selling.id = loan.selling) as loan,employee) 
                                inner join loanpayment on loan.id = loanpayment.loan and employee.id = loanpayment.employee 
                                where loanpayment.id = :id",
                                array(':id' => $id));
    }

    function getCostumerDetails($costumer)
    {
        return $this->db->select("select * from costumer where id = :id", array(':id' => $costumer));
    }

    function getHistoryCostumer($costumer)
    {
        return $this->db->select("select costumer.id as costumerid,costumer.name as costumername,loan.* from costumer 
                                inner join loan on costumer.id = loan.costumer where loan.costumer = :costumer", 
                                array(':costumer' => $costumer));
    }

    function getHistoryPayment($loan)
    {
        return $this->db->select("select employee.name as employeename,loanpayment.* from employee inner join loanpayment on
                                employee.id = loanpayment.employee where loanpayment.loan = :loan", array(':loan' => $loan));
    }

    function getJsonListLoan()
    {
        $param = $_POST['param'];
        $jsonData = $this->db->select("select costumer.id as costumerid,costumer.name as costumername,selling.id as sellingid,selling.code as sellingcode,
                                    loan.* from (costumer,selling) 
                                    inner join loan on costumer.id = loan.costumer and selling.id = loan.selling
                                    where costumer.name like '%$param%' or loan.code like '%$param%'");
        echo json_encode($jsonData);	
    }
}