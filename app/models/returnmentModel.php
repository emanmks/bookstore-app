<?php

class returnmentModel extends Model
{
	function __construct()
	{
		parent::__construct();
	}

	function addNew()
	{
		$data = array('supplier' => $_POST['supplier'],
					'code' => $this->getCode(),
					'returndate' => date('Y-m-d', strtotime($_POST['returndate'])));

		$this->db->insert("returnment", $data);
		$id = $this->db->lastInsertId();

		echo json_encode(array('id' => $id));
	}

	function getCode()
	{
		$id = 0;
		$sth = $this->db->prepare("select id from returnment order by id desc limit 1");
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

		return '80'.$id;
	}

	function getReturnmentDetails($id)
	{
		return $this->db->select("select supplier.name as suppliername,returnment.* from supplier 
								inner join returnment on supplier.id = returnment.supplier where returnment.id = :id",
								array(':id' => $id));
	}

	function addNewDetails()
	{
		$data = array('returnment' => $_POST['returnment'],'product' => $_POST['product'], 'quantity' => $_POST['quantity']);

		$this->db->insert("returndetails", $data);
		$this->updateStock($_POST['product'],$_POST['quantity']);
	}

	function updateStock($product, $quantity)
	{
		$sth = $this->db->prepare("select stock from product where id = :id");
		$sth->execute(array(':id' => $product));

		$data = $sth->fetch();
		$count = $sth->rowCount();

		if($count > 0)
		{
			$currStock = array('stock' => $data['stock'] - $quantity);
			$this->db->update('product', $currStock, "id = $product");
		}
	}

	function deleteDetails()
	{
		$id = $_POST['id'];

		$this->normalizeStock($id);
		$this->db->delete("returndetails", "id = $id");
	}

	function normalizeStock($detailsID)
	{
		$sth = $this->db->prepare("select product.id as productid,product.stock,returndetails.id,returndetails.quantity from product 
								inner join returndetails 
								on product.id = returndetails.product
								where returndetails.id = :id");
		$sth->execute(array(':id' => $detailsID));

		$data = $sth->fetch();
		$count = $sth->rowCount();

		if($count > 0)
		{
			$currStock = $data['stock'];
			$quantity = $data['quantity'];
			$product = $data['productid'];
			$newStock = $currStock + $quantity;

			$uData = array('stock' => $newStock);
			$this->db->update("product", $uData, "id = $product");
		}
	}

	function getList()
	{
		return $this->db->select("select supplier.name as suppliername,returnment.* from supplier inner join returnment on
								supplier.id = returnment.supplier order by id desc limit 10");
	}

	function getDetails($id)
	{
		return $this->db->select("select supplier.name as suppliername,returnment.* from supplier inner join returnment on
								supplier.id = returnment.supplier where returnment.id = :id", array(':id' => $id));
	}

	function getListDetails($returnment)
	{
		return $this->db->select("select product.code,product.title,returndetails.* from product inner join returndetails on
								product.id = returndetails.product where returndetails.returnment = :returnment",
								array(':returnment' => $returnment));
	}	
}