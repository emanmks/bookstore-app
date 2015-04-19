<?php

class supplyModel extends Model
{
	function __construct()
	{
		parent::__construct();
	}

	function addNew()
	{
		$data = array('product' => $_POST['product'],
					'supplydate' => date('Y-m-d', strtotime($_POST['supplydate'])),
					'total' => $_POST['total']);

		$this->db->insert("supply", $data);
		$this->updateStock($data['product'], $data['total']);
	}

	function updateStock($product, $total)
	{
		$sth = $this->db->prepare("select stock from product where id = :id");
		$sth->execute(array(':id' => $product));

		$data = $sth->fetch();
		$count = $sth->rowCount();

		if($count > 0)
		{
			$newStock = $data['stock'] + $total;
			$uData = array('stock' => $newStock, 'lastopname' => date('Y-m-d'));
			$this->db->update("product", $uData, "id = $product");
		}
	}

	function delete()
	{
		$id = $_POST['id'];

		$this->cutStock($id);
		$this->db->delete("supply", "id = $id");
	}

	function cutStock($supplyID)
	{
		$sth = $this->db->prepare("select product.id as productid,product.stock,supply.id,supply.total from product inner join supply 
								on product.id = supply.product
								where supply.id = :id");
		$sth->execute(array(':id' => $supplyID));

		$data = $sth->fetch();
		$count = $sth->rowCount();

		if($count > 0)
		{
			$currStock = $data['stock'];
			$totalSupply = $data['total'];
			$product = $data['productid'];
			$newStock = $currStock - $totalSupply;

			$uData = array('stock' => $newStock, 'lastopname' => date('Y-m-d'));
			$this->db->update("product", $uData, "id = $product");
		}
	}

	function getList()
	{
		return $this->db->select("select product.id as productid,product.code,product.title,supply.* from product inner join supply on 
							product.id = supply.product order by supply.id desc limit 25");
	}

	function getListFilterbyProduct($product)
	{
		return $this->db->select("select product.id as productid,product.code,product.title,supply.* from product inner join supply on 
							product.id = supply.product where supply.product = :product order by supply.id desc", array(':product' => $product));
	}

	function getListFilterbyDate($first, $last)
	{
		return $this->db->select("select product.id as productid,product.code,product.title,supply.* from product inner join supply on 
							product.id = supply.product where supply.supplydate between :first and :last order by supply.id desc", 
							array(':first' => $first, ':last' => $last));
	}
}