<?php

class wholesaleModel extends Model
{
    function __construct()
    {
        parent::__construct();
    }

    function addNew()
    {
        $data = array('costumer' => $_POST['costumer'],
                    'employee' => $_POST['employee'],
                    'code' => $this->getCode(),
                    'selldate' => date('Y-m-d', strtotime($_POST['selldate'])));

        $this->db->insert("selling", $data);
        $id = $this->db->lastInsertId();

        echo json_encode(array('selling' => $id));
    }

    function getSellingDetails($id)
    {
        return $this->db->select("select costumer.id as costumerid, costumer.name as costumername,costumer.address, costumer.phone,
                                employee.id as employeeid,employee.name as employeename,selling.* 
                                from (costumer,employee) inner join selling 
                                on costumer.id = selling.costumer and employee.id = selling.employee
                                where selling.id = :id", array(':id' => $id));
    }

    function addNewDetails()
    {
        $data = array('selling' => $_POST['selling'],
                    'product' => $_POST['product'],
                    'total' => $_POST['total'],
                    'price' => $_POST['price'],
                    'discount' => $_POST['discount'],
                    'sellprice' => $_POST['sellprice']);

        $this->db->insert("sellingdetails", $data);
    }

    function updateStock($product, $total)
    {
        $sth = $this->db->prepare("select stock from product where id = :id");
        $sth->execute(array(':id' => $product));

        $data = $sth->fetch();
        $count = $sth->rowCount();

        if($count > 0)
        {
            $newStock = $data['stock'] - $total;
            $uData = array('stock' => $newStock);
            $this->db->update("product", $uData, "id = $product");
        }
    }

    function getCode()
    {
        $id = 0;
        $sth = $this->db->prepare("select id from selling order by id desc limit 1");
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

        return '50'.$id;
    }

    function deleteDetails()
    {
        $id = $_POST['id'];
        $this->db->delete("sellingdetails", "id = $id");
    }

    function closeSelling($selling)
    {
        $data = array('closing' => 1);
        $this->db->update('selling', $data, "id = $selling");

        $productData = $this->db->select("select sellingdetails.product,sellingdetails.total from 
                                                                sellingdetails where sellingdetails.selling = :selling", array(':selling' => $selling));

        foreach ($productData as $key => $value) {
                $this->updateStock($value['product'], $value['total']);
        }
    }

    function setCash($selling)
    {
        $data = array('cash' => 1);
        $this->db->update('selling', $data, "id = $selling");
    }

    function setLoan($selling)
    {
        $data = array('cash' => 0);
        $this->db->update('selling', $data, "id = $selling");
    }

    function getListTransaction($first, $last)
    {
        return $this->db->select("select selling.sellingid,selling.code,selling.selldate,selling.closing,selling.costumername,selling.cash,
                                selling.total,loan.total as loantotal,loan.dp,loan.balance 
                                from (select selling.id as sellingid,selling.code,selling.selldate,selling.closing,selling.costumername,selling.cash,
                                sum(sellingdetails.sellprice*sellingdetails.total) as total
                                from 
                                        (select costumer.name as costumername,selling.* from costumer 
                                                left outer join selling on costumer.id = selling.costumer) as selling 
                                left outer join sellingdetails on
                                selling.id = sellingdetails.selling 
                                group by sellingdetails.selling) as selling left outer join loan on selling.sellingid = loan.selling
                                where selling.selldate between :first and :last",
                                array(':first' => $first, ':last' => $last));
    }

    function getListTransactionDetails($selling)
    {
        return $this->db->select("select selling.id as sellingid,selling.code,selling.selldate,selling.closing,
                                product.title,product.publishername,sellingdetails.* from (selling,
                                        (select publisher.name as publishername,product.* from publisher inner join 
                                                product on publisher.id = product.publisher) as product) 
                                inner join sellingdetails on
                                product.id = sellingdetails.product and
                                selling.id = sellingdetails.selling where sellingdetails.selling = :selling", array(':selling' => $selling));
    }

    function getLoanDetails($id)
    {
        return $this->db->select("select id,code,dp,balance,deadline from loan where id = :id", 
                                                            array(':id' => $id));
    }

    function getLoanDetailsbySelling($selling)
    {
        return $this->db->select("select id,code,total,dp,balance,deadline from loan where selling = :selling", 
                                                            array(':selling' => $selling));
    }
}