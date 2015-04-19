<?php

class placementModel extends Model
{
	function __construct()
	{
		parent::__construct();
	}

	function addNew()
	{
		$data = array('product' => $_POST['product'],'place' => $_POST['place']);

		$this->db->insert("placement", $data);
	}

	function update()
	{
		$id = $_POST['id'];
		$data = array('product' => $_POST['product'],'place' => $_POST['place']);

		$this->db->update("placement", $data, "id = $id");
	}

	function delete()
	{
		$id = $_POST['id'];

		$this->db->delete("placement", "id = $id");
	}

	function getListPlace()
	{
		return $this->db->select("select * from place order by name asc");
	}

	function getList()
	{
		return $this->db->select("select place.name,product.id as productid,product.title,placement.* from (place,product) inner join placement on
								place.id = placement.place and product.id = placement.product order by product.code");
	}

	function getListFilterbyProduct($product)
	{
		return $this->db->select("select place.name,product.id as productid,product.code,product.title,placement.* from (place,product) inner join placement on
								place.id = placement.place and product.id = placement.product where placement.product = :product",
								array('product' => $product));
	}

	function getListFilterbyPlace($place)
	{
		return $this->db->select("select place.name,product.id as productid,product.code,product.title,placement.* from (place,product) inner join placement on
								place.id = placement.place and product.id = placement.product where placement.place = :place",
								array('place' => $place));
	}
}