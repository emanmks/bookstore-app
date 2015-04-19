<?php

class productModel extends Model
{
	function __construct()
	{
		parent::__construct();
	}

	function addNew()
	{
		$data = array('class' => $_POST['classes'],
					'publisher' => $_POST['publisher'],
					'supplier' => $_POST['supplier'],
					'code' => $this->getCode(),
					'title' => $_POST['title'],
					'writer' => $_POST['writer'],
					'price' => $_POST['price'],
					'sellprice' => $_POST['sellprice'],
					'stock' => $_POST['stock'],
					'lastopname' => date('Y-m-d'));

		$this->db->insert("product", $data);
	}

	function getCode()
	{
		$id = 0;
		$sth = $this->db->prepare("select id from product order by id desc limit 1");
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

		return '10'.$id;
	}

	function updateDetails()
	{
		$id = $_POST['id'];
		$data = array('title' => $_POST['title'],
					'writer' => $_POST['writer'],
					'price' => $_POST['price'],
					'sellprice' => $_POST['sellprice']); 

		$this->db->update("product", $data, "id = $id");
	}

	function updateStock()
	{
		$id = $_POST['id'];
		$data = array('stock' => $_POST['stock'], 'lastopname' => date('Y-m-d')); 

		$this->db->update("product", $data, "id = $id");
	}

	function delete()
	{
		$id = $_POST['id'];

		$this->db->delete("product", "id = $id");
	}

	function updateClass()
	{
		$id = $_POST['id'];
		$data = array('class' => $_POST['classes']);
		$this->db->update("product", $data, "id = $id");
	}

	function updatePublisher()
	{
		$id = $_POST['id'];
		$data = array('publisher' => $_POST['publisher']);
		$this->db->update("product", $data, "id = $id");
	}

	function updateSupplier()
	{
		$id = $_POST['id'];
		$data = array('supplier' => $_POST['supplier'], 'consignment' => $_POST['consignment']);
		$this->db->update('product', $data, "id = $id");
	}

	function getLastProduct()
	{
		return $this->db->select("select * from product order by id desc limit 50");
	}

	function getList($class)
	{
		return $this->db->select("select * from product where class = :class", array(':class' => $class));
	}

	function getDetails($id)
	{
		return $this->db->select("select class.name as classname, publisher.name as publishername, supplier.name as suppliername,product.* from product 
								left outer join class on product.class = class.id 
								left outer join publisher on product.publisher = publisher.id 
								left outer join supplier on product.supplier = supplier.id 
								where product.id = :id", array(':id' => $id));
	}

	function getListClass()
	{
		return $this->db->select("select * from class order by name asc");
	}

	function getListsupplier()
	{
		return $this->db->select("select * from supplier order by id asc");
	}


	/* AJAX Processing */
	function getJsonListProduct()
	{
		$title = $_POST['title'];
		$jsonData = $this->db->select("select publisher.name as publishername,product.* from publisher inner join product
									on publisher.id = product.publisher where lower(product.title) like '%$title%' order by product.title asc");

		echo json_encode($jsonData);
	}

	function getJsonListProductFilterSupplier()
	{
		$title = $_POST['title'];
		$supplier = $_POST['supplier'];
		$jsonData = $this->db->select("select publisher.name as publishername,product.* from publisher inner join product
									on publisher.id = product.publisher where product.supplier = :supplier and lower(product.title) like '%$title%'",
									array(':supplier' => $supplier));

		echo json_encode($jsonData);
	}


	function getJsonListPublisher()
	{
		$name = $_POST['param'];
		$jsonData = $this->db->select("select * from publisher where name like '%$name%'");

		echo json_encode($jsonData);
	}

	function getJsonListSupplier()
	{
		$name = $_POST['param'];
		$jsonData = $this->db->select("select * from supplier where name like '%$name%'");

		echo json_encode($jsonData);
	}
}