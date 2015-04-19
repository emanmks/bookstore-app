<?php

class retailModel extends Model
{
	function __construct()
	{
		parent::__construct();
	}

	function addNew()
	{
		$data = array('costumer' => 0,
					'employee' => $_POST['employee'],
					'code' => $this->getCode(),
					'selldate' => date('Y-m-d', strtotime($_POST['selldate'])),
					'cash' => 1);

		$this->db->insert("selling", $data);
		$id = $this->db->lastInsertId();

		echo json_encode(array('selling' => $id));
	}

	function getSellingDetails($id)
	{
		return $this->db->select("select employee.name as employeename,selling.* from employee inner join selling 
								on employee.id = selling.employee
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

		return '40'.$id;
	}

	function deleteDetails()
	{
		$id = $_POST['id'];

		$this->normalizeStock($id);
		$this->db->delete("sellingdetails", "id = $id");
	}

	function normalizeStock($sellingDetailsID)
	{
		$sth = $this->db->prepare("select product.id as productid,product.stock,sellingdetails.id,sellingdetails.total from product 
								inner join sellingdetails 
								on product.id = sellingdetails.product
								where sellingdetails.id = :id");
		$sth->execute(array(':id' => $sellingDetailsID));

		$data = $sth->fetch();
		$count = $sth->rowCount();

		if($count > 0)
		{
			$currStock = $data['stock'];
			$total = $data['total'];
			$product = $data['productid'];
			$newStock = $currStock + $total;

			$uData = array('stock' => $newStock);
			$this->db->update("product", $uData, "id = $product");
		}
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

	function getListTransaction($first, $last)
	{
		return $this->db->select("select selling.id as sellingid,selling.code,selling.selldate,selling.closing,
								sum(sellingdetails.sellprice*sellingdetails.total) as total
								from selling left outer join sellingdetails on
								selling.id = sellingdetails.selling where selling.costumer = 0 and selling.selldate between :first and :last 
								group by sellingdetails.selling",
								array(':first' => $first, ':last' => $last));
	}

	function getListTransactionDetails($selling)
	{
		return $this->db->select("select selling.id as sellingid,selling.code,selling.selldate,selling.closing,product.title,sellingdetails.* 
								from (selling,product) 
								inner join sellingdetails on
								product.id = sellingdetails.product and
								selling.id = sellingdetails.selling where sellingdetails.selling = :selling", array(':selling' => $selling));
	}

	function getListTransactionByProduct($product)
	{
		return $this->db->select("select selling.code,selling.selldate,selling.closing,sellingdetails.* from selling inner join sellingdetails on
								selling.id = sellingdetails.selling where sellingdetails.product = :product", 
								array(':product' => $product));
	}
}